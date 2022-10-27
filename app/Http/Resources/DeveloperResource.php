<?php

namespace App\Http\Resources;

use App\Models\Review;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class DeveloperResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'firstname' => $this->user->firstname,
            'lastname' => $this->user->lastname,
            'avatar' => $this->avatar,
            'average_rating' => $this->reviews->avg('rating'),
            'stack' => $this->developerStacks->firstWhere('is_primary', 1)->stack->name,
        ];
    }
}
