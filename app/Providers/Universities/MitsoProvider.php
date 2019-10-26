<?php

namespace App\Providers\Universities;

use Illuminate\Support\ServiceProvider;
use App\Services\MitsoService\MitsoFacultiesProvider\BaseMitsoFacultiesProvider;
use App\Services\MitsoService\MitsoFacultiesProvider\MitsoFacultiesProvider;
use App\Services\MitsoService\MitsoFacultiesProvider\Parser\MitsoFacultiesParser;
use Illuminate\Contracts\Foundation\Application;
use App\Services\MitsoService\MitsoFacultiesProvider\Fetcher\MitsoFacultiesFetcher;
use App\Services\MitsoService\MitsoStudyModelsProvider\BaseMitsoStudyModelsProvider;
use App\Services\MitsoService\MitsoStudyModelsProvider\MitsoStudyModelsProvider;
use App\Services\MitsoService\MitsoStudyModelsProvider\Fetcher\MitsoStudyModelsFetcher;
use App\Services\MitsoService\MitsoStudyModelsProvider\Parser\MitsoStudyModelsParser;
use App\Services\MitsoService\MitsoYearsProvider\BaseMitsoYearsProvider;
use App\Services\MitsoService\MitsoYearsProvider\MitsoYearsProvider;
use App\Services\MitsoService\MitsoYearsProvider\Fetcher\MitsoYearsFetcher;
use App\Services\MitsoService\MitsoYearsProvider\Parser\MitsoYearsParser;

class MitsoProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFacultiesProvider();
        $this->registerStudyModelsProvider();
        $this->registerYearsProvider();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerFacultiesProvider()
    {
        $this->app->bind(BaseMitsoFacultiesProvider::class, function () {
            return new BaseMitsoFacultiesProvider();
        });
        $this->app->bind(MitsoFacultiesProvider::class, BaseMitsoFacultiesProvider::class);

        $this->app->bind(MitsoFacultiesFetcher::class, function (Application $app) {
            /**
             * @var MitsoFacultiesProvider $provider
             */
            $provider = $app->make(MitsoFacultiesProvider::class);

            return $provider->createFetcher();
        });

        $this->app->bind(MitsoFacultiesParser::class, function (Application $app) {
            /**
             * @var MitsoFacultiesProvider $provider
             */
            $provider = $app->make(MitsoFacultiesProvider::class);

            return $provider->createParser();
        });
    }

    private function registerStudyModelsProvider()
    {
        $this->app->bind(BaseMitsoStudyModelsProvider::class, function () {
            return new BaseMitsoStudyModelsProvider();
        });
        $this->app->bind(MitsoStudyModelsProvider::class, BaseMitsoStudyModelsProvider::class);

        $this->app->bind(MitsoStudyModelsFetcher::class, function (Application $app) {
            /**
             * @var MitsoStudyModelsProvider $provider
             */
            $provider = $app->make(MitsoStudyModelsProvider::class);

            return $provider->createFetcher();
        });

        $this->app->bind(MitsoStudyModelsParser::class, function (Application $app) {
            /**
             * @var MitsoStudyModelsProvider $provider
             */
            $provider = $app->make(MitsoStudyModelsProvider::class);

            return $provider->createParser();
        });
    }

    private function registerYearsProvider()
    {
        $this->app->bind(BaseMitsoYearsProvider::class, function () {
            return new BaseMitsoYearsProvider();
        });
        $this->app->bind(MitsoYearsProvider::class, BaseMitsoYearsProvider::class);

        $this->app->bind(MitsoYearsFetcher::class, function (Application $app) {
            /**
             * @var MitsoYearsProvider $provider
             */
            $provider = $app->make(MitsoYearsProvider::class);

            return $provider->createFetcher();
        });

        $this->app->bind(MitsoYearsParser::class, function (Application $app) {
            /**
             * @var MitsoYearsProvider $provider
             */
            $provider = $app->make(MitsoYearsProvider::class);

            return $provider->createParser();
        });
    }
}
