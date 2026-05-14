<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $tokoPrefix = ['Toko', 'Warung', 'Kios', 'Agen', 'Grosir'];
        $tokoSuffix = ['Barokah', 'Makmur', 'Jaya', 'Sejahtera', 'Berkah', 'Abadi', 'Rejeki'];
        
        $namaToko = $this->faker->randomElement($tokoPrefix) . ' ' . $this->faker->randomElement($tokoSuffix);
        $namaPemilik = $this->faker->name();
        
        return [
            'code' => 'CST-' . $this->faker->unique()->numberBetween(100, 999),
            'nama_toko' => $namaToko,
            'nama_pemilik' => $namaPemilik,
            'no_whatsapp' => '8' . $this->faker->numberBetween(100000000, 999999999),
            'alamat_pasar' => 'Pasar ' . $this->faker->city() . ', Blok ' . $this->faker->bothify('??-##'),
            'status_langganan' => $this->faker->randomElement(['reguler', 'prioritas']),
            'credit_limit' => $this->faker->randomElement([0, 5000000, 10000000, 25000000]),
            'notes' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }

    /**
     * VIP Customer state
     */
    public function prioritas(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_langganan' => 'prioritas',
            'credit_limit' => 50000000,
        ]);
    }
}
