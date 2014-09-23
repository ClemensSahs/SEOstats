<?php

namespace SeoStats\V3\HttpAdapter;

use Guzzle\Http\Client as HttpClient;

interface ResponseInterface
{
    public function getBody();
    public function getBodyJson();
    public function getStatusCode();
}
