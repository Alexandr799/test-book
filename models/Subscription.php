<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Subscription model
 *
 * @property int $id
 * @property string $phone Телефон для SMS-уведомлений
 * @property bool|null $is_active Активна ли подписка
 * @property int $created_at
 */
class Subscription extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%subscription}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'match', 'pattern' => '/^\+?[0-9]{10,15}$/', 'message' => 'Некорректный формат телефона'],
            [['is_active'], 'boolean'],
            [['is_active'], 'default', 'value' => true],
            [['created_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Телефон',
            'is_active' => 'Активна',
            'created_at' => 'Создано',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = time();
            }
            return true;
        }
        return false;
    }
}

