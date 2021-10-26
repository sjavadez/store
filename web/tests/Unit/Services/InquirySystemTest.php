<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Models\Seller;
use App\Services\InquirySystem;
use Tests\TestCase;

class InquirySystemTest extends TestCase
{
    /** @test */
    function get_active_sellers_price_successful()
    {
        $randomPrice = random_int(1, 99999);
        $product = Product::factory()->create();
        $seller = Seller::factory()->create();
        $product->seller()->attach([['seller_id' => $seller->id, 'price' => $randomPrice]]);

        $price = InquirySystem::create($product)->inquiry();

        $this->assertEquals($randomPrice, $price[0]['price']);
    }

    /** @test */
    function ignore_non_active_seller_price()
    {
        $randomPrice = random_int(1, 99999);
        $product = Product::factory()->create();
        $seller = Seller::factory()->create(['status'=> 'inactive']);
        $product->seller()->attach([['seller_id' => $seller->id, 'price' => $randomPrice]]);

        $price = InquirySystem::create($product)->inquiry();

        self::assertEquals([],$price);
    }

    /** @test */
    function get_product_price_by_seller_successful()
    {
        $randomPrice = random_int(1, 99999);
        $product = Product::factory()->create();
        $seller = Seller::factory()->create();
        $product->seller()->attach([['seller_id' => $seller->id, 'price' => $randomPrice]]);

        $price = InquirySystem::create($product)->inquiryPerSeller($seller);

        self::assertEquals($randomPrice, $price['price']);
    }

    /** @test */
    function show_error_if_product_has_no_price_for_seller()
    {
        $randomPrice = random_int(1, 99999);
        $product = Product::factory()->create();
        $seller = Seller::factory()->create(['status'=> 'inactive']);
        $product->seller()->attach([['seller_id' => $seller->id, 'price' => $randomPrice]]);

        $price = InquirySystem::create($product)->inquiryPerSeller($seller);

        self::assertEquals('seller not found ', $price['message']);
    }
}
