<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use Adx\Module\NoteModule\Widget\NoteList;

$this->title = Yii::t('note', 'notes');
$this->params['subtitle'] = Yii::t('note', 'overview');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
	<div class="col-md-3">
		<div class="box box-default">
			<div class="box-header with-border">
				<i class="fa fa-list"></i><h3 class="box-title"><?= Yii::t('note', 'notes') ?> <small><?= $this->params['subtitle'] ?></small></h3>
				<div class="box-tools pull-right">
					<div class="btn-group">
					</div>
				</div>
			</div>

			<div class="box-body pad">
				<?= NoteList::widget() ?>
			</div>
		</div>
	</div>

	<div class="col-md-9">
		<div class="box box-default">
			<div class="box-header with-border">
				<i class="fa fa-edit"></i><h3 class="box-title">Что-то есть</h3>
				<div class="box-tools pull-right">
					<div class="btn-group">
						<?= Html::a('<i class="fa fa-plus text-green"></i>' . Yii::t('note', 'add'), ['create'], ['class' => 'btn btn-default btn-sm']) ?>
					</div>
				</div>
			</div>

			<div class="box-body pad">
				Hi dere!
			</div>
		</div>
	</div>
</div>
