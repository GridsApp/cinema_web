<?php

namespace App\Reports;

use twa\cmsv2\Reports\DefaultReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserSurveyRatingsReport extends DefaultReport
{
    public $label = "User Survey Ratings Report";

    public function filters()
    {
        $this->addFilter('filter_start_date');
        $this->addFilter('filter_end_date');
        // $this->addFilter('filter_branch');
        // $this->addFilter('filter_pos_user');
    }

    public function header()
    {

        $this->columns = collect([]);
        $this->addColumn('user_id', 'User ID');
        $this->addColumn('user', 'User');
        $this->addColumn('user_phone', 'User Phone');
        $this->addColumn('created_at', 'Submission Date (d-m-Y)');
        $this->addColumn('movie', 'Movie');
        $this->addColumn('rating_movie', 'Rating Movie');
        $this->addColumn('rating_popcorn_pepsi', 'Rating Popcorn Pepsi');
        $this->addColumn('rating_other_items', 'Rating Other Items');
        $this->addColumn('rating_ticketing_service', 'Rating Ticketing Service');
        $this->addColumn('rating_cafeteria_service', 'Rating Cafeteria Service');
        $this->addColumn('rating_users_service', 'Rating Users Service');
        $this->addColumn('rating_ticketing_friendliness', 'Rating Ticketing Friendliness');
        $this->addColumn('rating_cafeteria_friendliness', 'Rating Cafeteria Friendliness');
        $this->addColumn('rating_users_friendliness', 'Rating Users Friendliness');
        $this->addColumn('rating_ticketing_cleanliness', 'Rating Ticketing Cleanliness');
        $this->addColumn('rating_cafeteria_cleanliness', 'Rating Cafeteria Cleanliness');
        $this->addColumn('rating_users_cleanliness', 'Rating Users Cleanliness');
        $this->addColumn('rating_app', 'Rating App');
    }

    public function rows()
    {
        if (!$this->filterResults) {
            return [];
        }
    
        $dateRange = isset($this->filterResults['start_date'], $this->filterResults['end_date'])
            ? [Carbon::parse($this->filterResults['start_date'])->startOfDay(), Carbon::parse($this->filterResults['end_date'])->endOfDay()]
            : null;
    
        $query = DB::table('survey_results')
            ->leftJoin('orders', 'survey_results.order_id', '=', 'orders.id')
            ->leftJoin('users', 'survey_results.user_id', '=', 'users.id')
            ->join('order_seats', 'orders.id', '=', 'order_seats.order_id')
            ->leftJoin('movies', 'order_seats.movie_id', '=', 'movies.id') // if movie info is needed
            ->when($dateRange, fn($q) => $q->whereBetween('survey_results.created_at', $dateRange))
            ->when(!empty($this->filterResults['branch_id']), fn($q) =>
                $q->where('orders.branch_id', $this->filterResults['branch_id']))
            ->when(!empty($this->filterResults['pos_user_id']), fn($q) =>
                $q->where('orders.pos_user_id', $this->filterResults['pos_user_id']))
            ->select([
                'users.name as user',
                'users.phone as user_phone',
                'users.id as user_id',
                'movies.name as movie',
                'survey_results.rating_movie',
                'survey_results.rating_popcorn_pepsi',
                'survey_results.rating_other_items',
                'survey_results.rating_ticketing_service',
                'survey_results.rating_cafeteria_service',
                'survey_results.rating_users_service',
                'survey_results.rating_ticketing_friendliness',
                'survey_results.rating_cafeteria_friendliness',
                'survey_results.rating_users_friendliness',
                'survey_results.rating_ticketing_cleanliness',
                'survey_results.rating_cafeteria_cleanliness',
                'survey_results.rating_users_cleanliness',
                'survey_results.rating_app',
                'survey_results.created_at',
            ])
            ->groupBy('survey_results.id', 'users.name', 'movies.name');
    
        $results = $query->get();
    

 
        return $results->map(function ($item) {
            return [
                'user' => $item->user,
                'user_id' => $item->user_id,
                'user_phone' => $item->user_phone,
                'created_at' => now()->parse($item->created_at)->format('d-m-Y'),
                'movie' => $item->movie,
                'rating_movie' => $this->formatRating($item->rating_movie),
                'rating_popcorn_pepsi' => $this->formatRating($item->rating_popcorn_pepsi),
                'rating_other_items' => $this->formatRating($item->rating_other_items),
                'rating_ticketing_service' => $this->formatRating($item->rating_ticketing_service),
                'rating_cafeteria_service' => $this->formatRating($item->rating_cafeteria_service),
                'rating_users_service' => $this->formatRating($item->rating_users_service),
                'rating_ticketing_friendliness' => $this->formatRating($item->rating_ticketing_friendliness),
                'rating_cafeteria_friendliness' => $this->formatRating($item->rating_cafeteria_friendliness),
                'rating_users_friendliness' => $this->formatRating($item->rating_users_friendliness),
                'rating_ticketing_cleanliness' => $this->formatRating($item->rating_ticketing_cleanliness),
                'rating_cafeteria_cleanliness' => $this->formatRating($item->rating_cafeteria_cleanliness),
                'rating_users_cleanliness' => $this->formatRating($item->rating_users_cleanliness),
                'rating_app' => $this->formatRating($item->rating_app),
            ];
        })->toArray(); // Convert collection to array
        

      
    }

    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
    

    protected function formatRating($rating)
    {
        return $rating ? $rating . ' / 5' : '-';
    }
}
