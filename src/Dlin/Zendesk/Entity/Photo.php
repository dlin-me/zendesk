<?php
/**
 * 
 * User: davidlin
 * Date: 11/11/2013
 * Time: 11:08 PM
 * 
 */

namespace Dlin\Zendesk\Entity;


class Photo extends BaseEntity {
    /**
     * Automatically assigned when created
     * @var integer
     * @readonly
     */
    protected $id;

    /**
     * The name of the image file
     * @var string
     * @readonly
     */
    protected $file_name;

    /**
     * A full URL where the attachment image file can be downloaded
     * @var string
     * @readonly
     */
    protected $content_url;

    /**
     * The content type of the image. Example value: image/png
     * @var string
     * @readonly
     */
    protected $content_type;

    /**
     * The size of the image file in bytes
     * @var integer
     * @readonly
     */
    protected $size;

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->content_type;
    }

    /**
     * @return string
     */
    public function getContentUrl()
    {
        return $this->content_url;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }



}