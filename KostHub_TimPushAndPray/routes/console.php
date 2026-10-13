<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('invoices:generate')->monthlyOn(1, '00:00');