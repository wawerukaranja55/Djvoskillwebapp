<?php

namespace App\Console\Commands;

use App\Models\Events;
use Illuminate\Console\Command;

class UpdateEventStatusPast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eventstatus:done';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update event status to Already done Upon reaching that date on that month';

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
        //get all the events which have their status as happenning today
        $eves = Events::whereHas('event_statuses', function($q)
        {
            $q->where('status_id','=', 2);
        
        })->get();

        foreach($eves as $eve)
        {
            $eve->event_statuses()->sync(5);
        }

        $this->info('Event Status Updated successfully.');
    }
}
