<?php

namespace App\Livewire\EntityComponents;

use App\Jobs\CalculateOrderDistShare;
use App\Models\MovieShow;
use App\Models\Time;
use twa\uikit\Traits\ToastTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class ReviewWeekNumber extends Component
{

    use ToastTrait;

    public $canDrag;
    public $times;
    public $info;

    public $selected = [];
    public $days;

    #[Url]
    public $theater_id = null;
    public $events = [];

    #[Url]
    public $movie_show_id = null;


    #[Url]
    public $date_from = null;
    #[Url]
    public $date_to = null;


    public function handleNextWeek()
    {


        $this->date_from = Carbon::parse($this->date_from)->addDays(7)->format("d-m-Y");
        $this->date_to = Carbon::parse($this->date_to)->addDays(7)->format("d-m-Y");
    }

    public function handlePrevWeek()
    {
        $this->date_from = Carbon::parse($this->date_from)->subDays(7)->format("d-m-Y");
        $this->date_to = Carbon::parse($this->date_to)->subDays(7)->format("d-m-Y");
    }


    public function mount()
    {

       

        if (!$this->date_from && !$this->date_to) {

            $today = Carbon::now();

            if (in_array($today->format('l'), ["Monday", "Tuesday", "Wednesday"])) {
                $referenceDate = $today->subDays(7)->startOfWeek();
            } else {
                $referenceDate = $today->startOfWeek();
            }

            $this->date_from = $referenceDate->copy()->addDays(3)->format("d-m-Y");
            $this->date_to = $referenceDate->copy()->addDays(9)->format("d-m-Y");
        }
   
    }


    public function handleWeekUpdate($show_id , $value)
    {


       $movie_show =  MovieShow::find($show_id);

       if($movie_show->week == $value){
        return $this->sendError( 'Week not updated', 'You have entered the same week number' );
       }


        // Movie Show

        try {
          

        DB::beginTransaction();

        //Movie shows
        DB::table('movie_shows')->where('id' , $show_id)->update([
            'week' => $value
        ]);


        // Cart Seats
        DB::table('cart_seats')->where('movie_show_id' , $show_id)->update([
            'week' => $value
        ]);

        // Order Seats
        DB::table('order_seats')->where('movie_show_id' , $show_id)->update([
            'week' => $value,
            'dist_share_percentage' => null,
            'dist_share_amount' => null
        ]);
        
        DB::commit();

          //code...
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->sendError('Week update failed' , 'The week number is not updated');
        }
        
        dispatch((new CalculateOrderDistShare));

        return $this->sendSuccess('Week updated' , 'The week number is successfully updated');
    }




 
    public function get()
    {



      return MovieShow::whereNull('movie_shows.deleted_at')
       ->select('movie_shows.id' , 'movies.condensed_name as movie_name' , 'branches.label_en as branch' , 'theaters.label as theater' , 'movie_shows.week' , 'times.label as time' , 'movie_shows.date')
       ->join('movies' , 'movie_shows.movie_id' , 'movies.id')
       ->join('theaters', 'movie_shows.theater_id' , 'theaters.id')
       ->join('times', 'movie_shows.time_id' , 'times.id')
       ->join('branches', 'theaters.branch_id' , 'branches.id')
       ->orderBy('branches.id', 'ASC')
       ->orderBy( 'movie_shows.theater_id' , 'ASC')
       ->orderBy( 'movie_shows.date' , 'ASC')
       ->orderBy( 'movie_shows.time_id', 'ASC')

       ->whereBetween('movie_shows.date' , [ now()->parse($this->date_from) , now()->parse($this->date_to)])
       ->get()->groupBy('movie_name')->map(function($shows){

       

        $maxElement = $shows->pluck('week')
        ->countBy()
        ->sortDesc()
        ->keys()
        ->first();

        return $shows->map(function($show) use ($maxElement){

            $show->max_week = $maxElement;

            return $show;

        });

       

       });


       
    }

    public function render()
    {

      
        $shows = $this->get();

       

        return view('pages.entity.components.review-week-number' , ['shows' => $shows]);
    }
}
