<div class="col-xs-12">

    <div class="form-group" style="overflow: visible;">
        <?php echo $form->labelEx($model->content,'industryFormat', array('class' => "col-xs-12 col-sm-4 control-label")); ?>
        <div class="col-xs-12 col-sm-8">
            <?=$form->dropDownList($model->content,'industryFormat',ReferenceIndustry::getList(),array('multiple'=>true,'class'=>'chosen','placeholder'=>Yii::t('main','Отраcли')))?>
            <?php echo $form->error($model->content,'industryFormat'); ?>
        </div>
    </div>
    <?php if(false):?>
    <!--div class="form-group">
        <?php echo $form->labelEx($model->content, 'social_overview', array('class' => "col-xs-12 col-sm-4 control-label")); ?>
        <div class="col-xs-12 col-sm-8">
            <?php echo $form->textArea($model->content, 'social_overview', array('rows' => 6, 'cols' => 50, 'class' => 'ckeditor')); ?>
            <?php echo $form->error($model->content, 'social_overview'); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model->content, 'social_natural_resources', array('class' => "col-xs-12 col-sm-4 control-label")); ?>
        <div
            class="col-xs-12 col-sm-8"><?php echo $form->textArea($model->content, 'social_natural_resources', array('rows' => 6, 'cols' => 50, 'class' => 'ckeditor')); ?>
            <?php echo $form->error($model->content, 'social_natural_resources'); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model->content, 'social_ecology', array('class' => "col-xs-12 col-sm-4 control-label")); ?>
        <div
            class="col-xs-12 col-sm-8"><?php echo $form->textArea($model->content, 'social_ecology', array('rows' => 6, 'cols' => 50, 'class' => 'ckeditor')); ?>
            <?php echo $form->error($model->content, 'social_ecology'); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model->content, 'social_population', array('class' => "col-xs-12 col-sm-4 control-label")); ?>
        <div
            class="col-xs-12 col-sm-8"><?php echo $form->textArea($model->content, 'social_population', array('rows' => 6, 'cols' => 50, 'class' => 'ckeditor')); ?>
            <?php echo $form->error($model->content, 'social_population'); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model->content, 'social_economy', array('class' => "col-xs-12 col-sm-4 control-label")); ?>
        <div
            class="col-xs-12 col-sm-8"><?php echo $form->textArea($model->content, 'social_economy', array('rows' => 6, 'cols' => 50, 'class' => 'ckeditor')); ?>
            <?php echo $form->error($model->content, 'social_economy'); ?>
        </div>
    </div-->
    <?php endif;?>
</div>