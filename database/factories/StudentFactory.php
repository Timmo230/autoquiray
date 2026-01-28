<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'user_id' => function () {
                $user = User::whereIn('type', 'student')
                ->whereDoesntHave('student')
                ->first();

                if (!$user) {
                throw new \Exception("Error: No quedan usuarios de tipo 'student' sin perfil asignado en la base de datos.");
                }
                return $user->id;
            },
        ];
    }
}