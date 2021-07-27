<?php

namespace Ankje\Laravel5I18n;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\Translator;

class Laravel5I18nProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/ai18n.php' => config_path('ai18n.php'),
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
            __DIR__ . '/../config/ai18n.php',
            'ai18n'
        );

        $this->registerLoader();

        $this->app->singleton('a.translator', function ($app) {
            $loader = $app['a.translation.loader'];

            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = $app['config']['app.locale'];

            $trans = new Translator($loader, $locale);

            $trans->setFallback($app['config']['app.fallback_locale']);

            return $trans;
        });
    }

    /**
     * Register the translation line loader.
     *
     * @return void
     */
    protected function registerLoader()
    {
        $this->app->singleton('a.translation.loader', function ($app) {
            $langLoaderClass = Arr::get($this->app['config']->get('ai18n'),'translation_loader');
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
        return ['a.translator', 'a.translation.loader'];
    }
}
