<?php

namespace app\controllers;

use app\models\Application;
use app\models\ApplicationSearch;
use kartik\grid\EditableColumnAction;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'create', 'view', 'delete', 'update'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'delete', 'update'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $searchModel = new ApplicationSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('login');
    }

    /**
     * Lists all Application models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Application model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Application model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Application();
        $model->scenario = Application::SCENARIO_INSERT;
        //VarDumper::dump(Yii::$app->request->post(),10,true); die();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            echo Yii::$app->session->addFlash('success', " Sizning arizangiz qabul qilindi. Adminlar bog'lanishini kuting");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Application model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Application model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Application model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Application the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Application::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * @return mixed
     */

    public function actionEditstatus()
    {
        if (Yii::$app->request->post('hasEditable')) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $response['result'] = [];
            $modelId = Yii::$app->request->post('editableKey');
            $value = current(Yii::$app->request->post('status'));
            $model = Application::findOne($modelId);
            $response['value'] = $value['status'];
            if ($model) {
                $model->status = $response['value'];
                if ($model->save(false)) {
                    $response['result'] = $model;
                } else {
                    $response['result'] = 'Saqlnamadi';
                }
            }
            $response['model'] = $model;
            return $response;
        }
    }

    /**
     * @return mixed
     */

    public function actionAddNote()
    {
        if (Yii::$app->request->post('hasEditable')) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $response['result'] = [];
            $modelId = Yii::$app->request->post('editableKey');
            $value = current(Yii::$app->request->post('note'));

            $model = Application::findOne($modelId);
            $response['value'] = $value['note'];
            if ($model) {
                $model->note = $response['value'];
                if ($model->save(false)) {
                    $response['result'] = $model;
                } else {
                    $response['result'] = 'Saqlanmadi';
                }
            }
            $response['model'] = $model;
            return $response;
        }
    }

    /**
     * @return mixed
     */

    public function actionAddDate()
    {
        if (Yii::$app->request->post('hasEditable')) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $response['result'] = [];
            $modelId = Yii::$app->request->post('editableKey');
            $value = current(Yii::$app->request->post('date'));

            $model = Application::findOne($modelId);
            $response['value'] = $value['date'];
            if ($model) {
                $model->date = $response['value'];
                $model->admin_id = Yii::$app->user->identity->id;
                if ($model->save(false)) {
                    $response['result'] = $model;
                } else {
                    $response['result'] = 'Saqlanmadi';
                }
            }
            $response['model'] = $model;
            return $response;
        }
    }

    /**
     * @return array
     */
    public function actions()
    {

        return yii\helpers\ArrayHelper::merge(parent::actions(), [
            'editstatus' => [
                'class'         => EditableColumnAction::class,
                'modelClass'    => Application::class,
                'outputValue'   => function ($model, $attribute, $key, $index) {
                    return $model->$attribute;
                },
                'outputMessage' => function ($model, $attribute, $key, $index) {
                    return '';
                },
            ],
            'add-note'   => [
                'class'         => EditableColumnAction::class,
                'modelClass'    => Application::class,
                'outputValue'   => function ($model, $attribute, $key, $index) {
                    return $model->$attribute;
                },
                'outputMessage' => function ($model, $attribute, $key, $index) {
                    return '';
                },
            ],
            'add-date'   => [
                'class'         => EditableColumnAction::class,
                'modelClass'    => Application::class,
                'outputValue'   => function ($model, $attribute, $key, $index) {
                    return $model->$attribute;
                },
                'outputMessage' => function ($model, $attribute, $key, $index) {
                    return '';
                },
            ]

        ]);
    }

}
