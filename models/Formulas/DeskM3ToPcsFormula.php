<?php

namespace d3yii2\d3product\models\Formulas;

class DeskM3ToPcsFormula extends BaseFormula
{

    /** @var int */
    public $length;

    /** @var int */
    public $width;

    /** @var int */
    public $thickness;


    public function rules(): array
    {
        return [
            [['length', 'width', 'thickness', 'qnt'], 'required'],
            [['length', 'width', 'thickness'], 'integer', 'min' => 1],
            [['qnt'], 'number', 'min' => .001],
        ];
    }

    public function init(): void
    {
        parent::init();
        $this->loadAttributes = ['width', 'length', 'thickness'];
    }

    public function calc(float $qnt)
    {
        $this->qnt = $qnt;
        if (!$this->validate()) {
            return false;
        }
        return round(($this->qnt * 1000 * 1000 * 1000) / ($this->thickness * $this->width * $this->length));
    }
}
