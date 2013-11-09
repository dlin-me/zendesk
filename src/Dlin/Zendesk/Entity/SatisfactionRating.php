<?php
/**
 * 
 * User: davidlin
 * Date: 6/11/2013
 * Time: 11:24 PM
 * 
 */

namespace Dlin\Zendesk\Entity;


class SatisfactionRating extends BaseEntity{
    /**
     *
     * Automatically assigned upon creation
     * @var integer
     * @readonly
     *
     */
    protected  $id;

    /**
     *
     * The API url of this rating
     * @var string
     * @readonly
     *
     */
    protected $url;

    /**
     *
     * The id of agent assigned to at the time of rating
     * @var integer
     * @readonly
     * @required
     */
    protected $assignee_id;

    /**
     * The id of group assigned to at the time of rating
     * @var integer
     * @readonly
     * @required
     */
    protected $group_id;

    /**
     * The id of ticket requester submitting the rating
     * @var integer
     * @readonly
     * @required
     */
    protected $requester_id;

    /**
     * The id of ticket being rated
     * @var integer
     * @readonly
     * @required
     */
    protected $ticket_id;


    /**
     * The id of ticket being rated ("offered", "unoffered", "good" or "bad")
     * @var string
     * @see \Dlin\Zendesk\Enum\SatisfactionRatingScore
     * @readonly
     * @required
     */
    protected $score;


    /**
     * The time the satisfaction rating got created
     * @var string e.g. 2013-11-03 for task only
     * @readonly
     */
    protected $created_at;


    /**
     * The time the satisfaction rating got updated
     * @var string e.g. 2013-11-03 for task only
     * @readonly
     */
    protected $updated_at;


    /**
     * The comment received with this rating, if available
     * @var string e.g. 2013-11-03 for task only
     * @readonly
     */
    protected $comment;

    /**
     * @return int
     */
    public function getAssigneeId()
    {
        return $this->assignee_id;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->group_id;
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
    public function getRequesterId()
    {
        return $this->requester_id;
    }

    /**
     * @return string
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return int
     */
    public function getTicketId()
    {
        return $this->ticket_id;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }


}