<?php
/**
 * Mailing module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-mailing
 * @package   hipanel-module-mailing
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\mailing\forms;

use Yii;
use yii\base\Model;

class FiltersForm extends Model
{
    public $client_in;

    public $client_state_in;

    public $seller_in;

    public $server_in;

    public $has_server;

    public $server_state_in;

    public $server_type_in;

    public $server_switch_like;

    public $server_rack_like;

    public $server_pdu_like;

    public $domain_like;

    public $has_domain;

    public $domain_state_in;

    public $exclude_unsubscribed;

    public $language_in;

    public $include_subclients;

    public function attributes()
    {
        return [
            'client_in', 'client_state_in', 'include_subclients',
            'seller_in',
            'server_in', 'has_server', 'server_state_in', 'server_type_in',
            'server_switch_like', 'server_rack_like', 'server_pdu_like',
            'domain_like', 'has_domain', 'domain_state_in',
            'language_in',
            'exclude_unsubscribed',
        ];
    }

    public function rules()
    {
        return [
            [$this->attributes(), 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'seller_in' => Yii::t('hipanel:mailing', 'Sellers'),
            'client_in' => Yii::t('hipanel:mailing', 'Clients'),
            'client_state_in' => Yii::t('hipanel:mailing', 'Client state'),
            'has_server' => Yii::t('hipanel:mailing', 'Has server'),
            'server_in' => Yii::t('hipanel:mailing', 'Servers'),
            'server_state_in' => Yii::t('hipanel:mailing', 'State'),
            'server_type_in' => Yii::t('hipanel:mailing', 'Type'),
            'server_switch_like' => Yii::t('hipanel:mailing', 'Switch'),
            'server_rack_like' => Yii::t('hipanel:mailing', 'Rack'),
            'server_pdu_like' => Yii::t('hipanel:mailing', 'PDU'),
            'has_domain' => Yii::t('hipanel:mailing', 'Has domain'),
            'domain_like' => Yii::t('hipanel:mailing', 'Domain'),
            'domain_state_in' => Yii::t('hipanel:mailing', 'State'),
            'exclude_unsubscribed' => Yii::t('hipanel:mailing', 'Exclude unsubscribed'),
            'language_in' => Yii::t('hipanel:mailing', 'Languages'),
            'language_unknown' => Yii::t('hipanel:mailing', 'Language is unknown'),
            'include_subclients' => Yii::t('hipanel:mailing', 'Include subclients')
        ];
    }
}
