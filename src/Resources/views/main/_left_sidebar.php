<?php

use yii\helpers\Url;
use yii\helpers\Html;
use Adx\Module\NoteModule\Widget\NoteList;

?>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-list"></i><h3 class="box-title"><?= Yii::t('note', 'overview') ?></h3>
        <div class="box-tools pull-right">
            <div class="btn-group">
            </div>
        </div>
    </div>

    <div class="box-body pad">
        <?= NoteList::widget() ?>
    </div>

    <div class="box-footer clearfix">
        <?= Html::submitButton('<span class="fa fa-fw fa-sort-amount-asc"></span> Сохранить порядок сортировки',
            [
                'id' => 'save-order',
                'class' => 'btn btn-default',
                'data-url' => Url::toRoute(['main/save-order'])
            ]
        ) ?>
    </div>
</div>

<?php

$script = <<< 'JAVASCRIPT'
    $("#note-list").sortable({
        placeholder: 'note-list__placeholder',
        cursor: 'move',
        start: function(e, ui) {
            ui.placeholder.width(ui.helper.width());
            ui.placeholder.height(ui.helper.height());
        },
    });

    var saveOrderButton = document.querySelector('#save-order');
    var noteList = document.querySelector('#note-list');

    saveOrderButton.addEventListener('click', function (event) {
        event.preventDefault();

        let sendUrl = saveOrderButton.getAttribute('data-url');
        let noteItems = noteList.querySelectorAll('[data-key]');
        let formData = new FormData();

        if (!noteItems.length) {
            return;
        }

        for (let i = 0; i < noteItems.length; i++) {
            let note = noteItems[i];
            let id = parseInt(note.getAttribute('data-key'), 10);

            if (NaN === id) {
                continue;
            }

            formData.append('order[]', id);
        }

        fetch(sendUrl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        }).then((response) => {
            if (!response.ok) {
                throw new Error(response.statusText);
            }

            return response;
        })
        .then(response => response.json())
        .then((data) => {
            if (data.error !== undefined) {
                throw new Error(data.error.message);
            }

            toastr.success(data.message);
        }).catch(function(error) {
            toastr.error(error.message);
        });
    });
JAVASCRIPT;

$this->registerJS($script);
