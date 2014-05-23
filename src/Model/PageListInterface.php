<?php

namespace SeoStats\Model;

use Iterator;

interface PageListInterface extends Iterator
{
    public function add($url);
    public function remove($url);
}
