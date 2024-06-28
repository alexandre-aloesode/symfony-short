<?php
namespace App\DataFixtures;

use App\DataFixtures\AppFixtures;
use App\Entity\PublicationImages;
use Doctrine\Persistence\ObjectManager;

class PublicationImagesFixtures extends AppFixtures {

    protected $imageName = ['cards', 'color', 'numbers', 'origami', 'rocks', 'sky', 'street', 'suit', 'water'];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(PublicationImages::class, 20, function(PublicationImages $publicationImage, $count) {
            $publicationImage->setImage($this->faker->randomElement($this->imageName) . '.jpg');
            $publicationImage->setCreatedAt($this->faker->dateTimeBetween('-1 years', 'now'));
            $publicationImage->setTitle($this->faker->sentence(6));
        });
    }
}