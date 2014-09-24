<?php

namespace SeoStats\V3\HttpAdapter;

use Guzzle\Http\Message\Response as ResponseObject;

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
    public function getBodyFromJson ()
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
}
