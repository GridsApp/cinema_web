<?php

namespace App\Interfaces;

interface ReportRepositoryInterface 
{
    public function getOrdersGroupedByTypeAndMovie($date,$branch);
}