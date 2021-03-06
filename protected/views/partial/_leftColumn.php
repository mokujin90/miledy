<?
/**
 * @var $model User|Project
 * @var $types array
 * @var $content str "user" | 1 | 2 | 3 | 4| 5
 * @var $form CActiveForm
 */
$params = array();
//определим какие связи нужны
$content = Candy::get($content,'user');
$params['attributes']['name'] = $content == 'user' ? 'company_name' : 'name';
Yii::app()->clientScript->registerScript('init', 'projectDetail.init();', CClientScript::POS_READY);
?>
<div class="cabinet side-column opacity-box">
    <div class="base-block">
        <div id="logo_block" class="profile-image">
            <span class="rel">
                <?=Candy::preview(array($model->logo, 'scale' => '102x102'))?>
                <?php echo CHtml::hiddenField('logo_id',$model->logo_id)?>
            </span>
            <div class="notice">
                Рекомендуемые параметры:<br>
                Размер не менее 100х100.<br>
                Пропорции сторон 1 к 1<br>
            </div>
        </div>

        <?php
            $this->widget('application.components.MediaEditor.MediaEditor',
                array('data' => array(
                    'items' => null,
                    'field' => 'logo_id',
                    'item_container_id' => 'logo_block',
                    'button_image_url' => '/images/markup/logo.png',
                    'button_width' => 28,
                    'button_height' => 28,
                ),
                    'scale' => '102x102',
                    'scaleMode' => 'in',
                    'needfields' => 'false',
                    'crop'=>true
                ));
        ?>
        <div class="profile-text"><?= $model->$params['attributes']['name']?></div>

        <?if(!empty($types)):?>
            <div class="profile-name"><?= $types[$model->type]?></div>
        <?endif;?>

        <div class="open-dialog load-action"><?= Yii::t('main','Загрузить логотип')?></div>
    </div>
    <?php if($content!='user'):?>
        <div class="map-block">
            <?php $this->widget('Map', array(
                'id'=>'map',
                'projects'=>array($model),
                'draggableBalloon'=>true
            )); ?>
            <?=$form->hiddenField($model,'lat',array('id'=>'coords-lat'))?>
            <?=$form->hiddenField($model,'lon',array('id'=>'coords-lon'))?>
        </div>
        <div id="upload-block">
            <?=$this->renderPartial('/user/_upload',array('model'=>$model))?>
        </div>
        <div class="complete-status" style="padding: 0 0 15px 6px;">
            <?=$form->label($model,'complete')?>
            <?=$form->textField($model,'complete')?>
            <?=$form->error($model,'complete'); ?>
        </div>
        <?$price = Price::get(Price::P_CURRENT_URL)?>
        <?if(!$model->isNewRecord && Balance::get(Yii::app()->user->id)->value >=$price && empty($model->url)):?>
            <?php echo CHtml::link('Уникальный url',array('user/uniqueUrl','projectId'=>$model->id),array('class'=>'btn fancybox.ajax fancy-open unique-url','style'=>'margin: 0 0 7px 7px;'))?>
        <?endif;?>
        <div id="unique-url-block" style="<?if(empty($model->url)):?>display:none<?endif;?>">
            <?=$form->label($model,'url')?>
            <?=$form->textField($model,'url',array('id'=>'unique-url-value'))?>
            <?=$form->error($model,'url'); ?>
        </div>
        <div class="is-disable" style="padding: 0 0 15px 6px;">
            <?=$form->label($model,'is_disable')?>
            <?=$form->checkBox($model,'is_disable')?>
            <?=$form->error($model,'is_disable'); ?>
        </div>
    <?php endif;?>
</div>