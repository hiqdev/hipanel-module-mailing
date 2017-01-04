<?php
/**
 * Mailing module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-mailing
 * @package   hipanel-module-mailing
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\mailing\menus;

use Yii;

/**
 * Class SidebarSubMenu.
 */
class SidebarSubMenu extends \hiqdev\yii2\menus\Menu
{
    public function items()
    {
        return [
            'clients' => [
                'items' => [
                    'mailing' => [
                        'label' => Yii::t('hipanel:mailing', 'Mailing preparation'),
                        'url' => ['@mailing/prepare/index'],
                        'visible' => function () {
                            return Yii::$app->user->can('mailing.prepare');
                        },
                    ],
                ],
            ],
        ];
    }
}
