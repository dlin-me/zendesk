<?php
namespace Dlin\Zendesk\Tests;




use Dlin\Zendesk\ZendeskApi;

class ZendeskApiTest extends \PHPUnit_Framework_TestCase
{
    public function testClient()
    {

        $api = new ZendeskApi('api@estimateone.com', 'c6EFbHZ7YdggbIMSvOqiq3HduOLljaV7DSgexzoc',
        'https://estimateone.zendesk.com/api/v2/');

        $resp = $api->get('tickets.json')->send();

        $this->assertArrayHasKey('tickets', $resp->json());

    }



}