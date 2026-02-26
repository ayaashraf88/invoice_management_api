<?php

namespace Database\Factories;

use App\Domain\Tenants\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Tenant::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'slug' => fn(array $attributes) => Str::slug($attributes['name']),
        ];
    }
}
