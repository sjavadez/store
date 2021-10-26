<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Guest\ProductResource;
use \App\Http\Resources\V1\Admin\ProductResource as AdminProductResource;
use App\Models\Product;
use App\Models\Seller;
use App\Services\InquirySystem;
use App\Services\ReviewSystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()->with(['comments', 'votes'])->where('active', true)->paginate($request->get('per_page' , 10));

        return AdminProductResource::collection($products);
    }

    public function show(Product $product)
    {
        if (!$product->active) {
            abort(404, 'not found!');
        }

        $reviews = ReviewSystem::create($product)->getReviewResponse();
        $prices =  InquirySystem::create($product)->inquiry();


        return new ProductResource($product, $reviews, $prices);
    }

    public function sellerPrices(Product $product, Seller $seller): JsonResponse
    {
        $data = InquirySystem::create($product)->inquiryPerSeller($seller);
        return response()->json($data);
    }
}
