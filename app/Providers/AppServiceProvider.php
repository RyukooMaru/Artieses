<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use League\Flysystem\Filesystem;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        
        Storage::extend('azure', function ($app, $config) {
            $client = BlobRestProxy::createBlobService(
                sprintf(
                    'DefaultEndpointsProtocol=https;AccountName=%s;AccountKey=%s;EndpointSuffix=core.windows.net',
                    $config['name'],
                    $config['key']
                )
            );

            $adapter = new AzureBlobStorageAdapter(
                $client,
                $config['container']
            );
            return new Filesystem($adapter);
        });
        ini_set('upload_max_filesize', '9999M');
        ini_set('post_max_size', '9999M');
        ini_set('memory_limit', '9999M');
    }
    
}
