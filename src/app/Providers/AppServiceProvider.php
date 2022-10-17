<?php

namespace App\Providers;

use App;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Model::preventLazyLoading(!App::isProduction());
        Model::preventSilentlyDiscardingAttributes(!App::isProduction());
        DB::whenQueryingForLongerThan(CarbonInterval::millisecond(5000), function (Connection $connection) {
            logger()->channel('telegram')->debug('whenQueryingForLongerThan: ' . $connection->query()->toSql());
        });

        $kernel = app(App\Http\Kernel::class);
        $kernel->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(4),
            function () {
                logger()->channel('telegram')->debug('whenRequestLifecycleIsLongerThan: ' . request()->url());
            }
        );
    }
}
