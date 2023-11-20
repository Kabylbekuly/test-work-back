<?php

namespace App\Observers;

use App\Http\Controllers\API\Admin\LogController;
use App\Models\QLog;
use Illuminate\Database\Eloquent\Model;

class BaseObserver
{
    protected function logChanges(Model $model, $action)
    {

    }
}
