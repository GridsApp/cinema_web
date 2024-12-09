<?php

namespace App\Interfaces;

interface MovieRepositoryInterface 
{
    public function getMovie($id);
    public function getBranchActiveMovies($branch_id , $date);
    public function searchMovies($search);
    public function getMovies($ids);
    public function getMovieShows($branch_id, $movie_id, $date);
}