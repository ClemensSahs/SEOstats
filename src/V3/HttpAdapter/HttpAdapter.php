<?php

namespace SeoStats\V3\HttpAdapter;

use Guzzle\Http\Client as HttpClient;

class HttpAdapter implements HttpAdapterInterface
{

    protected $allowedMethods = array(
      self::HTTP_METHOD_GET,
      self::HTTP_METHOD_POST,
      self::HTTP_METHOD_DELETE,
      self::HTTP_METHOD_PUT
    );

    /**
     * @var HttpClient
     */
    protected $client;

    protected $requestVariable;
    protected $requestHttpMethod;
    protected $requestUrl;
    protected $requestHeader;
    protected $requestBody;
    protected $requestAutoClean = true;


    public function __construct($baseUrl = null, array $baseVariable = array())
    {
        if ($baseUrl) {
            $this->setBaseUrl($baserUrl);
        }
        if ($baseVariable) {
            $this->setBaseUrl($baseVariable);
        }
    }

    public function setUrl($url)
    {
        $this->requestUrl = $url;
        return $this;
    }

    public function setAutoClean($autoclean = true)
    {
        $this->requestAutoClean = (bool) $autoclean;
        return $this;
    }

    protected function runAutoClean()
    {
        if (!$this->requestAutoClean) {
            return ;
        }

        $this->clean();
    }

    public function clean()
    {

    }

    public function getUrl()
    {
        return $this->requestUrl;
    }

    public function setVariable($variables)
    {
        $this->requestVariable = $variables;
        return $this;
    }

    public function getVariable()
    {
        return $this->requestVariable;
    }

    public function setHttpMethod($httpMethod)
    {
        if (in_array($httpMethod, $allowedMethode)) {
            throw new \RuntimeMethodeIsNotAllowed();
        }
        $this->requestHttpMethod = $httpMethod;
        return $this;
    }

    public function getHttpMethod()
    {
        return $this->requestHttpMethod;
    }

    public function setHeader(array $header)
    {
        $this->requestHeader = $header;
        return $this;
    }

    public function getHeader()
    {
        return $this->requestHeader;
    }

    /**
     * @param array
     */
    public function setBaseVariable( array $variables)
    {
        $client = $this->getClient();
        $client->setConfig($variables);
    }

    /**
     * @param array
     */
    public function getBaseVariable()
    {
        $client = $this->getClient();
        return $client->getConfig()->toArray();
    }

    /**
     * @param string
     */
    public function setBaseUrl($url)
    {
        $client = $this->getClient();
        $client->setBaseUrl($url);
    }

    /**
     * @param string
     */
    public function getBaseUrl($url)
    {
        $client = $this->getClient();
        return $client->setBaseUrl($url);
    }

    public function send()
    {
        $client = $this->getClient();

        $urlArray = array($this->getUrl, $this->getVariable());

        $request = $client->createRequest($this->getHttpMethod(),
                                          $urlArray,
                                          $this->getHeader(),
                                          $this->getBody()
                                         );
        $response = $request->send();

        $this->runAutoClean();

        return $response;
    }

    protected function getClient ()
    {
        if (! isset($this->client)) {
            $this->initClient();
        }

        return $this->client;
    }

    protected function setClient (HttpClient $client)
    {
        $this->client = $client;
    }

    protected function initClient ()
    {
        $this->client = new HttpClient();
    }
}
