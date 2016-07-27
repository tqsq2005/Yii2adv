<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-27 上午8:16
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use bedezign\yii2\audit\Audit;
use bedezign\yii2\audit\components\Access;
use bedezign\yii2\audit\models\AuditTrail;
use bedezign\yii2\audit\models\AuditTrailSearch;
use bedezign\yii2\audit\web\AuditAsset;
use yii\db\ActiveQuery;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var bool $filter
 * @var array $params
 * @var ActiveQuery $query
 * @var array $columns
 * @var array $exceptField 不显示的字段
 */
$this->title = '操作记录';
$this->params['breadcrumbs'][] = $this->title;

$exceptField = ['created_at', 'updated_at', 'created_by', 'updated_by'];
$params = isset($params) ? $params : Yii::$app->request->get();
$query = isset($query) ? $query : null;
$columns = isset($columns) ? $columns : [];
$filter = isset($filter) ? $filter : true;

$this->registerAssetBundle(AuditAsset::className());

$auditTrailSearch = new AuditTrailSearch();
$auditTrailDataProvider = $auditTrailSearch->search($params, $query);
$auditTrailDataProvider->pagination = ['pageSize' => 10, 'pageParam' => 'page-auditTrails'];
$auditTrailDataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];

$_columns = [];

if (empty($columns) || in_array('user_id', $columns)) {
    $_columns[] = [
        'attribute' => 'user_id',
        'value' => function ($data) {
            $user_id = Audit::getInstance()->getUserIdentifier($data->user_id);
            $user    = \dektrium\user\models\User::findOne($user_id);
            return '<h4><span class="label label-info">'.($user ? $user->username : '员工本人').'</span></h4>';
        },
        'format' => 'raw',
    ];
}
if (empty($columns) || in_array('entry_id', $columns)) {
    $_columns[] = [
        'attribute' => 'entry_id',
        'value' => function ($model) {
            /** @var AuditTrail $model */
            if (Access::checkAccess()) {
                return Html::a('<h4><span class="label label-success">'.$model->entry_id.'</span></h4>', ['/audit/entry/view', 'id' => $model->entry_id]);
            }
            return '<h4><span class="label label-success">'.$model->entry_id.'</span></h4>';
        },
        'format' => 'raw',
    ];
}
if (empty($columns) || in_array('action', $columns)) {
    //$_columns[] = 'action';
    $_columns[] = [
        'attribute' => 'action',
        'value' => function ($model) {
            /** @var AuditTrail $model */
            $label = '<span class="label label-success">新增</span>';
            switch( strtolower($model->action) ) {
                case 'update':
                    $label = '<span class="label label-primary">修改</span>';
                    break;
                case 'delete':
                    $label = '<span class="label label-danger">删除</span>';
                    break;
            }
            return '<h4>'.$label.'</h4>';
        },
        'format' => 'raw',
    ];
}
if (empty($columns) || in_array('model', $columns)) {
    $_columns[] = 'model';
}
if (empty($columns) || in_array('model_id', $columns)) {
    $_columns[] = 'model_id';
}
if (empty($columns) || in_array('field', $columns)) {
    //$_columns[] = 'field';
    $_columns[] = [
        'attribute' => 'field',
        'value' => function ($model) {
            /** @var AuditTrail $model */
            /**
             * 先将`["pbc_classmark","updated_at"]`类似的转为 数组
             */
            if (!$model->field)
                return '';
            $field      = explode(',', str_replace( ['[', ']', '"'], ['', '', ''], $model->field));
            $rawModel   = new $model->model;
            $display    = [];
            foreach($field as $label) {
                if( in_array($label, ['created_at', 'updated_at', 'created_by', 'updated_by']) )
                    continue;
                $label = $rawModel->getAttributeLabel($label);
                $label = '<span class="label label-default">'.$label.'</span>';
                $display[] = $label;
            }

            return '<h4>'.implode('<br>', $display).'</h4>';
        },
        'format' => 'raw',
    ];
}
if (in_array('old_value', $columns)) {
    //$_columns[] = 'old_value';
    $_columns[] = [
        'attribute' => 'old_value',
        'value' => function ($model) {
            /** @var AuditTrail $model */
            /**
             * 先将`["pbc_classmark","updated_at"]`类似的转为 数组
             * 获取每个字段对应的`classmark`, 如果有，则转为相关的`中文描述`，无则用原值
             */
            if (!$model->old_value)
                return '';

            $rawModel   = new $model->model;
            $table      = $rawModel->tableName();
            $display    = [];
            /** 删除 */
            if( strtolower($model->action) == 'delete' ) {
                $old_value = \yii\helpers\Json::decode($model->old_value);
                foreach ($old_value as $k => $v) {
                    if( in_array($k, ['created_at', 'updated_at', 'created_by', 'updated_by']) )
                        continue;
                    $field      = $rawModel->getAttributeLabel($k);
                    $classmark  = \common\populac\models\ColTable::getClassmark($table, $k);
                    $tmpVal     = \common\populac\models\Preferences::get($classmark, $v);
                    $value      = $tmpVal ? $tmpVal : $v;
                    $display[]  = '<span style="line-height: 28px;" class="bg-info text-primary"><span class="label label-default">'.$field .'</span>:'.$value.'</span>';
                }
                return '<h4>'.implode('<br>', $display).'</h4>';
            }

            /** 新增或修改 */
            $old        = explode(',', str_replace( ['[', ']', '"'], ['', '', ''], $model->old_value));
            $field      = explode(',', str_replace( ['[', ']', '"'], ['', '', ''], $model->field));

            foreach ($old as $i => $line) {
                if( in_array($field[$i], ['created_at', 'updated_at', 'created_by', 'updated_by']) )
                    continue;

                $classmark  = '';
                $value      = '';
                $classmark  = \common\populac\models\ColTable::getClassmark($table, $field[$i]);
                $value      = \common\populac\models\Preferences::get($classmark, $line);
                if(in_array($field[$i], ['created_at', 'updated_at'])) {
                    $value  = date('Y.m.d H:i:s', $line);
                }
                $line       = $value ? $value : $line;
                $line       = '<span class="bg-warning text-muted">'.$line.'</span>';
                $display[]  = $line;
            }
            return '<h4>'.implode('<br>', $display).'</h4>';
        },
        'contentOptions'    => ['width' => '20%'],
        'format' => 'raw',
    ];
}
if (in_array('new_value', $columns)) {
    //$_columns[] = 'new_value';
    $_columns[] = [
        'attribute' => 'new_value',
        'value' => function ($model) {
            /** @var AuditTrail $model */
            /**
             * 先将`["pbc_classmark","updated_at"]`类似的转为 数组
             * 获取每个字段对应的`classmark`, 如果有，则转为相关的`中文描述`，无则用原值
             */
            if (!$model->new_value)
                return '';
            $new        = explode(',', str_replace( ['[', ']', '"'], ['', '', ''], $model->new_value));
            $field      = explode(',', str_replace( ['[', ']', '"'], ['', '', ''], $model->field));
            $rawModel   = new $model->model;
            $table      = $rawModel->tableName();
            $display    = [];

            foreach ($new as $i => $line) {
                if( in_array($field[$i], ['created_at', 'updated_at', 'created_by', 'updated_by']) )
                    continue;

                $classmark  = '';
                $value      = '';
                $classmark  = \common\populac\models\ColTable::getClassmark($table, $field[$i]);
                $value      = \common\populac\models\Preferences::get($classmark, $line);
                $line       = $value ? $value : $line;
                $line       = '<span class="bg-info text-success">'.$line.'</span>';
                $display[]  = $line;
            }
            return '<h4>'.implode('<br>', $display).'</h4>';
        },
        'contentOptions'    => ['width' => '20%'],
        'format' => 'raw',
    ];
}
if (empty($columns) || in_array('diff', $columns)) {
    $_columns[] = [
        'label' => Yii::t('audit', 'Diff'),
        'value' => function ($model) {
            /** @var AuditTrail $model */
            return $model->getDiffHtml();
        },
        'format' => 'raw',
    ];
}
if (empty($columns) || in_array('created', $columns)) {
    $_columns[] = [
        'attribute'         => 'created',
        'contentOptions'    => ['class' => 'text-center', 'style' => ['vertical-align' => 'middle']]
    ];
}

$_columns[] = [
    'label' => '恢复',
    'value' => function ($model) {
        /** @var AuditTrail $model */
        if(in_array(strtolower($model->action), ['update', 'delete', 'create'])) {
            $rawModel   = $model->model;
            $field      = $model->field;
            $old_value  = $model->old_value;
            $pkey       = $model->model_id;
            $action     = $model->action;
            $title      = '恢复至修改前状态';
            if( strtolower($model->action) == 'create' ) {
                $old_value  = $model->new_value;
                $title      = '恢复至新增时状态';
            }
            return '<a id="retrieve" class="btn btn-sm bg-purple" '.
            ' data-action=\''.$action.'\' data-model=\''.$rawModel.'\' data-field=\''.$field.'\' data-value=\''.$old_value.'\' data-pkey=\''.$pkey.'\' '.
            ' data-toggle="tooltip" title="'.$title.'"><i class="fa fa-undo"></i> 恢复</a>';
        }
        return '';
    },
    'contentOptions'    => ['class' => 'text-center', 'style' => ['vertical-align' => 'middle']],
    'format'            => 'raw',
];
?>
<div class="box box-primary">
    <div class="box-header" style="cursor: pointer;">
        <i class="fa fa-history"></i>
        <h3 class="box-title"><?= $this->title ?></h3>
    </div>
    <div class="box-body">
    <?php
    Pjax::begin([
        'id' => 'pjax-AuditTrails',
        'enableReplaceState' => false,
        'linkSelector' => '#pjax-AuditTrails ul.pagination a, th a',
    ]);

    echo '<div class="table-responsive">' . GridView::widget([
            //'layout' => '{summary}{pager}<br/>{items}{pager}',
            'dataProvider' => $auditTrailDataProvider,
            'filterModel' => $filter ? $auditTrailSearch : null,
            'columns' => $_columns,
        ]) . '</div>';

    Pjax::end();

    // row grouping
    //ob_start();
    ?>
    </div>
</div>
<script>
    // grouping not working
    // see http://www.hafidmukhlasin.com/2015/02/09/yii2-create-grouping-in-gridview-from-scracth-with-jquery/
    //        var gridview_id = "#pjax-AuditTrails .grid-view"; // specific gridview
    //        var columns = [1]; // index column that will grouping, (user_id, entry_id)
    //
    //        var column_data = [];
    //        column_start = [];
    //        rowspan = [];
    //
    //        for (var i = 0; i < columns.length; i++) {
    //            column = columns[i];
    //            column_data[column] = "";
    //            column_start[column] = null;
    //            rowspan[column] = 1;
    //        }
    //
    //        var row = 1;
    //        $(gridview_id + " table > tbody  > tr").each(function () {
    //            var col = 1;
    //            $(this).find("td").each(function () {
    //                for (var i = 0; i < columns.length; i++) {
    //                    if (col == columns[i]) {
    //                        if (column_data[columns[i]] == $(this).html()) {
    //                            $(this).remove();
    //                            rowspan[columns[i]]++;
    //                            $(column_start[columns[i]]).attr("rowspan", rowspan[columns[i]]);
    //                        }
    //                        else {
    //                            column_data[columns[i]] = $(this).html();
    //                            rowspan[columns[i]] = 1;
    //                            column_start[columns[i]] = $(this);
    //                        }
    //                    }
    //                }
    //                col++;
    //            });
    //            row++;
    //        });
</script>
<?php
//// get contents
//$js = ob_get_clean();
//$js = str_replace(array('<script>', '</script>'), '', $js);
//// register the js script
//$this->registerJs($js . ';', View::POS_READY);
?>
<?php \common\widgets\JsBlock::begin(); ?>
<script type="text/javascript">
    $(function() {
        $(document).on('click', '#retrieve', function(e) {
            var data    = $(this).data(),
                model   = data.model,
                action  = data.action,
                field   = data.field,
                value   = data.value,
                pkey    = data.pkey;
            layer.confirm('即将恢复，确定吗？', { icon: 6, shift: 6, title: '系统提示' }, function(index) {
                $.ajax({
                    url : '<?= \yii\helpers\Url::to(['/populac/default/log-retrieve']) ?>',
                    type: 'post',
                    data: { model: model, action: action, field: field, value: value, pkey: pkey },
                    beforeSend: function () {
                        layer.load(1);
                    },
                    complete: function () {
                        layer.closeAll('loading');
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.alert('撤销操作出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                    },
                    success: function(data) {
                        layer.msg('数据已恢复,请返回并刷新相应的数据页面查看..', {icon: 6, time: 1500}, function(index) {
                            layer.close(index);
                        });
                    }
                });
            });
        });
    });
</script>
<?php \common\widgets\JsBlock::end(); ?>
