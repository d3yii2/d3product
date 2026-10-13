<?php

namespace d3yii2\d3product\models;

use d3yii2\d3product\models\base\D3productPrice as BaseD3productPrice;
use Yii;

/**
 * This is the model class for table "d3product_price".
 */
class D3productPrice extends BaseD3productPrice
{
    public function rules(): array
    {
        $rules = parent::rules();
        unset($rules['decimal-unsigned-10-2']);
        $rules['decimal-unsigned-12-4'] = [
            ['price'],
            'number',
            'numberPattern' => '/^\+?(?:\d{1,8}(?:\.\d{0,4})?|\.\d{1,4})$/',
            'message' => Yii::t('crud', 'Invalid number format'),
        ];
        return $rules;
    }
}

