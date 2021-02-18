<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Arizalar');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="reference-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    $colums = [
        ['class' => 'yii\grid\SerialColumn'],

        'name',
        'surname',
        'phone',
        [
            'attribute'       => 'status',
            'class'           => '\kartik\grid\EditableColumn',
            'editableOptions' => function ($model, $key, $index) {
                return [
                    'value'              => $model->status,
                    'inputType'          => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'formOptions'        => [
                        'action' => \yii\helpers\Url::to(['editstatus'])
                    ],
                    'data'               => \app\models\Application::statusList(),
                    'displayValueConfig' => [
                        \app\models\Application::STATUS_NEW          => Yii::t('app', 'Yangi'),
                        \app\models\Application::STATUS_SPECIFIED    => Yii::t('app', 'Interyu belgilangan'),
                        \app\models\Application::STATUS_ACCEPTED     => Yii::t('app', 'Qabul qilingan'),
                        \app\models\Application::STATUS_NOT_ACCEPTED => Yii::t('app', 'Qabul qilinmagan'),
                    ],
                ];
            },

            'format'        => 'html',
            'headerOptions' => ['width' => '150'],
            'filterType' => GridView::FILTER_SELECT2,
        ],
        [
            'class'           => 'kartik\grid\EditableColumn',
            'attribute'       => 'note',
            'hAlign'          => 'top',
            'vAlign'          => 'middle',
            'width'           => '100px',
            'editableOptions' => function ($model, $key, $index) {
                return [
                    'value'       => $model->note,
                    'inputType'   => \kartik\editable\Editable::INPUT_TEXTAREA,
                    'formOptions' => [
                        'action' => \yii\helpers\Url::to(['add-note'])
                    ],
                    // 'data' => \app\models\Application::statusList(),
                ];
            },
            'headerOptions'   => ['class' => 'kv-sticky-column'],
            'contentOptions'  => ['class' => 'kv-sticky-column'],
            'pageSummary'     => true,
        ],
        [
            'class'           => 'kartik\grid\EditableColumn',
            'attribute'       => 'date',
            'hAlign'          => 'top',
            'vAlign'          => 'middle',
            'width'           => '200px',
            'editableOptions' => function ($model, $key, $index) {
                return [
                    'value'       => $model->date,
                    'inputType'   => \kartik\editable\Editable::INPUT_DATETIME,
                    'formOptions' => [
                        'action' => \yii\helpers\Url::to(['add-date'])
                    ],
                    // 'data' => \app\models\Application::statusList(),
                ];
            },

            'headerOptions'   => ['class' => 'kv-sticky-column'],
            'contentOptions'  => ['class' => 'kv-sticky-column'],
            'pageSummary'     => true,
        ],
        [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons'  => [
            ],

        ],


    ]
    ?>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider'   => $dataProvider,
        'filterModel'    => $searchModel,
        'options'        => ['class' => 'grid-view', 'id' => 'grid_id_1'],
        //background rang qo'yish
        'rowOptions'     => function ($model) {
            if ($model->status === \app\models\Application::STATUS_NEW) {
                return ['style' => 'background:#fdb378'];
            } elseif ($model->status === \app\models\Application::STATUS_SPECIFIED) {
                return ['style' => 'background:#79b4f6'];
            } elseif ($model->status === \app\models\Application::STATUS_ACCEPTED) {
                return ['style' => 'background:#68EB26'];
            }
            return ['style' => 'background:#ff8785'];
        },
        //background
        'summaryOptions' => ['style' => 'text-align:right;'],
        'summary'        => Yii::t('app', 'Showing <strong>{begin}-{end}</strong> of <strong>{totalCount}</strong> items'),
        'export'         => false,
        'pjax'           => true,

        'columns' => $colums
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>