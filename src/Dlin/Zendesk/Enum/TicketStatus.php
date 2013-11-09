<?php
/**
 *
 * User: davidlin
 * Date: 6/11/2013
 * Time: 11:04 PM
 *
 */

namespace Dlin\Zendesk\Enum;


class TicketStatus
{
    const NEW_TICKET = 'new'; //New is a php reserve word
    const OPEN_TICKET = 'open';
    const PENDING_TICKET = 'pending';
    const HOLD_TICKET = 'hold';
    const SOLVED_TICKET = 'solved';
    const CLOSED_TICKET = 'closed';

}