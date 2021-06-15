<?php

namespace d3yii2\d3product;

use Yii;
use d3system\yii2\base\D3Module;

class Module extends D3Module
{
    public $controllerNamespace = 'd3yii2\d3product\controllers';

    public $leftMenu = 'd3yii2\d3product\LeftMenu';

    public function getLabel(): string
    {
        return Yii::t('d3product','d3product');
    }
}
