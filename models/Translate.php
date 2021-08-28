<?php

namespace simsol\multilang\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use function array_merge;
use function count;
use function get_class;

/**
 * This is the model class for table "translate".
 *
 * @property int         $id_translate
 * @property string|null $language_code
 * @property int|null    $id_object
 * @property string|null $object_class
 * @property string|null $object_field
 * @property string|null $value
 * @property int|null    $created_at
 * @property int|null    $updated_at
 */
class Translate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translate';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_object','created_at','updated_at'],'integer'],
            [['value'],'string'],
            [['language_code','object_class','object_field'],'string','max' => 255],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_translate'  => Yii::t('app','Id Translate'),
            'language_code' => Yii::t('app','Language Code'),
            'id_object'     => Yii::t('app','Id Object'),
            'object_class'  => Yii::t('app','Object Class'),
            'object_field'  => Yii::t('app','Object Field'),
            'value'         => Yii::t('app','Value'),
            'created_at'    => Yii::t('app','Created At'),
            'updated_at'    => Yii::t('app','Updated At'),
        ];
    }
    
    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            TimestampBehavior::class,
        ]);
    }
    
    public static function saveTranslation($translations,$objectId,$objectClass)
    {
        $flag = 0;
        if (!empty($translations) && !empty($objectId) && !empty($objectClass)) {
            foreach ($translations as $field => $translation) {
                foreach ($translation as $language => $value) {
                    $model = Translate::findOne([
                        'id_object'     => $objectId,
                        'object_class'  => $objectClass,
                        'object_field'  => $field,
                        'language_code' => $language,
                    ]);
                    if ($model === null) {
                        $model = new Translate([
                            'id_object'     => $objectId,
                            'object_class'  => $objectClass,
                            'object_field'  => $field,
                            'language_code' => $language,
                        ]);
                    }
                    $model->value = $value;
                    if (!$model->save()) {
                        $flag++;
                    }
                }
            }
        }
        
        return $flag === 0;
    }
    
    
    public static function loadTranslation($model,$attribute = null,$modelId = null,$modelClass = null,$useAppLanguage = false)
    {
        $result      = null;
        $appLanguage = Yii::$app->language;
        if ($model !== null && $model instanceof Model) {
            $objectClass = $modelClass !== null ? $modelClass : get_class($model);
            $objectId    = $modelId !== null ? $modelId : $model->getPrimaryKey();
            $fieldsWhere = [
                'AND',
                ['id_object' => $objectId],
                ['object_class' => $objectClass],
            ];
            
            if ($attribute !== null) {
                $fieldsWhere[] = ['object_field' => $attribute];
            }
            
            $fields = Translate::find()->select(['object_field'])->where($fieldsWhere)->groupBy(['object_field'])->column();
            
            if ($fields !== null && count($fields) > 0) {
                foreach ($fields as $field) {
                    $valuesWhere = [
                        'AND',
                        ['id_object' => $objectId],
                        ['object_class' => $objectClass],
                        ['object_field' => $field],
                    ];
                    if ($useAppLanguage === true) {
                        $valuesWhere[] = ['language_code' => $appLanguage];
                    }
                    $values = Translate::find()->select(['language_code','value'])->where($valuesWhere)->asArray()->all();
                    if ($values !== null && count($values) > 0) {
                        $translations = [];
                        foreach ($values as $value) {
                            if ($useAppLanguage === true) {
                                $translations = $value['value'];
                            }else {
                                $translations[$value['language_code']] = $value['value'];
                            }
                        }
                        if ($attribute !== null) {
                            $result = $translations;
                        }else {
                            $result[$field] = $translations;
                        }
                    }
                }
            }
        }
        
        return $result;
    }
}
