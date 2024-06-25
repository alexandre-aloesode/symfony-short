<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use APP\Third_Party\ArticleGetter;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Publication;
use App\Entity\PublicationImages;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\PublicationController;
use App\Form\CreatePublicationFormType;
use Symfony\Component\HttpFoundation\Request;



class FeedController extends AbstractController
{
    #[Route('/feed', name: 'app_feed')]
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

            return $this->redirectToRoute('app_feed');
        }
        return $this->render('feed/index.html.twig', [
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
