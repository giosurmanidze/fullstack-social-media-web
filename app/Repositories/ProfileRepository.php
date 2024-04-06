<?php

namespace App\Repositories;
use App\Contracts\ProfileRepositoryInterface;
use App\Models\User;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }
}