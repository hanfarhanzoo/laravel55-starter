<?php

namespace Modules\User\Events\Subscribers;

use Log;
use Modules\User\Models\User;

class UserSubscriber
{
    public function onCreated($model)
    {
        Log::info('User #' . $model->id . ' was created.');
    }

    public function onUpdated($model)
    {
        Log::info('User #' . $model->id . ' was updated.');
    }

    public function onDeleted($model)
    {
        Log::info('User #' . $model->id . ' was deleted.');
    }

    public function onLogin($event)
    {
        Log::info('User #' . $event->user->id . ' logged in.');
    }

    public function onRegister($event)
    {
        Log::info('User #' . $event->user->id . ' registered.');
    }

    public function subscribe($events)
    {
        $events->listen('eloquent.created: ' . User::class, UserSubscriber::class . '@onCreated');
        $events->listen('eloquent.updated: ' . User::class, UserSubscriber::class . '@onUpdated');
        $events->listen('eloquent.deleted: ' . User::class, UserSubscriber::class . '@onDeleted');

        # login, register, logout, etc events
        # ref: https://laravel.com/docs/5.5/authentication#events
        $events->listen('Illuminate\Auth\Events\Login', UserSubscriber::class . '@onLogin');
        $events->listen('Illuminate\Auth\Events\Registered', UserSubscriber::class . '@onRegister');
    }
}
