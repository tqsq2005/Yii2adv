Yii2-cropper
===================
Wrapper for [Image Cropper](http://fengyuanchen.github.io/cropper/) javascript library 


```php
echo Cropper::widget([
    // If true - it's output button for toggle modal crop window
    'modal' => true,
    // You can customize modal window. Copy /vendor/demi/cropper/views/modal.php
    'modalView' => '@backend/views/image/custom_modal',
    // URL-address for the crop-handling request
    // By default, sent the following post-params: x, y, width, height, rotate
    'cropUrl' => ['cropImage', 'id' => $image->id],
    // Url-path to original image for cropping
    'image' => Yii::$app->request->baseUrl . '/images/' . $image->src,
    // The aspect ratio for the area of cropping
    'aspectRatio' => 4 / 3, // or 16/9(wide) or 1/1(square) or any other ratio. Null - free ratio
    // Additional params for JS cropper plugin
    'pluginOptions' => [
        // All possible options: https://github.com/fengyuanchen/cropper/blob/master/README.md#options
        'minCropBoxWidth' => 400, // minimal crop area width
        'minCropBoxHeight' => 300, // minimal crop area height
    ],
    // HTML-options for widget container
    'options' => [],
    // HTML-options for cropper image tag
    'imageOptions' => [],
    // Additional ajax-options for send crop-request. See jQuery $.ajax() options
    'ajaxOptions' => [
        'success' => new JsExpression(<<<JS
            function(data) {
                // data - your JSON response from [[cropUrl]]
                $("#myImage").attr("src", data.croppedImageSrc);
            }
JS
        ),
    ],
]);
```

```php
    <?= $form->field($model, 'image_name')->fileInput(['accept' => 'image/*']) ?>
    
    Original:
    <?= Html::img(Yii::$app->request->baseUrl . '/images/example/' . $model->image_name) ?>
    <br />
    
    Cropped:
    <?= Html::img(Yii::$app->request->baseUrl . '/images/example/cropped_' . $model->image_name, ['id' => 'myImage']) ?>
    
    <br />
    <?= Cropper::widget([
        'modal' => true,
        'cropUrl' => ['cropImage', 'id' => $model->id],
        'image' => Yii::$app->request->baseUrl . '/images/example/' . $model->image_name,
        'aspectRatio' => 4 / 3,
        'pluginOptions' => [
            'minCropBoxWidth' => 400, // minimal crop area width
            'minCropBoxHeight' => 300, // minimal crop area height
        ],
        // HTML-options for widget container
        'options' => [],
        // HTML-options for cropper image tag
        'imageOptions' => [],
        // Additional ajax-options for send crop-request. See jQuery $.ajax() options
        'ajaxOptions' => [
            'success' => new JsExpression(<<<JS
                function(data) {
                    // data - your JSON response from [[cropUrl]]
                    $("#myImage").attr("src", data.croppedImageSrc);
                }
    JS
            ),
        ],
    ]); ?>
```

```php
    public function actionCropImage($id)
    {
        $request = Yii::$app->request;
        $model = ModelClass::find()->where(['id' => $id])->one();
    
        $imagePath = Yii::getAlias('@app/images/example/') . $model->image_name;
        $cropImagePath = Yii::getAlias('@app/images/example/') . 'cropped_' . $model->image_name;
        $x = $request->get('x');
        $y = $request->get('y');
        $width = $request->get('width');
        $height = $request->get('height');
        $rotate = $request->get('rotate');
    
        $yiiImage = Yii::createObject([
            'class' => 'yii\image\ImageDriver',
        ]);
        /* @var $image \yii\image\drivers\Image_GD|\yii\image\drivers\Image_Imagick */
        $image = $yiiImage->load($imagePath);
    
        $image->crop($width, $height, $x, $y);
        $image->rotate($rotate);
    
        $image->save($cropImagePath);
    
        $response = Yii::$app->response;
        // if is AJAX request
        if ($request->isAjax) {
            $response->getHeaders()->set('Vary', 'Accept');
            $response->format = Response::FORMAT_JSON;
    
            return [
                'status' => 'success',
                'croppedImageSrc' => $request->baseUrl . '/images/example/cropped_' . $model->image_name,
            ];
        } else {
            return $this->redirect(['update' => $model->id]);
        }
    }
```

> [demisang/yii2-cropper](https://github.com/demisang/yii2-cropper/issues/1)