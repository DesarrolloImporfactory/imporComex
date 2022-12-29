<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(BuildingMenu::class, function(BuildingMenu $event){
            $usuario = User::where('id', Auth::user()->id)->first();
            $event->menu->addAfter('Dashboard',
            [
                
                'text' => 'Especialistas',
                'url'  => route('admin.especialistas.show',$usuario->id),
                'icon'=>'fa fa-fw fa-headset',
                'label'=>'new',
                'label_color'=>'primary',
            ],
            [
                
                'text' => 'Cotizaciones',
                'url'  => route('admin.cotizaciones.show',$usuario->id),
                'icon'=>'fa fa-solid fa-coins',
                'label'=>'new',
                'label_color'=>'primary',
            ]
        );
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
