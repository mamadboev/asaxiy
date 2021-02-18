<?php


namespace app\modules\api\forms;


use yii\base\Model;

class BaseForm extends  Model
{
    /**
     * @param array $data
     * @param null $formName
     * @return bool
     */
    public function load($data, $formName = null): bool
    {
        $formName = $formName ?? '';
        return parent::load($data, $formName);
    }

}