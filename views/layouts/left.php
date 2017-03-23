<?php
if(empty($this->params['_yiikit_left_menu'])) {
    $this->params['_yiikit_left_menu'] = [];
}
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $this->params['_yiikit_left_menu']
            ]
        ) ?>

    </section>

</aside>
