<?php

namespace App\Actions\Admin\Coupons;

use App\Models\Coupon;

class UpdateCouponAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, Coupon $coupon): void
    {
        $coupon->update([
            "code"=>$data["code"],
            "discount_type"=>$data["discount_type"],
            "discount_amount"=>$data["discount_amount"],
            "min_spend"=>$data["min_spend"],
            "start_date"=>$data["start_date"],
            "end_date"=>$data["end_date"],
            "max_uses"=>$data["max_uses"],
        ]);
    }
}
