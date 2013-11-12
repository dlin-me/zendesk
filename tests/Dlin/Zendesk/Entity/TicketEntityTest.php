<?php
/**
 *
 * User: davidlin
 * Date: 9/11/2013
 * Time: 10:40 PM
 *
 */

namespace Dlin\Zendesk\Tests\Entity;


use Dlin\Zendesk\Entity\Ticket;
use Dlin\Zendesk\Enum\SatisfactionRatingScore;

class TicketEntityTest extends \PHPUnit_Framework_TestCase
{



    public function testFromToArray()
    {

        $data = <<<JSON
{
  "id":               35436,
  "url":              "https://company.zendesk.com/api/v2/tickets/35436.json",
  "external_id":      "ahg35h3jh",
  "created_at":       "2009-07-20T22:55:29Z",
  "updated_at":       "2011-05-05T10:38:52Z",
  "type":             "incident",
  "subject":          "Help, my printer is on fire!",
  "description":      "The fire is very colorful.",
  "priority":         "high",
  "status":           "open",
  "recipient":        "support@company.com",
  "requester_id":     20978392,
  "submitter_id":     76872,
  "assignee_id":      235323,
  "organization_id":  509974,
  "group_id":         98738,
  "collaborator_ids": [35334, 234],
  "forum_topic_id":   72648221,
  "problem_id":       9873764,
  "has_incidents":    false,
  "due_at":           null,
  "tags":             ["enterprise", "other_tag"],
  "via": {
    "channel": "web"
  },
  "custom_fields": [
    {
      "id":    27642,
      "value": "745"
    },
    {
      "id":    27648,
      "value": "yes"
    }
  ],
  "satisfaction_rating": {
    "id": 1234,
    "score": "good",
    "comment": "Great support!"
  },
  "sharing_agreement_ids": [84432]
}
JSON;

        $data = json_decode($data, true);

        $ticket = new Ticket($data);

        $this->assertEquals($ticket->getId(), 35436);
        $this->assertEquals($ticket->getDescription(), "The fire is very colorful.");
        $this->assertEquals($ticket->getOrganizationId(), 509974);
        $this->assertContains(35334, $ticket->getCollaboratorIds());
        $this->assertContains(234, $ticket->getCollaboratorIds());

        $satisfactionRating = $ticket->getSatisfactionRating();

        $this->assertEquals($satisfactionRating->getId(), 1234);
        $this->assertEquals($satisfactionRating->getScore(), SatisfactionRatingScore::GOOD);
        $this->assertEquals($satisfactionRating->getComment(), "Great support!");
        $this->assertNull($satisfactionRating->getGroupId());


        $this->assertEquals('web', $ticket->getVia()->getChannel() );

        $customFields = $ticket->getCustomFields();

        $this->assertCount(2, $ticket->getTags());
        $this->assertCount(1, $ticket->getSharingAgreementIds());
        $this->assertCount(2, $customFields);

        $this->assertEquals($customFields[0]->getId() ,27642 );
        $this->assertEquals($customFields[0]->getValue() ,"745" );
        $this->assertEquals($customFields[1]->getId() ,27648 );
        $this->assertEquals($customFields[1]->getValue() ,"yes" );


        $array = $ticket->toArray();



        $this->assertEquals('https://company.zendesk.com/api/v2/tickets/35436.json', $array['url']);
        $this->assertEquals('web', $array['via']['channel']);
        $this->assertCount(2, $array['custom_fields']);
        $this->assertEquals(27642, $array['custom_fields'][0]['id']);





    }

}


