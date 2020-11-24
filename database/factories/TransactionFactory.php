<?php

namespace Database\Factories;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'title' => 'Payment to ' . $this->faker->name,
            'amount' => random_int(10, 500),
            'status' => Arr::random(['success', 'processing', 'failed']),
            'date' => Carbon::now()->subDays(random_int(1, 365))->startOfDay(),
        ];
    }
}
