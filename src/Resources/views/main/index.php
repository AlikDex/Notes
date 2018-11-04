<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use Adx\Module\NoteModule\Widget\NoteList;

$this->title = Yii::t('note', 'notes');
$this->params['subtitle'] = Yii::t('note', 'overview');
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('https://fonts.googleapis.com/icon?family=Material+Icons');
$this->registerCssFile('https://code.getmdl.io/1.3.0/material.indigo-pink.min.css');
$this->registerJsFile('https://code.getmdl.io/1.3.0/material.min.js', ['position' => View::POS_END]);

$this->registerCssFile('https://cdn.quilljs.com/1.3.6/quill.snow.css');
$this->registerJsFile('https://cdn.quilljs.com/1.3.6/quill.min.js', ['position' => View::POS_END]);

?>

<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--3-col">
  		<?= $this->render('_left_sidebar', []) ?>
	</div>

  	<div class="mdl-cell mdl-cell--9-col">
	  	<div id="note-container" class="note-container mdl-shadow--2dp">
			<?= Html::beginForm(['ajax/save'], 'post', ['id' => 'note-form']) ?>
				<div class="mdl-textfield mdl-js-textfield">
					<input name="title" class="mdl-textfield__input" type="text" value="Untitled">
					<label class="mdl-textfield__label" for="sample1">Title...</label>
				</div>

				<div class="action-bar">
					<?= Html::button('<i class="material-icons">done</i> ' . Yii::t('note', 'save'), [
						'class' => 'mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--mini-fab mdl-button--accent',
						'form' => 'note-form',
						'data-action' => 'save',
						'data-action-url' => Url::toRoute(['ajax/save']),
						'style' => 'margin-right: 10px',
					]) ?>

					<?= Html::button('<i class="material-icons">edit</i> ' . Yii::t('note', 'edit'), [
						'class' => 'mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect',
						'data-action' => 'edit',
					]) ?>
				</div>

				<div id="editor-container" class="editor-container">
					<div id="quill" class="note-text ql-editor"></div>
				</div>

				<?= Html::hiddenInput('id', 0) ?>
				<?php /*Html::hiddenInput('content', '')*/ ?>
			<?= Html::endForm() ?>
		</div>
  	</div>
</div>

<?php

$css = <<< 'CSS'
	.inactive .ql-toolbar {
		display:none;
	}
	.inactive .ql-container.ql-snow {
		border:none;
	}
	.action-bar {
    	display: flex;
    	justify-content: flex-end;
    	margin-bottom: 10px;
	}
	label {
		margin-bottom: 0;
	}

	.note-list-container {
		background: white;
	}
	.note-container {
		background: #fff;
		padding: 10px;
	}

	.menu-bar {
		box-sizing: border-box;
		position: relative;
		background: #3F51B5;
		color: white;
		height: 64px;
		width: 100%;
		padding: 16px;
	}
	.menu-bar__wrapper {
		box-sizing: border-box;
		position: absolute;
		right: 16px;
	}

	.mdl-menu__item .material-icons {
		vertical-align: -25%;
		margin-right: 5px;
	}
	.material-icons.md-20 {
		font-size: 20px;
	}

	.inactive button[data-action="save"] {
		display: none;
	}
	.note-container [data-action="edit"] {
		display: none;
	}
	.note-container.inactive [data-action="edit"] {
		display: inline-block;
	}
CSS;

$script = <<< 'JAVASCRIPT'
	var noteContainer = document.querySelector('#note-container');
	var noteForm = noteContainer.querySelector('#note-form');

	var quill = new Quill('#quill', {
		modules: {
			toolbar: [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                [{ 'direction': 'rtl' }],                         // text direction

                [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                [{ 'font': [] }],
                [{ 'align': [] }],
                ['link', 'blockquote', 'code-block', 'image'],
			]
		},
        strict: true,
		placeholder: 'Write your note',
		theme: 'snow'
	});

	var saveButton = noteContainer.querySelector('.action-bar [data-action="save"]');

	saveButton.addEventListener('click', function (event) {
		event.preventDefault();
		event.stopPropagation();

		let actionUrl = this.getAttribute('data-action-url');
		let formData = new FormData(noteForm);

		formData.append('note', JSON.stringify(quill.getContents()));

		fetch(actionUrl, {
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

			noteForm.title.value = data.note.title;
			noteForm.id.value = data.note.note_id;

            noteForm.title.disabled = true;
            quill.disable();
            noteContainer.classList.add('inactive');

            toastr.success(data.message);
        }).catch(function(error) {
            toastr.error(error.message);
        });
	});

	var editButton = noteContainer.querySelector('.action-bar [data-action="edit"]');

	editButton.addEventListener('click', function (event) {
		event.preventDefault();
		event.stopPropagation();

		noteForm.title.disabled = false;
		quill.enable();
        noteContainer.classList.remove('inactive');
	});
JAVASCRIPT;

$this->registerCss($css);
$this->registerJS($script);
