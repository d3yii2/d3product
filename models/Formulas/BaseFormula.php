<?php

namespace d3yii2\d3product\models\Formulas;


use d3modules\d3productadmin\models\D3productAttributes;
use Yii;
use yii\base\Model;

class BaseFormula extends Model
{
    /** @var \d3modules\d4storei\models\D4StoreStoreProduct */
    public $storeProduct;

    public $loadAttributes = [];

    /** @var float */
    public $qnt;

    public $formulasFieldMapping = [];

    public $d3ModuleId = 'd3product';

    public function init(): void
    {
        parent::init();
        if (!$this->formulasFieldMapping) {
            /** @var \d3yii2\d3product\Module $d3module */
            $d3module = Yii::$app->getModule($this->d3ModuleId);
            $this->formulasFieldMapping = $d3module->formulasFieldMapping;
        }
    }


    public function loadStoreProduct(int $productId): void
    {
        foreach (D3productAttributes::findAll(['product_id' => $productId]) as $d3attribute) {
            if (!$modelAttribute = $this->formulasFieldMapping[$d3attribute->name] ?? false) {
                continue;
            }
            if (!in_array($modelAttribute, ['width', 'length', 'thickness'], true)) {
                continue;
            }

            $this->$modelAttribute = $d3attribute->value;
        }
    }

    public function loadAttributes(array $attributes): void
    {
        foreach ($attributes as $name => $value) {
            if (!$modelAttribute = $this->formulasFieldMapping[$name] ?? false) {
                continue;
            }
            if (!in_array($modelAttribute, $this->loadAttributes, true)) {
                continue;
            }

            $this->$modelAttribute = $value;
        }
    }

    /**
     * @param float|false $qnt
     * @return float
     */
    public function calc(float $qnt)
    {
        return 0.;
    }
}
