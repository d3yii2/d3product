<?php

namespace d3yii2\d3product\models;

use d3yii2\d3product\dictionaries\D3productUnitDictionary;
use \d3yii2\d3product\models\base\D3productAttributes as BaseD3productAttributes;

/**
 * This is the model class for table "d3product_attributes".
 */
class D3productAttributes extends BaseD3productAttributes
{
    public function unitLabel(int $sysCompanyId)
    {
        return D3productUnitDictionary::getList($sysCompanyId)[$this->unit_id] ?? ' - ';
    }
}
