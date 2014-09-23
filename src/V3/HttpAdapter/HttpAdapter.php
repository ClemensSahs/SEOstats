<?php

namespace SeoStats\V3\HttpAdapter;

use Guzzle\Http\Client as HttpClient;
use SeoStats\V3\HttpAdapter\Exception\MethodeIsNotAllowedException;

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

    protected $requestAutoClean = true;

    // cleanable
    protected $requestVariable;
    protected $requestHttpMethod;
    protected $requestUrl;
    protected $requestHeader;
    protected $requestBody;


    public function __construct($baseUrl = null, array $baseVariable = null)
    {
        $this->clean();

        if ($baseUrl) {
            $this->setBaseUrl($baseUrl);
        }
        if ($baseVariable) {
            $this->setBaseVariable($baseVariable);
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
        $this->requestVariable = array();
        $this->requestHttpMethod = self::HTTP_METHOD_GET;
        $this->requestUrl = null;
        $this->requestHeader = array();
        $this->requestBody = null;
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
        if (! in_array($httpMethod, $this->allowedMethods)) {
            throw new MethodeIsNotAllowedException();
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

        return $this;
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

        return $this;
    }

    /**
     * @param string
     */
    public function getBaseUrl()
    {
        $client = $this->getClient();
        return $client->getBaseUrl(false);
    }

    public function send()
    {
        $client = $this->getClient();

        $urlArray = array($this->getUrl(), $this->getVariable());

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

        return $this;
    }

    public function getBody ()
    {
        return $this->requestBody;
    }

    public function setBody ($body)
    {
        $this->requestBody = $body;

        return $this;
    }

    protected function initClient ()
    {
        $this->client = new HttpClient();
    }
}
