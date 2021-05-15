<?php


namespace App\Services\Repositories\CMS\Providers;

use App\Services\Repositories\CMS\ArticleRepo;
use App\Services\Repositories\CMS\ChannelRepo;
use App\Services\Repositories\CMS\Interfaces\IArticle;
use App\Services\Repositories\CMS\Interfaces\IChannel;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
    }

    public function register()
    {
        $this->app->bind(IChannel::class, ChannelRepo::class);//内容栏目
        $this->app->bind(IArticle::class, ArticleRepo::class);//内容
    }
}
