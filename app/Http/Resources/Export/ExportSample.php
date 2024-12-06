<?php

namespace App\Http\Resources\Export;

use App\Models\branch_backend_main\BackendMainCategory;
use App\Models\branch_backend_main\BackendMainType;
use Illuminate\Http\Resources\Json\JsonResource;

class ExportSample extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'is_visible' => $this->is_visible ? '顯示' : '隱藏',
            'is_preview' => $this->is_preview ? '●' : '',
            'img' => $this->img,
            'textInput' => $this->textInput,
            'textArea' => $this->textArea,
            'colorPicker' => $this->colorPicker,
            'datePicker' => $this->datePicker,
            'category_ids' => $this->multiSelect($this->category_ids ?? '', BackendMainCategory::getCategoryList()),
            'type_id' => isset(BackendMainType::getTypeList()[$this->type_id]) ? (BackendMainType::getTypeList()[$this->type_id]['title'] ?? '') : '',
            'updated_at' => $this->updated_at,
            'contents' => ExportSampleContent::collection($this['Contents']),
        ];
    }
    protected function multiSelect(string $json, array $options)
    {
        $ids = json_decode($json) ?? [];
        $keys = array_keys($options);
        return implode(', ', array_reduce($ids, function ($res, $id) use ($keys, $options) {
            if (in_array($id, $keys)) {
                $res[] = $options[$id]['title'];
            }
            return $res;
        }, []));
    }
}
