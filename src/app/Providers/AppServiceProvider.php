<?php

namespace App\Providers;

use App\Contracts\Abstracts\AbstractFileValidator;
use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileManagerFactoryInterface;
use App\Contracts\FileReaderInterface;
use App\DataTransferObjects\FileDTO;
use App\Factories\FileManagerFactory;
use App\Http\Controllers\FileController;
use App\Rules\DecimalRule;
use Illuminate\Support\Facades\Validator;
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
        $this->app->when(FileController::class)
            ->needs(FileManagerFactoryInterface::class)
            ->give(FileManagerFactory::class);

        $this->app->when(FileController::class)
            ->needs(DataTransferObjectInterface::class)
            ->give(FileDTO::class);
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        // @todo: Refactor to be inside Rule class
        Validator::extend('check_decimal', function ($attribute, $value, $params, $validator) {

            $validator->setCustomMessages(['check_decimal' => 'The :attribute must be (length of '. $params[0] .
                ' digits and '. $params[1] .' digits after the comma)']);

            return (new DecimalRule($params[0], $params[1]))->passes($attribute, $value);
        });
    }
}
