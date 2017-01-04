<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\client\widgets\combo\SellerCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hiqdev\combo\StaticCombo;

/**
 * @var \hipanel\widgets\AdvancedSearch
 * @var array $serverStates
 * @var array $serverTypes
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('seller_in')->widget(SellerCombo::class, [
        'multiple' => true,
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('client_in')->widget(ClientCombo::class, [
        'multiple' => true,
    ]) ?>
</div>

<?php if (Yii::getAlias('@server', false) !== false) : ?>
    <div class="col-md-4 col-sm-6 col-xs-12 text-center">
        <hr>
        <?= Yii::t('hipanel:mailing', 'Server') ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('has_server')->checkbox() ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('server_in')->widget(ServerCombo::class, [
            'multiple' => true,
        ]) ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('server_state_in')->widget(StaticCombo::class, [
            'multiple' => true,
            'data' => $serverStates,
        ]) ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('server_type_in')->widget(StaticCombo::class, [
            'multiple' => true,
            'data' => $serverTypes,
        ]) ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('server_switch_like') ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('server_rack_like') ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('server_pdu_like') ?>
    </div>
<?php endif ?>

<?php if (Yii::getAlias('@domain', false) !== false) : ?>
    <div class="col-md-4 col-sm-6 col-xs-12 text-center">
        <hr>
        <?= Yii::t('hipanel:mailing', 'Domain') ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('has_domain')->checkbox() ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('domain_like') ?>
    </div>
<?php endif ?>
