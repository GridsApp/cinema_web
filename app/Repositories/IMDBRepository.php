<?php

namespace App\Repositories;


use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class IMDBRepository
{

    public function generate(){

        do {
            $nbr = random_int(1000000, 9999999);
        } while (Movie::where("movie_key", "=", $nbr)->first() instanceof Movie);

        return "IH".$nbr;

    }

    public function query($key){

     
        $response =  Http::get("https://www.omdbapi.com/?i=$key&apikey=e40ab84b");

        $json = $response->json();

        if(!$response->ok() || ($response->ok() && !$json)){
           
            return ['error' => true  , "message" => "Unable to resolve endpoint"];
        }

        $existing_movie = Movie::whereNull('deleted_at')->where('movie_key' , $key)->first();
        if($existing_movie){
            return ['error' => true  , "message" => "This movie already exists"];
        }

    
       
        if(isset($json["Error"])){
            return ['error' => true  , "message" => "Unable to fetch data"];
        }

        $AgeRate = "";
        if($json["Rated"] !=  "N/A" && !empty($json["Rated"])){
            try {

                preg_match_all('!\d+!', $json["Rated"], $matches);

                $AgeRate = $matches[0][0];
                $AgeRate .= "+";
            } catch (\Throwable $th) {

                $AgeRate = "";
            }
        }

        $director =$this->createOrGetID($json["Director"] , "movie_directors" , "name");
        $age_rating = $this->createOrGetID($AgeRate , "movie_age_ratings" , "label");
        $language = $this->createOrGetID($json["Language"] , "movie_languages" , "label");
        $casts = $this->createOrGetIDs($json["Actors"] , "movie_casts" , "name");
        $genres = $this->createOrGetIDs($json["Genre"] , "movie_genres" , ["label_en"]);

        $image = $json["Poster"] ==  "N/A" || empty( $json["Poster"]) ? null : $json["Poster"];

//        https://m.media-amazon.com/images/M/MV5BMjMyNDkzMzI1OF5BMl5BanBnXkFtZTgwODcxODg5MjI@._V1_SX300.jpg

        $final = null;


        if($image){

            $field = config('fields.main_image');

            [$name , $extension] = $this->splitOnLastDot($this->splitOnLastSlash($image)[1] ?? "");

            $imageContents = file_get_contents($image);



            $file = [
                'file' => $image,
                'crop' => isset($file['cropping']) ? [
                    'x' => 0,
                    'y' => 0,
                    'width' => 400,
                    'height' => 600
                ] : null
            ];



            $final = (new UploadController($field))->uploadFromSource($file, $imageContents , $extension);

            

        }

        $payload = [
//                "movie_key" => $key,
                "name" => $json["Title"],
                "condensed_name" => $json["Title"],
                'director_id' => $director,
                'age_rating_id' => $age_rating,
                'language_id' => $language,
                'cast_id' => json_encode($casts),
                'genre_id' => json_encode($genres),
                "description" => $json["Plot"],
                "duration" => str_replace(["min", " "] , [""], $json["Runtime"]),
                "release_date" => $json["Released"] == 'N/A' || empty($json["Released"]) ?  null : Carbon::parse($json["Released"])->format("Y-m-d"),
                "imdb_rating" => $json["imdbRating"],
                "imdb_vote" => $json["imdbVotes"],
                "main_image" => $final
        ];



        return $payload;
    }

    function splitOnLastSlash($string) {
        $lastDotPos = strrpos($string, '/');
        if ($lastDotPos === false) {
            return [$string];  // No dot found, return the entire string
        }
        $beforeDot = substr($string, 0, $lastDotPos);
        $afterDot = substr($string, $lastDotPos + 1);
        return [$beforeDot, $afterDot];
    }

    function splitOnLastDot($string) {
        $lastDotPos = strrpos($string, '.');
        if ($lastDotPos === false) {
            return [$string];  // No dot found, return the entire string
        }
        $beforeDot = substr($string, 0, $lastDotPos);
        $afterDot = substr($string, $lastDotPos + 1);
        return [$beforeDot, $afterDot];
    }

    public function createOrGetID($value , $table , $field){
        if($value ==  "N/A" || empty($value)){ return null; }

        try {
            $query = DB::table($table)->where(is_array($field)? $field[0] : $field , $value)->whereNull('deleted_at')->first();
            if(!$query){
                $input = [];
                if(is_array($field)){
                    foreach($field as $key){
                        $input[$key] = $value;
                    }
                }else{
                  $input = [
                    $field => $value
                  ];
                }
                $result = (string) DB::table($table)->insertGetId($input);
            }else{
                $result = (string) $query->id;
            }
        } catch (\Throwable $th) {
            $result = "";
        }

        return $result;
    }

    public function createOrGetIDs($value , $table , $field){
        if($value ==  "N/A" || empty($value)){ return []; }
        $arr = explode("," , $value);
        $result = [];

        foreach($arr as $arr_value){
            $arr_value = trim($arr_value);
            $result [] = $this->createOrGetID($arr_value , $table , $field);
        }

        return $result;
    }
}
