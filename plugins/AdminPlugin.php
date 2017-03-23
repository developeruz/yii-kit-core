<?php
namespace developeruz\yii_kit_core\plugins;

use developeruz\yii_kit_core\base\Plugin;

class AdminPlugin extends Plugin
{
    public function init()
    {
        if(!\Yii::$app->user->isGuest) {
            $userMenu = \Yii::$app->view->renderFile('@vendor/developeruz/yii-kit-core/views/_partials/user_dropdown_menu.php');
            $this->addNotificationMenuItem('notifications-menu',
                '<span class="hidden-xs">' . \Yii::$app->user->identity->getUserName() . '</span>', $userMenu);

            $this->addLeftMenuItem(['label' => 'Settings', 'icon' => 'fa fa-cog', 'url' => ['/admin/settings']]);
            $this->addLeftMenuItem([
                'label' => 'Users',
                'icon' => 'fa fa-users',
                'url' => '#',
                'items' => [
                    ['label' => 'Users', 'icon' => 'fa fa-users', 'url' => ['/user/admin/index'],],
                    ['label' => 'Roles', 'icon' => 'fa fa-user-secret', 'url' => ['/permit/access/role'],],
                    ['label' => 'Permissions', 'icon' => 'fa fa-unlock-alt', 'url' => ['/permit/access/permission'],],
                ]
            ]);
        };
    }
}
