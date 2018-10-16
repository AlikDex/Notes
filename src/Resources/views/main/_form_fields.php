<?php

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\HtmlPurifier;

?>

<?php $activeForm = ActiveForm::begin([
    'id' => 'note-form',
]) ?>

    <?= $activeForm->field($form, 'title')->textInput(['maxlength' => true])
        ->hint('Просто название')
    ?>


    <div class="form-group field-note">
        <label class="control-label" for="note">Note</label>
        <?= Html::activeHiddenInput($form, 'note', ['label' => false]) ?>

        <div id="editor">
            <?= HtmlPurifier::process($form->note, [
                'Attr.AllowedFrameTargets' => ['_blank', '_self', '_parent', '_top'],
            ]) ?>
        </div>

        <div class="hint-block">Текст или что-то еще</div>
    </div>

<?php ActiveForm::end() ?>

<?php

$js = <<< 'Js'
	Quill.prototype.getHtml = function() {
		return this.container.firstChild.innerHTML;
	};

    var quill = new Quill('#editor', {
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
		placeholder: 'Write your note',
		theme: 'snow'
	});

	var noteForm = document.querySelector('#note-form');
	noteForm.onsubmit = function(event) {
		event.preventDefault();
		event.stopPropagation();

		// Populate hidden form on submit
		var note = noteForm.querySelector('input[name=note]');
		note.value = quill.getHtml();
		this.submit();
	};
Js;

$this->registerCssFile('//cdn.quilljs.com/1.3.6/quill.snow.css');
$this->registerJsFile('//cdn.quilljs.com/1.3.6/quill.min.js', ['position' => View::POS_END]);
$this->registerJs($js, View::POS_END);
