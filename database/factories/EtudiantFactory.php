<?php

namespace Database\Factories;

use App\Models\Sexe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etudiant>
 */
class EtudiantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'cin' => strtoupper($this->faker->bothify('??######')),
            'date_naissance' => $this->faker->date(),
            'adresse' => $this->faker->address,
            'telephone' => $this->faker->phoneNumber,
            'sexe_id' => Sexe::inRandomOrder()->first()->id,
        ];
    }
}
