<?php

/**
 * @var \yii\web\View
 * @var \hipanel\modules\mailing\renderers\RedirectFormRenderer $renderer
 */

?>

<h1 class="text-center">
    <i class="fa fa-refresh fa-spin"></i>
    <?= Yii::t('hipanel:mailing', 'We are redirecting you to the mailing service, please wait a bit') ?>
</h1>

<?= $renderer->render() ?>
