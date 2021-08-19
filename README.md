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
  - `attributeLabel`: In case you want to use another name for model attribute, default is model's attribute name.
  - `inputType`: Default is text input, available options:
    - Text Input: MultiLangFieldsWidget::TYPE_TEXT_INPUT
    - Textarea: MultiLangFieldsWidget::TYPE_TEXTAREA

  ```
  <?=$form->field($model,'attribute')->widget(MultiLangFieldsWidget::class,[
                  'inputType' => MultiLangFieldsWidget::TYPE_TEXTAREA,
                  'attributeLabel' => 'Another name',
              ])->label(false)?>
  ```


