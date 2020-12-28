<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "session".
 *
 * @property int $ID
 * @property int $userID
 * @property string $name
 * @property string $description
 * @property string $start
 * @property int $duration
 * @property string $created
 * @property string $updated
 *
 * @property User $user
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'session';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'userID',
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'start', 'duration'], 'required'],
            [['userID', 'duration'], 'integer'],
            [['description'], 'string'],
            [['start', 'created', 'updated'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'userID' => 'User ID',
            'name' => 'Name',
            'description' => 'Description',
            'start' => 'Start',
            'duration' => 'Duration',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['ID' => 'userID']);
    }
}
