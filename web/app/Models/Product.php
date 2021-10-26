<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    const REVIEW_ALLOWED_TYPE_ALL = 'all';
    const REVIEW_ALLOWED_TYPE_BUYER = 'buyer';
    const REVIEW_ALLOWED_TYPE_NONE = 'none';

    const REVIEW_ALLOWED_TYPES = [
        self::REVIEW_ALLOWED_TYPE_ALL,
        self::REVIEW_ALLOWED_TYPE_BUYER,
        self::REVIEW_ALLOWED_TYPE_NONE,
    ];

    protected $fillable = [
        'name',
        'description',
        'comment_is_allowed',
        'vote_is_allowed',
        'active'
    ];


    /**
     * @return BelongsToMany
     */
    public function seller(): BelongsToMany
    {
        return $this->belongsToMany(Seller::class , 'product_seller')
            ->withPivot('price');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function getVotesByStatus(string $status)
    {
        return $this->votes()->where('status' , $status)->get();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getCommentsByStatus(string $status)
    {
        return $this->comments()->where('status' , 'approved')->get();
    }

    public function voteAvg()
    {
        return $this->votes()->where('status', 'approved')->avg('rate') ?:0;
    }

}
