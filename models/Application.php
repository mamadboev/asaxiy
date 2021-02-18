<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $address
 * @property string|null $country
 * @property string|null $email
 * @property string|null $phone
 * @property int|null $age
 * @property int|null $hired
 * @property int|null $status
 * @property string|null $date
 * @property string|null $note
 * @property int|null $admin_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $admin
 */
class Application extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;        // 'Yangi'
    const STATUS_SPECIFIED = 2; // 'Interyu belgilangan'
    const STATUS_ACCEPTED = 3;   // 'Qabul qilingan',
    const STATUS_NOT_ACCEPTED = 4;// 'Qabul qilinmagan'
    const SCENARIO_INSERT = 'insert';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class'      => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value'      => date('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'address', 'country', 'email', 'phone', 'age'], 'required'],
            [['name', 'surname'], 'string', 'length' => [5, 255]],
            ['address', 'string', 'length' => [10, 255]],
            ['email', 'email'],
            [['age', 'status', 'hired', 'admin_id'], 'integer'],
            ['status', 'in', 'range' => self::statusList(), 'on' => self::SCENARIO_INSERT],
            [['created_at', 'updated_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['note',], 'string'],
            [['phone'], 'string', 'max' => 20],
            [
                ['phone'],
                'match',
                'pattern' => '/^\((9[1|3|4|5|7|8|9|0])|(33)|(88)\)\-\d{3}\-\d{2}\-\d{2}$/',
                'on'      => self::SCENARIO_INSERT
            ],
            [['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['admin_id' => 'id']],
        ];
    }


    public function beforeSave($insert)
    {
        if ($this->scenario === self::SCENARIO_INSERT) {
            return $this->phone = '+998' . str_replace(array('(', '-', ')'), '', $this->phone);
        }
        return $this->phone;


    }

    /**
     * @param bool $key
     *
     * @return array
     */
    public static function statusList($key = false)
    {
        $list = [
            self::STATUS_NEW          => Yii::t('app', 'Yangi'),
            self::STATUS_SPECIFIED    => Yii::t('app', 'Interyu belgilangan'),
            self::STATUS_ACCEPTED     => Yii::t('app', 'Qabul qilingan'),
            self::STATUS_NOT_ACCEPTED => Yii::t('app', 'Qabul qilinmagan')
        ];

        return $key ? array_keys($list) : $list;
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::statusList(), $this->status);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'name'       => 'Name',
            'surname'    => 'Surname',
            'address'    => 'Address',
            'country'    => 'Country',
            'email'      => 'Email',
            'phone'      => 'Phone',
            'age'        => 'Age',
            'hired'      => 'Hired',
            'status'     => 'Status',
            'date'       => 'Date',
            'note'       => 'Note',
            'admin_id'   => 'Admin ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Admin]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(User::className(), ['id' => 'admin_id']);
    }
}
