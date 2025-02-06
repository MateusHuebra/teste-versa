<?php

namespace App\Console\Commands;

use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleExample extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:example';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log the first name of the people updated up to 5 minutes ago';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        info('Running task '.now());

        $fiveMinutesAgo = Carbon::now()->subMinutes(5);
        $personsUpdatedUpToFiveMinutesAgo = Person::where('updated_at', '>=', $fiveMinutesAgo)
            ->pluck('first_name')
            ->toArray();

        if(empty($personsUpdatedUpToFiveMinutesAgo)) {
            $list = 'none';
        } else {
            $list = implode(', ', $personsUpdatedUpToFiveMinutesAgo);
        }
        $content = "Persons updated up to 5 minutes ago: ".$list;
        
        info($content);
    }
}
