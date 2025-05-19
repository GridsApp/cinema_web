<?php

namespace App\Livewire\EntityForms;

use App\Models\MovieShow;
use twa\uikit\Traits\ToastTrait;
use Livewire\Component;
use App\Rules\TimeConflictRule;

class MovieShowEditForm extends Component
{

    use ToastTrait;

    public $id;


    public $type = "single";

    public $form;
    public $uniqeid;


    public function handleIdChange($selected)
    {

        if (!is_array($selected)) {
            $this->id = $this->type == "single" ? null : [];
        }

        $this->id = $selected;
        $this->mount();
    }

    public function render()
    {
        return view('pages.form.components.movie-show-edit-form');
    }

    public function resetForm($data = null)
    {

        $fields = [
            'time',
            'screen_type',
            'color',
            'apply_time',
            'apply_screen_type',
            'apply_color',
            // 'system',
            'week'
        ];


        if ($this->type == "single") {
            $fields [] = 'date';
            $fields [] = 'apply_date';
        }

        foreach ($fields as $field) {
            $info = config('fields.' . $field);
            if (!isset($info['name'])) {
                continue;
            }
            $this->form[$info['name']] = field_init($info, $data);
        }


    }

    public function mount()
    {

        $data = null;


        if ($this->id[0] ?? null) {
            $data = (object)MovieShow::where('id', $this->id[0])->first();

        }
        $this->resetForm($data);
    }

    public function save()
    {
        $updateData = [];

        $message = ["Updated" , "Record successfully updated"];

        if ($this->type == "single") {


            $required_array = [
                'form.screen_type_id' => 'required',
                'form.date' => 'required',
                'form.time_id' => 'required',
            ];

            $required_messages = [
                'form.screen_type_id' => 'screen type',
                'form.date' => 'date',
                'form.time_id' => 'time',
            ];

            $this->validate($required_array , [] , $required_messages);

            $existing_movie_show = MovieShow::where('id' , $this->id)->first();
            if(!$existing_movie_show){ return; }

            $required_array = [
                'form.time_id' => [ new TimeConflictRule($existing_movie_show->theater_id , [now()->parse($this->form['date'])]  , $this->form['time_id'] , $existing_movie_show->duration , [$this->id]) ],
            ];


            // dd(($this->form['week']));
            $this->validate($required_array);

            MovieShow::where('id', $this->id)->update([
                'screen_type_id' => $this->form['screen_type_id'],
                'time_id' => $this->form['time_id'],
                'date' => $this->form['date'],
                'color' => $this->form['color'],
                // 'system_id' => $this->form['system_id'],
                'week' => $this->form['week']
            ]);
        } else {

            $required_array = [];

            $required_messages = [];

            $no_apply = true;

            if (!empty($this->form['apply_time'])) {
                $updateData['time_id'] = $this->form['time_id'];

                $required_array["form.time_id"] = "required";
                $required_messages["form.time_id"] = "time";

                $no_apply = $no_apply && false;
            }
            if (!empty($this->form['apply_screen_type'])) {
                $updateData['screen_type_id'] = $this->form['screen_type_id'];

                $required_array["form.screen_type_id"] = "required";
                $required_messages["form.screen_type_id"] = "time";

                $no_apply = $no_apply && false;
            }
            if (!empty($this->form['apply_color'])) {
                $updateData['color'] = $this->form['color'];
                $no_apply = $no_apply && false;
            }


            if (!empty($this->form['apply_week'])) {
                $updateData['week'] = $this->form['week'];
                $no_apply = $no_apply && false;
            }


            if(!empty($this->form['apply_system'])){
                $updateData['system_id'] = json_encode($this->form['system_id']);
                $no_apply = $no_apply && false;
            }

            if(!$no_apply){

                if(count($required_array) > 0){
                    $this->validate($required_array , [] , $required_messages);
                }

                if(!empty($this->form['apply_time'])){
                 
                    $existing_movie_show = MovieShow::whereIn('id', $this->id)->whereNull('deleted_at')->first();
                    
                    if(!$existing_movie_show){
                        $this->dispatch('record-not-created-' . $this->uniqeid);
                        $this->sendError("Unexpected Error" , "Something went wrong");
                        return;
                    }
                    
                    $dates = MovieShow::whereIn('id', $this->id)->whereNull('deleted_at')->get()->map(function($show){
                            return now()->parse($show->date);
                    });

                    $required_array = [
                        'form.time_id' => [ new TimeConflictRule($existing_movie_show->theater_id , $dates  , $updateData['time_id'] , $existing_movie_show->duration , $this->id) ],
                    ];

                    $this->validate($required_array);
                }


                MovieShow::whereIn('id', $this->id)->whereNull('deleted_at')->update($updateData);


                $this->resetForm();
                $this->dispatch('record-created-' . $this->uniqeid);
                $this->sendSuccess(...$message);

            }else{
                $message = ["Nothing updated" , "Nothing was applied"];

                $this->resetForm();
                $this->dispatch('record-created-' . $this->uniqeid);
                $this->sendSuccess(...$message);
            }


            return;

        }

        $this->resetForm();
        $this->dispatch('record-created-' . $this->uniqeid);
        $this->sendSuccess(...$message);

    }


}
