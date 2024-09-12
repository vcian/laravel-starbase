<?php

declare(strict_types = 1);

namespace App\Services\User;

use App\Models\User\User;

final readonly class UserService
{
    public function __construct(Private User $user)
    {
    }
}
