<?php
/**
 * 
 * User: davidlin
 * Date: 18/11/2013
 * Time: 11:37 PM
 * 
 */

namespace Dlin\Zendesk\Entity;


class TicketMetaData extends BaseEntity {
    /**
     * Custom meta data
     * @var array
     */
    protected $custom;


    /**
     * System meta data;
     * @var array
     */
    protected $system;

    /**
     * @return array
     */
    public function getCustom()
    {
        return $this->custom;
    }

    /**
     * @return array
     */
    public function getSystem()
    {
        return $this->system;
    }



}