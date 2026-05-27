<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use Faker\Generator;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $ingredients = [];
        for ($i = 1; $i <= 50; $i++) {
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word())
                ->setPrice(mt_rand(1, 199));
            $manager->persist($ingredient);
            $ingredients[] = $ingredient;
        }

        for ($i = 1; $i <= 50; $i++) {
            $recipe = new Recipe();
            $recipe->setName($this->faker->word())
                ->setDescription($this->faker->sentence())
                ->setIsFavorite($this->faker->boolean())
                ->setTime($this->faker->numberBetween(10, 45))
                ->setNbPersons($this->faker->numberBetween(1, 6))
                ->setDifficulty($this->faker->numberBetween(1, 5))
                ->setPrice($this->faker->numberBetween(10, 200));

            $randomIngredients = $this->faker->randomElements($ingredients, $this->faker->numberBetween(1, 5));
            foreach ($randomIngredients as $ingredient) {
                $recipe->addIngredient($ingredient);
            }

            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
