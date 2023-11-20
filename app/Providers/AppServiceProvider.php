<?php

namespace App\Providers;

use App\Models\Hotel;
use App\Models\HotelOrders;
use App\Models\HotelRoom;
use App\Models\Order;
use App\Models\Partner;
use App\Models\Tour;
use App\Models\TourTicket;
use App\Models\User;
use App\Observers\HotelObserver;
use App\Observers\HotelOrdersObserver;
use App\Observers\HotelRoomObserver;
use App\Observers\OrderObserver;
use App\Observers\PartnerObserver;
use App\Observers\TourObserver;
use App\Observers\TourTicketObserver;
use App\Observers\UserObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

    }
}
