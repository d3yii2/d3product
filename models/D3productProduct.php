<?php

namespace d3yii2\d3product\models;

use d3modules\d3productadmin\models\D3productAttributes;
use d3modules\d3productadmin\ModuleConfig;
use d3system\exceptions\D3ActiveRecordException;
use d3yii2\d3product\models\base\D3productProduct as BaseD3productProduct;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "d3product_product".
 */
class D3productProduct extends BaseD3productProduct
{

    /**
     * @throws \yii\db\Exception
     */
    public function beforeSave($insert): bool
    {
        if ($this->isNewRecord && $this->product_type_id) {
            if (!$productType = \d3modules\d3productadmin\models\D3productProductType::findOne($this->product_type_id)) {
                throw new Exception('Can not find D3productProductType for id: ' . $this->product_type_id);
            }
            $this->unit_id = $productType->unit_id;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return false|int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */

    public function delete()
    {
        foreach ($this->d3productAttributes as $attribute) {
            $attribute->delete();
        }

//        foreach ($this->d3productCodes as $code) {
//            $code->delete();
//        }

        foreach ($this->d3productProductGroups as $productGroups) {
            $productGroups->delete();
        }

//        foreach ($this->d3productProductPrices as $productPrice) {
//            $productPrice->delete();
//        }
        return parent::delete();
    }

    /**
     * @throws \d3system\exceptions\D3ActiveRecordException|\yii\db\Exception
     */
    public function createFromProductType(int $productTypeId): bool
    {
        if (!$productType = D3productProductType::findOne($productTypeId)) {
            throw new Exception(' Can not find productType id: ' . $productTypeId);
        }
        $this->sys_company_id = $productType->sys_company_id;
        $this->product_type_id = $productType->id;
        $this->unit_id = $productType->unit_id;
        if (!$this->save()) {
            throw new D3ActiveRecordException($this);
        }

        foreach ($this->productType->d3productProductTypeGroups as $typeGroup) {
            $productGroup = new D3productProductGroup();
            $productGroup->product_id = $this->id;
            $productGroup->group_id = $typeGroup->group_id;
            if (!$productGroup->save()) {
                throw new D3ActiveRecordException($productGroup);
            }
        }
        foreach ($this->productType->d3productTypeAttributes as $typeAttribute) {
            $productAttribute = new D3productAttributes();
            $productAttribute->product_id = $this->id;
            $productAttribute->type_attribute_id = $typeAttribute->id;
            $productAttribute->sqn = $typeAttribute->sqn;
            $productAttribute->name = $typeAttribute->name;
            $productAttribute->input_type_id = $typeAttribute->input_type_id;
            $productAttribute->unit_id = $typeAttribute->unit_id;
            if (!$productAttribute->save()) {
                throw new D3ActiveRecordException($productAttribute);
            }
        }

        return true;
    }

    /**
     * @throws \d3system\exceptions\D3ActiveRecordException
     * @throws \Throwable
     */
    public function copy(): self
    {

        /**
         * shis te kopee ari saistitos ierkastus - mistika
         */
        $model = clone $this;
        $model->id = null;
        $model->isNewRecord = true;
        $model->name .= '(copy)';
        if (!$model->save()) {
            throw new D3ActiveRecordException($model);
        }

        foreach ($this->d3productAttributes as $attribute) {
            if ($attribute->isTemplate()) {
                continue;
            }
            $attribute->id = null;
            $attribute->isNewRecord = true;
            $attribute->product_id = $model->id;
            if (!$attribute->save()) {
                throw new D3ActiveRecordException($attribute);
            }
        }

        foreach ($this->d3productProductGroups as $productGroups) {
            $productGroups->id = null;
            $productGroups->isNewRecord = true;
            $productGroups->product_id = $model->id;
            if (!$productGroups->save()) {
                throw new D3ActiveRecordException($productGroups);
            }
        }

//        foreach ($this->d3productProductPrices as $productPrice) {
//            $productPrice->id = null;
//            $productPrice->isNewRecord = true;
//            $productPrice->product_id = $model->id;
//            if (!$productPrice->save()) {
//                throw new D3ActiveRecordException($productPrice);
//            }
//        }
        return $model;
    }

    public function genName(): ?string
    {
        $from = $to = [];
        foreach ($this->d3productAttributes as $attribute) {
            $from[] = '{' . $attribute->name . '}';
            $to[] = $attribute->value;
        }
        return str_replace($from, $to, $this->productType->template);
    }

    public function getLabel(): string
    {
        return $this->productType->name . ' ' . $this->name;
    }

    /**
     * get product attributes values array
     * @return array
     */
    public function getProductAttributes(): array
    {
        return ArrayHelper::map(
            D3productAttributes::find()
                ->innerJoin(
                    'd3product_input_type',
                    'd3product_input_type.id = d3product_attributes.input_type_id'
                )
                ->where(['d3product_attributes.product_id' => $this->id])
                ->andWhere('d3product_input_type.name != \'' . ModuleConfig::INPUT_TYPE_TEMPLATE_NAME . '\'')
                ->all(),
            'name',
            'value'
        );
    }

    public function getProductTemplateAttributes(): array
    {
        return ArrayHelper::map(
            D3productAttributes::find()
                ->innerJoin(
                    'd3product_input_type',
                    'd3product_input_type.id = d3product_attributes.input_type_id'
                )
                ->where([
                    'd3product_attributes.product_id' => $this->id,
                    'd3product_input_type.name' => ModuleConfig::INPUT_TYPE_TEMPLATE_NAME
                ])
                ->all(),
            'name',
            'value'
        );
    }

    /**
     * @throws \yii\base\Exception
     */
    public function unitConvertFromTo(float $qnt, int $fromUnitId, int $toUnitId): ?float
    {
        if (!$qnt) {
            return $qnt;
        }
        if ($fromUnitId === $toUnitId) {
            return $qnt;
        }
        $query = D3productUnitFormula::find()
            ->innerJoinWith('d3productTypeFormulas')
            ->andWhere([
                'd3product_type_formula.product_type_id' => $this->product_type_id,
                'd3product_unit_formula.from_unit_id' => $fromUnitId,
                'd3product_unit_formula.to_unit_id' => $toUnitId,
            ]);
        if (!$formula = $query
            ->one()) {
            return null;
        }
        return $formula->calc($this->getProductAttributes(), $qnt);
    }

    public function getToUnitIds(int $fromUnitId): array
    {
        return D3productUnitFormula::find()
            ->select('to_unit_id')
            ->innerJoinWith('d3productTypeFormulas')
            ->andWhere([
                'd3product_type_formula.product_type_id' => $this->product_type_id,
                'd3product_unit_formula.from_unit_id' => $fromUnitId,
            ])
            ->column();
    }

    public function getFromUnitToBaseUnitsIds(): array
    {
        $list = D3productUnitFormula::find()
            ->select('from_unit_id  unitId')
            ->innerJoinWith('d3productTypeFormulas')
            ->andWhere([
                'd3product_type_formula.product_type_id' => $this->product_type_id,
                'd3product_unit_formula.to_unit_id' => $this->unit_id,
            ])
            ->column();
        $list[] = (string)$this->unit_id;
        return $list;
    }

    /**
     * @throws \d3system\exceptions\D3ActiveRecordException
     */
    public static function findOrCreate(int $productTypeId, array $attributes): self
    {
        if ($product = self::find()
            ->findByProductAttributes($productTypeId, $attributes)
            ->one()
        ) {
            return $product;
        }

        $product = new self();
        $product->createFromProductType($productTypeId);
        foreach ($product->d3productAttributes as $productAttribute) {
            if (isset($attributes[$productAttribute->name])) {
                $productAttribute->value = (string)$attributes[$productAttribute->name];
                if (!$productAttribute->save()) {
                    throw new D3ActiveRecordException($productAttribute);
                }
            }
        }
        $product->name = $product->genName();
        if (!$product->save()) {
            throw new D3ActiveRecordException($product);
        }
        return $product;
    }
}
