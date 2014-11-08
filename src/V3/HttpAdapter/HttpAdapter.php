<?php

namespace SeoStats\V3\HttpAdapter;

use GuzzleHttp\Client as HttpClient;
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

    /**
     * @var array
     */
    protected $baseVariable = array();

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
     * @var array
     */
    protected $requestOptions;

    /**
     *
     * @param string $baseUrl
     * @param array $baseVariable
     */
    public function __construct(array $baseVariable = null)
    {
        $this->clean();

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
        $this->requestOptions = array();
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
        $this->baseVariable = $variables;

        return $this;
    }

    /**
     * @param array
     */
    public function getBaseVariable()
    {
        return $this->baseVariable;
    }

    /**
     *
     * @param array $options
     * @return HttpAdapter
     */
    public function setOptions($options = array())
    {
        $this->requestOptions = $options;
        return $this;
    }

    public function getOptions()
    {
        return array_merge(
            array(
                'body'=>$this->getBody(),
                'headers'=>$this->getHeader()
            ),
            $this->requestOptions
        );
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
                                          $this->getOptions()
                                         );
        $response = $client->send($request);

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
