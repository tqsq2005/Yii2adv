<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%helpmenu}}".
 *
 * @property integer $id
 * @property string $unitcode
 * @property string $unitname
 * @property string $upunitcode
 * @property string $upunitname
 * @property integer $corpflag
 * @property string $content
 * @property string $introduce
 * @property string $do_man
 * @property string $do_date
 * @property string $do_man_unit
 * @property string $advise
 * @property string $answer
 * @property string $answerdate
 * @property integer $is_private
 * @property string $answercontent
 * @property integer $created_at
 * @property integer $updated_at
 */
class Helpmenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%helpmenu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unitcode', 'unitname', 'upunitcode', 'upunitname', 'corpflag', 'content', 'introduce', 'do_man', 'do_date', 'do_man_unit', 'advise', 'answer', 'answerdate', 'is_private', 'answercontent', 'created_at', 'updated_at'], 'required'],
            [['corpflag', 'is_private', 'created_at', 'updated_at'], 'integer'],
            [['content', 'introduce', 'advise', 'answercontent'], 'string'],
            [['do_date', 'answerdate'], 'safe'],
            [['unitcode', 'upunitcode', 'do_man', 'do_man_unit', 'answer'], 'string', 'max' => 30],
            [['unitname', 'upunitname'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unitcode' => 'Unitcode',
            'unitname' => 'Unitname',
            'upunitcode' => 'Upunitcode',
            'upunitname' => 'Upunitname',
            'corpflag' => 'Corpflag',
            'content' => 'Content',
            'introduce' => 'Introduce',
            'do_man' => 'Do Man',
            'do_date' => 'Do Date',
            'do_man_unit' => 'Do Man Unit',
            'advise' => 'Advise',
            'answer' => 'Answer',
            'answerdate' => 'Answerdate',
            'is_private' => 'Is Private',
            'answercontent' => 'Answercontent',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getChildren($unitcode)
    {
        $query = $this::find();
        $query->select([
            'id'        => 'unitcode',
            'text'      => 'unitname',
            //'content',
            //'children'  => true,
        ]);
        $query->andFilterWhere([
            'upunitcode' => $unitcode,
        ]);
        $data = $query->asArray()->all();
        if(count($data) > 0) {
            foreach($data as &$arr) {
                $arr['children']    = $this->isParent($arr['id']);
                $arr['icon']        = $arr['children'] ? 'fa fa-book text-success' : 'fa fa-bookmark-o text-success';
            }
        }
        return $data;
    }

    protected function isParent($unitcode)
    {
        $query = $this::find()->andFilterWhere([
            'upunitcode' => $unitcode,
        ])->count(1);

        if($query > 0) {
            return true;
        }

        return false;
    }

    /**
     * 获取菜单Tree
     *
     * @return multitype:
     */
    public function getMenuAllList() {
        $resArr = $this->getTreeChilds ( 0 );
        $arr = array ();
        $arr [0] = "作为一级菜单";
        foreach ( $resArr as $rs ) {
            $id = $rs ['id'];
            $text = $rs ['text'];
            $arr [$id] = $text;
        }
        return $arr;
        //return $resArr = CHtml::listData ( $arr, 'id', 'text');
    }
    public function getTreeChilds($parentid) {
        $icon = array (
            '├─ ',
            '├─ ',
            '└─ '
        );

        $rs = $this->findAll([
            'upunitcode' => $parentid,
        ]);
        $returnArr = array ();
        if (count ( $rs ) > 0) {

            for($i = 0; $i < count ( $rs ); $i ++) {
                if ($parentid > '') {


                    $strnbsp = str_repeat ( '    ', $rs [$i] ['level'] );

                    if (count($rs)==1) {
                        $strnbsp .= $icon [2];
                    }else{
                        if ($i == 0) {
                            $strnbsp .= $icon [0];
                        } elseif ($i == count ( $rs ) - 1) {
                            $strnbsp .= $icon [2];
                        } else {
                            $strnbsp .= $icon [1];
                        }
                    }

                    $returnArr [Menu::$ii] ['id'] = $rs [$i] ['id'];
                    $returnArr [Menu::$ii] ['text'] = $strnbsp. $rs [$i] ['text'];
                } else {
                    $returnArr [Menu::$ii] ['id'] = $rs [$i] ['id'];
                    $returnArr [Menu::$ii] ['text'] = $rs [$i] ['text'];
                }
                $childArr = $this->getTreeChilds ( $rs [$i] ['id'] );
                if (count ( $childArr ) > 0) {
                    foreach ( $childArr as $child ) {
                        array_push ( $returnArr, $child );
                    }
                }
                Menu::$ii ++;
            }
        }
        return $returnArr;
    }
}
