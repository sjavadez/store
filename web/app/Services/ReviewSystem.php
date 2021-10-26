<?php

namespace App\Services;

use App\Http\Resources\V1\Admin\CommentResource;
use App\Models\Product;

class ReviewSystem
{
    /**
     * @var Product
     */
    private $product;

    public static function create(Product $product)
    {
        $instance = new self();
        $instance->product = $product;
        return $instance;
    }

    public function getApprovedComments()
    {
        return $this->product->getCommentsByStatus('approved');
    }

    public function getApprovedVotes()
    {
        return $this->product->getVotesByStatus('approved');
    }

    public function getCommentCount()
    {
        return $this->product->comments()->where('status', 'approved')->count();
    }

    public function getVoteAvg()
    {
        return $this->product->voteAvg();
    }

    public function getReviewResponse()
    {
        $comments = $this->product->comments()->where('status', 'approved')->take(3)->get();

        return [
            'vote_avg' => $this->getVoteAvg(),
            'comment_count' => $this->getCommentCount(),
            'last_three_comments' => CommentResource::collection($comments),
        ];
    }

    public function checkCommentIsAllowed()
    {
        return $this->product->comment_is_allowed == Product::REVIEW_ALLOWED_TYPE_ALL;
    }

    public function checkVoteIsAllowed()
    {
        return $this->product->vote_is_allowed == Product::REVIEW_ALLOWED_TYPE_ALL;
    }


}
