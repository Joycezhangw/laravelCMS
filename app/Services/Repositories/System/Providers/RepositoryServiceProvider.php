<?php


namespace App\Services\Repositories\System\Providers;
use App\Services\Repositories\System\AlbumFileRepo;
use App\Services\Repositories\System\AlbumRepo;
use App\Services\Repositories\System\DistrictRepo;
use App\Services\Repositories\System\Interfaces\IAlbum;
use App\Services\Repositories\System\Interfaces\IAlbumFile;
use App\Services\Repositories\System\Interfaces\IDistrict;
use App\Services\Repositories\System\Interfaces\ISlide;
use App\Services\Repositories\System\Interfaces\ISysMpPages;
use App\Services\Repositories\System\Interfaces\IWebLogError;
use App\Services\Repositories\System\SlideRepo;
use App\Services\Repositories\System\SysMpPagesRepo;
use App\Services\Repositories\System\WebLogErrorRepo;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
    }

    public function register()
    {
        $this->app->bind(IAlbumFile::class, AlbumFileRepo::class);//附件
        $this->app->bind(IAlbum::class, AlbumRepo::class);//附件专辑
        $this->app->bind(ISlide::class, SlideRepo::class);//幻灯片



        $this->app->bind(IWebLogError::class, WebLogErrorRepo::class);//前端错误日志
        $this->app->bind(IDistrict::class, DistrictRepo::class);//行政区域划分
        $this->app->bind(ISysMpPages::class,SysMpPagesRepo::class);//金刚
    }
}
