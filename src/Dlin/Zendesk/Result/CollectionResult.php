<?php
/**
 * 
 * User: davidlin
 * Date: 8/11/2013
 * Time: 8:14 AM
 * 
 */

namespace Dlin\Zendesk\Result;


class CollectionResult implements \ArrayAccess, \Countable {

    /**
     * @var \Dlin\Zendesk\Client\BaseClient
     *
     */
    private $client;


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
     * @var integer
     */
    private $current_page;

    /**
     * @var integer
     */
    private $per_page;



    /**
     * @var array
     */
    private $items;



    /**
     * @return $this
     */
    public function getNextResult(){
        if($this->getNextPage()){
            return $this->client->getCollection($this->getNextPage(), $this->getCurrentPage()+1, $this->getPerPage());
        }
        return null;
    }


    /**
     * @return $this
     */
    public function getPreviousResult(){
        if($this->getPreviousPage()){
            return $this->client->getCollection($this->getNextPage(), $this->getCurrentPage()-1, $this->getPerPage());
        }
        return null;
    }


    /**
     * @param \Dlin\Zendesk\Client\BaseClient $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return \Dlin\Zendesk\Client\BaseClient
     */
    public function getClient()
    {
        return $this->client;
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

    /**
     * @param int $current_page
     */
    public function setCurrentPage($current_page)
    {
        $this->current_page = $current_page;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->current_page;
    }

    /**
     * @param int $per_page
     */
    public function setPerPage($per_page)
    {
        $this->per_page = $per_page;
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->per_page;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getItems(){
        return $this->items;
    }

//ArrayAccess Interface Implementation bellow
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }
    public function offsetExists($offset) {
        return isset($this->items[$offset]);
    }
    public function offsetUnset($offset) {
        unset($this->items[$offset]);
    }
    public function offsetGet($offset) {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    public function count(){
        return is_array($this->items) ? count($this->items) : 0;
    }

}