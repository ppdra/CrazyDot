<?php

use Illuminate\Console\Scheduling\Schedule;


app(Schedule::class)->command('crazy:insert-teams')->twiceDaily(0, 12);

app(Schedule::class)->command('crazy:insert-matches')->dailyAt('00:00');

app(Schedule::class)->command('crazy:insert-matches-results')->everyFifteenMinutes();
