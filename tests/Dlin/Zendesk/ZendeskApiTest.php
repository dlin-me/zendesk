<?php
namespace Dlin\Zendesk\Tests;




use Dlin\Zendesk\ZendeskApi;

class ZendeskApiTest extends \PHPUnit_Framework_TestCase
{
    public function testClient()
    {

        $api = new ZendeskApi('youemail@email.com', 'e6EFbHZ7YdggbIMSvOqiq3HduOLljaV7DSgexzoc',
        'https://subdomain.zendesk.com/api/v2/');

        $resp = $api->get('tickets.json')->send();

        $this->assertArrayHasKey('tickets', $resp->json());

    }



}