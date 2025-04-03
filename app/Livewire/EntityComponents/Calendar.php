<?php

namespace App\Livewire\EntityComponents;

use App\Models\MovieShow;
use App\Models\Time;
use twa\uikit\Traits\ToastTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class Calendar extends Component
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


    public function handleNextWeek(){


        $this->date_from = Carbon::parse($this->date_from)->addDays(7)->format("d-m-Y");
        $this->date_to = Carbon::parse($this->date_to)->addDays(7)->format("d-m-Y");

    }

    public function handlePrevWeek(){
        $this->date_from = Carbon::parse($this->date_from)->subDays(7)->format("d-m-Y");
        $this->date_to = Carbon::parse($this->date_to)->subDays(7)->format("d-m-Y");
    }


    public function mount(){

        $this->canDrag = cms_check_permission('can-drag');
     
        if(!$this->date_from && !$this->date_to){

        $today = Carbon::now();

        if(in_array($today->format('l') , ["Monday" , "Tuesday" , "Wednesday"])){
            $referenceDate = $today->subDays(7)->startOfWeek();
        }else{
            $referenceDate = $today->startOfWeek();
        }

        $this->date_from = $referenceDate->copy()->addDays(3)->format("d-m-Y");
        $this->date_to = $referenceDate->copy()->addDays(9)->format("d-m-Y");

    }
        $this->times = Time::whereNull('deleted_at')->get()->pluck('label')->toArray();


        $this->info = [
            'id' => uniqid(),
            'listen' =>  [
                "init" => "theaterselectedvalue",
                "change" =>  "theaterchangedvalue"
            ],
        ];
        
    }




    public function deleteMovieShows(){
        
       MovieShow::whereIn('id' , $this->selected)
            ->update([
                'deleted_at' => now()
            ]);
        
        $this->dispatch('empty-selected');
        
        $this->sendSuccess(...["Successfully Deleted",
            "Movie Shows you have selected were successfully deleted"]);

        $this->skipRender();
        
    }

    public function updateInfo($id , $dateIndex , $timeIndex ){

            $date = $this->days[$dateIndex]['value'] ?? null;
            $time = $this->times[$timeIndex] ?? null;

            if(!$time || !$date){
                return;
            }

            $time = Time::where('label' , $time)->first();
            if(!$time){
                return;
            }

            $existing_movie_show = MovieShow::find($id);

            if(!$existing_movie_show){
                return; 
            }
  

            $slots = ceil($existing_movie_show->duration / 15);;

            if(!validate_movie_show($existing_movie_show->theater_id , now()->parse($date) , $time->id , $slots , [$id])){
                $this->sendError('Scheduling Conflict.', 'The target movie showtime overlaps with an existing show');
                return;
            }

            MovieShow::where('id' , $id)
                ->update([
                    'date' => now()->parse($date),
                    'time_id' => $time->id
            ]);

            $this->skipRender();
    }

    function getMinutesDifference($startTime, $endTime) {
        list($startHours, $startMinutes) = explode(":", $startTime);
        list($endHours, $endMinutes) = explode(":", $endTime);

        // Create DateTime objects for start and end times
        $startDate = new \DateTime();
        $startDate->setTime((int)$startHours, (int)$startMinutes);

        $endDate = new \DateTime();
        $endDate->setTime((int)$endHours, (int)$endMinutes);

        // Calculate the difference in minutes
        $diffInSeconds = $endDate->getTimestamp() - $startDate->getTimestamp();
        $diffInMinutes = floor($diffInSeconds / 60);

        return $diffInMinutes;
    }


    public function updateEvents(){
        $this->getEvents();
        $this->selected = [];
    }

    public function getEvents()
    {
        $dayIndex = [
            "thursday" => 0,
            "friday" => 1,
            "saturday" => 2,
            "sunday" => 3,
            "monday" => 4,
            "tuesday" => 5,
            "wednesday" => 6
        ];

        if(!$this->theater_id){
            $this->events = collect([]);
            return;
        }

        $gap = 0;
        $this->events = MovieShow::select([
            'movie_shows.id',
            'movie_shows.group',
            'movie_shows.color',
            'movies.name as label',
            'times.label as time',
            'movie_shows.duration',
            'movie_shows.week',
            DB::raw("DATE_FORMAT(movie_shows.date, '%d-%m-%Y') as date")
        ])
            ->where('movie_shows.theater_id', $this->theater_id)
            ->whereBetween('movie_shows.date', [Carbon::parse($this->date_from), Carbon::parse($this->date_to)])
            ->leftJoin('movies', 'movie_shows.movie_id', 'movies.id')
            ->leftJoin('times', 'movie_shows.time_id', 'times.id')
            ->whereNull('movie_shows.deleted_at')
            ->get()->map(function ($event) use($dayIndex){
                $minutes = $this->getMinutesDifference($this->times[0] , $event->time);
                return [

                        'active' => $event->id == $this->movie_show_id,
                        'details' => $event,
                        'reserved' => $event->reserved->count(),
                        'id' => $event->id,
                        'group'=> $event->group,
                        'date'=> $event->date,
                        'dayIndex' => $dayIndex[str(now()->parse($event->date)->format('l'))->lower()->toString()],
                        'time'=> $event->time,
                        'height'=> ($event->duration / 60) * 120 - 1,
                        'top'=> ($minutes / 60) * 120
                ];

            });
    }

    public function render()
    {

        $this->days = collect(CarbonPeriod::create($this->date_from, $this->date_to))->map(function ($date) {
            return [
                'value' => $date->format("d-m-Y"),
                'label' => $date->format("D d M")
            ];
        });

        $this->getEvents();

        return view('pages.entity.components.calendar');
    }
}
