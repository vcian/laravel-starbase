<?php

declare(strict_types = 1);

namespace App\Models\User\Traits\Scope;

trait UserScope
{
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
