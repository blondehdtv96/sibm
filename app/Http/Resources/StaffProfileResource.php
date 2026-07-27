<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffProfileResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->display_name,
            'slug' => $this->slug,
            'position' => $this->position,
            'category' => $this->category,
            'department' => $this->jurusan,
            'subjects' => $this->subjects,
            'employment_status' => $this->employment_status,
            'photo_url' => $this->photo_url,
            'bio' => $this->bio,
            'motto' => $this->motto,
            'gallery' => StaffProfileImageResource::collection($this->whenLoaded('activeImages')),
        ];
    }
}
