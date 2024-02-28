<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property string|null $number
 * @property string|null $description
 * @property int|null $user_id
 * @property int|null $status_id
 *
 * @property Status $status
 * @property User $user
 */
class Report extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['user_id', 'status_id'], 'integer'],
            [['fio'], 'string', 'max' => 127],
            [['data_of_reception'],'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'data_of_reception'=> 'Дата записи',
            'description' => 'симптомы',
            'user_id' => 'Пациент',
            'status_id' => 'статус заявки',
        ];
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}