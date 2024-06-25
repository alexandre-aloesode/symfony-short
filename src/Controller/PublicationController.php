<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Publication;
use App\Form\CreatePublicationFormType;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Attribute\Route;

class PublicationController extends AbstractController
{
    #[Route('/newPublication', name: 'app_new_publication')]

    public function newPublication(Request $request): Response
    {
        $publication = new Publication();
        $publication->setTitle('Write a title here');
        $publication->setContent('Write a content here');
        $publication->setCreatedAt(new \DateTime('now'));
        $publication->setUrl('Write a url here');

        $form = $this->createForm(CreatePublicationFormType::class, $publication);

        return $this->render('publication/new.html.twig', [
            'newPublicationForm' => $form,
        ]);
    }
}
