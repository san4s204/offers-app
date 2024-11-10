<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "offers".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string $created_at
 */
class Offers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
{
    return [
        [['name', 'email'], 'required'],
        ['email', 'trim'],
        ['email', 'filter', 'filter' => 'strtolower'],
        ['email', 'email'],
        [['created_at'], 'safe'],
        [['name'], 'string', 'max' => 255],
        [['phone'], 'string', 'max' => 20],
        [
            ['email'],
            'unique',
            'targetClass' => self::class,
            'targetAttribute' => 'email',
            'message' => 'Этот email уже используется.',
        ],
    ];
}
    


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'created_at' => 'Created At',
        ];
    }

    public function beforeSave($insert)
{
    if ($insert) {
        // Устанавливаем текущую дату и время при создании нового оффера
        $this->created_at = date('Y-m-d H:i:s');
    }

    return parent::beforeSave($insert);
}

public function beforeValidate()
{
    if (!parent::beforeValidate()) {
        return false;
    }
    $this->email = strtolower(trim($this->email));
    return true;
}
}
