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
use hipanel\modules\mailing\forms\FiltersForm;
use hipanel\modules\mailing\logic\TargetsPreparation;
use hipanel\modules\mailing\renderers\TabularRenderer;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class PrepareController extends CrudController
{
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

    public function actions()
    {
        return [
            'set-orientation' => [
                'class' => OrientationAction::class,
                'allowedRoutes' => [
                    '@mailing/prepare/index',
                ],
            ],
        ];
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
        $model = new FiltersForm();

        if ($model->load(Yii::$app->request->get(), '') && $model->validate()) {
            /** @var TargetsPreparation $targetsPreparation */
            $targetsPreparation = Yii::createObject(TargetsPreparation::class, [$model]);
            $targets = $targetsPreparation->execute();

            /** @var TabularRenderer $renderer */
            $renderer = Yii::createObject(TabularRenderer::class, [$targets]);

            return Yii::$app->response->sendContentAsFile($renderer->render(), 'emails_' . date('Y-m-d--H-i') . '.txt');
        }

        throw new NotFoundHttpException('Failed to export the list');
    }

    private function getClientTypes()
    {
        return $this->getRefs('type,client', 'hipanel:client');
    }

    private function getServerTypes()
    {
        return $this->getRefs('type,device', 'hipanel:server');
    }

    private function getServerStates()
    {
        return $this->getRefs('state,device', 'hipanel:server');
    }

    private function getDomainStates()
    {
        return $this->getRefs('state,domain', 'hipanel:domain');
    }

    private function getLanguages()
    {
        return $this->getRefs('type,lang', 'hipanel');
    }
}
