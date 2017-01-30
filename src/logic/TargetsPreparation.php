<?php
/**
 * Mailing module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-mailing
 * @package   hipanel-module-mailing
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\mailing\logic;

use hipanel\modules\mailing\forms\FiltersForm;
use hipanel\modules\mailing\models\Mailing;
use hipanel\modules\mailing\models\Target;
use hiqdev\hiart\ResponseErrorException;

class TargetsPreparation
{
    /**
     * @var FiltersForm
     */
    private $filtersForm;

    /**
     * @var
     */
    private $targetClass;

    public function __construct(FiltersForm $filtersForm, $targetClass = Target::class)
    {
        $this->filtersForm = $filtersForm;
        $this->targetClass = $targetClass;
    }

    public function execute()
    {
        try {
            $data = Mailing::perform('prepare', $this->getFilters());

            return $this->createTargets($data);
        } catch (ResponseErrorException $e) {
            throw $e;
        }
    }

    protected function createTargets($data)
    {
        $result = [];

        foreach ($data as $item) {
            $result[] = new $this->targetClass($item);
        }

        return $result;
    }

    protected function getFilters()
    {
        return array_filter($this->filtersForm->getAttributes());
    }
}
