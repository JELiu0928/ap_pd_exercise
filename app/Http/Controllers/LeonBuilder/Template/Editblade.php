{{-- 表名跟哪一筆資料 --}}
<form id="{{ $formKey }}">
    <input name="modelName" type="hidden" value="{{ $model }}">

    <div class="backEnd_quill">
        <article class="work_frame">
            <section class="content_box">
                <div class="for_ajax_content">
                    <section class="content_a">
                        <ul class="frame">
                            @if($formKey == 'search')
                            {$search_unit}
                            @endif
                            @if($formKey == 'batch')
                            {$batch_unit}
                            @endif
                            {$main_unit}
                            {$son_unit}            
                            @if($formKey == 'Form_1')
                                @include('Fantasy.cms_view.back_article_v3', [
                                'Model' => 'Elite_business_dept_content',
                                'ThreeModel' => 'Elite_business_dept_content_img',
                                ])

                            @endif
                        </ul>
                    </section>
                </div>
            </section>
        </article>
    </div>
</form>
