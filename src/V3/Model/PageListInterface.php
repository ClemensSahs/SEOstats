<?php

namespace SeoStats\V3\Model;

use Iterator;
use Countable;

interface PageListInterface extends Iterator, Countable
{

    /**
     * @param string|PageInterface $page
     */
    public function add($url);

    /**
     *
     * @param PageInterface $page
     */
    public function addPage(PageInterface $page);

    /**
     * @param string|PageInterface $page
     */
    public function hasPage($page);

    /**
     * @param string|PageInterface $page
     */
    public function remove($url);

   /**
    * @param string $url
    */
    public function findPage($url);
}
