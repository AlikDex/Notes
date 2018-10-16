<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::t('note', 'notes');
$this->params['subtitle'] = Yii::t('note', 'edit');

$this->params['breadcrumbs'][] = ['label' => Yii::t('note', 'notes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('note', 'edit');

?>

<div class="row">

	<div class="col-md-3">
		<?= $this->render('_left_sidebar', [
			'active_id' => $note->getId(),
		]) ?>
	</div>

	<div class="col-md-9">

		<div class="box box-primary">
			<div class="box-header with-border">
				<i class="fa fa-edit"></i><h3 class="box-title">Редактирование: <?= $note->title ?></h3>
				<div class="box-tools pull-right">
					<div class="btn-group">
						<?= Html::a('<i class="fa fa-fw fa-plus text-green"></i>' . Yii::t('note', 'add'), ['create'], ['class' => 'btn btn-default btn-sm', 'title' => 'new']) ?>
						<?= Html::a('<i class="fa fa-fw fa-eye text-blue"></i>' . Yii::t('note', 'view'), ['view', 'id' => $note->getId()], ['class' => 'btn btn-default btn-sm', 'title' => 'Просмотр']) ?>
						<?= Html::a('<i class="fa fa-fw fa-info-circle text-blue"></i>' . Yii::t('note', 'info'), ['info', 'id' => $note->getId()], ['class' => 'btn btn-default btn-sm', 'title' => 'Информация']) ?>
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
				<?= $this->render('_form_fields', [
					'form' => $form,
				]) ?>
			</div>

			<div class="box-footer clearfix">
			    <div class="form-group">
					<?= Html::submitButton('<i class="fa fa-fw fa-check text-green"></i>' . Yii::t('note', 'save'), ['class' => 'btn btn-default', 'form' => 'note-form']) ?>
				</div>
			</div>

		</div>

	</div>
</div>
