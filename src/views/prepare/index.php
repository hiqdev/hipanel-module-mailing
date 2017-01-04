<?php

use hipanel\widgets\IndexPage;
use yii\helpers\Html;

/**
 * @var \yii\data\ArrayDataProvider
 * @var \hipanel\modules\mailing\forms\FiltersForm $model
 * @var array $types
 * @var array $states
 * @var array $statuses
 */
$this->title = Yii::t('hipanel:mailing', 'Mailing preparation');
$this->params['breadcrumbs'][] = $this->title;

$activeFilters = array_filter($model->getAttributes());
?>

<?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>
<?= $page->setSearchFormData(compact(['types', 'states', 'statuses'])) ?>

<?php $page->beginContent('show-actions') ?>
    <?= $page->renderLayoutSwitcher() ?>
    <?= !empty($activeFilters) ? Html::a(
        Yii::t('hipanel:mailing', 'Export mailing list'),
        ['export'] + $activeFilters,
        ['class' => 'btn btn-sm btn-success']
    ) : '' ?>
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
                'domains',
            ],
        ]) ?>
    <?php $page->endBulkForm() ?>
<?php $page->endContent() ?>

<?php $page->end() ?>
