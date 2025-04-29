<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Movie;
use App\Models\MovieShow;
use Carbon\CarbonPeriod;
use Livewire\Attributes\Url;
use twa\uikit\Traits\ToastTrait;

class ManageBookings extends Component
{

    use ToastTrait;


    #[Url]
    public $date;
    public $canToggle;


    public function mount()
    {

        $this->canToggle = cms_check_permission('can-toggle-show');
        if (!$this->date) {
            $this->date = now()->format('d-m-Y');
        } else {
            try {
                $this->date = now()->parse($this->date)->format('d-m-Y');
            } catch (\Throwable $th) {
                $this->date = now()->format('d-m-Y');
            }
        }
    }

    public function render()
    {


        $cms_user = session('cms_user');

        // $branch_id = $cms_user['attributes']['branch_id'] ?? null;

        // dd($branch_id);



        $date = now()->parse($this->date);
        $period = collect(CarbonPeriod::create($date, (clone $date)->addDays(30)))->map(function ($d) {
            return $d->format('d-m-Y');
        })->toArray();


        $visible = [];

        $movie_shows = MovieShow::with([
            'time' => function ($query) {
                $query->select('id', 'iso');
            },
            'theater' => function ($query) {
                $query->select("id", "label", "branch_id", "hall_number", "price_group_id");
            },
            'theater.branch' => function ($query) {
                $query->select('id', 'label_en', 'label_ar');
            },
            'theater.priceGroup' => function ($query) {
                $query->select('id', 'label');
            },
            'movie' => function ($query) {
                $query->select('id', 'name', 'main_image');
            },
            'screenType' => function ($query) {
                $query->select('id', 'label');
            },
        ])->whereNull('deleted_at')->where('date', $date)->get()
            // ->where('theater.branch_id', $branch_id)
            ->map(function ($movie_show) use (&$visible) {
                $movie = $movie_show->movie;

                $theater = $movie_show->theater ?? null;

                $time = $movie_show->time ?? null;

                $branch = $movie_show->theater->branch ?? null;

                $price_group = $theater->priceGroup ?? null;

                $screen_type = $movie_show->screenType ?? null;


                if ($movie_show->visibility == 1) {
                    $visible[] = 'key_' . $branch->id . '_' . $movie->id . '_' . $movie_show->id;
                }


                return [

                    'movie_show_id' => $movie_show->id,
                    'movie_show_date' => $movie_show->date,
                    'movie_id' => $movie->id,
                    'movie_image' => get_image($movie->main_image),
                    'movie_name' => $movie->name,

                    'branch_id' => $branch->id,
                    'branch_name' => $branch->label ?? null,

                    'theater_id' =>  $theater->id ?? null,
                    'theater_label' =>  $theater->label ?? null,

                    'price_group_id' => $price_group->id,
                    'price_group_label' => $price_group->label,

                    'time_id' => $time->id ?? null,
                    'time_label' => $time->iso ?? null,

                    'screen_type_id' => $screen_type->id ?? null,
                    'screen_type_label' => $screen_type->label ?? null,

                    'branch_identifier' => 'key_' . $branch->id,
                    'movie_identifier' => 'key_' . $branch->id . '_' . $movie->id,
                    'movie_show_identifier' => 'key_' . $branch->id . '_' . $movie->id . '_' . $movie_show->id

                ];
            });



        $identifiers = collect([
            ...$movie_shows->pluck('branch_identifier')->toArray(),
            ...$movie_shows->pluck('movie_identifier')->toArray(),
            ...$movie_shows->pluck('movie_show_identifier')->toArray(),
        ])->unique()->filter()->values()->toArray();



        $states = [];
        foreach ($identifiers as $identifier) {
            $states[$identifier] = in_array($identifier, $visible);
        }


        return view('components.form.manage-bookings', [
            'date' => $date,
            'states' =>  json_encode($states),
            'period' => $period,
            'movie_shows' => $movie_shows
        ]);
    }


    public function updateVisibility($movie_shows)
    {


        //needs to be optmized to 2 queries

        foreach ($movie_shows as $movie_show) {
            MovieShow::where('id', $movie_show['movie_show_id'])->update([
                'visibility' => $movie_show['visibility']
            ]);
        }

        // $this->sendSuccess("Visibility updated" , "Visibility updated");

    }
}
