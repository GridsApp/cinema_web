<?php

namespace App\Interfaces;

interface MovieShowRepositoryInterface 
{
    public function getMovieShows($branch_id, $movie_id, $date , $strict = false);
    // public function getShows($movie_id , $date);
    public function getMovieShowById($id);
}