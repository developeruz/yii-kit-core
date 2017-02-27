<?php
namespace developeruz\yii_kit_core\plugins;

use developeruz\yii_kit_core\base\Plugin;

class AdminPlugin extends Plugin
{
    public function init()
    {
        $userMenu = \Yii::$app->view->renderFile('@vendor/developeruz/yii-kit-core/views/_partials/user_dropdown_menu.php');
        $this->addNotificationMenuItem('notifications-menu', '<img src="/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs">Alexander Pierce</span>',$userMenu);

        $this->addLeftMenuItem(['label' => 'Settings', 'icon' => 'fa fa-cog', 'url' => ['/admin/settings']]);
        $this->addLeftMenuItem(['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']]);
    }
}
