<?php
namespace App\DataFixtures;

use App\DataFixtures\AppFixtures;
use App\Entity\PublicationReactions;
use Doctrine\Persistence\ObjectManager;

class PublicationReactionsFixtures extends AppFixtures {

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(PublicationReactions::class, 80, function(PublicationReactions $publicationReaction, $count) {
            $publicationReaction->setCreatedAt($this->faker->dateTimeBetween('-1 years', 'now'));
        });
    }
}