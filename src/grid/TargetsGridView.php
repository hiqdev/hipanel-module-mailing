<?php
/**
 * Mailing module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-mailing
 * @package   hipanel-module-mailing
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\mailing\grid;

use yii\base\InvalidConfigException;

class TargetsGridView extends \hipanel\grid\BoxedGridView
{
    /**
     * @var array possible columns. Each column will be displayed in case when it is filled at least for one of models
     */
    public $possibleColumns;

    public function columns()
    {
        return array_merge(parent::columns(), [
            'seller' => [
                'attribute' => 'seller',
            ],
            'client' => [
                'attribute' => 'client',
            ],
        ]);
    }

    public function init()
    {
        $this->ensureActiveColumns();

        parent::init();
    }

    public function ensureActiveColumns()
    {
        $dataProvider = $this->dataProvider;

        foreach ($this->possibleColumns as $possibleColumn) {
            if (is_array($possibleColumn)) {
                throw new InvalidConfigException('"possibleColumns" parameter does not support array configuration yet.');
            }

            foreach ($dataProvider->getModels() as $model) {
                if ($model->$possibleColumn !== null) {
                    $this->columns[] = $possibleColumn;
                    continue 2;
                }
            }
        }
    }
}
