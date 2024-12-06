<?php

namespace App\Services\Cms\api\traits;

trait BasicRole
{
    /** @return array */
    private function basicRole(bool $canBatch = false)
    {
        $role = method_exists($this, 'getRoles') ? $this->getRoles() :
        [
            'view' => false,
            'edit' => false,
            'delete' => false,
            'create' => false,
            'need_review' => false,
            'can_review' => false,
            'is_review_edit' => false,
        ];
        $role['canExport'] = method_exists($this, 'getExport');
        $role['canBatch'] = $canBatch;
        return $role;
    }
}
