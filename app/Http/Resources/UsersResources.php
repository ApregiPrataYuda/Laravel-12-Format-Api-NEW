<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            // 'projects' => $this->projects,
            'projects' => json_decode($this->projects, true),
            'created_at' => $this->created_at?->toDateString() ?? '-',
            'updated_at' => $this->updated_at?->toDateString() ?? '-',
        ];
    }
}
