<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'bio' => $this->bio,
            'website' => $this->website,
            'github_username' => $this->github_username,
            'twitter_username' => $this->twitter_username,
            'is_public' => $this->is_public,
            'created_at' => $this->created_at,
        ];
    }
}
