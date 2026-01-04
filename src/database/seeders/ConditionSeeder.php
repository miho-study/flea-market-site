<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    $conditions = [
        '新品・未使用',
        '未使用に近い',
        '目立った傷や汚れなし',
        '傷や汚れあり',
    ];

    foreach ($conditions as $name) {
        Condition::create(['name' => $name]);
    }
}
}
