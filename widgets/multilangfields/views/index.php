<?php
/* @var $this yii\web\View */
/* @var $field string */
/* @var $attributeLabel string */
/* @var $inputType string */
/* @var $id string */
/* @var $modelClass string */

/* @var $model */


use simsol\multilang\models\Translate;
use simsol\multilang\Module;
use simsol\multilang\widgets\multilangfields\MultiLangFieldsWidget;
use yii\helpers\Html;

/** @var Module $module */
$module    = \Yii::$app->getModule('multilang');
$languages = [];
if ($module !== null) {
    $languages = $module->languages;
}
$fieldLabel   = $attributeLabel ?: $model->getAttributeLabel($field);
$panelId      = $id . '-' . time();
$translations = Translate::loadTranslation($model,$field,$modelClass);
Yii::debug(Translate::loadTranslation($model));
Yii::debug(Translate::loadTranslation($model,'title'));
Yii::debug(Translate::loadTranslation($model,'title',null,true));
Yii::debug(Translate::loadTranslation($model,null,null,true));
?>

<div class="panel panel-default panel-translations" id="<?=$id?>">
    <div class="panel-heading">
        <?=Module::t('Translation for') . ' "' . $fieldLabel . '"'?>
        <div class="pull-right">
            <button type="button" class="btn btn-xs btn-link btn-translate-collapse" data-toggle="collapse" data-target="#<?=$panelId?>">
                <div class="icon"></div>
            </button>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body collapse in" id="<?=$panelId?>">
        <?php foreach ($languages as $key => $language): ?>
            <?php
            $fieldNam = $model->formName() . "[translations][$field][$key]";
            $value    = null;
            
            if (!empty($translations) && count($translations) > 0 && isset($translations[$key])) {
                $value = $translations[$key];
            }
            ?>
            <div class="form-group form-group-translations">
                <label class="control-label" for="song-description"><?=$fieldLabel . " ($language)"?></label>
                <?php
                switch ($inputType) {
                    case MultiLangFieldsWidget::TYPE_TEXTAREA:
                        echo Html::textarea($fieldNam,$value,[
                            'class' => 'form-control',
                        ]);
                        break;
                    default:
                        echo Html::textInput($fieldNam,$value,[
                            'class' => 'form-control',
                        ]);
                        break;
                }
                ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
