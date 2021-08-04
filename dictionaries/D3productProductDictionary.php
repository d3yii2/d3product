<?php

namespace d3yii2\d3product\dictionaries;

use d3yii2\d3product\models\D3productGroup;
use d3yii2\d3product\models\D3productProduct;
use d3yii2\d3product\models\D3productProductGroup;
use d3yii2\d3product\models\D3productProductType;
use yii\helpers\StringHelper;

class D3productProductDictionary
{

    /**
     * select2
     * search expression [group]/[type]/[product name]
     * product name - can use separator spaces for searching by parts
     *
     * @param int $sysCompanyId
     * @param string $q
     * @return array
     */
    public static function searchByGroupTypeName(int $sysCompanyId, string $q = ''): array
    {

        if (!$q = trim($q)) {
            return [];
        }

        [$group, $type, $productCode] = array_pad(explode('/', $q, 3), 3, '');

        if (!$type && !$productCode && $group !== '*') {
            $groupNames = D3productGroup::find()
                ->select([
                    'name'
                ])
                ->where([
                    'sys_company_id' => $sysCompanyId
                ])
                ->andWhere(['LIKE', 'name', $group])
                ->orderBy(['name' => SORT_ASC])
                ->limit(20)
                ->column();
            $returnList = [];
            foreach ($groupNames as $key => $name) {
                $returnList[] = [
                    'id' => $key,
                    'text' => $name
                ];
            }
            return $returnList;
        }
        $query = D3productGroup::find()
            ->select([
                'id' => D3productProduct::tableName() . '.id',
                'groupName' => D3productGroup::tableName() . '.name',
                'productType' => D3productProductType::tableName() . '.name',
                'productName' => D3productProduct::tableName() . '.name'
            ])
            ->distinct()
            ->innerJoin(
                D3productProductGroup::tableName(),
                D3productProductGroup::tableName() . '.group_id = ' . D3productGroup::tableName() . '.id'
            )
            ->innerJoin(
                D3productProduct::tableName(),
                D3productProductGroup::tableName() . '.product_id = ' . D3productProduct::tableName() . '.id'
            )
            ->innerJoin(
                D3productProductType::tableName(),
                D3productProductType::tableName() . '.id = ' . D3productProduct::tableName() . '.product_type_id'
            )
            ->orderBy([
                'groupName' => SORT_ASC,
                'productType' => SORT_ASC,
            ])
            ->limit(20);


        if ($group && $group !== '*') {
            $query->andWhere(['LIKE', D3productGroup::tableName() . '.name', $group]);
        }
        if ($type && $type !== '*') {
            $query->andWhere(['LIKE', D3productProductType::tableName() . '.name', $type]);
        }
        if ($productCode && $productCode !== '*') {
            $productSearch = implode('%', StringHelper::explode($productCode, ' '));
            $query
                ->addSelect(['productName' => D3productProduct::tableName() . '.name'])
                ->andWhere(D3productProduct::tableName() . '.name LIKE \'%' . $productSearch . '%\'')
                ->addOrderBy(['productName' => SORT_ASC]);
        }
        $returnList = [];
        foreach ($query->asArray()->all() as $res) {
            $displayName = [
                $res['groupName'],
                $res['productType']
            ];

            if (isset($res['productName'])) {
                $displayName[] = $res['productName'];
            }
            $returnList[] = [
                'id' => $res['id'],
                'text' => implode('/', $displayName)
            ];
        }
        return $returnList;
    }
}