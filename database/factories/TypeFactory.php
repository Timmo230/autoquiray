<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Type;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class typeFactory extends Factory
{
    protected $model = Type::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $types = ['student', 'teacher', 'administrator'];
    public function definition(): array
    {
        $type = array_shift(self::$types);
        return [
            'type' => $type,
        ];
    }
}
