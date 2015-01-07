<?php
/**
 *
 * @var UserController $this
 * @var InvestmentProject $model
 */
?>
<style>
    .red-box {
        background: #F00;
        font-size: 12px;
        line-height: 20px;
        width: 120px;
    }
</style>
<div id="general">
    <div class="content columns">
        <?php if(!isset($admin)):?>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'user-form',
                'enableAjaxValidation'=>false,
                'htmlOptions'=>array(
                    "onkeypress"=>"return event.keyCode != 13;"
                )
            )); ?>

            <?$this->renderPartial('/partial/_leftColumn',array('model'=>$model,'content'=>Project::T_INVEST,'form'=>$form));?>
            <?$this->renderPartial('/user/_projectNews',array('model'=>$model));?>
            <?$this->renderPartial('/user/_request',array('model'=>$model));?>
        <?php endif;?>

        <div class="main-column opacity-box">
            <div class="inner-column">
                <h2><?=Yii::t('main','Резюме проекта')?></h2>
                <div class="row">
                    <?php echo $form->labelEx($model,'name'); ?>
                    <?php echo $form->textField($model,'name'); ?>
                    <?php echo $form->error($model,'name'); ?>
                </div>
                <div class="row">
                    <?php echo $form->labelEx($model->investment,'short_description'); ?>
                    <?php echo $form->textArea($model->investment,'short_description',array('class'=>'middle-textarea')); ?>
                    <?php echo $form->error($model->investment,'short_description'); ?>
                </div>
                <div class="row">
                    <?$this->widget('crud.dropDownList',
                        array('model'=>$model, 'attribute'=>'region_id','elements'=>CHtml::listData($regions,'id','name'),
                            'options'=>array('multiple'=>false,'label'=>true)
                        ));?>
                    <?php echo $form->error($model,'region_id'); ?>
                </div>
                <div class="row">
                    <?$this->widget('crud.dropDownList',
                        array('model'=>$model, 'attribute'=>'industry_type','elements'=>Project::getIndustryTypeDrop(),
                            'options'=>array('multiple'=>false,'label'=>true)
                        ));?>
                    <?php echo $form->error($model,'industry_type'); ?>
                </div>
                <div class="row">
                    <?$this->widget('crud.dropDownList',
                        array('model'=>$model, 'attribute'=>'object_type','elements'=>Project::getObjectTypeDrop(),
                            'options'=>array('multiple'=>false,'label'=>true)
                        ));?>
                    <?php echo $form->error($model,'object_type'); ?>
                </div>
                <!--filter_fields-->
                <div class="row">
                    <?php echo $form->labelEx($model,'investment_sum'); ?>
                    <?php echo $form->textField($model,'investment_sum'); ?>
                    <?php echo $form->error($model,'investment_sum'); ?>
                </div>
                <div class="row">
                    <?php echo $form->labelEx($model,'period'); ?>
                    <?php echo $form->textField($model,'period'); ?>
                    <?php echo $form->error($model,'period'); ?>
                </div>
                <div class="row">
                    <?php echo $form->labelEx($model,'profit_norm'); ?>
                    <?php echo $form->textField($model,'profit_norm'); ?>
                    <?php echo $form->error($model,'profit_norm'); ?>
                </div>
                <div class="row">
                    <?php echo $form->labelEx($model,'profit_clear'); ?>
                    <?php echo $form->textField($model,'profit_clear'); ?>
                    <?php echo $form->error($model,'profit_clear'); ?>
                </div>
                <!--end-filter_fields-->
                <div class="row">
                    <?php echo $form->labelEx($model->investment,'address'); ?>
                    <?php echo $form->textArea($model->investment,'address',array('class'=>'middle-textarea')); ?>
                    <?php echo $form->error($model->investment,'address'); ?>
                </div>
                <div class="row">
                    <?php echo $form->labelEx($model->investment,'market_size'); ?>
                    <?php echo $form->textField($model->investment,'market_size'); ?>
                    <?php echo $form->error($model->investment,'market_size'); ?>
                </div>
                <div class="row">
                    <?$this->widget('crud.dropDownList',
                        array('model'=>$model->investment, 'attribute'=>'investment_form','elements'=>InvestmentProject::getInvestmentFormDrop(),
                            'options'=>array('multiple'=>false,'label'=>true)
                        ));?>
                    <?php echo $form->error($model->investment,'investment_form'); ?>
                </div>
                <div class="row">
                    <?php echo $form->labelEx($model->investment,'investment_direction'); ?>
                    <?php echo $form->textArea($model->investment,'investment_direction',array('class'=>'middle-textarea')); ?>
                    <?php echo $form->error($model->investment,'investment_direction'); ?>
                </div>
                <div class="row">
                    <?php echo $form->labelEx($model->investment,'financing_terms'); ?>
                    <?php echo $form->textArea($model->investment,'financing_terms',array('class'=>'middle-textarea')); ?>
                    <?php echo $form->error($model->investment,'financing_terms'); ?>
                </div>
            </div>
            <div class="inner-column">
                <h2><?= Yii::t('main','Производственный план')?></h2>
                <div class="row">
                    <?php echo $form->labelEx($model->investment,'products'); ?>
                    <?php echo $form->textArea($model->investment,'products',array('class'=>'middle-textarea')); ?>
                    <?php echo $form->error($model->investment,'products'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model->investment,'max_products'); ?>
                    <?php echo $form->textArea($model->investment,'max_products',array('class'=>'middle-textarea')); ?>
                    <?php echo $form->error($model->investment,'max_products'); ?>
                </div>
                <h2><?= Yii::t('main','Финансовый план')?></h2>

                <div class="row">
                    <?php echo $form->labelEx($model->investment,'no_finRevenue'); ?>
                    <?php echo $form->textField($model->investment,'no_finRevenue'); ?>
                    <?php echo $form->error($model->investment,'no_finRevenue'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model->investment,'no_finCleanRevenue'); ?>
                    <?php echo $form->textField($model->investment,'no_finCleanRevenue'); ?>
                    <?php echo $form->error($model->investment,'no_finCleanRevenue'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model->investment,'profit'); ?>
                    <?php echo $form->textField($model->investment,'profit'); ?>
                    <?php echo $form->error($model->investment,'profit'); ?>
                </div>

            </div>
            <div class="clear"></div>
            <div class="button-panel center">
                <?=CHtml::submitButton($model->isNewRecord ? Yii::t('main','Создать') : Yii::t('main','Сохранить'),array('class'=>'btn'))?>
            </div>
        </div>
        <?php if(!isset($admin)):?>
            <?php $this->endWidget(); ?>
        <?php endif;?>

    </div>
</div>