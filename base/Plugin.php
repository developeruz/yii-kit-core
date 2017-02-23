<?php
namespace developeruz\yii_kit_core\base;

use yii\web\View;

class Plugin
{

    public function addNotificationMenuItem($menuItemClass, $linkContent, $dropDownMenu)
    {
        $html = '<li class="dropdown ' . $menuItemClass . '">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        ' . $linkContent . '
                    </a>
                    <ul class="dropdown-menu">
                       ' . $dropDownMenu . '
                    </ul>
                </li>';

        \Yii::$app->view->on(View::EVENT_BEGIN_BODY, function ($event) {
            $params = \Yii::$app->getView()->params['_yiikit_notification_menu'];
            $params[] = $event->data['html'];
            \Yii::$app->getView()->params['_yiikit_notification_menu'] = array_reverse($params);
        }, ['html' => $html]);
    }

    public function addLeftMenuItem($arr)
    {
        \Yii::$app->view->on(View::EVENT_BEGIN_BODY, function ($event) {
            $params = \Yii::$app->getView()->params['_yiikit_left_menu'];
            $params[] = $event->data['data'];
            \Yii::$app->getView()->params['_yiikit_left_menu'] = array_reverse($params);
        }, ['data' => $arr]);
    }
}
