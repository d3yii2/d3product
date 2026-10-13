#Products"

## Features


## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ composer require d3yii2/d3product "*"
```

or add

```
"d3yii2/d3product": "*"
```

to the `require` section of your `composer.json` file.


## Methods


## Usage

Product prices support four decimal places, such as `0.0220 EUR`, through
`D3productPrice` validation. Apply
`m261013_152416_d3yii2_d3product_price_precision` from this package's migration
path before storing these prices. The migration changes `d3product_price.price`
to unsigned `DECIMAL(12,4)`, preserving the existing eight-digit integer range.
It cannot be reverted because reducing precision could round stored prices.

## Examples
