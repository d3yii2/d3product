<?php

namespace d3yii2\d3product\models;

use d3yii2\d3product\dictionaries\D3productUnitFormulaDictionary;
use \d3yii2\d3product\models\base\D3productTypeFormula as BaseD3productTypeFormula;

/**
 * This is the model class for table "d3product_type_formula".
 */
class D3productTypeFormula extends BaseD3productTypeFormula
{
    public static function optsUnitFormula(): array
    {
        return D3productUnitFormulaDictionary::getList();
    }
}
