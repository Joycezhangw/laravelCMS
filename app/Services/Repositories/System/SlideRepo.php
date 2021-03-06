<?php
declare (strict_types=1);

namespace App\Services\Repositories\System;


use App\Services\Models\System\SlideModel;
use App\Services\Repositories\System\Interfaces\ISlide;
use App\Utility\Format;
use Illuminate\Support\Facades\Storage;
use JoyceZ\LaravelLib\Helpers\DateHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

/**
 * 幻灯片
 * Class SlideRepo
 * @package App\Services\Repositories\System
 */
class SlideRepo extends BaseRepository implements ISlide
{
    public function __construct(SlideModel $model)
    {
        parent::__construct($model);
    }

    /**
     * 获取幻灯片分页列表
     * @param array $params
     * @return array
     */
    public function getSlidePageList(array $params): array
    {
//        DB::enableQueryLog();
        $lists = $this->model->where(function ($query) use ($params) {
            if (isset($params['search_text']) && $params['search_text'] != '') {
                $query->where('slide_name', 'like', '%' . $params['search_text'] . '%');
            }
            if (isset($params['created_time']) && $params['created_time'] != '') {
                $date = explode('至', $params['created_time']);
                $query->where('created_at', '>=', strtotime(trim($date[0])))->where('created_at', '<=', strtotime(trim($date[1])));
            }
        })->paginate(isset($params['page_size']) ? $params['page_size'] : config('student.paginate.page_size'));
//        dd(DB::getQueryLog());
        return $lists->toArray();
    }

    public function parseDataRow(array $row): array
    {
        if (isset($row['slide_pic'])) {
            $row['slide_pic_url'] = Format::buildPictureUrl($row['slide_pic']);
        }
        if (isset($row['created_at'])) {
            $row['created_at_txt'] = DateHelper::formatParseTime((int)$row['created_at']);
            $row['created_at_ago'] = DateHelper::formatDateLongAgo((int)$row['created_at']);
        }
        return $row;
    }


}
