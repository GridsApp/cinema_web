<?php

namespace App\Reports;

use twa\cmsv2\Reports\DefaultReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SurveyRatingsReport extends DefaultReport
{


    public $label = "Survey Ratings Report";



    public function filters()
    {
        $this->addFilter('filter_start_date');
        $this->addFilter('filter_end_date');
        $this->addFilter('filter_branch');
        $this->addFilter('filter_pos_user');
    }

    public function header()
    {
        $this->addColumn('metric', 'Metric');
        $this->addColumn('average', 'Average Score');
        $this->addColumn('percentage', 'Satisfaction (%)');
    }


    public function rows()
    {
        if (!$this->filterResults) {
            return [];
        }
    
        $dateRange = isset($this->filterResults['start_date'], $this->filterResults['end_date'])
            ? [Carbon::parse($this->filterResults['start_date'])->startOfDay(), Carbon::parse($this->filterResults['end_date'])->endOfDay()]
            : null;
    
        $baseQuery = DB::table('surveys')
            ->join('orders', 'surveys.order_id', '=', 'orders.id')
            ->when($dateRange, fn($q) => $q->whereBetween('surveys.created_at', $dateRange))
            ->when(!empty($this->filterResults['branch_id']), fn($q) =>
                $q->where('orders.branch_id', $this->filterResults['branch_id']))
            ->when(!empty($this->filterResults['pos_user_id']), fn($q) =>
                $q->where('orders.pos_user_id', $this->filterResults['pos_user_id']));
    
        $ratings = [
            'rating_movie' => 'Movie Experience',
            'rating_popcorn_pepsi' => 'Popcorn & Pepsi',
            'rating_other_items' => 'Other Items',
            'rating_ticketing_service' => 'Ticketing Service',
            'rating_cafeteria_service' => 'Cafeteria Service',
            'rating_users_service' => 'User Service',
            'rating_ticketing_friendliness' => 'Ticketing Friendliness',
            'rating_cafeteria_friendliness' => 'Cafeteria Friendliness',
            'rating_users_friendliness' => 'User Friendliness',
            'rating_ticketing_cleanliness' => 'Ticketing Cleanliness',
            'rating_cafeteria_cleanliness' => 'Cafeteria Cleanliness',
            'rating_users_cleanliness' => 'User Cleanliness',
            'rating_app' => 'App Experience',
        ];
    
        $results = $baseQuery->selectRaw("
            COUNT(*) as total_surveys,
            AVG(rating_movie) as rating_movie,
            AVG(rating_popcorn_pepsi) as rating_popcorn_pepsi,
            AVG(rating_other_items) as rating_other_items,
            AVG(rating_ticketing_service) as rating_ticketing_service,
            AVG(rating_cafeteria_service) as rating_cafeteria_service,
            AVG(rating_users_service) as rating_users_service,
            AVG(rating_ticketing_friendliness) as rating_ticketing_friendliness,
            AVG(rating_cafeteria_friendliness) as rating_cafeteria_friendliness,
            AVG(rating_users_friendliness) as rating_users_friendliness,
            AVG(rating_ticketing_cleanliness) as rating_ticketing_cleanliness,
            AVG(rating_cafeteria_cleanliness) as rating_cafeteria_cleanliness,
            AVG(rating_users_cleanliness) as rating_users_cleanliness,
            AVG(rating_app) as rating_app
        ")->first();
    
        $maxRating = 5;
        $rows = [];
    
        foreach ($ratings as $field => $label) {
            $avg = round($results->$field, 2);
            $percentage = round(($avg / $maxRating) * 100);
    
            $rows[] = [
                'metric' => $label,
                'average' => $avg,
                'percentage' => $percentage . '%',
            ];
        }
    
        // Optional: add a final footer row with total responses
        $this->setFooter([
            'metric' => 'Total Surveys',
            'average' => $results->total_surveys,
            'percentage' => '-',
        ]);
    
        return $rows;
    }
    


}