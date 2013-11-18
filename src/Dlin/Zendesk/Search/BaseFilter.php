<?php
/**
 *
 * User: davidlin
 * Date: 16/11/2013
 * Time: 11:11 PM
 *
 */

namespace Dlin\Zendesk\Search;


abstract class BaseFilter
{

    /**
     * @return string
     */
    abstract public function getType();

    /**
     * property values can either be a scalar value or an array with ':', '<', or '>' as keys
     *
     * if it is a scalar value, it is assumed a ':'
     *
     *
     * @return array
     */
    public function toArray()
    {
        $vars = get_object_vars($this);
        $vars['type'] = $this->getType();
        $queries = array();
        foreach ($vars as $k => $v) {
            if ($v !== null) {
                $values = is_array($v) ? $v : array(':'=>$v);
                foreach ($values as $matcher=>$value) {
                    $queries[] = $k . $matcher .  $value;
                }
            }
        }
        return $queries;
    }
}