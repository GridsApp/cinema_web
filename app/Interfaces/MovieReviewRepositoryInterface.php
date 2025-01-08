<?php

namespace App\Interfaces;

interface MovieReviewRepositoryInterface 
{
    public function getLastReviewByUserAndMovie($user_id, $movie_id);
}