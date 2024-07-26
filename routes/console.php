<?php
use Illuminate\Support\Facades\Schedule;

Schedule::command('send:salesreport')->everyMinute();
Schedule:: command('send:customerreport')->everyTenSeconds();