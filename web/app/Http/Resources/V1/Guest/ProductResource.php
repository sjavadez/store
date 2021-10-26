<?php

namespace App\Http\Resources\V1\Guest;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    private $reviews;
    private $prices;

    public function __construct($resource, $reviews, $prices)
    {
        parent::__construct($resource);
        $this->reviews =  $reviews;
        $this->prices = $prices;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'reviews' => $this->reviews,
            'prices' => $this->prices
        ];
    }
}
