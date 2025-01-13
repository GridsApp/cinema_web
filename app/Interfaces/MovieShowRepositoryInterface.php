<?php

namespace App\Interfaces;

interface MovieShowRepositoryInterface 
{
    public function getMovieShows($branch_id ,$movie_id , $date);
    // public function getShows($movie_id , $date);
    public function getMovieShowById($id);
}