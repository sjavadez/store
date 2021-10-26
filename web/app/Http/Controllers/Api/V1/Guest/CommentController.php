<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Guest\CommentRequest;
use App\Models\Product;
use App\Services\ReviewSystem;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Product $product)
    {
        if (ReviewSystem::create($product)->checkCommentIsAllowed()) {
            abort(403);
        }

        $product->comments()->create($request->all());

        return $this->successResponse([],'Comment saved.');
    }
}
