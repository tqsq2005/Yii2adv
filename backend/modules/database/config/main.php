<?php

return [
    'params' => [
        'DATA_BACKUP_PATH' => \Yii::getAlias('@backend').'/modules/database/data/',
        'DATA_BACKUP_PART_SIZE' => 20971520,
        'DATA_BACKUP_COMPRESS' => 1,
        'DATA_BACKUP_COMPRESS_LEVEL' => 9,
    ]
];