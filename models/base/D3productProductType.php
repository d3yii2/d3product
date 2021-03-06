<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace d3yii2\d3product\models\base;

use Yii;


/**
 * This is the base-model class for table "d3product_product_type".
 *
 * @property integer $id
 * @property integer $sys_company_id
 * @property string $name
 * @property integer $unit_id
 * @property string $template
 *
 * @property \d3yii2\d3product\models\D3productProductTypeGroup[] $d3productProductTypeGroups
 * @property \d3yii2\d3product\models\D3productProduct[] $d3productProducts
 * @property \d3yii2\d3product\models\D3productTypeAttributes[] $d3productTypeAttributes
 * @property \d3yii2\d3product\models\D3productTypeFormula[] $d3productTypeFormulas
 * @property \d3yii2\d3product\models\D3productUnit $unit
 * @property string $aliasModel
 */
abstract class D3productProductType extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'd3product_product_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'required' => [['sys_company_id'], 'required'],
            'smallint Unsigned' => [['id','sys_company_id','unit_id'],'integer' ,'min' => 0 ,'max' => 65535],
            [['name', 'template'], 'string', 'max' => 250],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => \d3yii2\d3product\models\D3productUnit::className(), 'targetAttribute' => ['unit_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('d3product', 'ID'),
            'sys_company_id' => Yii::t('d3product', 'Sys Company ID'),
            'name' => Yii::t('d3product', 'Name'),
            'unit_id' => Yii::t('d3product', 'Unit'),
            'template' => Yii::t('d3product', 'Template'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints(): array
    {
        return array_merge(parent::attributeHints(), [
            'name' => Yii::t('d3product', 'Name'),
            'unit_id' => Yii::t('d3product', 'Unit'),
            'template' => Yii::t('d3product', 'Template'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getD3productProductTypeGroups()
    {
        return $this->hasMany(\d3yii2\d3product\models\D3productProductTypeGroup::className(), ['product_type_id' => 'id'])->inverseOf('productType');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getD3productProducts()
    {
        return $this->hasMany(\d3yii2\d3product\models\D3productProduct::className(), ['product_type_id' => 'id'])->inverseOf('productType');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getD3productTypeAttributes()
    {
        return $this->hasMany(\d3yii2\d3product\models\D3productTypeAttributes::className(), ['product_type_id' => 'id'])->inverseOf('productType');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getD3productTypeFormulas()
    {
        return $this->hasMany(\d3yii2\d3product\models\D3productTypeFormula::className(), ['product_type_id' => 'id'])->inverseOf('productType');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(\d3yii2\d3product\models\D3productUnit::className(), ['id' => 'unit_id'])->inverseOf('d3productProductTypes');
    }



}
