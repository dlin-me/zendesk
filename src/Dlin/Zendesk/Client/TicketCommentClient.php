<?php
/**
 *
 * User: matks
 * Date: 14/08/2014
 * Time: 16:20 AM
 *
 */

namespace Dlin\Zendesk\Client;

use Dlin\Zendesk\Entity\Ticket;

class TicketCommentClient extends BaseClient
{

    /**
     * Return entity class type.
     *
     * @return string
     */
    public function getType()
    {
        return '\Dlin\Zendesk\Entity\TicketComment';
    }

    /**
     * List ticket comments
     *
     * @param  int                                  $ticket_id
     * @param  int                                  $page
     * @param  int                                  $per_page
     * @return \Dlin\Zendesk\Result\PaginatedResult
     */
    public function getTicketComments($ticket_id, $page = 1, $per_page = 100)
    {
        return $this->getCollection("tickets/$ticket_id/comments.json", 'comments', $page, $per_page);
    }
}
