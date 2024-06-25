<?php
namespace App\Third_Party;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ArticleGetter
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function getArticles(): array
    {
        $response = $this->client->request(
            'GET',
            'https://newsapi.org/v2/everything?q=Apple&from=2024-06-25&sortBy=popularity&apiKey=dacda3723dd945828bd93a04408905a1'
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }
}