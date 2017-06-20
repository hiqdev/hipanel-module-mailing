<?php
/**
 * Mailing module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-mailing
 * @package   hipanel-module-mailing
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

return [
    'bootstrap' => array_filter([
        'yii2-mailing.service.submitUrl-warning' =>
            (defined('YII_DEBUG') && YII_DEBUG && empty($params['mailing.service.submitUrl'])) ?
                function () {
                    Yii::warning('Parameter "mailing.service.submitUrl" is not configured');
                }
            : null,
    ]),
    'aliases' => [
        '@mailing'   => '/mailing',
    ],
    'modules' => [
        'mailing' => [
            'class' => \hipanel\modules\mailing\Module::class,
        ],
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'hipanel:mailing' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@hipanel/modules/mailing/messages',
                ],
            ],
        ],
    ],
    'container' => [
        'definitions' => [
            \hipanel\modules\mailing\renderers\RedirectFormRendererInterface::class => [
                ['class' => \hipanel\widgets\RedirectFormRenderer::class],
                [1 => $params['mailing.service.submitUrl']],
            ],
            \hiqdev\thememanager\menus\AbstractSidebarMenu::class => [
                'add' => [
                    'client' => [
                        'menu' => [
                            'merge' => [
                                'mailing' => [
                                    'menu' => \hipanel\modules\mailing\menus\SidebarSubMenu::class,
                                    'where' => [
                                        'after' => ['documents'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
