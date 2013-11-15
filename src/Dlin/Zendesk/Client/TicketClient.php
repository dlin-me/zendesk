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

    /**
     * Return entity class type.
     *
     * @return string
     */
    public function getType(){
        return '\Dlin\Zendesk\Entity\Ticket';
    }


    public function getOneById($id){
        return $this->getOne("tickets/$id.json");
    }


    public function getMultiple(array $ids, $page=1, $per_page=100){

        return $this->getCollection('tickets/show_many.json?ids='.implode(',',$ids), $page, $per_page);
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


    public function searchTickets(array $query, $page=1, $per_page=100, $sort_by=null, $sort_order='asc'){
        $query['type'] = 'ticket';
        $searchTerms = array();
        foreach($query as $k=>$v){
            if(strpos($v, ' ')){
                $v = '"'.addcslashes($v, '"').'"';
            }
            $searchTerms[]="$k:$v";
        }

        return $this->getCollection('tickets/show_many.json?ids='.implode(',',$ids), $page, $per_page);
    }


}