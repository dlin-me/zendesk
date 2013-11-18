<?php
/**
 *
 * User: davidlin
 * Date: 18/11/2013
 * Time: 11:40 PM
 *
 */

namespace Dlin\Zendesk\Entity;


class TicketAudit extends BaseEntity
{

    /**
     * Automatically assigned when creating audits
     * @var integer
     * @readonly
     */
    protected $id;

    /**
     * The ID of the associated ticket
     * @var integer
     * @readonly
     */
    protected $ticket_id;

    /**
     * Metadata for the audit, custom and system data
     * @var TicketMetaData
     *
     */
    protected $metadata;

    /**
     * This object explains how this audit was created
     * @var Via
     */
    protected $via;

    /**
     * The time the audit was created e.g. 2013-11-03
     * @var string
     * @readonly
     */
    protected $created_at;


    /**
     * The user who created the audit
     * @var integer
     * $readonly
     */
    protected $author_id;

    /**
     * An array of the events that happened in this audit. See Audit Events
     * @var array
     * @readonly
     */
    protected $events;

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
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Dlin\Zendesk\Entity\TicketMetaData
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return int
     */
    public function getTicketId()
    {
        return $this->ticket_id;
    }

    /**
     * @return \Dlin\Zendesk\Entity\Via
     */
    public function getVia()
    {
        return $this->via;
    }




}