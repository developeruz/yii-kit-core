<?php

use yii\grid\GridView;

$this->params['breadcrumbs'][] = Yii::t('app', 'Plugins');
$this->title = Yii::t('app', 'Plugins');

?>
<div class="nav-tabs-custom">
    <?= GridView::widget([
        'dataProvider' => $plugins,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'folder',
            'description',
            [
                'label' => Yii::t('app', 'Install'),
                'attribute' => 'is_installed',
                'format' => 'html',
                'value' => function ($model) {
                    if(!$model['is_plugin']) return Yii::t('app', "Plugin can not be installed");

                    if($model['is_installed']) {
                        return '<a href="'.\yii\helpers\Url::to(['/admin/plugins/uninstall/', 'folder' => $model['folder']]).'" class="btn btn-primary">Uninstall</a>';
                    }
                    else {
                        return '<a href="'.\yii\helpers\Url::to(['/admin/plugins/install/', 'folder' => $model['folder']]).'" class="btn btn-success">Install</a>';
                    }
                },
            ],
            [
                'label' => Yii::t('app', 'Priority'),
                'attribute' => 'priority',
                'format' => 'html',
                'value' => function ($model) {
                   if($model['is_plugin']) {
                       return '<a href="' . \yii\helpers\Url::to(['/admin/plugins/up/', 'folder' => $model['folder']]) . '" class="btn btn-primary"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                   <a href="' . \yii\helpers\Url::to([
                           '/admin/plugins/down/',
                           'folder' => $model['folder']
                       ]) . '" class="btn btn-primary"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>';
                   }
                },
            ]
        ],
    ]); ?>
</div>
