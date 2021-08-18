# This is a Guide for using MultiLang Module
### 1. Install

```
composer require simsol/yii2-multilang:"@dev"
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