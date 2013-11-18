<?php
/**
 * 
 * User: davidlin
 * Date: 16/11/2013
 * Time: 12:10 AM
 * 
 */

namespace Dlin\Zendesk\Search;

/**
 * Class TicketFilter
 * @package Dlin\Zendesk\Search
 * @see https://support.zendesk.com/entries/20238632
 */
class TicketFilter extends BaseFilter {

    public function getType(){
        return 'ticket';
    }

    protected $id;
    protected $created;
    protected $updated;
    protected $solved;
    protected $due_date;
    protected $assignee;
    protected $submitter;
    protected $requester;
    protected $subject;
    protected $description;
    protected $status;
    protected $ticket_type;
    protected $priority;
    protected $group;
    protected $organization;
    protected $tags;
    protected $via;
    protected $commenter;
    protected $cc;

    /**
     * @param mixed $assignee
     */
    public function setAssignee($assignee)
    {
        $this->assignee = $assignee;
    }

    /**
     * @param mixed $cc
     */
    public function setCc($cc)
    {
        $this->cc = $cc;
    }

    /**
     * @param mixed $commenter
     */
    public function setCommenter($commenter)
    {
        $this->commenter = $commenter;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $due_date
     */
    public function setDueDate($due_date)
    {
        $this->due_date = $due_date;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $organization
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @param mixed $requester
     */
    public function setRequester($requester)
    {
        $this->requester = $requester;
    }

    /**
     * @param mixed $solved
     */
    public function setSolved($solved)
    {
        $this->solved = $solved;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param mixed $submitter
     */
    public function setSubmitter($submitter)
    {
        $this->submitter = $submitter;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param mixed $ticket_type
     */
    public function setTicketType($ticket_type)
    {
        $this->ticket_type = $ticket_type;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @param mixed $via
     */
    public function setVia($via)
    {
        $this->via = $via;
    }



}