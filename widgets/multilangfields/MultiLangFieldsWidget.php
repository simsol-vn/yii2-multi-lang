<?php

namespace simsol\multilang\widgets\multilangfields;

use simsol\multilang\Module;
use yii\widgets\InputWidget;

class MultiLangFieldsWidget extends InputWidget
{
    const TYPE_TEXT_INPUT = 'TEXT_INPUT';
    const TYPE_TEXTAREA   = 'TEXTAREA';
    
    public $attributeLabel  = null;
    public $inputType       = self::TYPE_TEXT_INPUT;
    public $modelClass      = null;
    public $modelId         = null;
    public $attributeToSave = null;
    public $attributeToLoad = null;
    
    
    public function init()
    {
        parent::init();
        $this->initOptions();
    }
    
    public function run()
    {
        $this->renderWidget();
        $this->registerAsset();
    }
    
    /**
     * Registers asset
     */
    protected function registerAsset()
    {
        $view = $this->getView();
        MultiLangFieldsWidgetAsset::register($view);
    }
    
    protected function initOptions()
    {
        Module::registerTranslations();
        $this->options['id'] .= '-translations';
        if (!isset($this->attributeToSave)) {
            $this->attributeToSave = $this->attribute;
        }
    }
    
    /**
     * Render widget
     */
    protected function renderWidget()
    {
        echo $this->render('index',[
            'attributeToSave' => $this->attributeToSave,
            'attributeToLoad' => $this->attributeToLoad,
            'model'           => $this->model,
            'modelClass'      => $this->modelClass,
            'attributeLabel'  => $this->attributeLabel,
            'inputType'       => $this->inputType,
            'id'              => $this->options['id'],
            'modelId'         => $this->modelId,
        ]);
    }
}