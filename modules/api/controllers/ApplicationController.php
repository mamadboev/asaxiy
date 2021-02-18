<?php


namespace app\modules\api\controllers;


use app\modules\api\resourse\Application;
use app\modules\api\forms\ApplicationForm;
use Yii;
use yii\filters\VerbFilter;

class ApplicationController extends DefaultController
{
    public $modelClass = Application::class;

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        $parent = parent::behaviors();
        $parent['verbs'] = [
            'class'   => VerbFilter::class,
            'actions' => [
                'create-application' => ['POST'],
                'create-note'        => ['POST'],
                'get-user'           => ['GET'],
                'update-application' => ['GET', 'POST'],
                'delete'             => ['GET'],
            ],
        ];
        return $parent;
    }

    /**
     * @return array
     * @throws \app\exceptions\ResponseException
     */
    public function actionCreateApplication(): array
    {
        $model = new Application();

        $params = Yii::$app->request->post();

        return $this->output((new ApplicationForm())->create($model, $params));
    }

    /**
     * @return array
     * @throws \app\exceptions\ResponseException
     */

    public function actionCreateNote()
    {
        $params = Yii::$app->request->bodyParams;
        return $this->output((new ApplicationForm())->note($params));
    }

    /**
     * @return array
     * @throws \app\exceptions\ResponseException
     */
    public function actionGetUser()
    {
        $id = Yii::$app->request->get('id');
        return $this->output((new ApplicationForm())->findModel($id));
    }

    /**
     * @return array
     * @throws \app\exceptions\ResponseException
     */
    public function actionUpdateApplication()
    {
        $id = Yii::$app->request->get('id');
        $params = Yii::$app->request->post();
        return $this->output((new ApplicationForm())->update($id, $params));
    }

    /**
     * @return array
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        return $this->output((new ApplicationForm())->delete($id));

    }

}