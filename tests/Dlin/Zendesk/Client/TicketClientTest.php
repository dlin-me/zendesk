<?php
/**
 * 
 * User: davidlin
 * Date: 11/11/2013
 * Time: 11:28 PM
 * 
 */

namespace Dlin\Zendesk\Tests\Client;


use Dlin\Zendesk\Client\TicketClient;
use Dlin\Zendesk\ZendeskApi;

class TicketClientTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \Dlin\Zendesk\Client\TicketClient
     *
     */
    protected  $client;
    public function setUp(){
        $api = new ZendeskApi('api@estimateone.com', 'c6EFbHZ7YdggbIMSvOqiq3HduOLljaV7DSgexzoc', 'https://estimateone.zendesk.com/api/v2/');

        $this->client = new TicketClient($api);
    }

    public function testList()
    {


        $resultSet = $this->client->getAllTickets(1,1);
        $this->assertGreaterThan(0, $resultSet->getCount() );
        $this->assertNull($resultSet->getPreviousPage());
        $this->assertNotNull($resultSet->getNextPage());
        $this->assertEquals(1, count($resultSet));


        /**
         * @var \Dlin\Zendesk\Entity\Ticket $ticket
         */
        $ticket = $resultSet ? $resultSet[0] : null;

        if($ticket){
            $oneTicket = $this->client->getOne($ticket->getId());

            $this->assertEquals($ticket->getId(), $oneTicket->getId());
            $this->assertEquals($ticket->getDescription(), $oneTicket->getDescription());
        }

        $nextResultSet = $resultSet->getNextResult();



        $this->assertEquals($resultSet->getCount(), $nextResultSet->getCount() );
        $this->assertNotNull($nextResultSet->getPreviousPage());
        $this->assertNotNull($nextResultSet->getNextPage());
        $this->assertEquals(1, count($nextResultSet));

        $nextTicket = $nextResultSet[0];

        $this->assertNotEquals($ticket->getId(), $nextTicket->getId());

        $prevResultSet = $nextResultSet->getPreviousResult();
        $this->assertGreaterThan(0, $prevResultSet->getCount() );
        $this->assertNull($prevResultSet->getPreviousPage());
        $this->assertNotNull($prevResultSet->getNextPage());
        $this->assertEquals(1, count($prevResultSet));

        $prevTicket = $prevResultSet[0];

        $this->assertEquals($prevTicket->getId(), $ticket->getId());



    }

    public function testOne(){
        $result = $this->client->getOne(140);
        $this->assertEquals(140, $result->getId());

    }

}