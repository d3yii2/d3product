<?php
namespace d3yii2\d3product;

use Yii;
class LeftMenu {

    public function list()
    {
        return [
            [
                'label' => Yii::t('d3product', '????'),
                'type' => 'submenu',
                //'icon' => 'truck',
                'url' => ['/d3product/????/index'],
            ],
        ];
    }
}
