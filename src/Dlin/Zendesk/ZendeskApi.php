<?php
/**
 * 
 * User: davidlin
 * Date: 7/11/2013
 * Time: 12:00 AM
 * 
 */
namespace Dlin\Zendesk;

use Guzzle\Service\Client;

class ZendeskApi {

    protected $emailAddress;
    protected $apiToken;
    protected $apiUrl; //e.g. https://subdomain.zendesk.com/api/v2

    /**
     * @var \Guzzle\Service\Client
     */
    private $client;

    /**
     * @return \Guzzle\Service\Client
     */
    public function getClient()
    {
        return $this->client;
    }


    public function __construct($emailAddress, $apiToken, $apiUrl)
    {
        $this->emailAddress = $emailAddress;
        $this->apiToken = $apiToken;
        $this->apiUrl = $apiUrl;
        $this->client = new Client($apiUrl, array('curl.options' => array('CURLOPT_FOLLOWLOCATION' => 1,
            'CURLOPT_MAXREDIRS' => 10,
            'CURLOPT_TIMEOUT'=>10,
            'CURLOPT_USERPWD'=>$this->emailAddress . '/token:'. $this->apiToken
        )));
        $this->client->setDefaultHeaders(array('Content-type' => 'application/json', 'User-Agent' => 'MozillaXYZ/1.0'));
    }



}