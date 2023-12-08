<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Database\Factories\PaymentMethodFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::factory()->createMany([
            [
                'name' => 'Paypal',
            ],
            [
                'name' => 'Credit Card',
            ],
            [
                'name' => 'Cash',
            ],
            [
                'name' => 'Bank Transfer',
            ],
            [
                'name' => 'Other',
            ]
        ]);
    }
}
