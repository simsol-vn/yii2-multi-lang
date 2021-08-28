<?php
/* @var $this yii\web\View */
/* @var $attributeToSave string */
/* @var $attributeToLoad string */
/* @var $attributeLabel string */
/* @var $inputType string */
/* @var $id string */
/* @var $modelClass string */
/* @var $modelId */

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
$attributeLabel   = $attributeLabel ?: $model->getAttributeLabel($attributeToSave);
$panelId      = $id . '-' . time();
$translations = Translate::loadTranslation($model,isset($attributeToLoad) ? $attributeToLoad : $attributeToSave,$modelId,$modelClass);
?>

<div class="panel panel-default panel-translations" id="<?=$id?>">
    <div class="panel-heading">
        <?=Module::t('Translation for') . ' "' . $attributeLabel . '"'?>
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
            $attributeName = $model->formName() . "[translations][$attributeToSave][$key]";
            $value    = null;
            
            if (!empty($translations) && count($translations) > 0 && isset($translations[$key])) {
                $value = $translations[$key];
            }
            ?>
            <div class="form-group form-group-translations">
                <label class="control-label" for="song-description"><?=$attributeLabel . " ($language)"?></label>
                <?php
                switch ($inputType) {
                    case MultiLangFieldsWidget::TYPE_TEXTAREA:
                        echo Html::textarea($attributeName,$value,[
                            'class' => 'form-control',
                        ]);
                        break;
                    default:
                        echo Html::textInput($attributeName,$value,[
                            'class' => 'form-control',
                        ]);
                        break;
                }
                ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
