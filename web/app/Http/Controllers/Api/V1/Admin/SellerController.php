<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\SellerRequest;
use App\Http\Resources\V1\Admin\SellerResource;
use App\Models\Seller;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return SellerResource::collection(Seller::paginate($request->get('per_page' , 10)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SellerRequest $sellerRequest
     * @return SellerResource
     */
    public function store(SellerRequest $sellerRequest): SellerResource
    {
        $seller = Seller::create($sellerRequest->validated());
        return new SellerResource($seller);
    }

    /**
     * Display the specified resource.
     *
     * @param Seller $seller
     * @return SellerResource
     */
    public function show(Seller $seller): SellerResource
    {
        return new SellerResource($seller);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SellerRequest $sellerRequest
     * @param Seller $seller
     * @return SellerResource
     */
    public function update(SellerRequest $sellerRequest, Seller $seller): SellerResource
    {
        $seller->update($sellerRequest->validated());
        return new SellerResource($seller);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Seller $seller
     * @return JsonResponse
     */
    public function destroy(Seller $seller): JsonResponse
    {
        $seller->update([
            'status' => Seller::STATUS_INACTIVE
        ]);
        return response()->json([
            'message' => 'seller was in active'
        ]);
    }
}
