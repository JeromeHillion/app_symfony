<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
{
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
    public function getPopularMovies(): array
    {
        $response = $this->client->request(

            "GET",
            "https://api.themoviedb.org/3/discover/movie?api_key=ddec886742429cd922ebad0010e96c2d&language=fr-FR&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_watch_monetization_types=flatrate"
        );


        return $response->toArray();


    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getPopularTvShow(): array
    {
        $response = $this->client->request(

            "GET",
            "https://api.themoviedb.org/3/discover/tv?api_key=ddec886742429cd922ebad0010e96c2d&language=fr-FR&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_watch_monetization_types=flatrate"
        );


        return $response->toArray();


    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getDatas(): array
    {

        $popularMovies = $this->getPopularMovies()['results'];
        $popularTvShows = $this->getPopularTvShow()['results'];
        $datas = [];
        shuffle($popularMovies);
        foreach ($popularMovies as $popularMovie) {

            $datas[] = [
                "id" => $popularMovie['id'],
                "poster_path" => $popularMovie['poster_path'],
                "title" => $popularMovie['title'],
                "slug" => 'film',
                "release_date" => $popularMovie['release_date']
            ];

        }
        foreach ($popularTvShows as $popularTvShow) {

            $datas[] = [
                "id" => $popularTvShow['id'],
                "poster_path" => $popularTvShow['poster_path'],
                "title" => $popularTvShow['name'],
                "slug" => 'tv',
                "release_date" => $popularTvShow['first_air_date']
            ];

        }
        return $datas;


    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getPopular(): array
    {

        $arrToShuffle = $this->getDatas();

        shuffle($arrToShuffle);
        $popular = [];

        foreach ($arrToShuffle as $data) {
            $popular[]= $data;
        }
        return $popular;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getInfosById(string $category,int $id): array
    {
        $response = $this->client->request(

            "GET",
            "https://api.themoviedb.org/3/{$category}/{$id}?api_key=ddec886742429cd922ebad0010e96c2d&language=fr-FR"
        );


        return $response->toArray();
    }
}