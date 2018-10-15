<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;

$this->title = Yii::t('note', 'notes');
$this->params['subtitle'] = Yii::t('note', 'overview');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box box-default">
	<div class="box-header with-border">
		<i class="fa fa-list"></i><h3 class="box-title"><?= $this->title ?> <small><?= $this->params['subtitle'] ?></small></h3>
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
