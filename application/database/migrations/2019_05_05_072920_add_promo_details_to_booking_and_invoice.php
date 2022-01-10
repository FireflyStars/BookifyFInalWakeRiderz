<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPromoDetailsToBookingAndInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('promo_used')->nullable();
            $table->string('promo_discount')->nullable();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->string('promo_used')->nullable();
            $table->string('promo_discount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('promo_used');
            $table->dropColumn('promo_discount');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('promo_used');
            $table->dropColumn('promo_discount');
        });
    }
}
