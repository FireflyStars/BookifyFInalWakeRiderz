<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('invoice_notes')->nullable();
            $table->text('invoice_terms')->nullable();
            $table->float('stripe_processing_fee')->nullable();
            $table->float('paypal_processing_fee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('invoice_notes');
            $table->dropColumn('invoice_terms');
            $table->dropColumn('stripe_processing_fee');
            $table->dropColumn('paypal_processing_fee');
        });
    }
}
