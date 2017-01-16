<?php

namespace hipanel\modules\mailing\renderers;

abstract class AbstractRedirectFormRenderer
{
    protected $list;

    public function __construct($list)
    {
        $this->list = $list;
    }

    public function render()
    {
        return $this->renderHtml();
    }

    abstract protected function renderHtml();
}
