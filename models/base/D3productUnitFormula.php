<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace d3yii2\d3product\models\base;

use Yii;

/**
 * This is the base-model class for table "d3product_unit_formula".
 *
 * @property integer $id
 * @property string $code
 * @property integer $from_unit_id
 * @property integer $to_unit_id
 * @property string $formula
 *
 * @property \d3yii2\d3product\models\D3productTypeFormula[] $d3productTypeFormulas
 * @property \d3yii2\d3product\models\D3productUnit $fromUnit
 * @property \d3yii2\d3product\models\D3productUnit $toUnit
 * @property string $aliasModel
 */
abstract class D3productUnitFormula extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'd3product_unit_formula';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'required' => [['code', 'from_unit_id', 'to_unit_id'], 'required'],
            'smallint Unsigned' => [['id','from_unit_id','to_unit_id'],'integer' ,'min' => 0 ,'max' => 65535],
            [['formula'], 'string'],
            [['code'], 'string', 'max' => 10],
            [['code'], 'unique'],
            [['from_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => \d3yii2\d3product\models\D3productUnit::className(), 'targetAttribute' => ['from_unit_id' => 'id']],
            [['to_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => \d3yii2\d3product\models\D3productUnit::className(), 'targetAttribute' => ['to_unit_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('d3product', 'ID'),
            'code' => Yii::t('d3product', 'Code'),
            'from_unit_id' => Yii::t('d3product', 'From Unit ID'),
            'to_unit_id' => Yii::t('d3product', 'To Unit ID'),
            'formula' => Yii::t('d3product', 'Formula'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getD3productTypeFormulas()
    {
        return $this->hasMany(\d3yii2\d3product\models\D3productTypeFormula::className(), ['unit_formula_id' => 'id'])->inverseOf('unitFormula');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUnit()
    {
        return $this->hasOne(\d3yii2\d3product\models\D3productUnit::className(), ['id' => 'from_unit_id'])->inverseOf('d3productUnitFormulas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUnit()
    {
        return $this->hasOne(\d3yii2\d3product\models\D3productUnit::className(), ['id' => 'to_unit_id'])->inverseOf('d3productUnitFormulas0');
    }



}
