<?php

namespace SeoStats\V3\HttpAdapter;

use Guzzle\Http\Client as HttpClient;

interface HttpAdapterInterface
{
    const HTTP_METHOD_GET    = 'get';
    const HTTP_METHOD_POST   = 'post';
    const HTTP_METHOD_PUT    = 'put';
    const HTTP_METHOD_DELETE = 'delete';

    public function setUrl($url);

    public function setAutoClean($autoclean = true);

    public function clean();
    public function getUrl();

    public function setVariable($variables);

    public function getVariable();

    public function setHttpMethod($httpMethod);

    public function getHttpMethod();

    public function setHeader(array $header);

    public function getHeader();

    /**
     * @param array
     */
    public function setBaseVariable( array $variables);

    /**
     * @param string
     */
    public function setBaseUrl($url);

    public function send();
}
