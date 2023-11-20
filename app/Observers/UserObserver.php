<?php

namespace App\Observers;

use App\Http\Controllers\API\Admin\LogController;
use App\Models\QLog;
use App\Models\User;

class UserObserver extends BaseObserver
{

    public function saving(User $task)
    {
        $this->logChanges($task,'saving');
    }

    public function saved(User $task)
    {
        $this->logChanges($task,'saved');
    }

}
