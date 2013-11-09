<?php
/**
 * 
 * User: davidlin
 * Date: 8/11/2013
 * Time: 8:14 AM
 * 
 */

namespace Dlin\Zendesk\Result;


class CollectionResult {

    /**
     * @var integer
     */
    private $count;

    /**
     * @var string
     */
    private $next_page;


    /**
     * @var string
     */
    private $previous_page;


    /**
     * @return $this
     */
    public function nextResult(){
        return $this;
    }

    /**
     * @return $this
     */
    public function previousResult(){
        return $this;
    }


    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param string $next_page
     */
    public function setNextPage($next_page)
    {
        $this->next_page = $next_page;
    }

    /**
     * @return string
     */
    public function getNextPage()
    {
        return $this->next_page;
    }

    /**
     * @param string $previous_page
     */
    public function setPreviousPage($previous_page)
    {
        $this->previous_page = $previous_page;
    }

    /**
     * @return string
     */
    public function getPreviousPage()
    {
        return $this->previous_page;
    }



}