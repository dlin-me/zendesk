<?php
/**
 *
 * User: matks
 * Date: 13/08/2014
 * Time: 11:31 AM
 *
 */

namespace Dlin\Zendesk\Client;


use Dlin\Zendesk\Entity\Ticket;
use Dlin\Zendesk\Entity\TicketRequester;
use Dlin\Zendesk\Search\TicketFilter;

class TicketFieldClient extends BaseClient
{

    /**
     * Return entity class type.
     *
     * @return string
     */
    public function getType()
    {
        return '\Dlin\Zendesk\Entity\TicketField';
    }

    /**
     * Return a ticket by ID
     *
     * @param $id
     * @return \Dlin\Zendesk\Entity\TicketField
     */
    public function getOneById($id)
    {
        return $this->getOne("ticket_fields/$id.json");
    }

    /**
     * List tickets fields
     *
     * @param int $page
     * @param int $per_page
     * @return \Dlin\Zendesk\Result\PaginatedResult
     */
    public function getAll($page = 1, $per_page = 100)
    {
        return $this->getCollection('ticket_fields.json', 'ticket_fields', $page, $per_page);
    }
}