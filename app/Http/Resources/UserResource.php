<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property mixed $contact_person_phone_number
 * @property mixed $email
 * @property mixed $name
 * @property mixed $id
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    #[ArrayShape(["id"=>"mixed", "name" => "mixed", "email" => "mixed", "contact_person_phone_number" => "mixed"])]
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "contact_person_phone_number" => $this->contact_person_phone_number
        ];
    }
}
