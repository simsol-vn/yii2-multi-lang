<?php

namespace simsol\multilang\widgets\multilangfields;

use simsol\multilang\Module;
use yii\widgets\InputWidget;

class MultiLangFieldsWidget extends InputWidget
{
    const TYPE_TEXT_INPUT = 'TEXT_INPUT';
    const TYPE_TEXTAREA   = 'TEXTAREA';
    
    public $fieldLabel = null;
    public $inputType  = self::TYPE_TEXT_INPUT;
    
    
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
    }
    
    /**
     * Render widget
     */
    protected function renderWidget()
    {
        echo $this->render('index',[
            'field'      => $this->attribute,
            'model'      => $this->model,
            'fieldLabel' => $this->fieldLabel,
            'inputType'  => $this->inputType,
            'id'         => $this->options['id'],
        ]);
    }
}