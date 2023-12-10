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
        Customer::factory()->count(438)->create()->each(function ($customer) use ($products, $categories, $payments) {
            $order_random_count = rand(1, 9);
            foreach (range(1, $order_random_count) as $index) {
                $item_random_count = rand(1, 6);
                $order = Order::factory()->create([
                    'customer_id' => $customer->id,
                    'payment_method' => fake()->randomElement($payments),
                    'created_at' => fake()->dateTimeBetween('-2 year', 'now'),
                ]);
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
            }
        });
    }
}
