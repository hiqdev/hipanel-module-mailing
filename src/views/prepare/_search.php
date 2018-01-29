<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\client\widgets\combo\SellerCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hiqdev\combo\StaticCombo;

/**
 * @var \yii\web\View
 * @var \hipanel\widgets\AdvancedSearch $search
 * @var array $serverStates
 * @var array $serverTypes
 * @var array $domainStates
 * @var array $languages
 * @var array $mailingTypes
 */
?>


<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('seller_in')->widget(SellerCombo::class, [
        'multiple' => true,
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('include_subclients')->checkbox() ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('client_type_in')->widget(StaticCombo::class, [
        'hasId' => true,
        'data' => $clientTypes,
        'multiple' => true,
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('mailing_type')->widget(StaticCombo::class, [
        'hasId' => true,
        'data' => $mailingTypes,
        'multiple' => false,
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('client_in')->textarea([
        'placeholder' => Yii::t('hipanel:mailing', 'Client logins list (comma-, or space-separated)')
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('language_in')->widget(StaticCombo::class, [
        'hasId' => true,
        'data' => ['-' => Yii::t('hipanel:mailing', 'Not set')] + $languages,
        'multiple' => true,
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('exclude_unsubscribed')->checkbox() ?>
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
        <?= $search->field('server_like')->textInput([
            'placeholder' => $search->model->getAttributeLabel('server_like')
        ]) ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('server_state_in')->widget(StaticCombo::class, [
            'multiple' => true,
            'hasId' => true,
            'data' => $serverStates,
        ]) ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('server_type_in')->widget(StaticCombo::class, [
            'multiple' => true,
            'hasId' => true,
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
        <?= $search->field('domain_state_in')->widget(StaticCombo::class, [
            'multiple' => true,
            'hasId' => true,
            'data' => $domainStates,
        ]) ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('domain_like') ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('domain_zone_in') ?>
    </div>
<?php endif ?>
