<?php

namespace app\modules\api\controllers;

use phpDocumentor\Reflection\Utils;
use yii\base\BaseObject;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

/**
 * Default controller for the `api` module
 */
class DefaultController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        $parent = parent::behaviors();

        $parent['auth'] = [
            'class'       => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
            ],
        ];

        return $parent;
    }

    public function output($data, bool $success = true, string $error_msg = '', int $error_code = 401): array
    {
        if ($success === false) {
            \Yii::$app->response->statusCode = $error_code;

            return [
                'code'    => $error_code,
                'message' => $error_msg,
            ];
        }

        return [
            $data,
        ];

    }

}
