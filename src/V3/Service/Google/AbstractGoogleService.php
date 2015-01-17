<?php

namespace SeoStats\V3\Service\Google;

use SeoStats\V3\Service\AbstractService;
use SeoStats\V3\Service\CachableServiceTrait;
use SeoStats\V3\Service\ConfigAwareTrait;
use SeoStats\V3\HttpAdapter\HttpAdapterAwareTrait;

abstract class AbstractGoogleService extends AbstractService
{
    use CachableServiceTrait;

    use ConfigAwareTrait;
    use HttpAdapterAwareTrait;
}
