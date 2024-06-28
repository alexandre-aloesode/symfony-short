<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Publication;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CreatePublicationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\PublicationImages;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\User;

class FeedController extends AbstractController
{
    #[Route('/feed', name: 'app_feed')]

    public function getPublications(EntityManagerInterface $entityManager): Response
    {
        // $users = $entityManager->getRepository(User::class)->findAll();

        // var_dump($users);
        $publications = $entityManager->getRepository(Publication::class)->findAll();

        foreach ($publications as $publication) {

            // $publicationUser = $publication->getUserId();
            // var_dump($publicationUser);
            // var_dump($publicationUser->getEmail());
            // var_dump($publicationUser->getId());
            // $publication->setUserId($publicationUser->getUsername());

            $publicationImages = $entityManager->getRepository(PublicationImages::class)->findBy(['publication' => $publication->getId()]);
            if ($publicationImages) {
                $collection = new ArrayCollection();
                foreach ($publicationImages as $image) {
                    $collection->add($image);
                }
                $publication->setPublicationImages($collection);
            }
        }

        return $this->render('feed/index.html.twig', [
            'allPublications' => $publications,
        ]);
    }

    #[Route('/new_publication', name: 'app_new_publication')]
    public function newPublication(Request $request, EntityManagerInterface $entityManager): Response
    {
        $publication = new Publication();

        $form = $this->createForm(CreatePublicationFormType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publication->setUserId($this->getUser());
            $publication->setTitle($form->get('title')->getData());
            $publication->setContent($form->get('content')->getData());
            $publication->setCreatedAt(new \DateTime());

            $entityManager->persist($publication);
            $entityManager->flush();

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $saveFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                // $safeFilename = $slugger->slug($originalFilename);
                try {
                    $imageFile->move(
                        // $this->getParameter('publication_images_directory'),
                        $this->getParameter('kernel.project_dir') . '/assets/images/publication_images',
                        $saveFilename
                    );
                    $imageObj = new PublicationImages();
                    $imageObj->setImage($saveFilename);
                    $imageObj->setTitle($originalFilename);
                    $imageObj->setCreatedAt(new \DateTime());
                    $imageObj->setPublicationId($publication);
                    $entityManager->persist($imageObj);
                    $entityManager->flush();
                } catch (FileException $e) {
                    // ... handle exception if something happens during                     // return new Response($e);
                }


                // $publication->setImageFilename($saveFilename);
            }

            // var_dump($publication);

            return $this->redirectToRoute('app_feed');
        }
        return $this->render('feed/newPublication.html.twig', [
            'newPublicationForm' => $form,
        ]);
    }


    // public function index(): Response
    // {
    //     if ($this->getUser() == null)
    //         return $this->redirectToRoute('app_login');

    // $client = HttpClient::create();
    // $response = $client->request(
    //     'GET',
    //     // 'https://newsapi.org/v2/everything?q=Apple&from=2024-06-25&sortBy=popularity&apiKey=dacda3723dd945828bd93a04408905a1'
    //     // 'https://newsapi.org/v2/everything?from=2024-06-24&to=2024-06-24&sortBy=popularity&apiKey=dacda3723dd945828bd93a04408905a1'
    //     // 'https://newsapi.org/v2/everything?q=Apple&from=2024-06-25&sortBy=popularity&apiKey=dacda3723dd945828bd93a04408905a1'
    // 'https://newsapi.org/v2/top-headlines?sources=bbc-news&apiKey=dacda3723dd945828bd93a04408905a1'
    // );
    // $result = $response->toArray();
    //         if($result['status'] == 'ok' && count($result['articles']) > 0){
    //             $articles = $result['articles'];
    // //I want to store all the articles in the Publication Entity
    //             foreach($articles as $article){
    //                 $publication = new Publication();
    //                 $publication->setTitle($article['title']);
    //                 $publication->setUrl($article['url']);
    //                 $image = new PublicationImages();
    //                 $image->setImage($article['urlToImage']);
    //                 $image->setTitle($article['title']);
    //                 $image->setCreatedAt(new \DateTime($article['publishedAt']));
    //                 $publication->addPublicationImage($image);
    //                 $publication->setCreatedAt(new \DateTime($article['publishedAt']));
    //                 $publication->setContent($article['content']);
    //                 $publication->setUserId($this->getUser());
    //                 // $object = new PublicationController();

    //             }
    //         }
    // $articleGetter = new ArticleGetter();
    // $articles = $articleGetter->getArticles();
    // var_dump($articles);

    //     return $this->render('feed/index.html.twig', [
    //         'controller_name' => 'FeedController',
    //         // 'articles' => $response->toArray(),
    //     ]);
    // }
}
