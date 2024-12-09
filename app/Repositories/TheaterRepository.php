<?php

namespace App\Repositories;

use App\Interfaces\TheaterRepositoryInterface;
use App\Models\Theater;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class TheaterRepository implements TheaterRepositoryInterface
{


    public function getTheaterById($id)
    {

        try {
            $theater =  Theater::where('id', $id)
            ->whereNull('deleted_at')
            ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }

        return $theater;
       
    }


    public function getTheaterMap($theater_id){

        $theater = $this->getTheaterById($theater_id);

        $theater_map = $theater->theater_map ? collect($theater->theater_map)->flatten(1) : [];

        if(count($theater_map) == 0){
            throw new Exception("Map is empty");
        }
        return $theater_map;

    }

    public function getSeatFromTheaterMap($theater_map , $seat){

      
       
        try {
            $seat = $theater_map->where('code' , $seat)->first();

            

            if(!$seat){
                throw new Exception("Seat of code  {$seat} was not found");
            }

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }


        return $seat;

    }

    public function getSeatsFromTheaterMap($theater_map , $seats){

        try {
            $object_seats = $theater_map->whereIn('code' , $seats)->values();

            if(count($object_seats) == count($seats) ){
                throw new Exception("Seats are missing");
            }

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }

        return $object_seats;

    }

}
