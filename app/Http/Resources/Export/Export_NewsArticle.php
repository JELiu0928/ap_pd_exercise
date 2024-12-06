<?php

namespace App\Http\Resources\Export;

use App\Models\branch_backend_main\BackendMainCategory;
use App\Models\branch_backend_main\BackendMainType;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\News\NewsCategory;

class Export_NewsArticle extends JsonResource
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
            'w_rank' => $this->w_rank,
            'is_visible' => $this->is_visible ? '顯示' : '隱藏',
            'is_preview' => $this->is_preview ? '●' : '',
            'img' => $this->img,
            'category_id' => isset(NewsCategory::categoryList()[$this->category_id]) ? (NewsCategory::categoryList()[$this->category_id]['title'] ?? '') : '',
            'updated_at' => $this->updated_at,
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
