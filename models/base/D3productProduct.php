<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace d3yii2\d3product\models\base;

use Yii;
use d3system\yii2\validators\D3TrimValidator;
use d3yii2\d3product\models\D3productAttributes;
use d3yii2\d3product\models\D3productPrice;
use d3yii2\d3product\models\D3productProductGroup;
use d3yii2\d3product\models\D3productProductQuery;
use d3yii2\d3product\models\D3productProductType;
use d3yii2\d3product\models\D3productUnit;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the base-model class for table "d3product_product".
 *
 * @property integer $id
 * @property integer $sys_company_id
 * @property string $name
 * @property string $description
 * @property integer $unit_id
 * @property integer $product_type_id
 *
 * @property D3productAttributes[] $d3productAttributes
 * @property D3productPrice[] $d3productPrices
 * @property D3productProductGroup[] $d3productProductGroups
 * @property D3productProductType $productType
 * @property D3productUnit $unit
 * @property string $aliasModel
 */
abstract class D3productProduct extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'd3product_product';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            'trimNumbers' => [['id','sys_company_id','unit_id','product_type_id'],D3TrimValidator::class, 'trimOnlyStringValues' => true],
            'required' => [['sys_company_id'], 'required'],
            'smallint Unsigned' => [['id','sys_company_id','unit_id','product_type_id'],'integer' ,'min' => 0 ,'max' => 65535],
            [['name', 'description', 'unit_id', 'product_type_id'], 'default', 'value' => null],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 256],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => D3productUnit::class, 'targetAttribute' => ['unit_id' => 'id']],
            [['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => D3productProductType::class, 'targetAttribute' => ['product_type_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('d3product', 'ID'),
            'sys_company_id' => Yii::t('d3product', 'Sys Company ID'),
            'name' => Yii::t('d3product', 'Name'),
            'description' => Yii::t('d3product', 'Description'),
            'unit_id' => Yii::t('d3product', 'Unit'),
            'product_type_id' => Yii::t('d3product', 'Type'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints(): array
    {
        return array_merge(parent::attributeHints(), [
            'name' => Yii::t('d3product', 'Name'),
            'description' => Yii::t('d3product', 'Description'),
            'unit_id' => Yii::t('d3product', 'Unit'),
            'product_type_id' => Yii::t('d3product', 'Type'),
        ]);
    }

    /**
     * @return ActiveQuery
     */
    public function getD3productAttributes(): ActiveQuery
    {
        return $this
            ->hasMany(D3productAttributes::class, ['product_id' => 'id'])
            ->inverseOf('product');
    }

    /**
     * @return ActiveQuery
     */
    public function getD3productPrices(): ActiveQuery
    {
        return $this
            ->hasMany(D3productPrice::class, ['product_id' => 'id'])
            ->inverseOf('product');
    }

    /**
     * @return ActiveQuery
     */
    public function getD3productProductGroups(): ActiveQuery
    {
        return $this
            ->hasMany(D3productProductGroup::class, ['product_id' => 'id'])
            ->inverseOf('product');
    }

    /**
     * @return ActiveQuery
     */
    public function getProductType(): ActiveQuery
    {
        return $this
            ->hasOne(D3productProductType::class, ['id' => 'product_type_id'])
            ->inverseOf('d3productProducts');
    }

    /**
     * @return ActiveQuery
     */
    public function getUnit(): ActiveQuery
    {
        return $this
            ->hasOne(D3productUnit::class, ['id' => 'unit_id'])
            ->inverseOf('d3productProducts');
    }

    /**
     * @inheritdoc
     * @return D3productProductQuery the active query used by this AR class.
     */
    public static function find(): D3productProductQuery    {
        return new D3productProductQuery(get_called_class());
    }
}
