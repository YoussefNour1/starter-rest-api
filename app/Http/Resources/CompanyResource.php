<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'company_name' => $this->company_name,
            'company_address'=> $this->comapny_address,
            'company_location'=>$this->company_location,
            'company_industry'=>$this->company_industry,
            'company_size'=>$this->company_size,
            'logo'=>$this->logo,
            'logo_path'=>$this->logo_path,
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
