<?php

namespace App\Console\Commands;

use App\Models\Events;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateEventStatusHappeningToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eventstatus:happeningtoday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update event status to happening today Upon reaching that date on that month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //on reaching todays date update all the events have todays date to happening today status
        $now = Carbon::today()->toDateString();

        $newDate = \Carbon\Carbon::createFromFormat('Y-m-d', $now)->format('d.m.Y');
        $eves=Events::where('event_date','=',$newDate )->get();

        foreach($eves as $eve)
        {
            $eve->event_statuses()->sync(2);
        }

        $this->info('Event Status Updated successfully.');
    }
}
