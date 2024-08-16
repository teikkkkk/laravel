<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
 

Broadcast::channel('orders', function (User $user) {
    return $user->hasRole('admin');
}, ['guards' => ['web', 'admin']]);
