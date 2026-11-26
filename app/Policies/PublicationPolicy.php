<?php

namespace App\Policies;

use App\Models\Publication;
use App\Models\User;

class PublicationPolicy
{
    public function update(User $utilisateur, Publication $publication): bool
    {
        return $utilisateur->id === $publication->user_id || $utilisateur->role === 'admin';
    }

    public function delete(User $utilisateur, Publication $publication): bool
    {
        return $this->update($utilisateur, $publication);
    }
}