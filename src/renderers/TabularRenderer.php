<?php
/**
 * Mailing module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-mailing
 * @package   hipanel-module-mailing
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\mailing\renderers;

use hipanel\modules\mailing\models\Target;

/**
 * Class TabularRenderer.
 */
class TabularRenderer
{
    /**
     * @var Target[]
     */
    private $models;

    /**
     * TabularRenderer constructor.
     * @param $models
     */
    public function __construct($models)
    {
        if (!is_array($models)) {
            throw new \InvalidArgumentException('$models must be array');
        }

        $this->models = $models;
    }

    /**
     * @return string
     */
    public function render()
    {
        if (empty($this->models)) {
            return '';
        }

        $result[] = $this->renderHeader();
        $result[] = $this->renderRows();

        return implode("\n", $result);
    }

    /**
     * @return string
     */
    private function renderHeader()
    {
        $result[] = $this->renderRow($this->getActiveColumns());
        $result[] = str_repeat('-', strlen($result[0]));

        return implode("\n", $result);
    }

    /**
     * Method filters columns that are not null in the **first** model of the list.
     *
     * @return array
     */
    private function getActiveColumns()
    {
        $model = reset($this->models);

        return array_filter($model->attributes(), function ($attribute) use ($model) {
            return $model->$attribute !== null;
        });
    }

    /**
     * @return string
     */
    private function renderRows()
    {
        $result = [];
        $activeAttributes = $this->getActiveColumns();

        foreach ($this->models as $model) {
            $result[] = $this->renderRow($model->getAttributes($activeAttributes));
        }
        return implode("\n", $result);
    }

    /**
     * @param $items
     * @return string
     */
    private function renderRow($items)
    {
        return implode(' | ', $items);
    }
}
