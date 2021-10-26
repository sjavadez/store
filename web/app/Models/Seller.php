<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static paginate(mixed $get)
 * @method static create(array $validated)
 * @method static find($seller_id)
 * @property mixed $id
 */
class Seller extends Model
{
    use HasFactory;

    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';

    const STATUES = [
      self::STATUS_ACTIVE,
      self::STATUS_INACTIVE,
    ];

    protected $fillable = [
        'company',
        'status'
    ];


    /**
     * @var string[]
     */
    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class , 'product_seller')
            ->withPivot('price');
    }
}
