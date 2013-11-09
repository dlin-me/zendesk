<?php
/**
 *
 * User: davidlin
 * Date: 5/11/2013
 * Time: 10:03 AM
 *
 */

namespace Dlin\Zendesk\Client;


use Dlin\Zendesk\Exception\ZendeskException;
use Dlin\Zendesk\ZendeskApi;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Client;

class BaseClient
{
    /**
     * @var \Dlin\Zendesk\ZendeskApi
     */
    protected $api;


    /**
     *
     * Constructor
     *
     * @param ZendeskApi $api
     */
    public function __construct(ZendeskApi $api)
    {
        $this->api = $api;
    }

    /**
     * Process request into a response object
     *
     * @param RequestInterface $request
     * @return \Guzzle\Http\Message\Response
     * @throws \Dlin\Zendesk\Exception\ZendeskException
     */
    public function processRequest(RequestInterface $request){
        $response = $request->send();
        $attempt = 0;
        while($response->getStatusCode() == 429 && $attempt < 5){
            $wait = $response->getHeader('Retry-After');
            if($wait > 0){
                sleep($wait);
            }
            $attempt++;
            $response = $request->send();
        }

        if($response->getStatusCode() >= 500){
            throw new ZendeskException('Zendesk Server Error Detected.');
        }


        if($response->getStatusCode() >= 400){
            if($response->getContentType() == 'application/json'){
                $result = $response->json();

                $description = array_key_exists($result, 'description') ? $result['description'] : 'Invalid Request';
                $value = array_key_exists($result, 'value') ? $result['value'] : array();

                $exception = new ZendeskException($description);
                $exception->setError($value);

                throw $exception;

            }else{
                throw new ZendeskException('Invalid API Request');
            }
        }

        return $response;
    }





}