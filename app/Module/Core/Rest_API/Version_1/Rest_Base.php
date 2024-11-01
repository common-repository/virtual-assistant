<?php

namespace EWVA\Module\Core\Rest_API\Version_1;

use EWVA\Module\Core\Rest_API\Base;

abstract class Rest_Base extends Base {

    /**
     * @var string
     */
    public $namespace = EWVA_REST_BASE_PREFIX . '/v1';

}
