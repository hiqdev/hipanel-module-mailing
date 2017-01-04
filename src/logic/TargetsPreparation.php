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

use hipanel\components\ApiConnectionInterface;
use hipanel\modules\mailing\forms\FiltersForm;
use hipanel\modules\mailing\models\Target;
use hiqdev\hiart\ErrorResponseException;

class TargetsPreparation
{
    /**
     * @var FiltersForm
     */
    private $filtersForm;
    /**
     * @var ApiConnectionInterface
     */
    private $api;
    /**
     * @var
     */
    private $targetClass;

    public function __construct(FiltersForm $filtersForm, ApiConnectionInterface $api, $targetClass = Target::class)
    {
        $this->filtersForm = $filtersForm;
        $this->api = $api;
        $this->targetClass = $targetClass;
    }

    public function execute()
    {
        try {
            $data = $this->api->post('mailingPrepare', $this->getFilters());

            return $this->createTargets($data);
        } catch (ErrorResponseException $e) {
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
