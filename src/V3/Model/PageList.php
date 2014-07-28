<?php

namespace SeoStats\V3\Model;

use SeoStats\V3\SeoStats;

class PageList implements PageListInterface
{
    protected static $pageClass = 'SeoStats\Model\Page';
    private $pages = array();
    private $position = 0;

    /**
     * @var SeoStats
     */
    protected $seoStats;

    /**
     * @param array $pages
     */
    public function __construct( array $pages, SeoStats $seoStats)
    {
        $this->setSeoStats($seoStats);

        $this->position = 0;
        $this->addArray($pages);
    }

   /**
    * @param PageInterface|string|array $url
    */
    public function add($url)
    {
        if(is_string($url)) {
            $url = $this->getSeoStats()->createPageObject($url);
            $url->setSeoStats($this->getSeoStats());
        }

        $this->addPage($url);
    }

   /**
    * @param PageInterface $page
    */
    protected function addPage(PageInterface $page)
    {
        array_push($this->pages, $url);
    }

   /**
    * @param PageInterface $page
    */
    protected function addArray(array $pageList)
    {
        foreach ($pageList as $page) {
            $this->add($page);
        }
    }

   /**
    * @param PageInterface|string $url
    */
    public function remove($url) {
        if(is_string($url)) {
            $url = static::$pageClass($url);
        }
        $this->removePage($url);
    }

   /**
    * @todo here we can be faster if we have a ObjectIndex, that index make a add slower...
    * @param PageInterface $page
    */
    protected function removePage(PageInterface $page)
    {
        $this->pages = array_diff($this->pages, array($url));
    }

    /**
     * Iterator methods
     */

    /**
     *
     */
    function rewind() {
        $this->position = 0;
    }

    /**
     *
     */
    function current() {
        return $this->pages[$this->position];
    }

    /**
     *
     */
    function key() {
        return $this->position;
    }

    /**
     *
     */
    function next() {
        ++$this->position;
    }

    /**
     *
     */
    function valid() {
        return isset($this->pages[$this->position]);
    }

    public function setSeoStats(SeoStats $seoStats)
    {
        $this->seoStats = $seoStats;
    }

    /**
     *
     * @return SeoStats
     */
    public function getSeoStats()
    {
        $this->guardHasSeoStats();
        return $this->seoStats;
    }

    /**
     *
     * @param string $url
     */
    protected function guardHasSeoStats()
    {
        if ($this->seoStats == null) {
            throw new \RuntimeException('...');
        }
    }
}
