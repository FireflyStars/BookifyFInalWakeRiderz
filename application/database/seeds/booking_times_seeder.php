<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class booking_times_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('booking_times')->insert([
            'id' => 1,
            'day' => __('backend.mon'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('booking_times')->insert([
            'id' => 2,
            'day' => __('backend.tue'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('booking_times')->insert([
            'id' => 3,
            'day' => __('backend.wed'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('booking_times')->insert([
            'id' => 4,
            'day' => __('backend.thu'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('booking_times')->insert([
            'id' => 5,
            'day' => __('backend.fri'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('booking_times')->insert([
            'id' => 6,
            'day' => __('backend.sat'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('booking_times')->insert([
            'id' => 7,
            'day' => __('backend.sun'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
