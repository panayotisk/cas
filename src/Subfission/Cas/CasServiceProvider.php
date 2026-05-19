<?php

namespace Subfission\Cas;

use Illuminate\Support\ServiceProvider;

class CasServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('cas.php'),
        ], 'cas');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php',
            'cas'
        );

        $this->app->singleton('cas', function () {
            $cas = new CasManager(config('cas'));

            /** @var LogFactory $logger */
            $logger = resolve(LogFactory::class);

            $cas->setLogger($logger->make());

            return $cas;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['cas'];
    }
}
