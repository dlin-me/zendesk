<?php
/**
 * 
 * User: davidlin
 * Date: 18/11/2013
 * Time: 11:46 PM
 * 
 */

namespace Dlin\Zendesk\Result;


class ChangeResult {

    protected $item;

    protected $audit;

    /**
     * @param mixed $audit
     */
    public function setAudit($audit)
    {
        $this->audit = $audit;
    }

    /**
     * @return mixed
     */
    public function getAudit()
    {
        return $this->audit;
    }

    /**
     * @param mixed $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }


}