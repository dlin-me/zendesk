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
     * @return \Dlin\Zendesk\Result\CollectionResult
     */
    public function getCollection($end_point, $page = 1, $per_page = 100, $sort_by = null, $sort_order = 'asc')
    {
        $end_point = strtolower($end_point);
        if (strpos($end_point, 'http') !== 0) {
            $end_point = $this->api->getApiUrl() . $end_point;
        }

        $request = $this->api->getClient()->get($end_point);
        $query = $request->getQuery()->set('page', $page)->set('per_page', $per_page)->set('sort_order', $sort_order == 'asc' ? 'asc' : 'desc');
        if ($sort_by) {
            $$query->set('sort_by', $sort_by);
        }

        $response = $this->processRequest($request);
        $results = $response->json();

        return $this->getCollectionResult($this, 'tickets', $this->getType(), $results, $page, $per_page);

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


        $request = $this->api->getClient()->get($end_point);
        $response = $this->processRequest($request);
        $result = $response->json();

        $type = $this->getType();
        $className = explode('\\', $type);
        $basename = strtolower(end($className));


        if ($result && isset($result[$basename])) {
            $t = new $type();
            $t->setManagingClient($this);
            return $t->fromArray($result[$basename]);
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
    protected function create(BaseEntity $entity, $endPoint)
    {
        $end_point = strtolower($endPoint);

        if (strpos($end_point, 'http') !== 0) {
            $end_point = $this->api->getApiUrl() . $end_point;
        }
        $type = $this->getType();
        $className = explode('\\', $type);
        $basename = strtolower(end($className));

        $request = $this->api->getClient()->post($end_point, null, array($basename => $entity->toArray()));
        $response = $this->processRequest($request);
        $result = $response->json();



        if ($result && isset($result[$basename])) {
            $changeResult = new ChangeResult();
            $t = new $type();
            $t->setManagingClient($this);
            $t->fromArray($result[$basename]);
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


    public function getCollectionResult(BaseClient $client, $key, $class, $values, $page = 1, $per_page = 100)
    {


        $result = new CollectionResult();
        $result->setClient($client);

        if (array_key_exists('count', $values)) {
            $result->setCount($values['count']);
        }
        if (array_key_exists('next_page', $values)) {
            $result->setNextPage($values['next_page']);
        }
        if (array_key_exists('previous_page', $values)) {
            $result->setPreviousPage($values['previous_page']);
        }

        $result->setCurrentPage($page);
        $result->setPerPage($per_page);

        if (array_key_exists($key, $values) && is_array($values[$key])) {
            foreach ($values[$key] as $value) {
                $entity = new $class();
                $entity->setManagingClient($this);
                $result[] = $entity->fromArray($value);
            }
        }
        return $result;

    }




}