<?php

namespace SeoStats\V3\HttpAdapter;

use Guzzle\Http\Message\MessageInterface as ResponseObject;
use SeoStats\V3\Helper\Json as Json;

class Response implements ResponseInterface
{
    /**
     *
     * @var ResponseObject
     */
    protected $responseObject;

    /**
     *
     * @param ResponseObject
     */
    public function __construct(ResponseObject $responseObject)
    {
        $this->responseObject = $responseObject;
    }

    /**
     *
     * @return string
     */
    public function getBody ()
    {
        return $this->responseObject->getBody(true);
    }

    /**
     *
     * @return string
     */
    public function getBodyJson ()
    {
        return Json::decode($this->getBody());
    }

    /**
     *
     * @return integer
     */
    public function getStatusCode () {
        return (integer) $this->responseObject->getStatusCode();
    }

    /**
     *
     * @return ResponseObject
     */
    public function getResponseObject () {
        return $this->responseObject;
    }
}
