<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:update-user-roles')->daily();
Schedule::command('notify:posyandu')->daily();
Schedule::command('report:generate-monthly')->daily();