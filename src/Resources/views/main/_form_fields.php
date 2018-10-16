<?php

use yii\helpers\Html;

?>

<?= $activeForm->field($form, 'title')->textInput(['maxlength' => true])
    ->hint('Просто название')
?>

<?= $activeForm->field($form, 'note')->textarea(['rows' => 10])
    ->hint('Текст или что-то еще')
?>
