[![Latest Stable Version](http://poser.pugx.org/simsol/yii2-multilang/v)](https://packagist.org/packages/simsol/yii2-multilang) [![Total Downloads](http://poser.pugx.org/simsol/yii2-multilang/downloads)](https://packagist.org/packages/simsol/yii2-multilang) [![Latest Unstable Version](http://poser.pugx.org/simsol/yii2-multilang/v/unstable)](https://packagist.org/packages/simsol/yii2-multilang) [![License](http://poser.pugx.org/simsol/yii2-multilang/license)](https://packagist.org/packages/simsol/yii2-multilang)

# This is a Guide for using MultiLang Module
### 1. Install

```
composer require simsol/yii2-multilang
```
### 2. Init
    ......
    'modules' => [
        'multilang' => [
            'class'     => 'simsol\multilang\Module',
            //config for languages, default will be ["en"=>"ENG"]."en" is language code and "ENG" is the label to be displayed
            'languages' => [
                'en' => 'ENG',
                'vi' => 'VN',
            ],
        ],
    ],
    ......

### 3. Run Migrations
```
./yii migrate --migrationPath=@simsol/multilang/migrations
```
