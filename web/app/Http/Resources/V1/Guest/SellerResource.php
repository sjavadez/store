<?php

namespace App\Http\Resources\V1\Guest;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property mixed $company
 * @property mixed $status
 * @property mixed $created_at
 */
class SellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'company'    => $this->company,
            'status'     => $this->status,
            'created_at' => $this->created_at
        ];
    }
}
