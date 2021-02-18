<?php


namespace app\modules\api\forms;


use app\exceptions\ResponseException;
use app\modules\api\resourse\Application;
use Yii;
use yii\db\Exception;

class ApplicationForm extends BaseForm
{
    public $name;
    public $surname;
    public $address;
    public $country;
    public $email;
    public $phone;
    public $age;
    public $hired;
    public $status;
    public $date;
    public $note;

    public const SCENARIO_CREATE = 'create';
    public const SCENARIO_CREATE_NOTE = 'create note';

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'address', 'country', 'phone', 'note'], 'string'],
            [['date'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['name', 'surname'], 'string', 'length' => [5, 255]],
            ['address', 'string', 'length' => [10, 255]],
            [['phone'], 'string', 'max' => 13],
            ['email', 'email'],
            ['age', 'integer'],
            [['name', 'surname', 'address', 'country', 'email', 'phone', 'age'], 'required', 'on' => self::SCENARIO_CREATE],
            [['id', 'date', 'note'], 'required', 'on' => self::SCENARIO_CREATE_NOTE]
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_CREATE      => ['name', 'surname', 'address', 'country', 'email', 'phone', 'age'],
            self::SCENARIO_CREATE_NOTE => ['id', 'date', 'note'],
        ]);
    }

    /**
     * @param Application $model
     * @param $params
     * @return Application|array
     * @throws ResponseException
     */
    public function create(Application $model, $params)
    {
        if ($this->load($params) && $this->validate()) {
            try {
                $this->scenario = self::SCENARIO_CREATE;
                $model->setAttributes($this->attributes);
                if (!$model->validate()) {
                    throw new ResponseException(array_values($model->firstErrors)[0] ?? 'unknown error');
                }
                if (!$model->save()) {
                    throw new ResponseException(array_values($model->firstErrors)[0] ?? 'unknown error');
                } else {
                    return $model;
                }
            } catch (Exception $e) {
                Yii::error($e, __METHOD__);

                return [

                    'message' => $e->getMessage(),
                ];
            }


        } else {
            throw new ResponseException(array_values($this->firstErrors)[0] ?? 'unknown error');
        }
    }

    /**
     * @param $params
     * @return Application|array|null
     * @throws ResponseException
     */

    public function note($params)
    {
        $id = $params['id'];
        $model = $this->findModel($id);
        if ($this->load($params) && $this->validate()) {
            try {
                $this->scenario = self::SCENARIO_CREATE_NOTE;
                $model->load($params, '');
                if (!$model->validate()) {
                    throw new ResponseException(array_values($model->firstErrors)[0] ?? 'unknown error');
                }
                if (!$model->save()) {
                    throw new ResponseException(array_values($model->firstErrors)[0] ?? 'unknown error');
                } else {
                    return $model;
                }

            } catch (Exception $e) {
                Yii::error($e, __METHOD__);

                return [
                    'message' => $e->getMessage(),
                ];
            }


        } else {
            throw new ResponseException(array_values($this->firstErrors)[0] ?? 'unknown error');
        }

    }

    /**
     * @param $id
     * @return Application|null
     * @throws ResponseException
     */
    public function findModel($id)
    {
        if (($model = Application::findOne($id)) === null) {
            throw new ResponseException(Yii::t('app', "Application doesnt have with id : {$id}"));
        }
        return $model;
    }

    /**
     * @param $id
     * @param $params
     * @return Application|array|null
     * @throws ResponseException
     */

    public function update($id, $params)
    {
        $model = $this->findModel($id);
        if ($this->load($params) && $this->validate()) {
            try {
                $model->load($params, '');
                if (!$model->validate()) {
                    throw new ResponseException(array_values($model->firstErrors)[0] ?? 'unknown error');
                }
                if (!$model->save()) {
                    throw new ResponseException(array_values($model->firstErrors)[0] ?? 'unknown error');
                } else {
                    return $model;
                }

            } catch (Exception $e) {
                Yii::error($e, __METHOD__);

                return [
                    'message' => $e->getMessage(),
                ];
            }


        } else {
            throw new ResponseException(array_values($this->firstErrors)[0] ?? 'unknown error');
        }
    }

    /**
     * @param $id
     * @return array
     * @throws ResponseException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */

    public function delete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            return [
                'message' => "Application is deleted"
            ];
        } else {
            return [
                'message' => "Application doesn't delete"
            ];
        }
    }

}