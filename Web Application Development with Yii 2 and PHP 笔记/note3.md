User Authorization and Access Control
=====================================
1. Hook methods of the controllers
----------------------------------
> 这两个 事件的方法 最后必须都返回 `true` 才能确保 `Controller` 的 `action` 继续执行，很容易犯错的就是没有 `返回值` 就会默认返回 `null` 即 `false`

- beforeAction($action)：
- afterAction($action, $result): `$result` 就是 `Controller` 的 `action` 输出到 `view` 之前 执行完的 `结果`

> `$action` 是类 `yii\base\Action` 实例，在这边其自身没什么作用，但能作为以下的容器`container`：

- Action ID  `$action->id`
- 指向该 `action` 所在的 `Controller` : `$action->controller`
- `yii\base\Action` 的 `run()` 方法

> `Controller` 的 `beforeAction($action)` 一般是通过验证 `token` 来防止 `CSRF` 攻击， 如果需要取消 该验证，可通过以下方法：

- ```Yii::$app->controller->enableCsrfValidation = false;```
- 在 `Controller` 中 ```$this->enableCsrfValidation = false;```
- **推荐做法** 在 `Controller` 中 `重写 beforeAction方法`
```
    public function beforeAction( $action )
    {
        if($action->id == 'Your action id') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
```

