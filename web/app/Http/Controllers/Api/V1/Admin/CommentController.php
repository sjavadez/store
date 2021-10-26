<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\CommentRequest;
use App\Http\Resources\V1\Admin\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::query()->latest()->paginate($request->get('per_page' , 10));

        return CommentResource::collection($comments);
    }

    public function update(CommentRequest $request, Comment $comment)
    {

        $comment->update($request->all());

        return new CommentResource($comment);
    }
}
