<?php

use hipanel\widgets\IndexPage;
use yii\helpers\Html;

/**
 * @var \yii\web\View
 * @var \yii\data\ArrayDataProvider $dataProvider
 * @var \hipanel\modules\mailing\forms\FiltersForm $model
 * @var array $serverTypes
 * @var array $serverStates
 * @var array $domainStates
 * @var array $languages
 * @var bool $isMailingServiceAvailable
 */
$this->title = Yii::t('hipanel:mailing', 'Mailing preparation');
$this->params['breadcrumbs'][] = $this->title;

$activeFilters = array_filter($model->getAttributes());
?>

<?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>
<?php $page->setSearchFormData(compact(['clientTypes', 'languages', 'serverTypes', 'serverStates', 'domainStates'])) ?>

<?php $page->beginContent('show-actions') ?>
    <?php if (!empty($activeFilters)) : ?>
        <?= $isMailingServiceAvailable ? Html::a(
            Yii::t('hipanel:mailing', 'Begin mailing'),
            ['redirect-to-mailing'] + $activeFilters,
            ['class' => 'btn btn-sm btn-success', 'target' => '_blank']
        ) : '' ?>
        <?= Html::a(
            Yii::t('hipanel:mailing', 'Export mailing list'),
            ['export'] + $activeFilters,
            ['class' => 'btn btn-sm btn-info']
        ) ?>

    <?php endif ?>
<?php $page->endContent() ?>

<?php $page->beginContent('table') ?>
    <?php $page->beginBulkForm() ?>
        <?php $dataProvider->pagination = false ?>
        <?= \hipanel\modules\mailing\grid\TargetsGridView::widget([
            'boxed' => false,
            'dataProvider' => $dataProvider,
            'filterModel' => $model,
            'emptyText' => empty($activeFilters)
                ? Yii::t('hipanel:mailing', 'Set filters to start the mailing preparation')
                : null,
            'possibleColumns' => [
                'seller',
                'client',
                'to',
                'language',
                'servers',
                'server_states',
                'domains',
            ],
        ]) ?>
    <?php $page->endBulkForm() ?>
<?php $page->endContent() ?>

<?php $page->end() ?>
