<?php

namespace SeoStats\V3\Model;

use Iterator;

interface PageListInterface extends Iterator
{
    public function add($url);
    public function remove($url);
}
