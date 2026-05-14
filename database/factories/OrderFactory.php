<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $orderDate = $this->faker->dateTimeBetween('-4 months', 'now');
        $status = $this->faker->randomElement(['draft', 'confirmed', 'processing', 'ready', 'delivered', 'completed']);
        
        return [
            'order_number' => 'ORD-' . $orderDate->format('Ymd') . '-' . $this->faker->unique()->numberBetween(100, 999),
            'customer_id' => Customer::factory(),
            'created_by' => User::first()?->id ?? User::factory(),
            'status' => $status,
            'order_date' => $orderDate,
            'requested_delivery_date' => (clone $orderDate)->modify('+2 days'),
            'subtotal' => 0, // Will be calculated by items or seeder
            'discount_amount' => 0,
            'total_amount' => 0,
            'estimated_cogs' => 0,
            'estimated_profit' => 0,
            'notes' => $this->faker->optional()->sentence(),
            'created_at' => $orderDate,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'actual_delivery_date' => (clone $attributes['order_date'])->modify('+3 days'),
        ]);
    }
}
