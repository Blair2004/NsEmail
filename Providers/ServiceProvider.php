<?php
namespace Modules\NsEmail\Providers;

use App\Classes\Hook;
use Illuminate\Support\Facades\Event;
use Modules\NsEmail\Services\EmailService;
use Modules\NsMultiStore\Events\MultiStoreApiRoutesLoadedEvent;
use Modules\NsMultiStore\Events\MultiStoreWebRoutesLoadedEvent;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        Hook::addFilter( 'ns-dashboard-menus', function( $menus ) {
            if ( $menus[ 'settings' ] ) {
                $menus[ 'settings' ][ 'childrens' ]  =   array_insert_after( $menus[ 'settings' ][ 'childrens' ], 'general', [
                    'email' => [
                        'label' => __m( 'Email Settings', 'NsEmail' ),
                        'href' => ns()->route( 'ns.dashboard.settings', [ 'ns-email-settings' ] ),
                        'permission' => [ 'manage.options' ],
                    ]
                ]);
            }

            return $menus;
        });

        $this->app->bind( EmailService::class, function( $app ) {
            return new EmailService();
        });
    }

    public function boot()
    {
        Event::listen( MultiStoreWebRoutesLoadedEvent::class, function() {
            include_once( dirname( __FILE__ ) . '/../Routes/multistore.php' );
        });
      
        Event::listen( MultiStoreApiRoutesLoadedEvent::class, function() {
            include_once( dirname( __FILE__ ) . '/../Routes/api.php' );
        });
    }
}