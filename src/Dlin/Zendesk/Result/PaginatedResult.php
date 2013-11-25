<?php
/**
 * 
 * User: davidlin
 * Date: 8/11/2013
 * Time: 8:14 AM
 * 
 */

namespace Dlin\Zendesk\Result;


class PaginatedResult implements \ArrayAccess, \Countable {

    /**
     * @var \Dlin\Zendesk\Client\BaseClient
     *
     */
    private $client;


    private $endPoint;

    /**
     * @var integer
     */
    private $count;



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
        if($this->getCount() > $this->per_page * $this->getCurrentPage()){
            return $this->client->getCollection($this->getEndPoint(), 'tickets', $this->getCurrentPage()+1, $this->getPerPage());
        }
        return null;
    }


    /**
     * Note: the web service never return next page URL, this method overrides the next_page url and resets the current pages param
     * @return $this
     */
    public function getPreviousResult(){
        if($this->getCurrentPage() > 1){
            return $this->client->getCollection($this->getEndPoint(), 'tickets', $this->getCurrentPage()-1, $this->getPerPage());
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
        return intval($this->count);
    }

    /**
     * @return mixed
     */
    public function getEndPoint()
    {
        return $this->endPoint;
    }

    /**
     * @param mixed $endPoint
     */
    public function setEndPoint($endPoint)
    {
        $this->endPoint = $endPoint;
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