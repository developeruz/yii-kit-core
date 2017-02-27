<?php
use yii\helpers\Html;
?>
<li>
<ul class="menu">
    <li>
        <a href="#">
            <i class="fa fa-users text-aqua"></i>Profile
        </a>
    </li>
    <li>
        <?= Html::a(
            'Sign out',
            ['/site/logout'],
            ['data-method' => 'post']
        ) ?>
    </li>
</ul>
</li>
