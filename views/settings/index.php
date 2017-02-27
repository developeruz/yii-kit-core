<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = Yii::t('app', 'Settings');
$this->title = Yii::t('app', 'Settings');
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#themes" data-toggle="tab" aria-expanded="false">Themes</a></li>
        <li class=""><a href="#system" data-toggle="tab" aria-expanded="false">System</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="themes">
            <div class="row">
            <?php
            foreach ($themes as $theme) {
             ?>
                <div class="col-sm-3">
                    <div class="box <?=($theme == $activeTheme) ? 'box-success' : '' ?>">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?=\yii\helpers\Inflector::camel2words($theme);?></h3>
                            <div class="pull-right">
                                <?= ($theme == $activeTheme) ? '<i class="fa fa-check" aria-hidden="true"></i> Active' :
                                    '<a href="'.Url::to(['/admin/settings/set-theme']).'" data-method="post"
                                    data-params=\'{"theme":"'.$theme.'"}\' class="btn btn-primary">Activate</a>'; ?>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <img src="<?=Yii::getAlias('@yii_kit_theme')?>/<?=$theme; ?>/screenshot.jpg" width="250" height="250">
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            <?php
            }
            ?>
            </div>
        </div>
        <div class="tab-pane" id="system">
            <a href="<?=Url::to(['/admin/settings/flush-cache']);?>" class="btn btn-default">
                <i class="glyphicon glyphicon-flash"></i><?=Yii::t('app', 'Flush Cache');?></a>
            <a href="<?=Url::to(['/admin/settings/clear-assets']);?>" class="btn btn-default">
                <i class="glyphicon glyphicon-trash"></i><?=Yii::t('app', 'Clear Assets');?></a>
        </div>
    </div>
</div>
