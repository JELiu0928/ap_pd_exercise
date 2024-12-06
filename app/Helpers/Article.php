<?php

namespace App\Helpers;

use Config;
use Illuminate\Support\Facades\View;
use App\Models\Basic\Fms\FmsFile;

class Article
{
    protected $paragraphs = [];
    protected $imageGroupKey = '';
    protected $currentParagraph = null;

    // 此陣列只記錄特殊樣式的模板, 通用模板(typeBasic)作為預設, 模板位置: resources/views/Front/components/article
    protected $specialStyleList = [
        'typeL' => 'typeLR',
        'typeR' => 'typeLR',
        'typeLR' => 'typeWrap',
        'typeRR' => 'typeWrap',
        'typeF' => 'typeFull',
        'typeFL' => 'typeFull',
        'typeFR' => 'typeFull',
        'typeFBox' => 'typeFull',
        'typeFBoxL' => 'typeFull',
        'typeFBoxR' => 'typeFull',
    ];

    public function __construct($paragraphs, $imageGroupKey)
    {

        $this->paragraphs = $paragraphs;
        $this->imageGroupKey = $imageGroupKey;
    }

    public function buildArticle()
    {
        $article = '';

        foreach ($this->paragraphs as $paragraph) {
            $article .= $this->buildParagraph($paragraph);
        }

        return $article;
    }

    public function buildParagraph($paragraph)
    {
        $this->currentParagraph = $paragraph;

        $styleBlade = $this->specialStyleList[$paragraph['article_style']] ?? 'typeBasic';

        $blade = Config::get('blade_template').".components.article.{$styleBlade}";

        try {

            $start = "<article data-aost-offset='30' class='_article {$paragraph['article_style']}'
                        {$this->addAttributes($paragraph)}
                        data-index='{$paragraph['article_style']}-{$paragraph['id']}' data-aost data-aost-fade-up>";

            $content = View::make($blade, [
                'paragraph' => $paragraph,
                'threes' => $paragraph[$this->imageGroupKey],
                'builder' => $this
            ])->render();

            $end = "</article>";

            $this->currentParagraph = null;

            return "{$start}{$content}{$end}";
        } catch (\Exception $e) {
            throw new \Exception(
                "標題為: {$paragraph->article_title} , ID為: {$paragraph->id} 的段落發生錯誤, 錯誤內容:{$e->getMessage()}"
            );
        }
    }

    // 建立內文區塊
    public function buildContext()
    {
        $data = $this->currentParagraph;

        if (!$data) throw new \Exception('方法buildContext: 目前沒有段落可做處理');

        $context = "<p>" . $data['article_inner'] . "</p>";

        $instagram = $data['instagram_content'] ?: '';
        return "{$context}{$instagram}";
    }

    // 建立圖片區塊
    public function buildImages()
    {
        $data = $this->currentParagraph;
        if (!$data) throw new \Exception('方法buildImages: 目前沒有段落可做處理');

        return View::make(
            Config::get('blade_template').'.components.article.image-group',
            ['imageGroup' => $data[$this->imageGroupKey], 'isSwiper' => $data['is_swiper']]
        )->render();
    }

    // 建立按鈕
    public function buildButton()
    {
        if (!$this->currentParagraph) throw new \Exception('方法buildButton: 目前沒有段落可做處理');

        $paragraph = $this->currentParagraph;

        $target = $paragraph['link_type'] == 1 ? '_blank' : '';
        $color = $paragraph['button_textcolor'];
        $nocg = '';
        //檔案下載
        if ($paragraph->button_action) {
            $file = FmsFile::where('file_key', $paragraph->button_file)->first();
            $url = (!empty($file)) ? download($file['url_name'], $file['id']) : 'javascript:;';
            $nocg = 'nocg';
        } else {
            $url = (!empty($paragraph->button_link)) ? url($paragraph->button_link) : 'javascript:;';
        }

        $button = $paragraph->button_visible && !empty($paragraph->button) ?
            "<div class='_buttonCover'>
                        <a class='_button {$color} {$nocg}' target='{$target}' href='{$url}'>
                            <p>{$paragraph->button}<i class='icon-plus'></i></p>
                        </a>
                    </div>" : '';
        return $button;
    }

    // 加入<article>的屬性
    public function addAttributes($paragraph)
    {
        $attr = '';

        foreach ($paragraph->getAttributes() as $attribute => $value) {
            $changedAttr = str_replace('_', '-', $attribute);

            switch ($attribute) {
                case 'mobile_rwd':
                    $val = $value ?? 'off';
                    $attr .= " {$changedAttr}='{$val}'";
                    break;
                case 'button_color':
                    // if (!$value) {
                    //     $attr .= " {$changedAttr}='#FC8205'";
                    // } else {
                    $attr .= " {$changedAttr}='{$value}'";
                    // };
                    break;
                case 'h_align':
                case 'subh_align':
                case 'p_align':
                case 'button_align':
                case 'description_align':
                case 'img_flex': // 圖片彼此對齊方式
                case 'img_row': // 每列幾張圖 (非輪播)
                case 'img_size': // 圖片比例
                case 'h_color':
                case 'subh_color':
                case 'p_color':
                case 'button_color_hover':
                case 'description_color':
                case 'button_textcolor':
                    if (!$value) break;
                    $attr .= " {$changedAttr}='{$value}'";
                    break;

                case 'img_merge': // 拼圖模式
                case 'img_firstbig':
                    $val = $value ? 'on' : 'off';
                    $attr .= " {$changedAttr}={$val}";
                    break;

                case 'swiper_num': // 每列幾張圖 (輪播)
                    if (!$value || !$paragraph['is_swiper']) break;
                    $attr .= " {$changedAttr}='{$value}'";
                    break;

                case 'swiper_autoplay':
                case 'swiper_loop':
                case 'swiper_arrow':
                    // case 'swiper_nav':
                    if (!$paragraph['is_swiper']) break;
                    $val = $value ? 'on' : 'off';
                    $attr .= " {$changedAttr}={$val}";
                    break;

                    // 圖片與文字對齊方式 (圖左文右、圖右文左專用)
                case 'article_flex':
                    if (!in_array($paragraph->article_style, ['typeL', 'typeR'])) break;
                    $attr .= " {$changedAttr}='{$value}'";
                    break;

                    // 內文寬度 (滿版背景)
                    // case 'full_size':
                    //     if (! $value || ! in_array($paragraph->article_style, ['typeF', 'typeFL', 'typeFR', 'typeFBox', 'typeFBoxL', 'typeFBoxR'])) break;
                    //     $attr .= " typeFull-size='{$value}'";
                    //     break;
                    // 段落底色 (滿版背景)
                case 'article_color':
                    if (!in_array($paragraph->article_style, ['typeF', 'typeFL', 'typeFR', 'typeFBox', 'typeFBoxL', 'typeFBoxR'])) break;
                    $attr .= " typeFull-color='{$value}'";
                    break;

                    // 內文底色 (滿版色塊)
                case 'full_box_color':
                    if (!in_array($paragraph->article_style, ['typeFBox', 'typeFBoxL', 'typeFBoxR'])) break;
                    $attr .= " typeFull-boxcolor='{$value}'";
                    break;

                    // 是否對齊邊際 (滿版色塊)
                case 'is_slice':
                    if (!in_array($paragraph->article_style, ['typeFBox', 'typeFBoxL', 'typeFBoxR'])) break;
                    $val = $value ? 'on' : 'off';
                    $attr .= " typeFull-slice='{$val}'";
                    break;
            }
        }

        // 以下兩個屬性目前不給客戶修改, 數值請詢問前端
        if ($paragraph['is_swiper']) {
            $attr .= " swiper-speed=300";
            $attr .= " swiper-parallax=off";
            $attr .= " swiper-button_textcolor=white";
            $attr .= " swiper-nav=on";
        }
        //滿版背景都先都以下樣式呈現
        if (in_array($paragraph->article_style, ['typeFL'])) {
            // $attr .= " typeFull-size=m";
            // $attr .= " h-color=white";
            // $attr .= " p-color=white";
        }

        return $attr;
    }
}
