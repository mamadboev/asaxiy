<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Application */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="application-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'name',
            'surname',
            'address',
            'country',
            'email:email',
            'phone',
            'age',
            'hired',
            'status',
            'date',
            'note:ntext',
//            'admin_id',
//            'created_at',
//            'updated_at',
        ],
    ]) ?>

</div>
