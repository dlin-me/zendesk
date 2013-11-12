<?php
/**
 *
 * User: davidlin
 * Date: 6/11/2013
 * Time: 12:43 AM
 *
 */

namespace Dlin\Zendesk\Entity;


abstract class BaseEntity
{




    /**
     * Convert to an object
     *
     * @return \stdClass
     */
    public function toArray()
    {
        $vars = get_object_vars($this);
        $object = array();

        foreach ($vars as $k => $v) {
            if ($v !== null) {
                if (is_array($v)) {
                    $subV = array();

                    foreach ($v as $sub) {
                        if (is_a($sub, 'Dlin\Zendesk\Entity\BaseEntity')) {
                            $subV[] = $sub->toArray();
                        } else {
                            $subV[] = $sub;
                        }
                    }
                    $object[$k] = $subV;
                } else if (is_a($v, 'Dlin\Zendesk\Entity\BaseEntity')) {
                    $object[$k] = $v->toArray();
                } else {
                    $object[$k] = $v;
                }
            }
        }

        return $object;
    }


    /**
     * Load data from the past array into local properties
     *
     * @param array $array
     */
    public function fromArray(array $array)
    {
        foreach ($array as $k => $v) {

            if (!is_null($v) && property_exists(get_class($this), $k)) {

                $meta = new \ReflectionProperty(get_class($this), $k);

                $info = $this->parsePropertyDocComment($meta->getDocComment());

                $type =$info['type'];

                if(strtolower($type) == "array" && $elementType = $info['array_element']){
                    if(class_exists($elementType)){
                        $children = array();
                        foreach($v as $subV){
                            $newElement = new $elementType();
                            $children[] = $newElement->fromArray($subV);
                        }
                        $this->$k = $children;

                    }else{
                        throw new \Exception('@element Class Not Found:'.$elementType);
                    }

                }else if(class_exists($type)){
                    $this->$k = (new $type())->fromArray($v);
                }else{
                    $this->$k = $v;
                }


            }

        }

        return $this;
    }

    /**
     *
     * Parse the property doc comment
     * @param $comment
     * @return array
     */
    protected function parsePropertyDocComment($comment){
        $return = array();
        $return['type'] = preg_match('~@var (\S+)~m', $comment, $matches) ? $matches[1] :null;
        $return['array_element'] = preg_match('~@element (\S+)~m', $comment, $matches) ? $matches[1] :null;

        return $return;

    }


}
