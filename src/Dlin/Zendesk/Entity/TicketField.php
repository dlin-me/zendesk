<?php
/**
 *
 * User: matks
 * Date: 13/08/2014
 * Time: 11:09 AM
 *
 */

namespace Dlin\Zendesk\Entity;


class TicketField extends BaseEntity
{

    const ISO8601_DATE = 'Y-m-d\TH:i:sP';

    /**
     * Automatically assigned when creating ticket fields
     * @var integer
     * @readonly
     */
    protected $id;

    /**
     * API url of ticket field
     * @var string
     * @readonly
     */
    protected $url;

    /**
     * Ticket field type
     * @var string
     */
    protected $type;

    /**
     * Ticket field title
     * @var string
     */
    protected $title;

    /**
     * Ticket field dynamic content title
     * @var string
     * @see http://developer.zendesk.com/documentation/rest_api/dynamic_content.html
     */
    protected $raw_title;

    /**
     * Ticket field description
     * @var string
     */
    protected $description;

    /**
     * Ticket field dynamic content description
     * @var string
     * @see http://developer.zendesk.com/documentation/rest_api/dynamic_content.html
     */
    protected $raw_description;

    /**
     * Ticket field position (relative to other fields position)
     * For and display purposes
     * @var integer
     */
    protected $position;

    /**
     * Field available or not
     * @var boolean
     */
    protected $active;

    /**
     * Field required not to be empty when ticket is updated
     * @var boolean
     */
    protected $required;

    /**
     * @var boolean
     */
    protected $collapsed_for_agents;

    /**
     * Validation pattern for acceptable values for this field
     * @var string
     */
    protected $regexp_for_validation;

    /**
     * Title displayed in portal
     * @var string
     */
    protected $title_in_portal;

    /**
     * Dynamic content title displayed in portal
     * @var string
     * @see http://developer.zendesk.com/documentation/rest_api/dynamic_content.html
     */
    protected $raw_title_in_portal;

    /**
     * Field available in portal
     * @var boolean
     */
    protected $visible_in_portal;

    /**
     * Field editable in portal
     * @var boolean
     */
    protected $editable_in_portal;

    /**
     * Field required not to be empty in portal
     * @var boolean
     */
    protected $required_in_portal;

    /**
     * @var string
     */
    protected $tag;

    /**
     * @var string
     * @readonly
     */
    protected $created_at;

    /**
     * @var string
     * @readonly
     */
    protected $updated_at;

    /**
     * @var array
     */
    protected $system_field_options;

    /**
     * @var array
     */
    protected $custom_field_options;

    /**
     * @var string
     * @readonly
     */
    protected $removable;
}