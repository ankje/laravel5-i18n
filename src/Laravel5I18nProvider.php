<?php

namespace Jy\Laravel5I18n;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\Translator;

class Laravel5I18nProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/jyi18n.php' => config_path('jyi18n.php'),
        ],'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/jyi18n.php',
            'jyi18n'
        );

        $this->registerLoader();

        $this->app->singleton('jy.translator', function ($app) {
            $loader = $app['jy.translation.loader'];

            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = $app['config']['app.locale'];

            $trans = new Translator($loader, $locale);

            $trans->setFallback($app['config']['app.fallback_locale']);

            return $trans;
        });

        $this->app->singleton('jy.i18nhelper', function ($app) {
            return new I18nHelper();
        });
    }

    /**
     * Register the translation line loader.
     *
     * @return void
     */
    protected function registerLoader()
    {
        $this->app->singleton('jy.translation.loader', function ($app) {
            $langLoaderClass = Arr::get($this->app['config']->get('jyi18n'),'translation_loader');
            return new $langLoaderClass($app['files'], $app['path.lang']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['jy.translator', 'jy.translation.loader'];
    }
}
