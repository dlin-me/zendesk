<?php
/**
 *
 * User: davidlin
 * Date: 5/11/2013
 * Time: 10:03 AM
 *
 */

namespace Dlin\Zendesk\Client;


use Dlin\Zendesk\Entity\BaseEntity;
use Dlin\Zendesk\Entity\TicketAudit;
use Dlin\Zendesk\Exception\ZendeskException;
use Dlin\Zendesk\Result\ChangeResult;
use Dlin\Zendesk\Result\PaginatedResult;
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

    /**
     *
     * This is to make entity able to call update an delete methods
     *
     * @param BaseEntity $entity
     */
    public function manage(BaseEntity $entity){
        $entity->setManagingClient($this);
    }



    /**
     * @return string
     */
    abstract public function getType();


    /**
     * Generic function for getting a collection of entities
     *
     * @param $end_point
     * @param int $page
     * @param int $per_page
     * @param null $sort_by
     * @param string $sort_order
     * @return \Dlin\Zendesk\Result\PaginatedResult
     */
    public function getCollection($end_point, $collectionName,  $page = 1, $per_page = 100, $sort_by = null, $sort_order = 'asc')
    {
        $end_point = strtolower($end_point);
        if (strpos($end_point, 'http') !== 0) {
            $end_point = $this->api->getApiUrl() . $end_point;
        }

        $request = $this->api->get($end_point);
        $query = $request->getQuery()->set('page', $page)->set('per_page', $per_page);
        if ($sort_by) {
            $query->set('sort_by', $sort_by)->set('sort_order', $sort_order == 'asc' ? 'asc' : 'desc');
        }


        $response = $this->processRequest($request);


        $values = $response->json();

        $result = new PaginatedResult();
        $result->setClient($this);

        if (array_key_exists('count', $values)) {
            $result->setCount($values['count']);
        }



        /*
        if (array_key_exists('next_page', $values)) {
            $result->setNextPage($values['next_page']); //Note: the api skips the per_page parameter, making it useless
        }
        if (array_key_exists('previous_page', $values)) {
            $result->setPreviousPage($values['previous_page']); //Note: the api always return null
        }
        */

        $result->setCurrentPage($page);
        $result->setPerPage($per_page);
        $result->setEndPoint($end_point);

        $type = $this->getType();

        if (array_key_exists($collectionName, $values) && is_array($values[$collectionName])) {
            foreach ($values[$collectionName] as $value) {
                $entity = new $type();
                $this->manage($entity);
                $result[] = $entity->fromArray($value);
            }
        }
        return $result;


    }


    /**
     * Generic function for getting one entity
     *
     * @param $end_point
     * @return \Dlin\Zendesk\Entity\BaseEntity
     */
    protected function getOne($end_point)
    {

        $end_point = strtolower($end_point);
        if (strpos($end_point, 'http') !== 0) {
            $end_point = $this->api->getApiUrl() . $end_point;
        }


        $request = $this->api->get($end_point);
        $response = $this->processRequest($request);
        $result = $response->json();

        $type = $this->getType();
        $className = explode('\\', $type);
        $baseName = strtolower(end($className));


        if ($result && isset($result[$baseName])) {
            $t = new $type();
            $t->setManagingClient($this);
            return $t->fromArray($result[$baseName]);
        }
        return null;

    }

    /**
     * Create an entity
     *
     * @param BaseEntity $entity
     * @param $endPoint
     * @return ChangeResult|null
     */
    public function saveEntity(BaseEntity $entity, $endPoint='', $extraData=null)
    {
        $end_point = strtolower($endPoint);

        if (strpos($end_point, 'http') !== 0) {
            $end_point = $this->api->getApiUrl() . $end_point;
        }
        $type = $this->getType();
        $className = explode('\\', $type);
        $baseName = strtolower(end($className));

        $method = $entity->getId() ? 'put':'post';
        if($method == 'post'){
            $entity->checkCreatable();
        }


        $changes = $entity->toArray(true, $extraData);
        if(empty($changes)){
            return null;
        }

        $request = $this->api->$method($end_point, null, json_encode(array($baseName => $changes)));
        $response = $this->processRequest($request);
        $result = $response->json();


        if ($result && isset($result[$baseName])) {
            $changeResult = new ChangeResult();
            $t = new $type();
            $this->manage($t);
            $t->fromArray($result[$baseName]);
            $changeResult->setItem($t);
            if (isset($result['audit'])) {
                $audit = new TicketAudit();
                $audit->fromArray($result['audit']);
                $changeResult->setAudit($audit);
            }
            return $changeResult;
        }
        return null;
    }


    public function deleteById($id, $endPoint=''){

        $end_point = strtolower($endPoint).'/'.$id.'.json';

        if (strpos($end_point, 'http') !== 0) {
            $end_point = $this->api->getApiUrl() . $end_point;
        }
        $response = $this->api->delete($end_point)->send();
        return $response->getStatusCode() == 200;

    }




    public function deleteByIds(array $ids, $end_point=''){



        if (strpos($end_point, 'http') !== 0) {
            $end_point = $this->api->getApiUrl() . $end_point;
        }
        $request = $this->api->delete($end_point);
        $request->getQuery()->set('ids',implode(',',$ids) );
        $response=$request->send();
        return $response->getStatusCode() == 200;

    }



    /**
     * Process request into a response object
     *
     * @param RequestInterface $request
     * @return \Guzzle\Http\Message\Response
     * @throws \Dlin\Zendesk\Exception\ZendeskException
     */
    public function processRequest(RequestInterface $request)
    {


        $response = $request->send();


        $attempt = 0;
        while ($response->getStatusCode() == 429 && $attempt < 5) {
            $wait = $response->getHeader('Retry-After');
            if ($wait > 0) {
                sleep($wait);
            }
            $attempt++;
            $response = $request->send();
        }

        if ($response->getStatusCode() >= 500) {
            throw new ZendeskException('Zendesk Server Error Detected.');
        }


        if ($response->getStatusCode() >= 400) {
            if ($response->getContentType() == 'application/json') {
                $result = $response->json();

                $description = array_key_exists($result, 'description') ? $result['description'] : 'Invalid Request';
                $value = array_key_exists($result, 'value') ? $result['value'] : array();

                $exception = new ZendeskException($description);
                $exception->setError($value);

                throw $exception;

            } else {
                throw new ZendeskException('Invalid API Request');
            }
        }

        return $response;
    }







}