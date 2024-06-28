<?php
namespace App\DataFixtures;

use App\DataFixtures\AppFixtures;
use App\Entity\PublicationComments;
use Doctrine\Persistence\ObjectManager;

class PublicationCommentsFixtures extends AppFixtures {

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(PublicationComments::class, 60, function(PublicationComments $publicationComment, $count) {
            $publicationComment->setContent($this->faker->text(70));
            $publicationComment->setCreatedAt($this->faker->dateTimeBetween('-1 years', 'now'));
        });
    }
}