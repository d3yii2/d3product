<?php

namespace d3yii2\d3product\models;

use d3modules\d3productadmin\models\D3productAttributes;
use d3system\exceptions\D3ActiveRecordException;
use d3yii2\d3product\models\base\D3productProduct as BaseD3productProduct;
use yii\db\ActiveQuery;
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
     * @throws \d3system\exceptions\D3ActiveRecordException
     */
    public function createFromProductType(): bool
    {
        $this->save();

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
            D3productAttributes::findAll(['product_id' => $this->id]),
            'name',
            'value'
        );
    }

    public function unitConvertFromTo(float $qnt, int $fromUnitId, int $toUnitId)
    {
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

}
