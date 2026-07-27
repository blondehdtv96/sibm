<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffProfileImageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'url' => $this->image_url,
            'thumbnail_url' => $this->thumbnail_url,
            'caption' => $this->caption,
        ];
    }
}
