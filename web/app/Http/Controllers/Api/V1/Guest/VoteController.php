<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Guest\VoteRequest;
use App\Models\Product;
use App\Services\ReviewSystem;

class VoteController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(VoteRequest $request, Product $product)
    {
        if (ReviewSystem::create($product)->checkVoteIsAllowed()) {
            abort(403);
        }

        if ($vote = $product->votes()->where('user_id', $request->user()->id)->first()) {
            $vote->update($request->all());
        } else {
            $product->votes()->create($request->all());
        }

        return $this->successResponse([],'vote saved');
    }
}
