<?php

namespace d3yii2\d3product\widgets;

use eaBlankonThema\widget\ThSelect2Autocomplete;
use yii\helpers\Url;

class D3ProductSelect2Product extends ThSelect2Autocomplete
{
    public function init(): void
    {
        parent::init();
        $this->url = Url::to(['/d3product/search/ajax']);
        $this->options = [
            'prompt' => 'Grupa/Tips/P1 P2 P3',
        ];
        $this->pluginOptions = [
            'allowClear' => true,
        ];
        $this->inputMinLength = 2;
    }
}
