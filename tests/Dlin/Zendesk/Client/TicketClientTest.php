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
use Dlin\Zendesk\Entity\Ticket;
use Dlin\Zendesk\Entity\TicketComment;
use Dlin\Zendesk\Search\TicketFilter;
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

    public function testGet()
    {

        //all tickets
        $resultSet = $this->client->getAllTickets(1,1);
        $this->assertGreaterThan(0, $resultSet->getCount() );
        $this->assertNull($resultSet->getPreviousPage());
        $this->assertNotNull($resultSet->getNextPage());
        $this->assertEquals(1, count($resultSet));


        /**
         * @var \Dlin\Zendesk\Entity\Ticket $ticket
         */
        $ticket = $resultSet ? $resultSet[0] : null;

        //One ticket
        if($ticket){
            $oneTicket = $this->client->getOneById($ticket->getId());
            $this->assertEquals($ticket->getId(), $oneTicket->getId());
            $this->assertEquals($ticket->getDescription(), $oneTicket->getDescription());
        }

        //Test result set next and prev
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

        //recent tickets
        $twoTicketIds = array($ticket->getId(), $nextTicket->getId());
        $this->assertCount(2, $twoTicketIds);

        $result = $this->client->getMultiple($twoTicketIds);

        $this->assertCount(2, $result);



    }

    public function testSearch(){


        $filter = new TicketFilter();
        $filter->setSubject('hi');
        $result = $this->client->searchTickets($filter);

        echo $result->getCount();
    }

    public function testCreate(){
        $ticket = new Ticket();
        $comment = new TicketComment();
        $comment->setBody('TEST Ticket By David Lin');

        $ticket->setComment($comment);
        $ticket->setSubject('Test Ticket Subject By David Lin');
        $ticket->setTags(array('test'));

        $result = $this->client->createTicket($ticket);

        print_r($result);


    }



}