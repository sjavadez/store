<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\VoteRequest;
use App\Http\Resources\V1\Admin\VoteResource;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index(Request $request)
    {
        $comments = Vote::query()->latest()->paginate($request->get('per_page' , 10));

        return VoteResource::collection($comments);
    }

    public function update(VoteRequest $request, Vote $vote)
    {
        $vote->update($request->all());

        return new VoteResource($vote);
    }
}
