[![Latest Stable Version](http://poser.pugx.org/simsol/yii2-multilang/v)](https://packagist.org/packages/simsol/yii2-multilang) [![Total Downloads](http://poser.pugx.org/simsol/yii2-multilang/downloads)](https://packagist.org/packages/simsol/yii2-multilang) [![Latest Unstable Version](http://poser.pugx.org/simsol/yii2-multilang/v/unstable)](https://packagist.org/packages/simsol/yii2-multilang) [![License](http://poser.pugx.org/simsol/yii2-multilang/license)](https://packagist.org/packages/simsol/yii2-multilang)

# This is a Guide for using MultiLang Module
### 1. Install

```
composer require simsol/yii2-multilang
```
### 2. Init
Module declaration and config for languages to be stored:
```
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
```

### 3. Run Migrations
```
./yii migrate --migrationPath=@simsol/multilang/migrations
```

### 4. Usage
Please follow below steps to set up and use this extension.
#### a. In model

- Add property ```translation``` to your model class.

    ```
    public $translations;
    ```
- Add rule for ```translation``` property.

    ```
    /**
      * {@inheritdoc}
      */
      public function rules()
      {
         return [
            ...
            [['translations'],'safe'],
         ];
      }
    ```
- Modify ```afterSave()``` and add this line:

  ```
  Translate::saveTranslation($this->translations,$this->id_model,Model::class);
  ```
  This will save translation for current model.

#### b. In form
- Add this widget for attributes that you want to provide translation to your create or update form.

  ```
  <?=$form->field($model,'attribute')->widget(MultiLangFieldsWidget::class)->label(false)?>
  ```
- Available config:
  - `attributeLabel`: Optional. In case you want to use another name for model attribute, default is model's attribute name.
  - `attributeToSave`: Optional. In case you want to save with a different attribute, default is model's attribute. Useful when working with custom model.
  - `attributeToLoad`: Optional. In case you want to load saved translation value on edit with a different attribute, default is model's attribute. Useful when working with custom model.
  - `inputType`: Optional. Default is text input, available options:
    - Text Input: MultiLangFieldsWidget::TYPE_TEXT_INPUT
    - Textarea: MultiLangFieldsWidget::TYPE_TEXTAREA

  ```
  <?=$form->field($model,'attribute')->widget(MultiLangFieldsWidget::class,[
                  'inputType' => MultiLangFieldsWidget::TYPE_TEXTAREA,
                  'attributeLabel' => 'Another name',
              ])->label(false)?>
  ```
  
#### c. Query translations

```
 Translate::loadTranslation($model,$attribute = null,$modelId = null;$modelClass = null,$language = null)
```
- ```$model```: Required. Model to load translations.
- ```$attribute```: Optional. Translations for specified attribute will be queried if provided.
- ```$modelId```: Optional. In case the model id is different from defined $model, useful when working with custom model.
- ```$modelClass```: Optional. In case model class name is different from provided model. For example:  ```app\models\form\CustomerForm``` and ```app\models\Customer```
- ```$language```: Optional. If passed, value will be used to query for specified language.

- Query results: Result might be varied depends on provided parameters. See examples below:
```
Translate::loadTranslation($model);

Result:

[
    'description' => [
        'en' => 'Description of data.',
        'vi' => 'Mô tả của dữ liệu',
    ],
    'title' => [
        'en' => 'Title of data',
        'vi' => 'Tiêu đề của dữ liệu',
    ],
]
```

```
Translate::loadTranslation($model,'title');

Result:

[
        'en' => 'Title of data',
        'vi' => 'Tiêu đề của dữ liệu',
]
```

```
Translate::loadTranslation($model,'title',null,null,true);

Result:

'Title of data'
```

```
Translate::loadTranslation($model,null,null,null,true);

Result:

[
    'description' => 'Description of data.',
    'title' => 'Title of data',
]
```



