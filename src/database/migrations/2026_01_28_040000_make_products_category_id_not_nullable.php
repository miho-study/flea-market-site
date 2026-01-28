<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('products', 'category_id')) {
            $defaultCategoryId = DB::table('categories')->min('id');
            if (! $defaultCategoryId) {
                $defaultCategoryId = DB::table('categories')->insertGetId([
                    'category_name' => '未設定',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('products')
                ->whereNull('category_id')
                ->update(['category_id' => $defaultCategoryId]);

            DB::statement('ALTER TABLE products MODIFY category_id BIGINT UNSIGNED NOT NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'category_id')) {
            DB::statement('ALTER TABLE products MODIFY category_id BIGINT UNSIGNED NULL');
        }
    }
};
