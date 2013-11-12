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


}