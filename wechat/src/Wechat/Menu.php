<?php

namespace Stoneworld\Wechat;

use Closure;

/**
 * 菜单
 *
 * @property array $sub_button
 */
class Menu
{
    const API_CREATE             = 'https://qyapi.weixin.qq.com/cgi-bin/menu/create';
    const API_GET                = 'https://qyapi.weixin.qq.com/cgi-bin/menu/get';
    const API_DELETE             = 'https://qyapi.weixin.qq.com/cgi-bin/menu/delete';
    const API_QUERY              = 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info';

    /**
     * Http对象
     *
     * @var Http
     */
    protected $http;

    /**
     * constructor
     *
     * @param string $appId
     * @param string $appSecret
     */
    public function __construct($appId, $appSecret)
    {
        $this->http = new Http(new AccessToken($appId, $appSecret));
    }

    /**
     * 设置菜单
     *
     * @return bool
     */
    public function set($agentId, $menus)
    {
        $menus = $this->extractMenus($menus);

        $this->http->jsonPost(self::API_CREATE.'?agentid='.$agentId, array('button' => $menus));

        return true;
    }

    /**
     * 获取菜单
     *
     * @return array
     */
    public function get($agentId)
    {
        $menus = $this->http->get(self::API_GET.'?agentid='.$agentId);

        return empty($menus['menu']['button']) ? array() : $menus['menu']['button'];
    }

    /**
     * 删除菜单
     *
     * @return bool
     */
    public function delete($agentId)
    {
        $this->http->get(self::API_DELETE.'?agentid='.$agentId);

        return true;
    }

    /**
     * 转menu为数组
     *
     * @param mixed $menus
     *
     * @return array
     */
    protected function extractMenus($menus)
    {
        if ($menus instanceof Closure) {
            $menus = $menus($this);
        }

        if (!is_array($menus)) {
            throw new Exception('子菜单必须是数组或者匿名函数返回数组', 1);
        }

        foreach ($menus as $key => $menu) {
            $menus[$key] = $menu->toArray();

            if ($menu->sub_button) {
                $menus[$key]['sub_button'] = $this->extractMenus($menu->sub_button);
            }
        }

        return $menus;
    }
}
