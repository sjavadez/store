<?php


namespace App\Services;


use App\Http\Resources\V1\Guest\SellerResource;
use App\Models\Product;
use App\Models\Seller;

/**
 * Class InquirySystem
 * To query the price based on the product
 *
 * @package App\Services
 * @version 1.0
 */
class InquirySystem
{
    /**
     * @var
     */
    private $product;

    /**
     * @param Product $product
     * @return InquirySystem
     */
    public static function create(Product $product): InquirySystem
    {
        $instance = new self();
        $instance->product = $product;
        return $instance;
    }

    /**
     * @return array
     */
    public function inquiry(): array
    {
        $data = [];
        if (empty($this->product->seller)){
            return [
                'message' => 'seller not found '
            ];
        }
        foreach ($this->product->seller()->where('status', 'active')->get() as $seller) {
            $data[] = [
                'seller' => new SellerResource($seller),
                'price' => $seller->pivot->price
            ];
        }
        return $data;
    }

    /**
     * @param Seller $seller
     * @return array
     */
    public function inquiryPerSeller(Seller $seller): array
    {
        $productSeller = $this->product
                              ->seller()
                              ->where('status', 'active')
                              ->where('seller_id', $seller->id)
                              ->first();
        if (empty($productSeller)){
            return [
                'message' => 'seller not found '
            ];
        }
        return [
            'seller' => new SellerResource($seller),
            'price' => $productSeller->pivot->price
        ];
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }

}
