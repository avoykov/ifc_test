<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventsDaemon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:daemon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets data from events table and writes to log';

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
     * @return mixed
     */
    public function handle()
    {
        $events = DB::table('events')->where('status', false)->take(10)->get();
        $ids = [];
        foreach ($events as $event) {
            $ids[] = $event->id;
            $msg = "Request: {$event->token}; data: {$event->data}; count: {$event->count}";
            Log::info($msg);
        }
        DB::table('events')->whereIn('id', $ids)->update(['status' => true]);
    }
}
