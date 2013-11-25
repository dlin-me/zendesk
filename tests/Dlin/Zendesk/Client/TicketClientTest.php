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
        $resultSet = $this->client->getAll(1,1);
        $this->assertGreaterThan(0, $resultSet->getCount() );
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



        $this->assertEquals(1, count($nextResultSet));

        $nextTicket = $nextResultSet[0];

        $this->assertNotEquals($ticket->getId(), $nextTicket->getId());

        $prevResultSet = $nextResultSet->getPreviousResult();
        $this->assertGreaterThan(0, $prevResultSet->getCount() );

        $this->assertEquals(1, count($prevResultSet));

        $prevTicket = $prevResultSet[0];

        $this->assertEquals($prevTicket->getId(), $ticket->getId());

        //recent tickets
        $twoTicketIds = array($ticket->getId(), $nextTicket->getId());
        $this->assertCount(2, $twoTicketIds);

        $result = $this->client->getByIds($twoTicketIds);

        $this->assertCount(2, $result);



    }



    public function testCreateSearchDelete(){
        $comment = new TicketComment();
        $comment->setBody('TEST Ticket By David Lin');

        $ticket = new Ticket();
        $ticket->setComment($comment);
        $ticket->setSubject('Test Ticket Subject By David Lin 1');
        $ticket->setTags(array('test'));

        $this->client->save($ticket);

        $ticket = new Ticket();
        $ticket->setComment($comment);
        $ticket->setSubject('Test Ticket Subject By David Lin 2');
        $ticket->setTags(array('test'));
        $this->client->save($ticket);


        $ticket = new Ticket();
        $ticket->setComment($comment);
        $ticket->setSubject('Test Ticket Subject By David Lin 3');
        $ticket->setTags(array('test'));
        $this->client->save($ticket);

        sleep(5);//need to wait otherwise not searchable

        $filter = new TicketFilter();
        $filter->setSubject('Test David Lin');

        $searchResult = $this->client->search($filter);

        $count = $searchResult->getCount();
        $this->assertGreaterThanOrEqual(3, $count);


        //delete one
        $item = $searchResult->getItems();
        $this->client->delete($item[0]);

        $searchResult = $this->client->search($filter);

        $newCount = $searchResult->getCount();
        $this->assertEquals(--$count, $newCount);

        $this->client->deleteTickets($searchResult->getItems());

        $this->assertEquals(0, $this->client->search($filter)->getCount());





    }



}