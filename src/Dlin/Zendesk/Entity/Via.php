<?php
/**
 * 
 * User: davidlin
 * Date: 6/11/2013
 * Time: 11:24 PM
 * 
 */

namespace Dlin\Zendesk\Entity;


class Via extends BaseEntity {

    /**
     * tells you how the ticket or event was created
     * @var string
     * @readonly
     */
    protected $channel;


    /**
     * For some channels a source object gives more information about how or why the ticket or event was created
     *
     * Note: Structure of this object is undocumented and inconsistent across examples; Therefore it is simply an associate array
     *
     * @var array
     * @readonly
     */
    protected $source;

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return array
     */
    public function getSource()
    {
        return $this->source;
    }


}