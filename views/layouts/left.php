<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if (Yii::$app->user->identity->image != "" || Yii::$app->user->identity->image != NULL) { ?>
                    <img src="<?php echo Yii::getAlias('@web') . '/web/uploads/images/' . Yii::$app->user->identity->image; ?>" class="img-circle"  alt="User Image" />
                <?php } else { ?>
                    <img src="<?php echo Yii::getAlias('@web') . '/web/uploads/images/avatar.jpg' ?>" class="img-circle"  alt="User Image" />
                <?php } ?>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <?php
        if (Yii::$app->user->identity->role == "admin") {
            echo dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                            ['label' => 'เมนูหลัก', 'options' => ['class' => 'header']],
                            ['label' => 'HOME', 'icon' => 'home', 'url' => ['site/index']],
                            ['label' => 'การจัดการระบบ',
                                'url' => ['#'],
                                'template' => '<a href="{url}" ><i class="fa fa-tv"></i>{label}<i class="fa fa-angle-left pull-right"></i></a>',
                                'items' => [
                                    ['label' => 'ประกาศขาย', 'icon' => 'dot-circle-o', 'url' => ['/saleorders/selling']],
                                    ['label' => 'รายการทั้งหมด', 'icon' => 'reorder', 'url' => ['/saleorders/index']],
                                    ['label' => 'รายการสินค้า', 'icon' => 'folder-open', 'url' => ['/garbages']],
                                    ['label' => 'หน่วยนับ', 'icon' => 'folder-o', 'url' => ['/units']],
                                    ['label' => 'รายงาน', 'icon' => 'bar-chart', 'url' => ['/reports']],
                                    ['label' => 'สมาชิก', 'icon' => 'users', 'url' => ['/users']],
                                ]
                            ],
                            ['label' => 'ข้อมูลส่วนตัว', 'icon' => 'user', 'url' => ['/users/update', 'id' => Yii::$app->user->identity->id]],
                            ['label' => 'ออกจากระบบ', 'icon' => 'power-off', 'url' => ['site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>'],
                        ],
                    ]
            );
        } else if (Yii::$app->user->identity->role == "manager") {
            echo dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                            ['label' => 'เมนูหลัก', 'options' => ['class' => 'header']],
                            ['label' => 'รายงาน', 'icon' => 'user', 'url' => ['/reports']],
                            ['label' => 'ข้อมูลส่วนตัว', 'icon' => 'user', 'url' => ['/users/update', 'id' => Yii::$app->user->identity->id]],
                            ['label' => 'ออกจากระบบ', 'icon' => 'power-off', 'url' => ['site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>'],
                        ],
                    ]
            );
        } else if (Yii::$app->user->identity->role == "buyer") {
            echo dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                            ['label' => 'เมนูหลัก', 'options' => ['class' => 'header']],
                            ['label' => 'ประกาศขาย', 'icon' => 'clone', 'url' => ['site/']],
                            ['label' => 'รายการจอง', 'icon' => 'book', 'url' => ['saleorders/reserving']],
                            ['label' => 'รายการซื้อ', 'icon' => 'dot-circle-o', 'url' => ['saleorders/buying']],
                            ['label' => 'รายงาน', 'icon' => 'bar-chart', 'url' => ['/reports/buyer']],
                            ['label' => 'ข้อมูลส่วนตัว', 'icon' => 'user', 'url' => ['/users/update', 'id' => Yii::$app->user->identity->id]],
                            ['label' => 'ออกจากระบบ', 'icon' => 'power-off', 'url' => ['site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>'],
                        ],
                    ]
            );
        } else {
            echo dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                            ['label' => 'เมนูหลัก', 'options' => ['class' => 'header']],
                            ['label' => 'ประกาศขาย', 'icon' => 'clone', 'url' => ['/saleorders/selling']],
                            ['label' => 'รายการจอง', 'icon' => 'book', 'url' => ['/saleorders/reserve']],
                            ['label' => 'รายการปิดการขาย', 'icon' => 'dot-circle-o', 'url' => ['/saleorders/closed']],
                            ['label' => 'ราคาขยะ', 'icon' => 'folder-open', 'url' => ['/garbages/pricelist']],
                            ['label' => 'รายงาน', 'icon' => 'bar-chart', 'url' => ['/reports/seller']],
                            ['label' => 'ข้อมูลส่วนตัว', 'icon' => 'user', 'url' => ['/users/update', 'id' => Yii::$app->user->identity->id]],
                            ['label' => 'ออกจากระบบ', 'icon' => 'dashboard', 'url' => ['site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>'],
                        ],
                    ]
            );
        }
        ?>

    </section>

</aside>
