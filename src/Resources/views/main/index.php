<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use Adx\Module\NoteModule\Widget\NoteList;

$this->title = Yii::t('note', 'notes');
$this->params['subtitle'] = Yii::t('note', 'overview');
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('//cdn.quilljs.com/1.3.6/quill.snow.css');

?>

<div class="row">
	<div class="col-md-3">
		<?= $this->render('_left_sidebar', []) ?>
	</div>

	<div class="col-md-9">
		<div class="box box-default">
			<div class="box-header with-border">
				<i class="fa fa-edit"></i><h3 id="box-title" class="box-title"></h3>
				<div class="box-tools pull-right">
					<div class="btn-group">
						<?= Html::a('<i class="fa fa-plus text-green"></i>' . Yii::t('note', 'add'), ['create'], ['class' => 'btn btn-default btn-sm']) ?>
					</div>
				</div>
			</div>

			<div class="box-body pad">
				<div id="note-text" class="note-text ql-editor"></div>
			</div>
		</div>
	</div>
</div>
