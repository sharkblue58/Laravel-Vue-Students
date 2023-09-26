<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'name' => $this->name,
            'course' => $this->course,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' =>Carbon::parse($this->created_at)->format('d-m-Y') ,
        ];
    }
}
