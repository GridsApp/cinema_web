<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Movie;
use App\Models\MovieShow;
use Carbon\CarbonPeriod;

class TimeConflictRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */


    public $theater_id;
    public $dates;
    public $time;
    public $duration;
    public $except;

    public function __construct($theater_id , $dates , $time , $duration , $except = [])
    {
        $this->theater_id = $theater_id;
        $this->dates = $dates;
        $this->time = $time;
        $this->duration = $duration;
        $this->except = $except;
    }


    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $slots = ceil($this->duration / 15);
        $proceed = true;

        

        foreach ($this->dates as $date) {
            if (!validate_movie_show($this->theater_id, $date, $this->time, $slots , $this->except)) {
                $proceed = false;
                break;
            }
        }

        if (!$proceed) {
            $fail('form.time_id', 'Scheduling Conflict. The selected movie showtime overlaps with an existing show');
        }
    }
}
