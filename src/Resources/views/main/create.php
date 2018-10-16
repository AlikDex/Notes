<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::t('note', 'notes');
$this->params['subtitle'] = Yii::t('note', 'new');

$this->params['breadcrumbs'][] = Yii::t('note', 'new');

// "jquery sort elements" поиск в гугле, для сортировки элементов при помощи жс.
// Также в импорте категорий нужно сохранять выбранные элементы при помощи локал стораджа

?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_left_sidebar', [
            'active_id' => 0,
        ]) ?>
    </div>

    <div class="col-md-9">
        <div class="box box-success">
            <div class="box-header with-border">
                <i class="fa fa-file-o"></i><h3 class="box-title">Новая записка</h3>
            </div>

            <div class="box-body pad">

	        <div class="box-body pad">
				<?= $this->render('_form_fields', [
					'form' => $form,
				]) ?>
			</div>

            </div>

            <div class="box-footer clearfix">
			    <div class="form-group">
					<?= Html::submitButton('<i class="fa fa-fw fa-plus text-green"></i>' . Yii::t('note', 'create'), ['class' => 'btn btn-default', 'form' => 'note-form']) ?>
				</div>
			</div>

        </div>

    </div>
</div>
