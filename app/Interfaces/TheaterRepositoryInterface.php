<?php

namespace App\Interfaces;

interface TheaterRepositoryInterface 
{
    public function getTheaterById($id);
    public function getTheaterMap($theater_id);
    public function getSeatFromTheaterMap($theater_map , $seat);
    public function getSeatsFromTheaterMap($theater_map , $seats);
}