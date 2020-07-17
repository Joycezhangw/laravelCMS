<?php
declare (strict_types=1);

namespace App\Services\Repositories\Manage;


use App\Services\Models\Manage\ManageModule;
use App\Services\Repositories\Manage\Interfaces\IManageModule;
use JoyceZ\LaravelLib\Helpers\FiltersHelper;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Helpers\TreeHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

class ManageModuleRepo extends BaseRepository implements IManageModule
{

    public function __construct(ManageModule $model)
    {
        parent::__construct($model);
    }

    /**
     * 获取该用户的权限菜单，和所有菜单
     * @param string $moduleName
     * @param array $member
     * @return array
     */
    public function getModuleAuth(string $moduleName, array $member): array
    {
        if (intval($member['is_super']) === 1) {
            $menuList = $this->all(['module' => $moduleName, 'is_menu' => 1])->toArray();
            $authList = $this->all(['module' => $moduleName])->toArray();
        }
        $sideBar = TreeHelper::listToTreeMulti($menuList, 0, 'module_id');
        return compact('sideBar', 'authList');
    }

    /**
     * 根据路由名获取最新一条数据
     * @param string $route
     * @return array
     */
    public function getLastModuleByRoute(string $route): array
    {
        $ret = $this->model->where(['module_route' => $route])->orderBy('module_id', 'desc')->first();
        return $ret ? $ret->toArray() : [];
    }

    /**
     * 组装表数据
     * @param array $params
     * @return array
     */
    private function buildModuleField(array $params): array
    {
        $module_level = 1;
        if (intval($params['pid']) > 0) {
            $parent = $this->getByPkId(intval($params['pid']));
            $module_level = $parent ? $parent->module_level + 1 : 1;
        }
        return [
            'module_name' => FiltersHelper::stringFilter($params['module_name']),
            'module' => FiltersHelper::stringFilter($params['module']),
            'controller' => FiltersHelper::stringFilter($params['controller']),
            'method' => FiltersHelper::stringFilter($params['method']),
            'pid' => intval($params['pid']),
            'module_level' => $module_level,
            'is_menu' => isset($params['is_menu']) ? 1 : 0,
            'module_sort' => intval($params['module_sort']),
            'module_route' => FiltersHelper::stringFilter($params['module_route']),
            'module_desc' => FiltersHelper::stringFilter($params['module_desc']),
            'module_icon_class' => '',
        ];
    }

    /**
     * 创建权限规则菜单
     * @param array $params
     * @return array
     */
    public function doCreateModule(array $params): array
    {
        if ($this->doCreate($this->buildModuleField($params))) {
            return ResultHelper::returnFormat('创建权限规则成功', 200);
        }
        return ResultHelper::returnFormat('服务器繁忙，请稍后再试', -1);
    }

    /**
     * 根据id，更新权限规则
     * @param int $moduleId
     * @param array $params
     * @return array
     */
    public function doUpdateModule(int $moduleId, array $params): array
    {
        if ($this->doUpdateByPkId($this->buildModuleField($params), $moduleId)) {
            return ResultHelper::returnFormat('更新权限规则成功', 200);
        }
        return ResultHelper::returnFormat('服务器繁忙，请稍后再试', -1);
    }


}
