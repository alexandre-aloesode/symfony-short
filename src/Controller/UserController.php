<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CreateUserFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\UserImages;
use Doctrine\Common\Collections\ArrayCollection;

class UserController extends AbstractController
{
    public function getUsers(EntityManagerInterface $entityManager)
    {

        $users = $entityManager->getRepository(User::class)->findAll();

        return $users;
    }
}
