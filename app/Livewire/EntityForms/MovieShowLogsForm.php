<?php

namespace App\Livewire\EntityForms;

use App\Jobs\ProcessMovieShowCreationLogs;
use Carbon\CarbonPeriod;
use Livewire\Component;
use App\Models\MovieShow;
use App\Models\Movie;
use App\Models\MovieShowCreationLog;
use App\Models\ScreenType;
use App\Models\Theater;
use App\Models\Time;
use App\Rules\TimeConflictRule;
use twa\uikit\Traits\ToastTrait;


class MovieShowLogsForm extends Component
{
    use ToastTrait;


    public $json = [];

    public $form = [
        'movie_id' => null,
        'screen_type_id' => null,
        'theater_ids' => [],
        'time_ids' => [],
        'date_from' => null,
        'date_to' => null,

    ];

    public $uniqeid;
    public $logs = [];
    public $screenTypes = [];

    public function resetForm()
    {
        $this->form = [
            'movie_id' => null,
            'screen_type_id' => null,
            'theater_ids' => [],
            'time_ids' => [],
            'date_from' => null,
            'date_to' => null,
        ];
    }

    public function mount()
    {
        $this->screenTypes = ScreenType::all();


       $this->resetForm();
    }
    public $already_not_done = [];
    public $allDone = false;

    public function render()
    {

        $cms_user = session('cms_user');

        $this->already_not_done = MovieShowCreationLog::whereNull('deleted_at')->where('cms_user_id', $cms_user->id)->get();


        $this->logs = collect($this->already_not_done)->where('status', '!=', 'pending');




        return view('pages.form.components.movie-show-logs-form');
    }

    public function done()
    {
        $cms_user = session('cms_user');

        MovieShowCreationLog::where('cms_user_id', $cms_user->id)
            ->whereNull('deleted_at')
            ->delete();
            $this->resetForm();

        // $this->sendSuccess('Deleted Successfully.','All logs have been deleted.');
    }



    public function generate()
    {

        $this->json = [];

        $required_array = [
            'form.movie_id' => 'required',
            'form.screen_type_id' => 'required',
            'form.theater_ids' => 'required|array',
            'form.time_ids' => 'required|array',
            'form.date_from' => 'required',
            'form.date_to' => 'required',

        ];





        $required_messages = [
            'form.movie_id' => 'movie',
            'form.screen_type_id' => 'screen type',
            'theater_ids' => 'theater',
            'time_ids' => 'time',
            'form.date_from' => 'date from',
            'form.date_to' => 'date to',

        ];

        $this->validate($required_array, [], $required_messages);


        $movie = Movie::find($this->form['movie_id']);

        if (!$movie) {
            return;
        }

        $screenTypeId = $this->form['screen_type_id'];

        $period = CarbonPeriod::create($this->form['date_from'], $this->form['date_to']);



        foreach ($period as $date) {
            $formattedDate = $date->format('D j M, Y');

            foreach ($this->form['theater_ids'] as $theaterId) {
                $theater = Theater::find($theaterId);

                foreach ($this->form['time_ids'] as $timeId) {
                    $time = Time::find($timeId);

                    $this->json[] = [
                        'movie' => [
                            'value' => $movie->id ?? null,
                            'label' => $movie->condensed_name ?? '-',
                        ],
                        'theater' => [
                            'value' => $theater->id ?? null,
                            'label' => ($theater->branch->label_en ?? '-') . ' / ' . ($theater->label ?? ''),
                        ],
                        'time' => [
                            'value' => $time->id ?? null,
                            'label' => $time->label ?? '-',
                        ],
                        'date' => [
                            'value' => $date->format('Y-m-d'),
                            'label' => $formattedDate,
                        ],
                        'screen_type_id' => $screenTypeId,
                    ];
                }
            }
        }

        $this->resetForm();
    }

    public function submit()
    {

       
        $cms_user = session('cms_user');

        $pendingLogs = MovieShowCreationLog::whereNull('deleted_at')
            ->where('cms_user_id', $cms_user->id)
            ->where('status', 'pending')
            ->exists();

        if ($pendingLogs) {
            $this->sendError('You have pending logs' . 'Please wait until they are processed');
            return;
        }

       

        $data = collect($this->json)->map(function ($item) use ($cms_user) {
            // $week = calculate_week_from_start_year($item['date']['value']);

            return [
                'cms_user_id'     => $cms_user->id,
                'movie_id'        => $item['movie']['value'],
                'theater_id'      => $item['theater']['value'],
                'time_id'         => $item['time']['value'],
                'date'            => $item['date']['value'],
                'screen_type_id'  => $item['screen_type_id'] ?? null,
                'status'  => "pending",
                'created_at'      => now(),
                'updated_at'      => now(),
                // 'group' => md5($item['movie']['value'].$item['theater']['value'].$item['time']['value'].$week)
            ];
        })->toArray();


        MovieShowCreationLog::insert($data);
        $this->json = [];
        $newLogs = MovieShowCreationLog::whereNull('deleted_at')
            ->where('cms_user_id', $cms_user->id)
            ->where('status', 'pending')
            ->get();


    
        foreach ($newLogs as $log) {
            ProcessMovieShowCreationLogs::dispatch($log);
        }


        $this->sendSuccess('Successfully saved.', 'Movie show logs successfully saved.');
    }


    
}
