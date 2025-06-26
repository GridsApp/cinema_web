<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanOldReservedSeats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reserved-seats:clean-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete reserved seats for movie shows before today';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // Get all movie_show_ids from reserved_seats
        $movieShowIds = DB::table('reserved_seats')->select('movie_show_id')->distinct()->pluck('movie_show_id');

        // Get movie_show_ids where the show date is before today
        $oldShowIds = DB::table('movie_shows')
            ->whereIn('id', $movieShowIds)
            ->where('date', '<', $today)
            ->pluck('id');

        // Delete reserved_seats for these old shows
        $deleted = DB::table('reserved_seats')
            ->whereIn('movie_show_id', $oldShowIds)
            ->delete();

        $this->info("Deleted $deleted reserved seats for past movie shows.");
    }
}
