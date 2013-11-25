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

class ZendeskApi extends \Guzzle\Http\Client {

    /**
     * @var string
     */
    protected $emailAddress;
    /**
     * @var string
     */
    protected $apiToken;
    /**
     *
     * e.g. https://subdomain.zendesk.com/api/v2
     * @var string
     */
    protected $apiUrl;



    /**
     * @return string
     */
    public function getApiToken()
    {
        return $this->apiToken;
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }


    public function __construct($emailAddress, $apiToken, $apiUrl)
    {
        $this->emailAddress = $emailAddress;
        $this->apiToken = $apiToken;
        $this->apiUrl = $apiUrl;

        parent::__construct($apiUrl, array('curl.options' => array('CURLOPT_FOLLOWLOCATION' => 1,
            'CURLOPT_MAXREDIRS' => 10,
            'CURLOPT_TIMEOUT'=>10,
            'CURLOPT_USERPWD'=>$emailAddress . '/token:'. $apiToken
        )));

        $this->setDefaultHeaders(array('Content-type' => 'application/json', 'User-Agent' => 'MozillaXYZ/1.0'));
    }



}