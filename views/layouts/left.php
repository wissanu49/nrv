<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if(Yii::$app->user->identity->image != "" || Yii::$app->user->identity->image != NULL){ ?>
                    <img src="<?php echo Yii::getAlias('@web').'/web/uploads/images/'.Yii::$app->user->identity->image; ?>" class="img-circle"  alt="User Image" />
                <?php }else{ ?>
                    <img src="<?php echo Yii::getAlias('@web').'/web/uploads/images/avatar.jpg' ?>" class="img-circle"  alt="User Image" />
                <?php } ?>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <?php
        if(Yii::$app->user->identity->role == "admin"){
        echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'เมนูหลัก', 'options' => ['class' => 'header']],
                    ['label' => 'ประกาศขาย', 'icon' => 'file-code-o', 'url' => ['/saleorders']],
                    ['label' => 'รายการขยะ', 'icon' => 'dashboard', 'url' => ['/garbages']],
                    ['label' => 'รายงาน', 'icon' => 'dashboard', 'url' => ['/report']],
                    ['label' => 'สมาชิก', 'icon' => 'user', 'url' => ['/users']],
                    ['label' => 'ข้อมูลส่วนตัว', 'icon' => 'user', 'url' => ['/users/update', 'id' => Yii::$app->user->identity->id]],
                    ['label' => 'ออกจากระบบ', 'icon' => 'dashboard', 'url' => ['site/logout'],  'template' => '<a href="{url}" data-method="post">{icon} {label}</a>'],
                ],
            ]
        ); 
        }else{
            echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'เมนูหลัก', 'options' => ['class' => 'header']],
                    ['label' => 'ประกาศขาย', 'icon' => 'file-code-o', 'url' => ['/saleorders']],
                    ['label' => 'ข้อมูลส่วนตัว', 'icon' => 'user', 'url' => ['/users/update', 'id' => Yii::$app->user->identity->id]],
                    ['label' => 'ออกจากระบบ', 'icon' => 'dashboard', 'url' => ['site/logout'],  'template' => '<a href="{url}" data-method="post">{icon} {label}</a>'],
                ],
            ]
        );
        }
        
        ?>

    </section>

</aside>
