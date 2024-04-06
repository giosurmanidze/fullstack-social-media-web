<?php

namespace App\Contracts;

use App\Models\User;

interface ProfileRepositoryInterface
{
    public function update(User $user, array $data): bool;
}