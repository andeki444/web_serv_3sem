<?php

use Illuminate\Support\Facades\Schedule;

// 3. Вызов команды с частотой everyMinute
Schedule::command('stats:send')->everyMinute(); 