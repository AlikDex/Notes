<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use Adx\Module\NoteModule\Widget\NoteList;

$this->registerCssFile('//cdn.quilljs.com/1.3.6/quill.snow.css');
$this->registerJsFile('//cdn.quilljs.com/1.3.6/quill.min.js', ['position' => View::POS_END]);

?>

<div class="note-list-container mdl-shadow--2dp">
    <div>
        <?= NoteList::widget() ?>
    </div>

    <div class="menu-bar">
        <div class="menu-bar__wrapper">
            <button id="note-list-menu" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">more_vert</i></button>

            <ul id="note-list-actions" class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect"
                data-mdl-for="note-list-menu">
                <li class="mdl-menu__item"
                    data-action="save-order"
                    data-action-url="<?= Url::toRoute(['ajax/save-order']) ?>">
                        <i class="material-icons">sort</i> Сохранить сортировку
                </li>
            </ul>
        </div>
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

    var saveOrderButton = document.querySelector('#note-list-actions [data-action="save-order"]');
    var noteList = document.querySelector('#note-list');

    saveOrderButton.addEventListener('click', function (event) {
        event.preventDefault();

        let sendUrl = saveOrderButton.getAttribute('data-action-url');
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

    let noteListRows = noteList.querySelectorAll('.note-list__row');

    noteListRows.forEach(function (noteListRow) {
        let nodeListRowLink = noteListRow.querySelector('.note-row__link[data-action="note-view"]');

        nodeListRowLink.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            let noteDataUrl = this.getAttribute('href');

            fetch(noteDataUrl, {
                method: 'GET',
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

                // Установим местку "активный"
                let parentLi = this.closest('.note-row');
                if (null !== parentLi) {
                    noteListRows.forEach(function (element) {
                        element.classList.remove('active');
                    });

                    parentLi.classList.add('active');
                }

                noteForm.title.value = data.note.title;
                noteForm.title.disabled = true;
                noteForm.id.value = data.note.note_id;
                quill.setContents(JSON.parse(data.note.note));
                quill.disable();
                noteContainer.classList.add('inactive');
            }).catch(function(error) {
                toastr.error(error.message);
            });
        });
    });

JAVASCRIPT;

$this->registerJS($script);
