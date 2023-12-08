<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all()->pluck('id')->toArray();
        $payments = PaymentMethod::all()->pluck('id')->toArray();
        $products = Product::select('id', 'price')->get()->toArray();
        Customer::factory()->count(8)->create()->each(function ($customer) use ($products, $categories, $payments) {
            $order_random_count = rand(1, 6);
            foreach (range(1, $order_random_count) as $index) {
                $item_random_count = rand(1, 4);
                Order::factory()->create([
                    'customer_id' => $customer->id,
                    'payment_method' => fake()->randomElement($payments),
                    'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
                ])->each(function ($order) use ($products, $item_random_count, $categories) {
                    foreach (range(1, $item_random_count) as $index) {
                        $product = fake()->randomElement($products);
                        OrderItem::factory()->create([
                            'order_id' => $order->id,
                            'product_id' => $product['id'],
                            'price' => $product['price'],
                            'quantity' => rand(1, 10),
                            'discount' => rand(0, 15),
                            'created_at' => $order->created_at,
                        ]);
                    }
                });
            }
        });
    }
}
