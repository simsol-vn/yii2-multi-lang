<?php

namespace simsol\multilang;

use Yii;
use yii\i18n\PhpMessageSource;

/**
 * multilang module definition class
 */
class Module extends \yii\base\Module
{
    const ID                = 'multilang';
    
    const DEFAULT_LANGUAGES = [
        'en' => 'ENG',
    ];
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'simsol\multilang\controllers';
    
    public $languages = self::DEFAULT_LANGUAGES;
    
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here
        self::registerTranslations();
    }
    
    public static function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations['multilang'])) {
            Yii::$app->i18n->translations['multilang'] = [
                'class'          => PhpMessageSource::class,
                'sourceLanguage' => 'en',
                'basePath'       => __DIR__ . '/messages',
            ];
        }
    }
    
    public static function t($message,$params = [],$language = null)
    {
        return Yii::t('multilang',$message,$params,$language);
    }
}
