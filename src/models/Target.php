<?php
/**
 * Mailing module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-mailing
 * @package   hipanel-module-mailing
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\mailing\models;

use Yii;
use yii\base\Model;

class Target extends Model
{
    public $seller;

    public $seller_id;

    public $client;

    public $client_id;

    public $to;

    public $language;

    public $servers;

    public $server_states;

    public $domains;

    public function attributes()
    {
        return [
            'seller',
            'client',
            'to',
            'language',
            'servers',
            'server_states',
            'domains',
        ];
    }

    public function attributeLabels()
    {
        return [
            'seller' => Yii::t('hipanel:mailing', 'Seller'),
            'client' => Yii::t('hipanel:mailing', 'Client'),
            'to' => Yii::t('hipanel:mailing', 'Email'),
            'language' => Yii::t('hipanel:mailing', 'Language'),
            'servers' => Yii::t('hipanel:mailing', 'Servers'),
            'server_states' => Yii::t('hipanel:mailing', 'Server states'),
            'domains' => Yii::t('hipanel:mailing', 'Domains'),
        ];
    }
}
