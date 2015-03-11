<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_files".
 *
 * @property integer $status_id
 * @property string $file_url
 *
 * @property TaskStatus $status
 */
class TaskFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_id', 'file_url'], 'required'],
            [['status_id'], 'integer'],
            [['file_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status_id' => 'Status ID',
            'file_url' => 'File Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(TaskStatus::className(), ['status_id' => 'status_id']);
    }
}
