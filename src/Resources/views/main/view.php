<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = Yii::t('note', 'notes');
$this->params['subtitle'] = Yii::t('note', 'view');

$this->params['breadcrumbs'][] = ['label' => Yii::t('note', 'notes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('note', 'view');

$this->registerCssFile('//cdn.quilljs.com/1.3.6/quill.snow.css');

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
				<i class="fa fa-eye"></i><h3 id="box-title" class="box-title">Просмотр: <?= $note->title ?></h3>
				<div class="box-tools pull-right">
					<div class="btn-group">
						<?= Html::a('<i class="fa fa-fw fa-plus text-green"></i>' . Yii::t('note', 'add'), ['create'], ['class' => 'btn btn-default btn-sm', 'title' => 'new']) ?>
					</div>
				</div>
            </div>

            <div class="box-body pad">
				<div id="note-text" class="note-text ql-editor">
					<?= HtmlPurifier::process($note->note, [
						'Attr.AllowedFrameTargets' => ['_blank', '_self', '_parent', '_top'],
					]) ?>
				</div>
			</div>

		</div>

	</div>
</div>
