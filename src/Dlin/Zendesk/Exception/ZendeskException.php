<?php
/**
 * 
 * User: davidlin
 * Date: 7/11/2013
 * Time: 11:50 PM
 * 
 */

namespace Dlin\Zendesk\Exception;


class ZendeskException extends \Exception{

    /**
     * @var array
     */
    private  $error;


    /**
     * @param array $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return array
     */
    public function getError()
    {
        return $this->error;
    }


}