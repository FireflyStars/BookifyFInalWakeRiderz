<?php

namespace App\Imports;

use App\CouponCode;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CouponCodeImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        $coupon =  new CouponCode;

        $coupon->name = $row['name'];
        $coupon->code = $row['code'];
        $coupon->percentage = $row['percentage'];
        $coupon->max_uses = $row['max_uses'];
        $coupon->used = $row['used'];
        $coupon->valid_from = $row['valid_from'];
        $coupon->valid_to = $row['valid_to'];

        $coupon->save();

        $categories = explode(",", $row['category_id']);

        foreach ($categories as $category)
        {
            $coupon->categories()->attach($category);
        }

        return $coupon;
    }
}
