<?php

namespace App\Repositories;

use App\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use App\Models\MovieAgeRating;
use App\Models\MovieCast;
use App\Models\MovieDirector;
use App\Models\MovieFavorite;
use App\Models\MovieGenre;
use App\Models\MovieLanguage;
use App\Models\MovieReview;
use App\Models\MovieShow;
use App\Models\Order;
use App\Models\OrderSeat;
use App\Models\Theater;
use App\Models\Time;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MovieRepository implements MovieRepositoryInterface
{

    public function getMovie($id, $user = null)
    {
        $movie = Movie::whereNull('deleted_at')->where('id', $id)->first();


        if (!$movie) {
            return null;
        }

        $genres = [];
        if (is_array($movie->genre_id) && count($movie->genre_id) > 0) {
            $genres = MovieGenre::select("id", "label_".app()->getLocale()." as label")->whereIn('id', $movie->genre_id)->whereNull('deleted_at')->get();
        }

        $casts = [];
        if (is_array($movie->cast_id) && count($movie->cast_id) > 0) {
            $casts = MovieCast::select("id", "name", "image")
                ->whereIn('id', $movie->cast_id)
                ->whereNull('deleted_at')
                ->get()
                ->map(function ($cast) {
                    return [
                        'id' => $cast->id,
                        'name' => $cast->name,
                        'image' => get_image($cast->image),
                    ];
                });
        }

        $director = null;
        if ($movie->director_id) {
            $director = MovieDirector::select("id", "name")->where('id', $movie->director_id)->whereNull('deleted_at')->first();
        }

        $age_rating = null;
        if ($movie->age_rating_id) {
            $age_rating = MovieAgeRating::select("id", "label")->where('id', $movie->age_rating_id)->whereNull('deleted_at')->first();
        }


        $language = null;
        if ($movie->language_id) {
            $language = MovieLanguage::select("id", "label")->where('id', $movie->language_id)->whereNull('deleted_at')->first();
        }


        $is_favorite = false;
        if ($user) {
            $is_favorite = MovieFavorite::where('user_id', $user->id)->where('movie_id', $movie->id)->exists();
        }
        $can_review = false;
        if ($user) {
            // dd("e");

            $now_time = now()->subHours(3)->format('h:i');
            $times = Time::where('label' , '<=' , $now_time)->pluck('id');

            $seats_found = DB::table('order_seats')->whereNull('order_seats.refunded_at')->where('order_seats.movie_id', $movie->id)
                ->join('orders' , 'order_seats.order_id' ,'orders.id')
                ->where(function($q) use ($times){
                    $q->whereDate('order_seats.date' , '<' , now());
                    $q->orWhere(function($q1) use ($times){
                        $q1->whereDate('order_seats.date' , now());
                        $q1->whereIn('order_seats.time_id' , $times);
                    });
                })
                ->where('orders.user_id' , $user->id)
                ->first();

            // dd($seats_found);

            // dd($order_seat);

            $can_review = $seats_found ? true : false;



        }

        $movie = [
            'id' => $movie->id,
            'name' => $movie->name,
            'condensed_name' => $movie->condensed_name,
            'movie_key' => $movie->movie_key,
            'description' => $movie->description,
            'duration' => minutes_to_human($movie->duration),
            'release_date' => now()->parse($movie->release_date)->format('F d, Y'),
            'main_image' => get_image($movie->main_image),
            'cover_image' => get_image($movie->cover_image),
            'director' => $director,
            'genres' => $genres,
            'casts' => $casts,
            'age_rating' => $age_rating,
            'language' => $language,
            'imdb_rating' => $movie->imdb_rating,
            'imdb_vote' => $movie->imdb_vote,
            'youtube_video' => $movie->youtube_video,
            'is_favorite' => $is_favorite,
            'disable_booking' => false,
            'can_review' => $can_review,
        ];

        return $movie;
    }

    public function getMovies($ids)
    {

        $movies = Movie::select('id', 'name', 'release_date', 'main_image', 'duration', 'genre_id', 'slug')->whereNull('deleted_at')
            ->whereIn('id', $ids)
            ->get();


        $available_genre_ids = $movies->pluck('genre_id')->flatten()->unique()->values();
        $genres = MovieGenre::select("id", "label_".app()->getLocale()." as label")->whereIn('id', $available_genre_ids)->whereNull('deleted_at')->get();

        return $movies->map(function ($movie) use ($genres) {
            return [
                'id' => $movie->id,
                'slug' => $movie->slug,
                'main_image' => get_image($movie->main_image),
                'name' => $movie->name,
                'duration' => minutes_to_human($movie->duration),
                'genres' => $genres->whereIn('id', $movie->genre_id)->values()
            ];
        });
    }

    public function getBranchActiveMovies($branch_id, $date)
    {
        $theaters_ids = Theater::select('id')->whereNull('deleted_at')->where('branch_id', $branch_id)->pluck('id');


        $today = now();

        $strict = $today->format('d-m-Y') == $date->format('d-m-Y');

        $times = [];
        if($strict){
            $current_time = (string) now()->setTimezone(env('TIMEZONE', 'Asia/Baghdad'))->subMinutes(35)->format('H:i');
            $round_time = round_time($current_time);
            $times = Time::whereNull('deleted_at')->where('iso' , '>=' , $round_time)->pluck('id')->toArray();
        }

        $oneMonthAgo = now()->subMonths(1);
        $comingSoonOffset = now()->addMonths(8);
        $recentShowtimeCutoff = now();



        $movies = Movie::select('id', 'name', 'release_date', 'main_image', 'duration', 'genre_id', 'slug')->whereNull('deleted_at')
            ->where(function ($query) use ($today, $date, $oneMonthAgo, $recentShowtimeCutoff, $comingSoonOffset, $theaters_ids , $times , $strict) {
                $query->whereHas('movieShows', function ($q) use ($recentShowtimeCutoff, $today, $date, $theaters_ids , $times , $strict) {
                    $q->whereNull('deleted_at')
                        ->when($strict, function ($q1) use ($times) {
                            $q1->whereIn('time_id', $times);
                        })
                        ->whereDate('date', $date) // Now Showing
                        ->whereIn('theater_id', $theaters_ids);
                })

                    ->orWhere(function ($q) use ($oneMonthAgo, $today, $theaters_ids) {
                        $q->whereBetween('release_date', [$oneMonthAgo, $today]) // New Movies
                        ->whereHas('movieShows', function ($subQ) use ($theaters_ids) {
                            $subQ->whereIn('theater_id', $theaters_ids);
                        });
                    })
                    ->orWhere(function ($q) use ($today, $comingSoonOffset, $theaters_ids) {

                        $q->where('coming_soon', 1); // Coming Soon

//                    $q->whereBetween('release_date', [$today, $comingSoonOffset])
//                      ->whereHas('movieShows', function ($subQ) use ($theaters_ids) {
//                          $subQ->whereIn('theater_id', $theaters_ids);
//                      });
                    });

            })
            ->with(['movieShows' => function ($query) use ($recentShowtimeCutoff, $today , $times , $strict , $date , $theaters_ids) {
                $query->whereDate('date', $date)
                    ->when($strict, function ($q1) use ($times) {
                        $q1->whereIn('time_id', $times);
                    })
                    ->whereIn('theater_id', $theaters_ids);
                ;
            }]) // Can be removed. only for optimization
            ->get();


        $available_genre_ids = $movies->pluck('genre_id')->flatten()->unique()->values();
        $genres = MovieGenre::select("id", "label_".app()->getLocale().' as label')->whereIn('id', $available_genre_ids)->whereNull('deleted_at')->get();

        return $movies->map(function ($movie) use ($genres, $today, $oneMonthAgo, $comingSoonOffset) {


            $categories = [];
            $release_date = now()->parse($movie->release_date);

            // if(request()->has('debug') && $movie->id == 30){
            //     dd($movie->movieShows);
            // }

            if ($movie->movieShows->isNotEmpty()) {
                $categories[] = 'now-showing';
            }
            if ($release_date->between($oneMonthAgo, $today)) {
                $categories[] = 'new-movies';
            }
            if ($release_date->between($today->copy()->addDay(), $comingSoonOffset)) {
                $categories[] = 'coming-soon';
            }

            return [
                'id' => $movie->id,
                'main_image' => get_image($movie->main_image),
                'name' => $movie->name,
                'slug' => $movie->slug,

                'duration' => minutes_to_human($movie->duration),
                'genres' => $genres->whereIn('id', $movie->genre_id)->values(),
                'categories' =>  $categories,
            ];
        });
    }

    public function searchMovies($search)
    {


        $words = explode(" ", $search);

        return Movie::whereNull('deleted_at')->where(function ($q) use ($words) {
            foreach ($words as $word) {

                $word = trim($word);

                $q->orWhere('name', 'LIKE', '%' . $word);
                $q->orWhere('name', 'LIKE', $word . '%');
                $q->orWhere('name', 'LIKE', '% ' . $word);
                $q->orWhere('name', 'LIKE', $word . ' %');
            }

        })
            ->limit(10)
            ->get()->map(function ($movie) {
                return [
                    'id' => $movie->id,
                    'genre' => $movie->genre->label,
                    'name' => $movie->name,
                    'description' => $movie->description,
                    'duration' => minutes_to_human($movie->duration),
                    'main_image' => get_image($movie->main_image, 'thumb')
                ];
            });
    }





    public function getMovieShows($branch_id, $movie_id, $date)
    {

        $theaters = Theater::where('branch_id', $branch_id)
            ->whereNull('deleted_at')
            ->with(['movieShows' => function ($query) use ($movie_id, $date) {
                $query->where('movie_id', $movie_id)
                    ->whereDate('date', $date)
                    ->with([
                        'screenType',
                        'seats' => function ($seatQuery) {
                            $seatQuery->where('is_reserved', false);
                        }
                    ]);
            }])
            ->get();

        dd($theaters);

        // Map the data to the desired format
        $theaterData = $theaters->flatMap(function ($theater) {
            return $theater->movieShows->map(function ($show) use ($theater) {
                return [
                    'theater' => $theater->name,
                    'screen_type' => $show->screenType->label ?? 'Unknown',
                    'time_id' => $show->id,
                    'available_seats' => $show->seats->count(),
                    'movie' => [
                        'name' => $show->movie->name,
                        'duration' => minutes_to_human($show->movie->duration),
                    ],
                ];
            });
        });

        return $theaterData;
    }
}
