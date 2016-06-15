<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

\common\assets\FullcalendarAsset::register($this);
\common\populac\assets\AdminAsset::register($this);
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <code><?= __FILE__ ?></code>

</div>
<div class="row-fluid">
    <div class="span12">
        <div class="btn-toolbar">
            <div class="pull-right">
                <div class="input-append">
                    <input type="text" placeholder="模糊查询" id="fuzzy-search">
                    <div class="btn-group">
                        <button type="button" class="btn" id="btn-simple-search"><i class="fa fa-search"></i></button>
                        <button type="button" class="btn" title="高级查询" id="toggle-advanced-search">
                            <i class="fa fa-angle-double-down"></i>
                        </button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="btn-add"><i class="fa fa-plus"></i> 添加</button>
            <button type="button" class="btn btn-danger" id="btn-del"><i class="fa fa-remove"></i> 批量删除</button>
        </div>
    </div>
</div>
<div>
    <?= Html::checkbox('', true, [
        'class' => 'switch',
        'data-id' => 1,
        'data-link' => \yii\helpers\Url::to(['/populac/modules/']),
        'data-reload' => '1'
    ]) ?>
    <input type="checkbox" id="switchCheck1" name="switchCheck1" value="switchCheck1" />
</div>
<p></p>
<p></p>
<div id="calendar"></div>
<div class="row">
    <div class="col-md-4">
        <a href="<?= \Yii::$app->homeUrl ?>" style="color: #0095dd; text-decoration: none;">计生管理系统 </a>
        <p class="secondary" style="font-family: sans-serif; font-weight: normal; margin: 0; text-align: center; color: #8A9BA8; font-size: 11px; line-height: 13px; width: 310px !important; word-wrap:break-word">这是一封自动发送的邮件，请勿回复，欲了解更多信息，请访问 <a href="<?= \Yii::$app->homeUrl ?>" style="color: #0095dd; text-decoration: none;">计生管理系统 </a></p>
        <?= \yii\helpers\Url::to(['/admin/populac/guestbook/a/view', 'id' => 11], true) ?>
    </div>
    <div class="col-md-4">
        <tbody>

        <tr style="page-break-before: always">
            <td valign="top">
                <h1 style="font-family: sans-serif; font-weight: normal; margin: 0 0 24px 0; text-align: center;">欢迎！</h1>
                <p class="primary" style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0 0 24px 0; text-align: center;">请确认此邮件地址以激活您的账号。</p>
            </td>
        </tr>


        <tr height="50">
            <td align="center" valign="top">
                <table id="email-button" style="-webkit-text-size-adjust: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #0095dd; border-radius: 4px; height: 50px; width: 310px !important;" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                    <tbody><tr style="page-break-before: always">
                        <td id="button-content" style="font-family: sans-serif; font-weight: normal; text-align: center; margin: 0; color: #ffffff; font-size: 20px; line-height: 100%;" align="center" valign="middle">

                            <a href="https://accounts.firefox.com.cn/v1/verify_email?uid=ca0267c356954865a1e2afdd47f60324&amp;code=f80696075e689f7a2eb7f39f13ba69a7&amp;service=sync&amp;resume=eyJjYW1wYWlnbiI6bnVsbCwiZW50cnlwb2ludCI6Im1lbnVwYW5lbCIsInVuaXF1ZVVzZXJJZCI6IjgzZjQzNmQzLWE5NWEtNGZkMC05YjhiLWFiYzJlZTE0ZGE5OSIsInV0bUNhbXBhaWduIjpudWxsLCJ1dG1Db250ZW50IjpudWxsLCJ1dG1NZWRpdW0iOm51bGwsInV0bVNvdXJjZSI6bnVsbCwidXRtVGVybSI6bnVsbH0%3D" id="button-link" style="font-family:sans-serif; color: #fff; display: block; padding: 15px; text-decoration: none; width: 280px;">立即激活</a>

                        </td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>

        <tr style="page-break-before: always">
            <td border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <br>
                <p width="310" class="secondary" style="font-family: sans-serif; font-weight: normal; margin: 0 0 24px 0; text-align: center; color: #8A9BA8; font-size: 11px; line-height: 13px; width: 310px !important; word-wrap: break-word; word-break: break-all">或者：<a target="_blank" href="https://accounts.firefox.com.cn/v1/verify_email?uid=ca0267c356954865a1e2afdd47f60324&amp;code=f80696075e689f7a2eb7f39f13ba69a7&amp;service=sync&amp;resume=eyJjYW1wYWlnbiI6bnVsbCwiZW50cnlwb2ludCI6Im1lbnVwYW5lbCIsInVuaXF1ZVVzZXJJZCI6IjgzZjQzNmQzLWE5NWEtNGZkMC05YjhiLWFiYzJlZTE0ZGE5OSIsInV0bUNhbXBhaWduIjpudWxsLCJ1dG1Db250ZW50IjpudWxsLCJ1dG1NZWRpdW0iOm51bGwsInV0bVNvdXJjZSI6bnVsbCwidXRtVGVybSI6bnVsbH0%3D" style="color: #0095dd; text-decoration: none; width: 310px !important; display:block;"><br><font style="word-break:break-all;">https://accounts.firefox.com.cn/v1/verify_email?uid=ca0267c356954865a1e2afdd47f60324&amp;code=f80696075e689f7a2eb7f39f13ba69a7&amp;service=sync&amp;resume=eyJjYW1wYWlnbiI6bnVsbCwiZW50cnlwb2ludCI6Im1lbnVwYW5lbCIsInVuaXF1ZVVzZXJJZCI6IjgzZjQzNmQzLWE5NWEtNGZkMC05YjhiLWFiYzJlZTE0ZGE5OSIsInV0bUNhbXBhaWduIjpudWxsLCJ1dG1Db250ZW50IjpudWxsLCJ1dG1NZWRpdW0iOm51bGwsInV0bVNvdXJjZSI6bnVsbCwidXRtVGVybSI6bnVsbH0%3D</font></a></p>
                <p class="secondary" style="font-family: sans-serif; font-weight: normal; margin: 0; text-align: center; color: #8A9BA8; font-size: 11px; line-height: 13px; width: 310px !important; word-wrap:break-word">这是一封自动发送的邮件；如果您并未要求但收到这封信件，您不需要进行任何操作。 欲了解更多信息，请访问 <a href="https://support.mozilla.org" style="color: #0095dd; text-decoration: none;">Mozilla 技术支持</a></p>
            </td>
        </tr>

        </tbody>
    </div>
    <div class="col-md-4">
        <tbody>

        <tr style="page-break-before: always">
            <td valign="top">
                <h1 style="font-family: sans-serif; font-weight: normal; margin: 0 0 24px 0; text-align: center;">账号已验证！</h1>
                <p class="primary" style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0 0 24px 0; text-align: center;">您已成功连接了首台设备到您的 Firefox 账号。现在您可以在您的其他设备上登录和开始“同步”了，包括 Firefox 的 <a href="http://www.firefox.com.cn/#mobile">Android</a> 和 <a href="https://www.mozilla.org/en-US/firefox/ios/">iOS</a> 版本。</p>
            </td>
        </tr>


        <tr height="50">
            <td align="center" valign="top">
                <table id="email-button" style="-webkit-text-size-adjust: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #0095dd; border-radius: 4px; height: 50px; width: 310px !important;" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                    <tbody><tr style="page-break-before: always">
                        <td id="button-content" style="font-family: sans-serif; font-weight: normal; text-align: center; margin: 0; color: #ffffff; font-size: 20px; line-height: 100%;" align="center" valign="middle">

                            <a href="https://www.mozilla.org/en-US/firefox/sync/" id="button-link" style="font-family:sans-serif; color: #fff; display: block; padding: 15px; text-decoration: none; width: 280px;">连接另一台设备</a>

                        </td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>

        <tr style="page-break-before: always">
            <td border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <br>
                <p width="310" class="secondary" style="font-family: sans-serif; font-weight: normal; margin: 0 0 24px 0; text-align: center; color: #8A9BA8; font-size: 11px; line-height: 13px; width: 310px !important; word-wrap: break-word">或者：<a href="https://www.mozilla.org/en-US/firefox/sync/" style="color: #0095dd; text-decoration: none; width: 310px !important; display:block;"><br>https://www.mozilla.org/en-US/firefox/sync/</a></p>
                <p class="secondary" style="font-family: sans-serif; font-weight: normal; margin: 0; text-align: center; color: #8A9BA8; font-size: 11px; line-height: 13px; width: 310px !important; word-wrap:break-word">这是一封自动发送的邮件；如果您并未要求但收到这封信件，您不需要进行任何操作。 欲了解更多信息，请访问 <a href="https://support.mozilla.org" style="color: #0095dd; text-decoration: none;">Mozilla 技术支持</a></p>
            </td>
        </tr>

        </tbody>
    </div>
</div>
<?php
    /*echo \kartik\tree\TreeView::widget([
        // single query fetch to render the treemanager
        'query'             => \common\models\Preferences::find()->addOrderBy('root, lft'),
        'headingOptions'    => ['label' => '<span class="text-info">常用项目配置</span>'],
        'fontAwesome'       => true,                        // optional
        'isAdmin'           => true,                        // optional (toggle to enable admin mode)
        'displayValue'      => 1,                           // initial display value
        //'softDelete'      => true,                        // normally not needed to change
        //'cacheSettings'   => ['enableCache' => true]      // normally not needed to change
        'rootOptions'       => ['label'=>'<span class="text-primary">计生系统</span>'],
        'softDelete'        => true,
        'cacheSettings'     => ['enableCache' => true],
        'iconEditSettings'=> [
            'show'      => 'list',
            'listData'  => [
                'folder' => 'Folder',
                'file' => 'File',
                'star' => 'Star',
                'bell' => 'Bell',
            ]
        ],
    ]);*/
    echo \kartik\tree\TreeView::widget([
        'query' => \common\models\PreferencesTree::find()->addOrderBy('root, lft'),
        'headingOptions'    => ['label' => '<span class="text-info">系统参数配置</span>'],
        'fontAwesome'       => true,                        // optional
        'isAdmin'           => true,                        // optional (toggle to enable admin mode)
        'displayValue'      => 1,                           // initial display value
        //'rootOptions'       => ['label'=>'<span class="text-primary">系统参数</span>'],
        'softDelete'        => true,
        'cacheSettings'     => ['enableCache' => true],
        'iconEditSettings'=> [
            'show'      => 'list',
            'listData'  => [
                'folder' => 'Folder',
                'file' => 'File',
                'star' => 'Star',
                'bell' => 'Bell',
            ]
        ],
        'nodeAddlViews' => [
            \kartik\tree\Module::VIEW_PART_2 => '@common/views/treemanager/_preferencesTree'
        ]
    ]);

echo \kartik\tree\TreeView::widget([
    'query' => \common\models\Nav::find()->addOrderBy('root, lft'),
    'headingOptions'    => ['label' => '<span class="text-info">系统参数配置</span>'],
    'fontAwesome'       => true,                        // optional
    'isAdmin'           => true,                        // optional (toggle to enable admin mode)
    'displayValue'      => 1,                           // initial display value
    //'rootOptions'       => ['label'=>'<span class="text-primary">系统参数</span>'],
    'softDelete'        => true,
    'cacheSettings'     => ['enableCache' => true],
    'iconEditSettings'=> [
        'show'      => 'list',
        'listData'  => [
            'folder' => 'Folder',
            'file' => 'File',
            'star' => 'Star',
            'bell' => 'Bell',
        ]
    ],
    'nodeAddlViews' => [
        \kartik\tree\Module::VIEW_PART_2 => '@common/views/treemanager/_nav'
    ]
]);
?>
<?php \common\widgets\JsBlock::begin();  ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var switcher1 = $('#switchCheck1').switcher();
            var switcher2 = $('.switch').switcher();
            $('#switchCheck1').switcher().on('change', function() {
                console.log(1111);
            });
            $('#calendar').fullCalendar({
                theme: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultDate: '2016-01-12',
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: [
                    {
                        title: 'All Day Event',
                        start: '2016-01-01'
                    },
                    {
                        title: 'Long Event',
                        start: '2016-01-07',
                        end: '2016-01-10'
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: '2016-01-09T16:00:00'
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: '2016-01-16T16:00:00'
                    },
                    {
                        title: 'Conference',
                        start: '2016-01-11',
                        end: '2016-01-13'
                    },
                    {
                        title: 'Meeting',
                        start: '2016-01-12T10:30:00',
                        end: '2016-01-12T12:30:00'
                    },
                    {
                        title: 'Lunch',
                        start: '2016-01-12T12:00:00'
                    },
                    {
                        title: 'Meeting',
                        start: '2016-01-12T14:30:00'
                    },
                    {
                        title: 'Happy Hour',
                        start: '2016-01-12T17:30:00'
                    },
                    {
                        title: 'Dinner',
                        start: '2016-01-12T20:00:00'
                    },
                    {
                        title: 'Birthday Party',
                        start: '2016-01-13T07:00:00'
                    },
                    {
                        title: 'Click for Google',
                        url: 'http://google.com/',
                        start: '2016-01-28'
                    }
                ]
            });

        });
    </script>
<?php \common\widgets\JsBlock::end();  ?>



