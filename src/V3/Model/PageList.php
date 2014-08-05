<?php

namespace SeoStats\V3\Model;

use SeoStats\V3\SeoStats;

class PageList implements PageListInterface
{
    protected static $pageClass = 'SeoStats\Model\Page';
    private $pages = array();
    private $pageIndex = array();
    private $position = 0;

    /**
     * @var SeoStats
     */
    protected $seoStats;

    /**
     * @param SeoStats $seoStats
     * @param array $pages
     */
    public function __construct(SeoStats $seoStats, array $pages = null)
    {
        $this->setSeoStats($seoStats);

        if ($pages) {
            $this->addArray($pages);
        }
    }

   /**
    * @param PageInterface|string|array $url
    */
    public function add($url)
    {
        if(is_string($url)) {
            $page = $this->getSeoStats()->createPageObject($url);
        } else {
            $page = $url;
        }

        return $this->addPage($page);
    }

   /**
    * @param PageInterface $page
    */
    public function addPage(PageInterface $page)
    {
        if ($this->hasPage($page)) {
            return true;
        }
        array_push($this->pages, $page);
        $this->pageIndex[$page->getUrl()] = $page;
    }

   /**
    * @param PageInterface $page
    */
    public function hasPage($page)
    {
        if ($page instanceof PageInterface) {
            $url = $page->getUrl();
        } else {
            $urlObject = new Url($page);
            $url = $urlObject->getUrl();
        }

        return isset($this->pageIndex[$url]);
    }

   /**
    * @param PageInterface $page
    */
    public function findPage($url)
    {
        $urlObject = new Url($url);
        $url = $urlObject->getUrl();

        if (!isset($this->pageIndex[$url])) {
            return null;
        }

        return $this->pageIndex[$url];
    }

   /**
    * @param PageInterface $page
    */
    public function addArray(array $pageList)
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
            $page = $this->findPage($url);
        } else {
            $page = $url;
        }

        $this->removePage($page);
    }

   /**
    * @todo here we can be faster if we have a ObjectIndex, that index make a add slower...
    * @param PageInterface $page
    */
    protected function removePage(PageInterface $page)
    {
        unset($this->pageIndex[$page->getUrl()]);

        $remove = array($page);

        $this->pages = array_udiff($this->pages, $remove, function ($value1, $value2) {
            return ($value1 === $value2) ? 0 : -1;
        });
    }

    /**
     * Iterator methods
     */

    /**
     * @return interger
     */
    function count() {
        return count($this->pages);
    }

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

    /**
     *
     * @param SeoStats
     */
    protected function setSeoStats(SeoStats $seoStats)
    {
        $this->seoStats = $seoStats;
    }

    /**
     *
     * @return SeoStats
     */
    public function getSeoStats()
    {
        return $this->seoStats;
    }
}
