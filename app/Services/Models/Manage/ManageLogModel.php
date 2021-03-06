<?php
declare (strict_types=1);

namespace App\Services\Models\Manage;

use Illuminate\Database\Eloquent\Model;

/**
 * 管理员操作日志
 * Class ManageLogModel
 * @package App\Services\Models\Manage
 */
class ManageLogModel extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'hb_manage_log';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'log_id';

    /**
     * 指示是否自动维护时间戳
     * @var bool
     */
    public $timestamps = true;

    /**
     * 模型日期列的存储格式。
     * @var string
     */
    protected $dateFormat = 'U';

    protected $fillable = [
        'log_id',
        'manage_id',
        'manage_username',
        'log_url',
        'log_title',
        'log_content',
        'log_ip',
        'useragent',
        'created_at',
        'updated_at'
    ];

    /**
     * 注册ip地址
     * @return string
     */
    public function getLogIpAttribute()
    {
        return long2ip($this->attributes['log_ip']);
    }

    /**
     * 创建时间
     * @return string
     */
    public function getCreatedAtAttribute()
    {
        return date('Y-m-d H:i:s',$this->attributes['created_at']);
    }
}
