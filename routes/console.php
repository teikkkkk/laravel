<?php
use Illuminate\Support\Facades\Schedule;

Schedule::command('send:salesreport')->everyTenSeconds();
