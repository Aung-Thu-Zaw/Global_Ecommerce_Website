<?php

namespace App\Actions\Seller\ProductBanners;

use App\Models\SellerProductBanner;
use App\Services\UploadFiles\ProductBannerImageUploadService;

class UpdateSellerProductBannerAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data, SellerProductBanner $sellerProductBanner): void
    {
        $image = isset($data['image']) ? (new ProductBannerImageUploadService())->updateImage($data['image'], $sellerProductBanner->image) : $sellerProductBanner->image;

        $sellerProductBanner->update([
            'seller_id' => $data['seller_id'],
            'url' => $data['url'],
            'status' => $data['status'],
            'image' => $image,
        ]);
    }
}
