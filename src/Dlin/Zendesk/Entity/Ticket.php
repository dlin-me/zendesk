<?php
/**
 *
 * User: davidlin
 * Date: 6/11/2013
 * Time: 12:43 AM
 *
 */

namespace Dlin\Zendesk\Entity;


use Dlin\Zendesk\Enum\TicketPriority;
use Dlin\Zendesk\Enum\TicketStatus;
use Dlin\Zendesk\Enum\TicketType;

class Ticket extends BaseEntity
{

    const ISO8601_DATE = 'Y-m-d\TH:i:sP';


    /**
     * You can add up to 1 kilobyte of custom metadata upon Create or Update to Audi
     * @var array
     * @writeonly
     *
     */
    protected $metadata;


    /**
     * @var TicketComment
     * @writeonly
     * @required
     */
    protected $comment;

    /**
     * Automatically assigned when creating tickets
     * @var integer
     * @readonly
     */
    protected $id;

    /**
     *
     * The API url of this ticket
     * @var string
     * @readonly
     *
     */
    protected $url;

    /**
     * A unique external id, you can use this to link Zendesk tickets to local records
     * @var string
     */
    protected $external_id;

    /**
     * The type of this ticket, i.e. "problem", "incident", "question" or "task"
     * @var string (problem, incident, question, or task)
     * @see \Dlin\Zendesk\Enum\TicketType
     */
    protected $type;

    /**
     * The value of the subject field for this ticket
     * @var string
     * @required
     */
    protected $subject;

    /**
     * The first comment on the ticket
     * @var string
     * @readonly
     */
    protected $description;


    /**
     * Priority, defines the urgency with which the ticket should be addressed: "urgent", "high", "normal", "low"
     *
     * @var string
     * @see \Dlin\Zendesk\Enum\TicketPriority
     */
    protected $priority;


    /**
     * The state of the ticket, "new", "open", "pending", "hold", "solved", "closed"
     * @see \Dlin\Zendesk\Enum\TicketStatus
     * @var string
     */
    protected $status;


    /**
     * The original recipient e-mail address of the ticket
     * @var string
     * @readonly
     * @email
     */
    protected $recipient;


    /**
     * The user who requested this ticket
     * @var integer
     * 
     */
    protected $requester_id;

    /**
     * The user who submitted the ticket; The submitter always becomes the author of the first comment on the ticket.
     * @var integer
     */
    protected $submitter_id;


    /**
     * What agent is currently assigned to the ticket
     * @var integer
     */
    protected $assignee_id;


    /**
     * The organization of the requester
     * @var integer
     * @readonly
     */
    protected $organization_id;

    /**
     * The group this ticket is assigned to
     * @var integer
     */
    protected $group_id;

    /**
     * Who are currently CC'ed on the ticket
     * @var array
     *
     */
    protected $collaborator_ids;

    /**
     * The topic this ticket originated from, if any
     * @var integer
     */
    protected $forum_topic_id;

    /**
     * The problem this incident is linked to, if any
     * @var integer
     */
    protected $problemId;

    /**
     * Is true of this ticket has been marked as a problem, false otherwise
     * @var boolean
     * @readonly
     */
    protected $has_incidents;

    /**
     * If this is a ticket of type "task" it has a due date. Due date format uses ISO 8601 format.
     * @var string e.g. 2013-11-03 for task only
     */
    protected $due_at;

    /**
     * The array of tags applied to this ticket
     * @var array
     */
    protected $tags;

    /**
     * This object explains how the ticket was created
     *
     * @var \Dlin\Zendesk\Entity\Via
     * @readonly
     */
    protected $via;

    /**
     * The custom fields of the ticket
     * @var array
     * @element \Dlin\Zendesk\Entity\TicketCustomFieldValue
     */
    protected $custom_fields;

    /**
     * The satisfaction rating of the ticket, if it exists
     * @var \Dlin\Zendesk\Entity\SatisfactionRating
     * @readonly
     */
    protected $satisfaction_rating;

    /**
     * The ids of the sharing agreements used for this ticket
     * @var array
     * @readonly
     */
    protected $sharing_agreement_ids;

    /**
     * The ids of the followups created from this ticket - only applicable for closed tickets
     * @var array
     * @readonly
     */
    protected $followup_ids;

    /**
     * The id of the ticket form to render for this ticket - only applicable for enterprise accounts
     * @var integer
     * @readonly
     */
    protected $ticket_form_id;


    /**
     * When this record was created
     * @var string e.g. 2013-11-03 for task only
     * @readonly
     */
    protected $created_at;

    /**
     * When this record last got updated
     * @var string e.g. 2013-11-03 for task only
     * @readonly
     */
    protected $updated_at;

    /**
     * @return int
     */
    public function getAssigneeId()
    {
        return $this->assignee_id;
    }

    /**
     * @return array
     */
    public function getCollaboratorIds()
    {
        return $this->collaborator_ids;
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
    public function getCustomFields()
    {
        return $this->custom_fields;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getDueAt()
    {
        return $this->due_at;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->external_id;
    }

    /**
     * @return array
     */
    public function getFollowupIds()
    {
        return $this->followup_ids;
    }

    /**
     * @return int
     */
    public function getForumTopicId()
    {
        return $this->forum_topic_id;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @return boolean
     */
    public function getHasIncidents()
    {
        return $this->has_incidents;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return intval($this->id);
    }

    /**
     * @return int
     */
    public function getOrganizationId()
    {
        return $this->organization_id;
    }

    /**
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return int
     */
    public function getProblemId()
    {
        return $this->problemId;
    }

    /**
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @return int
     */
    public function getRequesterId()
    {
        return $this->requester_id;
    }

    /**
     * @return \Dlin\Zendesk\Entity\SatisfactionRating
     */
    public function getSatisfactionRating()
    {
        return $this->satisfaction_rating;
    }

    /**
     * @return array
     */
    public function getSharingAgreementIds()
    {
        return $this->sharing_agreement_ids;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return int
     */
    public function getSubmitterId()
    {
        return $this->submitter_id;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return int
     */
    public function getTicketFormId()
    {
        return $this->ticket_form_id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
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

    /**
     * @return \Dlin\Zendesk\Entity\Via
     */
    public function getVia()
    {
        return $this->via;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this->addChange('subject');
    }

    /**
     * @param int $requester_id
     */
    public function setRequesterId($requester_id)
    {
        $this->requester_id = $requester_id;
        return $this->addChange('requester_id');
    }

    /**
     * @param int $submitter_id
     */
    public function setSubmitterId($submitter_id)
    {
        $this->checkNotUpdatableField();
        $this->submitter_id = $submitter_id;
        return $this->addChange('submitter_id');
    }

    /**
     * @param int $assignee_id
     */
    public function setAssigneeId($assignee_id)
    {
        $this->assignee_id = $assignee_id;
        return $this->addChange('assignee_id');
    }

    /**
     * @param int $group_id
     */
    public function setGroupId($group_id)
    {
        $this->group_id = $group_id;
        return $this->addChange('group_id');
    }

    /**
     * @param int $organization_id
     */
    public function setOrganizationId($organization_id)
    {
        $this->organization_id = $organization_id;
        return $this->addChange('organization_id');
    }

    /**
     * @param array $collaborator_ids
     */
    public function setCollaboratorIds($collaborator_ids)
    {
        $this->collaborator_ids = $collaborator_ids;
        return $this->addChange('collaborator_ids');
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->checkEnumField($type, TicketType::values());
        $this->type = $type;
        return $this->addChange('type');
    }

    /**
     * @param string $priority
     */
    public function setPriority($priority)
    {
        $this->checkEnumField($priority, TicketPriority::values());
        $this->priority = $priority;
        return $this->addChange('priority');
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->checkEnumField($status, TicketStatus::values());
        $this->status = $status;
        return $this->addChange('status');
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this->addChange('tags');
    }

    /**
     * @param string $external_id
     */
    public function setExternalId($external_id)
    {
        $this->external_id = $external_id;
        return $this->addChange('external_id');
    }

    /**
     * @param int $forum_topic_id
     */
    public function setForumTopicId($forum_topic_id)
    {
        $this->forum_topic_id = $forum_topic_id;
        return $this->addChange('forum_topic_id');
    }

    /**
     * @param int $problemId
     */
    public function setProblemId($problemId)
    {
        $this->problemId = $problemId;
        return $this->addChange('problemId');
    }

    /**
     * @param string $due_at
     */
    public function setDueAt($due_at)
    {
        $this->due_at = $due_at;
        return $this->addChange('due_at');
    }

    /**
     * @param array $custom_fields
     */
    public function setCustomFields($custom_fields)
    {
        $this->custom_fields = $custom_fields;
        return $this->addChange('custom_fields');
    }

    /**
     * @param \Dlin\Zendesk\Entity\TicketComment $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this->addChange('comment');
    }

    /**
     * Checks this ticket is creatable
     */
    public function checkCreatable(){
        parent::checkCreatable();
        $this->checkFieldsSet(array('subject', 'comment'));
    }
    

}