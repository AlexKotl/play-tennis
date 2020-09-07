<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Recaount friends count
        $schedule->call(function () {
            DB::statement("UPDATE users SET friends_count = (
                SELECT COUNT(*) FROM (
                    SELECT *, (COUNT(DISTINCT id) = 2) is_friends  FROM (
                        SELECT id, author_id, recipient_id, IF (author_id > recipient_id, CONCAT(recipient_id, '-', author_id), CONCAT(author_id, '-',recipient_id) ) AS pair_id
                        FROM messages
                        GROUP BY author_id, recipient_id
                    ) pairs
                    GROUP BY pair_id
                    HAVING is_friends
                ) sub
                WHERE author_id = users.id OR recipient_id = users.id
            ) ");

        })->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
