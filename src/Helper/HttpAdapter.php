<?php

namespace SeoStats\Helper;

use Guzzle\Http\Client as HttpClient;

class HttpAdapter
{
    const HTTP_METHODE_GET    = 'get';
    const HTTP_METHODE_POST   = 'post';
    const HTTP_METHODE_PUT    = 'put';
    const HTTP_METHODE_DELETE = 'delete';

    protected $allowedMethodes = array(
      self::HTTP_METHODE_GET,
      self::HTTP_METHODE_POST,
      self::HTTP_METHODE_DELETE,
      self::HTTP_METHODE_PUT
    );

    /**
     * @var HttpClient
     */
    protected $client;

    public function sendRequest($httpMethode, $url, $headers = null, $body = null, $options = array())
    {
        $client = $this->getClient();

        if (in_array($httpMethode, $allowedMethodes)) {
            throw new \RuntimeMethodeIsNotAllowed();
        }

        return $client->createRequest($httpMethode, $url, $headers, $body, $options)->send();
    }

    public function getClient ()
    {
        if (! isset($this->client)) {
            $this->client = new HttpClient();
        }

        return $this->client;
    }

    public function setClient (HttpClient $client)
    {
        $this->client = $client;
    }
}
