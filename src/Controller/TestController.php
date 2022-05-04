<?php

namespace App\Controller;

use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    //private $apiKey;

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        //$this->apiKey = $apiKey;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[NoReturn] #[Route('/test', name: 'app_test')]
    public function getPopular()
    {
        $response = $this->client->request(

            'GET',
            'https://api.themoviedb.org/3/movie/popular?api_key=ddec886742429cd922ebad0010e96c2d&language=fr'
        );

        $dataPopularMovies = $response->toArray();
/*dd($dataPopularMovies);*/
        return $this->render('test/index.html.twig',[

            'dataPopularMovies' => $dataPopularMovies["results"]

        ]);
       
     
    }
}
