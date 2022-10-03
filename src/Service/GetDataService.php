<?php

namespace App\Service;

use DateTime;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetDataService
{
    private $client;


    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;

    }

    public function fromGouv(): string {
        $response =$this->client->request(
            'GET',
            'https://www.data.gouv.fr/fr/datasets/r/b39196f2-97c4-42f4-8dee-5eb07e823377'
        );

        $lastData= array_key_last($response->toArray());
        $date = new DateTime($response->toArray()[$lastData]['date']);
        $nombre =$response->toArray()[$lastData]['total_vaccines'];

        return 'Au' . $date->format('d/m/Y') . ', il ya'.$nombre . 'personne vaciné en france !' ;
    }


}