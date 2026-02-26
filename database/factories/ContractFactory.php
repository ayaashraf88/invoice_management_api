<?php

namespace Database\Factories;

use App\Domain\Contracts\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Contract::class;
    public function definition(): array
    {
       
        return [
            'unit_name'=>$this->faker->sentence(),
            'customer_name'=>$this->faker->name(),
            'rent_amount'=>$this->faker->numberBetween(1000,5000),
            'start_date'=>$this->faker->date(),
            'end_date'=>$this->faker->date(),
            'status'=>$this->faker->randomElement(['active','terminated','pending']),
            
        ];
    }
}
