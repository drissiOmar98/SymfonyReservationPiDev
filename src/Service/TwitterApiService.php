<?php

namespace App\Service;

use Abraham\TwitterOAuth\TwitterOAuth;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TwitterApiService
{
    private $getParams;

    public function __construct(ParameterBagInterface $getParams)
    {
        $this->getParams = $getParams;
    }

    public function post(string $content)
    {
        $consumerKey = $this->getParams->get('TWITTER_CONSUMER_KEY');
        $consumerSecret = $this->getParams->get('TWITTER_CONSUMER_SECRET');
        $accesToken = $this->getParams->get('TWITTER_ACCESS_TOKEN');
        $accesTokenSecret = $this->getParams->get('TWITTER_ACCESS_TOKEN_SECRET');
        $connection = new TwitterOAuth($consumerKey, $consumerSecret, $accesToken, $accesTokenSecret);
        $connection->post("statuses/update", ["status" => $content]);
    }
}