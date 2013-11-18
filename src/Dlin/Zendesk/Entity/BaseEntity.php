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
     * @var \Dlin\Zendesk\Client\BaseClient
     */
    protected $managingCleint;

    /**
     * @param \Dlin\Zendesk\Client\BaseClient $managingCleint
     */
    public function setManagingCleint($managingCleint)
    {
        $this->managingCleint = $managingCleint;
    }

    /**
     * @return \Dlin\Zendesk\Client\BaseClient
     */
    public function getManagingCleint()
    {
        return $this->managingCleint;
    }



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

    /**
     * This is used to validate a field having a  value amongst a list of valid value
     *
     * @param $value
     * @param $enum
     * @throws \Exception
     */
    protected function checkEnumField($value, $enum){
        if(!in_array($enum, $value)){
            throw new \Exception("Invalid value ($value) given, valid values are:".implode(', ',$enum));
        }
    }

    /**
     * Check if the field is Updatable or not
     *
     * @throws \Exception
     */
    protected function checkNotUpdatableField(){
        if(property_exists($this, 'id') && $this->id > 0){
            throw new \Exception("Field not updatable");
        }
    }

    /**
     * Checks if this entity is creatable
     * @throws \Exception
     */
    public  function checkCreatable(){
        if(property_exists($this, id) && $this->id > 0){
            throw new \Exception(get_class($this)." has ID:".$this->id()." thus not creatable.");
        }
    }

    /**
     * Checks if the fields given are all set
     * @param $fields
     * @throws \Exception
     */
    protected function checkFieldsSet($fields){
        foreach($fields as $field){
            if(property_exists($this, $field) && $this->$field === null){
                throw new \Exception("'$field' is required");
            }

        }

    }


    /**
     * @return bool
     */
    public function update(){
        if($this->getManagingCleint()){
           return  $this->getManagingCleint()->update($this);
        }
        throw new \Exception( get_class($this).' can not be updated without a managing client');
    }

    public function delete(){
        if($this->getManagingCleint()){
            return  $this->getManagingCleint()->delete($this);
        }
        throw new \Exception( get_class($this).' can not be deleted without a managing client');
    }


}
