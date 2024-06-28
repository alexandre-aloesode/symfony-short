<?php
namespace App\DataFixtures;

use App\DataFixtures\AppFixtures;
use App\Entity\Publication;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\UserRepository;
use App\Controller\UserController;

class PublicationFixtures extends AppFixtures {

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadData(ObjectManager $manager)
    {
        // $this->entityManager = new EntityManagerInterface();
        $this->createMany(Publication::class, 20, function(Publication $publication, $count) {
            // $publication->setUserId($this->getReference('App\Entity\User_' . $this->faker->numberBetween(1, 30)));
            
            // $publication->setUserID($entityManager->getRepository(User::class)->find($this->faker->numberBetween(1, 30)));
            
            // $user = $this->getDoctrine()->getRepository(User::class)->find($id);

            // $user = $this->entityManager->getRepository(User::class)->find($this->faker->numberBetween(1, 30));
            // $user = $this->entityManager->getRepository(User::class)->findAll();

            // var_dump($user);
            

            // $user = new User();
            // $user = $user->findOneById($this->faker->numberBetween(1, 30));

            // $userRepo = new UserRepository();

            // $users = new UserController();
            // $user = $users->getUsers($this->entityManager);
            // var_dump($user);

            // $publication->setUserId($this->faker->numberBetween(1, 30));

            // $user = new User();
            // $user->setId($this->faker->numberBetween(1, 30));
            // $publication->setUserId($user);
            $publication->setTitle($this->faker->sentence(6));
            $publication->setContent($this->faker->text(200));
            $publication->setCreatedAt($this->faker->dateTimeBetween('-1 years', 'now'));
        });
    }
}