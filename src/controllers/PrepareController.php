<?php
/**
 * Mailing module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-mailing
 * @package   hipanel-module-mailing
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\mailing\controllers;

use hipanel\actions\OrientationAction;
use hipanel\base\CrudController;
use hipanel\modules\mailing\actions\MailingRedirectAction;
use hipanel\modules\mailing\forms\FiltersForm;
use hipanel\modules\mailing\logic\TargetsPreparation;
use hipanel\modules\mailing\renderers\RedirectFormRendererInterface;
use hipanel\modules\mailing\renderers\TabularRenderer;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class PrepareController extends CrudController
{
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['export']);

        return $actions;
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['mailing.prepare'],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $model = new FiltersForm();
        $params = [
            'model' => $model,
            'dataProvider' => new ArrayDataProvider(),
            'clientTypes' => $this->getClientTypes(),
            'serverTypes' => $this->getServerTypes(),
            'serverStates' => $this->getServerStates(),
            'domainStates' => $this->getDomainStates(),
            'languages' => $this->getLanguages(),
            'isMailingServiceAvailable' => Yii::$container->has(RedirectFormRendererInterface::class),
            'mailingTypes' => $this->getMailingTypes(),
        ];

        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            /** @var TargetsPreparation $targetsPreparation */
            $targetsPreparation = Yii::createObject(TargetsPreparation::class, [$model]);
            $params['dataProvider']->allModels = $targetsPreparation->execute();
        }

        return $this->render('index', $params);
    }

    public function actionExport()
    {
        $targets = $this->createTabularTargetsList();
        /** @var TabularRenderer $renderer */
        $tabularRenderer = Yii::createObject(TabularRenderer::class, [$targets]);

        return Yii::$app->response->sendContentAsFile($tabularRenderer->render(), 'emails_' . date('Y-m-d--H-i') . '.txt');
    }

    public function actionRedirectToMailing()
    {
        $targets = $this->createTabularTargetsList();
        $tabularRenderer = Yii::createObject(TabularRenderer::class, [$targets]);

        $renderer = Yii::createObject(RedirectFormRendererInterface::class, [$tabularRenderer->render()]);

        return $this->render('mailingRedirect', [
            'renderer' => $renderer,
        ]);
    }

    private function createTabularTargetsList()
    {
        $model = new FiltersForm();

        if ($model->load(Yii::$app->request->get(), '') && $model->validate()) {
            /** @var TargetsPreparation $targetsPreparation */
            $targetsPreparation = Yii::createObject(TargetsPreparation::class, [$model]);
            return $targetsPreparation->execute();
        }

        throw new NotFoundHttpException('Failed to export the list');
    }

    private function getClientTypes()
    {
        return $this->getRefs('type,client', 'hipanel:client');
    }

    private function getServerTypes()
    {
        if (!Yii::getAlias('@server', false)) {
            return [];
        }

        return $this->getRefs('type,device', 'hipanel:server');
    }

    private function getServerStates()
    {
        if (!Yii::getAlias('@server', false)) {
            return [];
        }

        return $this->getRefs('state,device', 'hipanel:server');
    }

    private function getDomainStates()
    {
        if (!Yii::getAlias('@domain', false)) {
            return [];
        }

        return $this->getRefs('state,domain', 'hipanel:domain');
    }

    private function getMailingTypes()
    {
        return [
            'newsletters' => Yii::t('hipanel:client', 'Newsletters'),
            'commercial' => Yii::t('hipanel:client', 'Commercial'),
        ];
    }

    private function getLanguages()
    {
        return $this->getRefs('type,lang', 'hipanel');
    }
}
