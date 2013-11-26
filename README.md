Dlin Zendesk, PHP  client for Zendesk RESTful API
===========================================



## 1. Overview

This is a PHP Client library for [**Zendesk**](http://www.zendesk.com). Full API documentation is available at <http://developer.zendesk.com/documentation/rest_api/introduction.html>

This library uses [Guzzel](http://docs.guzzlephp.org/en/latest/) and provides preconfigurated Guzzel client for communicating with the Zendesk Webservice. Using this client is enough to work with all resource in low level JSON data format in the same way as using the PHP Curl.


However, the library aims to provid higher level of abstraction by providing resource mapping objects.

This library is still a work in progress. High level (Objects) supports are available to the following resource:


* **Tickets** ✓
* <del>Audits</del>
* <del>Users</del>
* <del>Groups</del>
* <del>Group Memberships</del>
* <del>Organizations</del>
* <del>View Execution / Previewing	</del>
* <del>Topics</del>
* <del>Topic Comments</del>
* <del>Requests</del>

Contributions and feature requests are welcome.




## 2. Installation

With composer, add to your composer.json :

```
{
    "require": {
        "dlin/zendesk": "dev-master"
    }
}
```

If you are new to [composer](http://getcomposer.org/), here is some simple steps to take.

1. Download *composer.phar* from the above link
2. Create a json file named *composer.json* containing just exactly the above "require" block
3. Having *composer.phar* and *composer.json* side by side, you can run the command:
```
php ./composer.phar install
```
4. The composer will create a directory named *vendor* and download all required libraries into it.

5. In the *vendor* directory, there's also a file named *autoload.php*. This is the PHP autoloader for the libraries inside. You might need to register it to you existing autoloader, or include it manually.




## 3. Using the low level API client
This library, comes with a configured Guzzel client for communicating with Zendesk's webservice. You don't need to learn about Guzzel to use this client object. 

Using the client means you are working with low level JSON format raw data. You are able to work with all resource exposed by Zendesk's API. However, one will find himself frequently needing to look up Zendesk's documentation for the right resource URL endpoints and data format.



#### Instantiate the client instance

```

// You will need to include this autoload script manually
// if you don't have any autoloader setup.
include "../path/to/vendor/autoload.php"; 

// one needs to declear the namespace for each class used 
use Dlin\Zendesk\ZendeskApi

//Your Zendesk account email
$accountEmail = 'account.email@example.com';

//Your zendesk api token
$apiToken = 'c6EFbHZ7YsdggbIMSvOqiq3HduO'; 

//replace with your subdomain with zendesk
$apiUrl = 'https://[your-subdomain].zendesk.com/api/v2/'; 


//Instantiate the client class for later use
$client = new ZendeskApi($accountEmail, apiToken,$apiUrl);

...

```
####  Quering resource
```
//Get tickets
$response = $api->get('tickets.json')->send()->json();

```
The $response variable is an array mapping to server's responded JSON data:

```
{
  "tickets": [
    {
      "id":      35436,
      "subject": "Help I need somebody!",
      ...
    },
    {
      "id":      20057623,
      "subject": "Not just anybody!",
      ...
    },
  ]
}
```

This is exactly the same as the examples given in Zendesk's [documentation](http://developer.zendesk.com/documentation/rest_api/tickets.html) page.

Similarly, here are some other examples:

```
//Get organization tickets
$response = $api->get('organizations/123/tickets.json')->send()->json();

//Get recent tickets
$response = $api->get('tickets/recent.json')->send()->json();

//Get one ticket (id = 123)
$response = $api->get('tickets/123.json')->send()->json();


```

To query tickets, the right api URL endpoints is what is required.


#### Creating resource

Creating resource is also easy. Data formats are exactly the same as given in Zendesk's [documentation](http://developer.zendesk.com/documentation/rest_api/tickets.html) page.


```
//JSON encoded ticket string
$newTicket = '{"ticket":{"subject":"My printer is on fire!", "comment": { "body": "The smoke is very colorful." }}}';

//WebService URL endpoint
$endPoint = 'tickets.json';

//No need
$extraHttpHeader = null; 

//Sent the request
$response = $api->post($endPoint, $extraHttpHeader, $ticket)->sent()->json();


```
The response will look like:

```
{
  "ticket": {
    {
      "id":      35436,
      "subject": "My printer is on fire!",
      ...
    }
  }
}
```




#### Updating resource

Updating resource works very similar to creating resource. The only different is PUT method should be used instead of POST:




```
$updateData = '{"ticket":{"status":"solved",   \
       "comment":{"public":true, "body": "Thanks, this is now solved!"}}}';
       

//WebService URL endpoint
$endPoint = 'tickets/123.json'; //e.g. ticket id 123

//No need
$extraHttpHeader = null; 

//Sent the request
$response = $api->put($endPoint, $extraHttpHeader, $ticket)->sent()->json();

```
The responded data:

```
{
  "ticket": {
     "id":      35436,
     "subject": "My printer is on fire!",
     "status":  "solved",
     ...
  },
  "audit": {
     "events": [...],
     ...
  }
}
```


#### Deleting Resource
To delete a resource, use DELETE method

```

//Specify the endpoint with the ID of the resource to be deleted
$endPoint = "tickets/{id}.json"; 

//delete
$response = $this->api->delete($end_point)->send();

//the response is empty but you can confirm the deletion by looking the response code
echo $response->getStatusCode(); // == 200;


```


## 4. Using high level Object Mapping Clients


While the low level Guzzel client provides full support for communicating with Zendesk's API, the real value this library offers lies in it's higher level resource client classes.

Resource clients are wrapper cleasses of the abovementioned low level client that provide a simple interface for interacting (e.g. CRUD, search and more ) with the subject resource.


#### Ticket Resource


##### 1. Instantiate a Ticket resource client.


```

// You will need to include this autoload script manually
// if you don't have any autoloader setup.
include "../path/to/vendor/autoload.php"; 

// one needs to declear the namespace for each class used 
use Dlin\Zendesk\ZendeskApi
use Dlin\Zendesk\Client\TicketClient;

//Your Zendesk account email
$accountEmail = 'account.email@example.com';

//Your zendesk api token
$apiToken = 'c6EFbHZ7YsdggbIMSvOqiq3HduO'; 

//replace with your subdomain with zendesk
$apiUrl = 'https://[your-subdomain].zendesk.com/api/v2/'; 


//Instantiate the client class for later use
$api = new ZendeskApi($accountEmail, apiToken,$apiUrl);

//Instantiate the Ticket Client
$ticketClient = new TicketClient($api);


```

#####2. Quering Tickets

When quering tickets, the expected return can either be a single ticket or a collection of tickets.  

When quering for a single ticket, the returned value is of type Dlin\Zendesk\Entity\Ticket is the target resource exists, null otherwise.

However, when queried for a collection of tickets, Zendesk's API can only return a paginated result with a limit of 100 tickets per request.  This library uses a type Dlin\Zendesk\Result\PaginatedResult to encapsulate the returned tickets and other information about the pagination(e.g. the total number of tickets, the current page and number of tickets per page):

```
//Query a ticket by ID
$ticket = $ticketClient->getOneById(123);
echo $ticket->getId(); //123
echo $ticket->getSubject(); //Ticket subject



//Query tickets by an array of IDs
$paginatedResult = $ticketClient->getByIds(array(123, 124, 125));
//Get the tickets (array) from the result object
$tickets = $paginatedResult->getItems();


//Query all tickets
$paginatedResult = $ticketClient->getAll();
//Get the result tickets
$tickets=$paginatedResult->getItems();
//Get the total number of tickets
$count = $paginatedResult->getCount();
//Get current page of the pagination
echo $paginatedResult->getCurrentPage(); //1
//Get per page count of the pagination
echo $paginatedResult->getPerPage(); //100 (default)


/* =================================
 * Other supported quering methods
 * ================================= */
 
 
//Get recent tickets
$paginatedResult=$ticketClient->getRecent();

//Get tickets associated with a given organization (e.g. id:34)
$paginatedResult = $ticketClient->getOrganizationTickets(34);

//Get tickets requested by a given user (e.g. id:234)
$paginatedResult = $ticketClient->getUserRequestedTickets(234);

//Get CCD tickets by a given user (e.g. id:234) 
$paginatedResult = $ticketClient->getUserCcdTickets(234);



```


#####3. More about the PaginatedResult type

Most collection query methods accepts optional parameters for current page and items per page settings. For example:

```
//get page 2, 50 tickets per page
$paginatedResult = $ticketClient->getAll(1, 50);

//Same for other methods
$paginatedResult = $ticketClient->getRecent(1, 50);
$paginatedResult = $ticketClient->getOrganizationTickets(34, 1, 50);
$paginatedResult = $ticketClient->getUserRequestedTickets(234, 1, 50);
$paginatedResult = $ticketClient->getUserCcdTickets(234, 1, 50);

```

After getting result for a given page, it is common to request for tickets on the next or previous page. The PaginatedResult type comes with two handle method for this:

```
$paginatedResult = $ticketClient->getRecent(1, 50);
$nextPageResult = $paginatedResult->getNextResult();  //if no next page, null
$prevPageResult = $paginatedResult->getPreviousResult(); //this is null, no prev page

```

The returned result is of the same type \Dlin\Zendesk\Result\PaginatedResult again. This means you can overcome the 100-tickets-per-request limit and get all tickets by:

```

//get the first 100 tickets
$paginatedResult = $ticketClient->getAll(1, 100);

$allTickets = $paginatedResult->getItems();

//get all the rest
while($result = $paginatedResult->getNextResult()){
	$allTickets = array_merge($allTickets, $result->getItems();
}


```

Moreover, the \Dlin\Zendesk\Result\PaginatedResult implements the ArrayAccess and ICountable interface, this means you can access the tickets in the result object like an array:

```
$paginatedResult = $ticketClient->getAll(1, 100);

echo count($paginatedResult); // 100;
echo count($paginatedResult->getItems()); //100;

foreach($paginatedResult as $ticket){
	echo $ticket->getId(); //e.g. 123
	...
}

 
```


#####3. Searching Tickets

To search ticket, one must provide an object of type \Dlin\Zendesk\Search\TicketFilter:

```
$filter = new TicketFilter();
$filter->setSubject('Test Ticket Subject'); 

$searchResult = $ticketClient->search($filter);

```

Again the returning result is limited to 100 tickets. Fortunately, the $searchResult is of type \Dlin\Zendesk\Result\PaginatedResult. One can use the getCoun, getItems and getNextResult methods to access all matching tickets.


Searching with the Zendesk API is a big topic. It is recommended to do [some reading](https://support.zendesk.com/entries/20239737). In particular, if one wants to find exact match of multiple words, the words need be be double quoted. 

```
$filter->setSubject('"My Subject"'); //the will do exact match against 'My Subject'
```
By default, the matching is a ':' (equal) matching. For matching dates, numeric value and some status types, one can also use '>' and '<' for matching. 

All the setter methods of the TicketFilter class accepts array values. This allows matching ranges:


```
$criteria  = array();
$criteria['>'] = '2011-08-01';
$criteria['<'] = '2011-08-05';

$filter->setCreated($criteria); //searching tickets from 1st Aug to 5th Aug 2011


```

Note that only ':' , '>' and '<' key is supported.


#####4. Creating Tickets

Creating ticket is easy, just create an object of Dlin\Zendesk\Entity\Ticket type and call the client's **save** method:

```
$comment = new TicketComment();
$comment->setBody('TEST Ticket Comment');

$ticket = new Ticket();
$ticket->setComment($comment);
$ticket->setSubject('Test Ticket Subject By David Lin 1');
$ticket->setTags(array('test'));

$result = $ticketClient->save($ticket); //more later for the $result

```


The $result is an object of type Dlin\Zendesk\Result\ChangeResult allow access to the [Audit](http://developer.zendesk.com/documentation/rest_api/ticket_audits.html) object and the updated ticket. 

```
$savedTicket = $result->getItem();
$audit = $result->getAudit();
```

Note that the original ticket object will not be updated upon new ticket creation. It works as a template for new tickets only. You can call the **save** method again to create another ticket or ignore it afterward. 



#####4. Updating Tickets
The **save** method for creating tickets can also be used to update a ticket. The result format is the same as the one from creating a ticket. i.e. a ChangeResult instance.

```
$ticket = $ticketClient->getOneById(123);
$ticket->setSubject('Updated new subject');

//Updating using TicketClient::save()
$result = $ticketClient->save($ticket);

//Or you can do this
$ticket->save();

```
When updating a ticket, the library only submit updated/modified fields to Zendesk's server since last update/creation. 

If a ticket is retrieved by the TicketClient object, it is said that it is 'managed' by the TicketClient and then you can call the **save** method on the Ticket object itself to update the ticket. In this case the $ticket object will be loaded with updated data (e.g. the lastUpdate timestamp ).The returned result of the Ticket::save() method is an instance of the Dlin\Zendesk\Entity\TicketAudit class providing data about an [Audit](http://developer.zendesk.com/documentation/rest_api/ticket_audits.html) resource.

The above example makes a request to get the ticket before updating it. If you know the ticket ID you are updating, you can also do this:

```
$ticket = new Ticket(123);
$tickets->setSubject('Updated subject') ;

//Updating using TicketClient::save()
$result = $ticketClient->save($ticket);


//Or manually manage the ticket
$ticketClient->manage($ticket);
$ticket->save();


```

You can manually add a Ticket object to be managed by a TicketClient object using the **manage** method. 


#####5. Deleting Tickets

The TicketClient class provide two methods for deleting tickets.

```
//delete one ticket 
$ticketClient->deleteTicket(new Ticket(123));

//delete multiple tickets
$toDelete = array();
$toDelete[] = new Ticket(123);
$toDelete[] = new Ticket(124);
$ticketClient->deleteTickets($toDelete);


//OR using Ticket::delete() method
$ticket = new Ticket(123);
$ticketClient->manage($ticket);
$ticket->delete();


```

If a ticket is 'managed' by a TicketClient, either fetched by the TicketClient or manually managed by the TicketClient, you can call the Ticket::delete() method to delete a ticket.

All the three delete methods return true on success, and false on failure.


Here is another example to delete all tickets having 'test subject' in the subject

```
$filter = new TicketFilter();
$filter->setSubject('test subject');

$searchResult = $ticketClient->search($filter);

$ticketClient->deleteTickets($searchResult->getItems());


```










## 5. Helper Classes
To make easy working with the resource classes, there are some useful helper classes available.


#### Enumeration Classes

To help avoid typos and make it easy to lookup values, constants grouped by classes with meaningful names are available. One can easily work out where they fit from the class names:


* SatisfactionRatingScore
* TicketPriority
* TicketStatus
* TicketType
* ... 

Enumeration classes extends the *EnumBase* class which provides two useful static methods *keys()* and *values()*:

##### keys()
Returns an array of constant names of the class

##### values()
Return an associate array with constant names as keys and their values as values











## 6. License


This library is free. Please refer to the license file in the root directory for detail license info.

