<?php

namespace backend\modules\database\controllers;

use backend\modules\database\models\Database;
use yii\base\Exception;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\web\Response;


class ExportController extends Controller
{
    public function actionIndex()
    {
        $Db    = \Yii::$app->db;
        $list  = $Db->createCommand('SHOW TABLE STATUS')->queryAll();
        $list  = array_map('array_change_key_case', $list);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $list
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 优化表
     * @param  String $tables 表名
     */
    public function actionOptimize($tables = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if($tables) {
            $Db   = \Yii::$app->db;
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
                $list = $Db->createCommand("OPTIMIZE TABLE `{$tables}`")->queryAll();

                if($list){
                    return [
                        'message' => '数据表优化完成'
                    ];
                } else {
                    throw new Exception('数据表优化出错请重试!');
                }
            } else {
                $list = $Db->createCommand("OPTIMIZE TABLE `{$tables}`")->queryAll();
                if($list){
                    return [
                        'message' => "数据表'{$tables}'优化完成！"
                    ];
                } else {
                    throw new Exception("数据表'{$tables}'优化出错请重试！");
                }
            }
        } else {
            throw new Exception('请指定要优化的表');
        }
    }

    /**
     * 修复表
     * @param  String $tables 表名
     */
    public function actionRepair($tables = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if($tables) {
            $Db   = \Yii::$app->db;
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
                $list = $Db->createCommand("REPAIR TABLE `{$tables}`")->queryAll();

                if($list){
                    return [
                        'message' => "数据表修复完成！"
                    ];
                } else {
                    throw new Exception('数据表修复出错请重试');
                }
            } else {
                $list = $Db->createCommand("REPAIR TABLE `{$tables}`")->queryAll();
                if($list){
                    return [
                        'message' => "数据表'{$tables}'修复完成！"
                    ];
                } else {
                    throw new Exception("数据表'{$tables}'修复出错请重试！");
                }
            }
        } else {
            throw new Exception("请指定要修复的表");
        }
    }

    public function actionInit()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $tables = \Yii::$app->request->post('tables');
        $path = \Yii::$app->controller->module->params['DATA_BACKUP_PATH'];
        if(!is_dir($path)){
            mkdir($path, 0755, true);
        }
        //读取备份配置
        $config = array(
            'path'     => realpath($path) . DIRECTORY_SEPARATOR,
            'part'     => \Yii::$app->controller->module->params['DATA_BACKUP_PART_SIZE'],
            'compress' => \Yii::$app->controller->module->params['DATA_BACKUP_COMPRESS'],
            'level'    => \Yii::$app->controller->module->params['DATA_BACKUP_COMPRESS_LEVEL']
        );

        //检查是否有正在执行的任务
        $lock = "{$config['path']}backup.lock";
        if(is_file($lock)){
            return ['status' => 0, 'info' => '检测到有一个备份任务正在执行，请稍后再试！'];
        } else {
            //创建锁文件
            file_put_contents($lock, time());
        }

        //检查备份目录是否可写
        if (!is_writeable($config['path'])) {
            return ['status' => 0, 'info' => '备份目录不存在或不可写，请检查后重试！'];
        }
        \Yii::$app->session->set('backup_config', $config);

        //生成备份文件信息
        $file = array(
            'name' => date('Ymd-His', time()),
            'part' => 1,
        );
        \Yii::$app->session->set('backup_file', $file);

        //缓存要备份的表
        \Yii::$app->session->set('backup_tables', $tables);

        //创建备份文件
        $Database = new Database($file, $config);
        if(false !== $Database->create()){
            $tab = ['id' => 0, 'start' => 0];
            return [
                'status' => 1,
                'info' => '初始化成功！',
                'tables' => $tables,
                'tab' => $tab
            ];
        } else {
            return [
                'status' => 0,
                'info' => '初始化失败，备份文件创建失败！'
            ];
        }
    }
    public function actionStart($id = null, $start = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $tables = \Yii::$app->session->get('backup_tables');
        $id = \Yii::$app->request->post('id');
        $start = \Yii::$app->request->post('start');
        //备份指定表
        $Database = new Database(\Yii::$app->session->get('backup_file'), \Yii::$app->session->get('backup_config'));
        $start  = $Database->backup($tables[$id], $start);
        if(false === $start){ //出错
            return [
                'status' => 0,
                'info' => '备份出错！'
            ];
        } elseif (0 === $start) { //下一表
            if(isset($tables[++$id])){
                $tab = array('id' => $id, 'start' => 0);
                return [
                    'status' => 1,
                    'tab' => $tab
                ];
            } else { //备份完成，清空缓存
                unlink(\Yii::$app->session->get('backup_config')['path'] . 'backup.lock');
                \Yii::$app->session->set('backup_tables', null);
                \Yii::$app->session->set('backup_file', null);
                \Yii::$app->session->set('backup_config', null);
                return [
                    'status' => 1,
                    'info' => '备份完成！'
                ];
            }
        } else {
            $tab  = array('id' => $id, 'start' => $start[0]);
            $rate = floor(100 * ($start[0] / $start[1]));
            return [
                'status' => 1,
                'info' => "正在备份...({$rate}%)",
                'tab' => $tab
            ];
        }
    }

}
