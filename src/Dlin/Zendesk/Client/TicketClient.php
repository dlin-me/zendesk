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

class TicketClient extends BaseClient
{


    public function getTickets($page=1, $per_page=100, $end_point = 'tickets.json')
    {
        $request = $this->api->getClient()->get($end_point);
        $request->getQuery()->set('page', $page)->set('per_page', $per_page);
        $response = $this->processRequest($request);
        $results = $response->json();

        $tickets = array();

        foreach($results['tickets'] as $ticket){
            $tickets[] = new Ticket($ticket);
        }


    }

    public function getRecentTickets(){

    }


    public function getOrganizationsTickets($organization_id){

    }

    public function getUserRequestedTickets($user_id){

    }

}