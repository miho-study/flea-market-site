<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {

            // 郵便番号を追加
            $table->string('shipping_postcode')->after('product_id');

            // 建物名を追加
            $table->string('shipping_building')
                  ->nullable()
                  ->after('shipping_address');
        });
    }

    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_postcode',
                'shipping_building',
            ]);
        });
    }
};
