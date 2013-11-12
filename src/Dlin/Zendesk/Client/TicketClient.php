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


    public function getCollection( $end_point, $page=1, $per_page=100)
    {
        $end_point = strtolower($end_point);
        if(strpos($end_point, 'http') !== 0){
            $end_point = $this->api->getApiUrl().$end_point;
        }

        $request = $this->api->getClient()->get($end_point);
        $request->getQuery()->set('page', $page)->set('per_page', $per_page);
        $response = $this->processRequest($request);
        $results = $response->json();
       return  $this->getCollectionResult($this, 'tickets', '\Dlin\Zendesk\Entity\Ticket', $results, $page, $per_page);

    }


    public function getOne($id){
        $request = $this->api->getClient()->get($this->api->getApiUrl()."tickets/$id.json");
        $response = $this->processRequest($request);
        $result = $response->json();


        if($result && isset($result['ticket'])){
            $t = new Ticket();
            return $t->fromArray($result['ticket']);
        }
        return null;
    }


    public function getAllTickets($page=1, $per_page=100){
        return $this->getCollection('tickets.json', $page, $per_page);
    }

    public function getRecentTickets($page=1, $per_page=100){
        return $this->getCollection('tickets/recent.json', $page, $per_page);
    }


    public function getOrganizationsTickets($organization_id, $page=1, $per_page=100){

        return $this->getCollection("organizations/$organization_id/tickets.json", $page, $per_page);
    }

    public function getUserRequestedTickets($user_id, $page=1, $per_page=100){
        return $this->getCollection("users/$user_id/tickets/requested.json", $page, $per_page);
    }

    public function getUserCcdTickets($user_id, $page=1, $per_page=100){
        return $this->getCollection("users/$user_id/tickets/ccd.json", $page, $per_page);
    }



}