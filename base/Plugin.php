<?php
namespace developeruz\yii_kit_core\base;

use yii\web\View;

class Plugin
{

    public function addNotificationMenuItem($menuItemClass, $linkContent, $dropDownMenu)
    {
        $html = '<li class="dropdown '.$menuItemClass.'">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        '.$linkContent.'
                    </a>
                    <ul class="dropdown-menu">
                       '.$dropDownMenu.'
                    </ul>
                </li>';

        \Yii::$app->view->on(View::EVENT_BEGIN_BODY, [$this, 'addNotificationMenu'], ['html' => $html]);
    }

    public function addNotificationMenu($event)
    {
        \Yii::$app->getView()->params['_yiikit_notification_menu'][] = $event->data['html'];
    }
}
