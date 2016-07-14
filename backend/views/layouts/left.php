<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <?php
        $user_avatar = $directoryAsset . '/img/user2-160x160.jpg';
        if( $avatar = \common\models\UserAvatar::getAvatar(Yii::$app->user->identity->id) )
            $user_avatar = Yii::$app->homeUrl.'/uploads/user/avatar/' . $avatar;
        ?>
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $user_avatar ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>超级管理员</p>

                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="搜索..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <?php
            $callback = function($menu){
                return [
                    'label' => $menu['name'],
                    'url' => [$menu['route']],
                    'icon' => $menu['data'],
                    //'active' => true,
                    'items' => $menu['children']
                ];
            };
        ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => \yii\helpers\ArrayHelper::merge(
                    [['label' => '管理台菜单', 'options' => ['class' => 'header']],],
                    \mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id, 14, $callback, true), [
                    ['label' => '管理台菜单', 'options' => ['class' => 'header']],
                    ['label' => '测试页面', 'icon' => 'fa fa-flag-checkered', 'url' => ['/site/test']],
                    [
                        'label' => 'Gii',
                        'icon' => 'fa fa-file-code-o',
                        'url' => ['/gii'],
                        'template' => '<a href="{url}" target="_blank">{icon} {label}</a>',
                    ],
                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => Yii::$app->getHomeUrl(), 'visible' => Yii::$app->user->isGuest],
                    /*[
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],*/
                    [
                        'label' => '系统管理',
                        'visible' => !Yii::$app->user->isGuest,
                        'icon'  => 'fa fa-cog fa-lg fa-fw fa-spin',
                        'url' => '#',
                        'items' => [
                            ['label' => '系统使用帮助1', 'icon' => 'fa fa-question-circle', 'url' => ['/helpdoc'],],
                            ['label' => '系统使用帮助2', 'icon' => 'fa fa-question-circle', 'url' => ['/helpmenu/main'],],
                            ['label' => '系统参数配置', 'icon' => 'fa fa-wrench', 'url' => ['/preferences/index', 'per-page' => Yii::$app->params['backend.view_item_per_page']],],
                            ['label' => '系统事件管理', 'icon' => 'fa fa-calendar', 'url' => ['/event/index'],],
                            ['label' => '系统事件管理', 'icon' => 'fa fa-calendar-plus-o', 'url' => ['/events/index'],],
                            ['label' => '系统提醒管理', 'icon' => 'fa fa-bell-o', 'url' => ['/reminders/index'],],

                            [
                                'label' => '系统日志管理', 'icon' => 'fa fa-history', 'url' => '#',
                                'items' => [
                                    ['label' => '系统日志审计', 'icon' => 'fa fa-hourglass-3', 'url' => ['/audit'],],
                                    ['label' => '系统日志管理', 'icon' => 'fa fa-hourglass-1', 'url' => ['/log'],],
                                    ['label' => '系统访问日志', 'icon' => 'fa fa-hourglass-2', 'url' => ['/request-log'],],
                                ],
                            ],
                        ],
                    ]
                ]),

            ]
        ) ?>

    </section>

</aside>
