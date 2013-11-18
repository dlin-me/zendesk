<?php
/**
 *
 * User: davidlin
 * Date: 7/11/2013
 * Time: 10:47 PM
 *
 */

namespace Dlin\Zendesk\Client;


use Dlin\Zendesk\Entity\Ticket;
use Dlin\Zendesk\Search\TicketFilter;

class TicketClient extends BaseClient
{

    /**
     * Return entity class type.
     *
     * @return string
     */
    public function getType(){
        return '\Dlin\Zendesk\Entity\Ticket';
    }

    /**
     * Return a ticket by ID
     *
     * @param $id
     * @return \Dlin\Zendesk\Entity\Ticket
     */
    public function getOneById($id){
        return $this->getOne("tickets/$id.json");
    }

    /**
     * Return tickets by an array of Ids
     *
     * @param array $ids
     * @param int $page
     * @param int $per_page
     * @return \Dlin\Zendesk\Result\CollectionResult
     */
    public function getMultiple(array $ids, $page=1, $per_page=100){

        return $this->getCollection('tickets/show_many.json?ids='.implode(',',$ids), $page, $per_page);
    }

    /**
     * List tickets
     *
     * @param int $page
     * @param int $per_page
     * @return \Dlin\Zendesk\Result\CollectionResult
     */
    public function getAllTickets($page=1, $per_page=100){
        return $this->getCollection('tickets.json', $page, $per_page);
    }

    /**
     * List recent tickets
     *
     * @param int $page
     * @param int $per_page
     * @return \Dlin\Zendesk\Result\CollectionResult
     */
    public function getRecentTickets($page=1, $per_page=100){
        return $this->getCollection('tickets/recent.json', $page, $per_page);
    }

    /**
     * List tickets for the given organization
     *
     * @param $organization_id
     * @param int $page
     * @param int $per_page
     * @return \Dlin\Zendesk\Result\CollectionResult
     */
    public function getOrganizationsTickets($organization_id, $page=1, $per_page=100){

        return $this->getCollection("organizations/$organization_id/tickets.json", $page, $per_page);
    }

    /**
     * List user requested tickets
     *
     * @param $user_id
     * @param int $page
     * @param int $per_page
     * @return \Dlin\Zendesk\Result\CollectionResult
     */
    public function getUserRequestedTickets($user_id, $page=1, $per_page=100){
        return $this->getCollection("users/$user_id/tickets/requested.json", $page, $per_page);
    }

    /**
     * List user ccd tickets
     * @param $user_id
     * @param int $page
     * @param int $per_page
     * @return \Dlin\Zendesk\Result\CollectionResult
     */
    public function getUserCcdTickets($user_id, $page=1, $per_page=100){
        return $this->getCollection("users/$user_id/tickets/ccd.json", $page, $per_page);
    }


    /**
     * Search tickets
     *
     * @param TicketFilter $query
     * @param int $page
     * @param int $per_page
     * @param null $sort_by
     * @param string $sort_order
     * @return \Dlin\Zendesk\Result\CollectionResult
     */
    public function searchTickets(TicketFilter $query, $page=1, $per_page=100, $sort_by=null, $sort_order='asc'){

        $endPoint = 'search.json?query='.urlencode(implode(' ',$query->toArray()));

        return $this->getCollection($endPoint, $page, $per_page, $sort_by, $sort_order);
    }


    public function createTicket(Ticket $ticket){

        return $this->create($ticket, 'tickets.json');

    }


}