<div class="padding-md">
    <?php
    /**
     *
     * @var AdminUserController $this
     * @var User $model
     * @var array $params
     * @var CActiveForm $form
     */
    Yii::app()->clientScript->registerScript('init', 'userProfilePart.init();', CClientScript::POS_READY);
    $types = User::getUserType();
    Yii::app()->clientScript->registerCssFile('/css/vendor/jquery-ui.min.css');
    ?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-form',
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('id' => 'formToggleLine', 'class' => 'form-horizontal no-margin form-border')
    )); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                Контактное лицо
            </div>
            <div class="panel-body">
                <?php if($model->isNewRecord):?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'login', array('class' => 'col-lg-2 control-label')); ?>
                        <div class="col-lg-10">
                            <?php echo $form->textField($model,'login',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'login'); ?>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
                <?else:?>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <?=CHtml::link('Все проекты',array('adminProject/index','Project[user_id]'=>$model->id),array('target'=>'_blank','class'=>'btn btn-success'))?>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
                <?php endif;?>
                <div class="form-group">
                    <div id="logo_block" class="profile-image col-lg-2">
                                <span class="rel">
                                    <?=Candy::preview(array($model->logo, 'scale' => '102x102', 'class' => 'img-circle'))?>
                                    <?php echo CHtml::hiddenField('logo_id',$model->logo_id)?>
                                </span>
                    </div>
                    <div class="col-lg-10">

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
                        <div class="open-dialog load-action btn btn-success"><?= Yii::t('main','Загрузить логотип')?></div>
                        <span class="help-block"> Рекомендуемые параметры: Размер не менее 100х100. Пропорции сторон 1 к 1</span>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'name', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'name'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <label class="col-lg-2 control-label">Регион</label>
                    <div class="col-lg-10">
                        <?$this->widget('crud.dropDownList',
                            array(
                                'model'=>$model,'attribute'=>'region_id',
                                'elements'=>Region::getDrop(),
                                'options'=>array('multiple'=>false),
                            ));?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'contact_address', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textArea($model,'contact_address',array('class' => 'form-control')); ?>
                        <?php echo $form->error($model,'contact_address'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'post', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textField($model,'post',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'post'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'phone', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'phone'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'fax', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textField($model,'fax',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'fax'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'contact_email', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->emailField($model,'contact_email',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'contact_email'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Yii::t('main','Управление аккаунтом')?>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'email', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'email'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <label class="col-lg-2 control-label"><?= Yii::t('main','Подписка')?></label>
                    <div class="col-lg-10">
                        <label class="label-checkbox inline">
                            <?php echo $form->checkBox($model,'is_subscribe'); ?>
                            <span class="custom-checkbox"></span>
                        </label>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <label class="col-lg-2 control-label"><?= Yii::t('main','Какие регионы интересны')?></label>
                    <div class="col-lg-10">
                        <?$this->widget('crud.dropDownList',
                            array(
                                'elements'=>Region::getDrop(),
                                'selected'=>CHtml::listData($model->user2Regions,'region_id','region_id'),
                                'options'=>array('multiple'=>true,'placeholder'=>Yii::t('main','Регионы'),'useButton'=>true,),
                                'name'=>'user2region'
                            ));?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Yii::t('main','Управление паролями')?>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'old_password', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?=CHtml::passwordField('User[old_password]','', array('class' => 'form-control'))?>
                        <?php echo $form->error($model,'old_password'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'password', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?=CHtml::passwordField('User[password]','', array('class' => 'form-control'))?>
                        <?php echo $form->error($model,'password'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'password_repeat', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?=CHtml::passwordField('User[password_repeat]','', array('class' => 'form-control'))?>
                        <?php echo $form->error($model,'password_repeat'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
            </div>
        </div>

        <div class="panel panel-default" style="<?if($model->type!='investor'):?>display:none<?endif;?>" id="investor-block">
            <div class="panel-heading">
                <?= Yii::t('main','Сведенья об инвесторе')?>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-lg-2 control-label"><?= Yii::t('main','Страна')?></label>
                    <div class="col-lg-10">
                        <?$this->widget('crud.dropDownList',
                            array('model'=>$model, 'attribute'=>'investor_country_id','elements'=>Country::getDrop(),
                                'options'=>array('multiple'=>false),
                            ));?>
                        <?php echo $form->error($model,'investor_country_id'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <label class="col-lg-2 control-label"><?= Yii::t('main','Тип')?></label>
                    <div class="col-lg-10">
                        <?$this->widget('crud.dropDownList',
                            array('model'=>$model, 'attribute'=>'investor_type','elements'=>Project::getObjectTypeDrop(),
                                'options'=>array('multiple'=>false),
                            ));?>
                        <?php echo $form->error($model,'investor_type'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->

                <div class="form-group">
                    <label class="col-lg-2 control-label"><?= Yii::t('main','Отрасль')?></label>
                    <div class="col-lg-10">
                        <?$this->widget('crud.dropDownList',
                            array('model'=>$model, 'attribute'=>'investor_industry','elements'=>Project::getIndustryTypeDrop(),
                                'options'=>array('multiple'=>false),
                            ));?>
                        <?php echo $form->error($model,'investor_industry'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'investor_finance_amount', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textField($model,'investor_finance_amount',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'investor_finance_amount'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Yii::t('main','Компания')?>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'company_form', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textField($model,'company_form',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'company_form'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'company_name', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textField($model,'company_name',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'company_name'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'company_description', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textArea($model,'company_description',array('class' => 'form-control')); ?>
                        <?php echo $form->error($model,'company_description'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'company_address', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textField($model,'company_address',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'company_address'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'company_form', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textField($model,'company_form',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'company_form'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'company_scope', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?$this->widget('crud.dropDownList',
                            array('model'=>$model, 'attribute'=>'company_scope','elements'=>Project::getIndustryTypeDrop(),
                                'options'=>array('multiple'=>false),
                            ));?>
                        <?php echo $form->error($model,'company_scope'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'inn', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textField($model,'inn',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'inn'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'ogrn', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo $form->textField($model,'ogrn',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                        <?php echo $form->error($model,'ogrn'); ?>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
            </div>
        </div>
    <?=CHtml::submitButton('Сохранить',array('class'=>'btn btn-success btn-sm'))?>
    <? $this->endWidget(); ?>
</div>

