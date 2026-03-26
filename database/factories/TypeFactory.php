<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Type;

class TypeFactory extends Factory
{
    protected $model = Type::class;

    protected static $types = ['student', 'teacher', 'administrator'];

    public function definition(): array
    {
        $type = array_shift(self::$types);

        if ($type === null) {
            $type = fake()->randomElement(['student', 'teacher', 'administrator']);
        }

        return [
            'type' => $type,
        ];
    }
}
