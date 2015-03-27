<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "flag_reports".
 *
 * @property integer $report_id
 * @property integer $reported_by
 * @property integer $user_id
 * @property string $report
 * @property string $datetimestamp
 * @property integer $active
 */
class FlagReports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flag_reports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reported_by', 'user_id', 'report', 'datetimestamp'], 'required'],
            [['reported_by', 'user_id', 'active'], 'integer'],
            [['datetimestamp'], 'safe'],
            [['report'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'report_id' => 'Report ID',
            'reported_by' => 'Reported By',
            'user_id' => 'User ID',
            'report' => 'Report',
            'datetimestamp' => 'Datetimestamp',
            'active' => 'Active',
        ];
    }
}
