<?php
/**
 *
 * User: davidlin
 * Date: 11/11/2013
 * Time: 10:59 PM
 *
 */

namespace Dlin\Zendesk\Entity;


class TicketComment extends BaseEntity
{

    /**
     * Automatically assigned when creating events
     * @var integer
     * @readonly
     */
    protected $id;

    /**
     *  Has the value Comment
     * @var string
     * @readonly
     */
    protected $type;

    /**
     * The actual comment made by the author. Use the return (\r) and newline (\n) characters for line breaks.
     * @var string
     * @readonly
     */
    protected $body;

    /**
     * The actual comment made by the author formatted to HTML
     * @var string
     * @readonly
     */
    protected $html_body;

    /**
     * If this is a protected comment or an internal agents only note
     * @var boolean
     * @readonly
     */
    protected $protected;

    /**
     * If this comment is trusted or marked as being potentially fraudulent
     * @var boolean
     * @readonly
     */
    protected $trusted;

    /**
     * The id of the author of this comment
     * @var integer
     * @readonly
     */
    protected $author_id;

    /**
     * The attachments on this comment as Attachment objects
     * @var array
     * @readonly
     * @element \Dlin\Zendesk\Entity\Attachement
     */
    protected $attachments;

    /**
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @return int
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getHtmlBody()
    {
        return $this->html_body;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return boolean
     */
    public function getProtected()
    {
        return $this->protected;
    }

    /**
     * @return boolean
     */
    public function getTrusted()
    {
        return $this->trusted;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param array $attachments
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
        return $this->addChange('attachments');
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this->addChange('body');
    }

    /**
     * @param string $html_body
     */
    public function setHtmlBody($html_body)
    {
        $this->html_body = $html_body;
        return $this->addChange('html_body');
    }

    /**
     * @param boolean $trusted
     */
    public function setTrusted($trusted)
    {
        $this->trusted = $trusted;
        return $this->addChange('trusted');
    }

    /**
     * @param boolean $protected
     */
    public function setProtected($protected)
    {
        $this->protected = $protected;
        return $this->addChange('protected');
    }




}