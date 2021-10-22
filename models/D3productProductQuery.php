<?php

namespace d3yii2\d3product\models;

use d3system\yii2\db\D3ActiveQuery;

/**
 * This is the ActiveQuery class for [[D3productProduct]].
 *
 * @see D3productProduct
 */
class D3productProductQuery extends D3ActiveQuery
{
    public function findByProductAttributes(int $productTypeId, array $attributes)
    {
        $this->andWhere(['product_type_id' => $productTypeId]);
        $key = 0;
        $prodAttribAlias = 'a' . $key;
        foreach ($attributes as $aName => $aValue) {
            $key ++;
            $prodAttribAlias = 'a' . $key;
            $this
                ->innerJoin(
                    [$prodAttribAlias => 'd3product_attributes'],
                    $prodAttribAlias . '.product_id = d3product_product.id'
                )
                ->andWhere([
                    $prodAttribAlias . '.name' => $aName,
                    $prodAttribAlias . '.value' => $aValue,
                ]);
        }
        return $this;
    }
}
