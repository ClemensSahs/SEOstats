<?php

namespace SeoStatsV3Test\Assert\Helper;

use SeoStats\V3\Helper\Json;

class HelperJsonMockLastErrorMessage extends Json
{
    protected static function isNativJsonLastErrorMassageExists()
    {
        return false;
    }
}
