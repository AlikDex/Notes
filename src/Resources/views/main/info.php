<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\StringHelper;

$this->title = Yii::t('note', 'notes');
$this->params['subtitle'] = Yii::t('note', 'info');

$this->params['breadcrumbs'][] = ['label' => Yii::t('note', 'notes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('project', 'info');

?>

<div class="row">

	<div class="col-md-3">
		<?= $this->render('_left_sidebar', [
			'active_id' => $note->getId(),
		]) ?>
	</div>

	<div class="col-md-9">
		<div class="box box-info">
			<div class="box-header with-border">
				<i class="fa fa-info-circle"></i><h3 class="box-title">Просмотр: <?= $note->title ?></h3>
				<div class="box-tools pull-right">
					<div class="btn-group">
						<?= Html::a('<i class="fa fa-fw fa-plus text-green"></i>' . Yii::t('note', 'add'), ['create'], ['class' => 'btn btn-default btn-sm', 'title' => 'new']) ?>
						<?= Html::a('<i class="fa fa-fw fa-edit text-blue"></i>' . Yii::t('note', 'edit'), ['update', 'id' => $note->getId()], ['class' => 'btn btn-default btn-sm', 'title' => 'edit']) ?>
                        <?= Html::a('<i class="fa fa-fw fa-eye text-blue"></i>' . Yii::t('note', 'view'), ['view', 'id' => $note->getId()], ['class' => 'btn btn-default btn-sm', 'title' => 'Просмотр']) ?>
                        <?= Html::a('<i class="fa fa-fw fa-trash-o text-red"></i>' . Yii::t('note', 'delete'), ['delete', 'id' => $note->getId()], [
				            'class' => 'btn btn-default btn-sm',
				            'title' => Yii::t('note', 'Delete note'),
				            'data' => [
				                'confirm' => Yii::t('note', 'Are you sure?'),
				                'method' => 'post',
				            ],
				        ]) ?>
					</div>
				</div>
            </div>

            <div class="box-body pad">
			    <?= DetailView::widget([
			        'model' => $note,
			        'attributes' => [
			            'note_id',
                        'title',
			            [
							'attribute' => 'note',
							'format' => 'text',
							'value' => function ($note) {
								return StringHelper::truncate($note->note, 500);
							},
						],
			            'updated_at:datetime',
			            'created_at:datetime',
					],
			    ]) ?>

			</div>

		</div>

	</div>
</div>