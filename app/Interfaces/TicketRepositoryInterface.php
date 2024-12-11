<?php

namespace App\Interfaces;

interface TicketRepositoryInterface 
{
    public function getTickets($user);
    public function getUserTickets($user_id);
}