<?php
namespace App\DataFixtures;

use App\DataFixtures\AppFixtures;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AppFixtures {

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 30, function(User $user, $count) {
            $user->setEmail($this->faker->email);
            $user->setPassword($this->faker->password);
            $user->setUsername($this->faker->userName);
            $user->setFirstname($this->faker->firstName);
            $user->setLastname($this->faker->lastName);
            $user->setBirthdate($this->faker->dateTimeBetween('-40 years', '-18 years'));
        });
    }
}