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
use Dlin\Zendesk\Result\CollectionResult;
use Dlin\Zendesk\ZendeskApi;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Client;

abstract class BaseClient
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


    abstract function getCollection( $end_point, $page=1, $per_page=100);
    abstract function getOne($id);



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


    public function getCollectionResult(BaseClient $client, $key,  $class, $values, $page=1, $per_page=100){


        $result = new CollectionResult();
        $result->setClient($client);

        if(array_key_exists('count',$values)){
            $result->setCount($values['count']);
        }
        if(array_key_exists('next_page',$values)){
            $result->setNextPage($values['next_page']);
        }
        if(array_key_exists('previous_page',$values)){
            $result->setPreviousPage($values['previous_page']);
        }

        $result->setCurrentPage($page);
        $result->setPerPage($per_page);

        if(array_key_exists($key, $values) && is_array($values[$key])){
            foreach($values[$key] as $value){
                $entity = new $class();
                $result[] =  $entity->fromArray($value);
            }
        }
        return $result;

    }


}