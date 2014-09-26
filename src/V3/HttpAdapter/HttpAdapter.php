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

    /**
     * @var bool
     */
    protected $requestAutoClean = true;

    // cleanable property

    /**
     * @var array
     */
    protected $requestVariable;

    /**
     * @var string
     */
    protected $requestHttpMethod;

    /**
     * @var string
     */
    protected $requestUrl;

    /**
     * @var array
     */
    protected $requestHeader;

    /**
     * @var string
     */
    protected $requestBody;

    /**
     *
     * @param string $baseUrl
     * @param array $baseVariable
     */
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

    /**
     *
     * @param string
     * @return HttpAdapter
     */
    public function setUrl($url)
    {
        $this->requestUrl = $url;
        return $this;
    }

    /**
     *
     * @param bool
     * @return HttpAdapter
     */
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

    /**
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->requestUrl;
    }

    /**
     *
     * @param array $variables
     * @return HttpAdapter
     */
    public function setVariable($variables)
    {
        $this->requestVariable = $variables;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getVariable()
    {
        return $this->requestVariable;
    }

    /**
     * @param string post|get|put|delete
     */
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

    /**
     *
     * @param array $variables
     * @return HttpAdapter
     */
    public function setHeader(array $header)
    {
        $this->requestHeader = $header;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getHeader()
    {
        return $this->requestHeader;
    }

    /**
     *
     * @param array $variables
     * @return HttpAdapter
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
     *
     * @param string $url
     * @return HttpAdapter
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

    /**
     *
     * @return ResponseInterface
     */
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

        return new Response($response);
    }

    /**
     *
     * @return HttpClient
     */
    protected function getClient ()
    {
        if (! isset($this->client)) {
            $this->initClient();
        }

        return $this->client;
    }

    /**
     *
     * @param HttpClient
     * @return HttpAdapter
     */
    protected function setClient (HttpClient $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getBody ()
    {
        return $this->requestBody;
    }

    /**
     *
     * @param string
     * @return HttpAdapter
     */
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
