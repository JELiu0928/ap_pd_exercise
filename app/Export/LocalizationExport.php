<?php 

namespace App\Export;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;

class LocalizationExport implements WithHeadings, ShouldAutoSize, FromCollection
{   
    protected $prefix = '固定ui表單';
    protected $request;
    protected $builder;
    protected $locale;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return ['@#$ 對應key值, 此欄文字用於程式判斷, 請勿更動', '待翻譯文字', '翻譯後的文字'];
    }

    public function collection()
    {
        $request = $this->request;
        $temp = include_once (resource_path('lang/' . $request->locale . '/' . $request->filename . '.php'));
        
        $data = $this->buildData($temp);

        return collect($data);
    }

    public function getFileName()
    {
        $request = $this->request;
        return sprintf('%s_%s_%s_%s.xlsx', $this->prefix, $request->locale, $request->filename, date('Ymd'));
    }

    public function buildData($items, $prefix = '', &$temp = [])
    {
        foreach ($items as $key => $value) {

            if ($prefix) $key = ($prefix . '.' . $key);

            if (! is_array($value)) {

                $temp[] = [$key, $value];

            } else {

                $this->buildData($value, $key, $temp);

            }

        }

        return $temp;
    }
}