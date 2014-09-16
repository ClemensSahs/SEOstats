<?php

namespace SeoStats\V3\HttpAdapter;

use Guzzle\Http\Message\Response as ResponseObject;

class Response implements ResponseInterface
{
    /**
     * @var ResponseObject
     */
    protected $responseObject;

    /**
     * @parms ResponseObject
     */
    public function construct(ResponseObject $responseObject)
    {
        $this->responseObject = $responseObject;
    }

    public function getBody () {
        return $this->responseObject->getBody(true);
    }

    public function getBodyFromJson () {
        return Json::decode($this->getBody());
    }
}
