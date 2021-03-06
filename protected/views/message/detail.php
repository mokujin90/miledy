<?
/**
 * @var $this MessageController
 * @var $model Message
 * @var $answer Message
 * @var $form CActiveForm
 */
$admin = Candy::get($admin,false);
$action = Yii::app()->controller->action->id;
$isSystem = is_null($model->user_from && $model->admin_type!=null) || is_null($model->user_to);
Yii::app()->clientScript->registerScript('init', 'messagePart.init();', CClientScript::POS_READY);

?>
<style>
    .overlay.sending {
        background: rgba(0,0,0,0.5);
        width: 100%;
        height: 100%;
        position: absolute;
        z-index: 100;
        border-radius: 2px;
    }
    #wrapper, #main-container {
        min-height: 400px !important;
    }
    #breadcrumb {
        position: fixed;
        width: 100%;
        z-index: 1;
        background: #f9f9f9;
    }
    .panel-tab {
        position: fixed;
        width: 100%;
        margin-top: 39px;
        z-index: 1;
    }
    .headline{
        position: fixed;
        margin-top: 76px;
        padding: 10px 15px 10px 10px;
        width: 100%;
        z-index: 1;
        background: #FFF;
    }
    .portal-deal-active .headline{
        margin-top: 121px;
    }
    .portal-deal-wrapper{
        display: none;
        position: fixed;
        width: 100%;
        margin-top: 76px;
        z-index: 32;
        padding: 5px;
        background: #FFFFFF;
        border-bottom: 1px solid #EEE;
    }
    .portal-deal-active .portal-deal-wrapper{
        display: block;
    }
    .portal-deal{
        padding: 8px 30px 8px 8px;
        margin: 0;
        float: left;
    }
    .portal-deal.alert .refresh-button{
        top: 8px;
    }
    .no-title-margin{
        margin-top: 60px;
    }
    .title-margin{
        margin-top: 100px;
    }
    .portal-deal-margin{
        margin-top: 140px;
    }
</style>
<div class="panel-tab clearfix" style="border-bottom: 1px solid #eee;">
    <ul class="tab-bar">
        <li <?=$dialog->type == 'chat' ? 'class="active"' : ''?>><a href="/message/inbox/"><i class="fa fa-home fa-fw"></i> Диалоги</a></li>
        <li <?=$dialog->type == 'project' ? 'class="active"' : ''?>><a href="/message/inbox/type/project"><i class="fa fa-file fa-fw"></i> Обсуждения</a></li>
        <li <?=$dialog->type == 'admin' ? 'class="active"' : ''?>><a href="/message/inbox/type/admin"><i class="fa fa-dollar fa-fw"></i> Услуги</a></li>
    </ul>
</div>
<?if(($dialog->type == 'project' && $dialog->project) || $dialog->type == 'admin'):?>
    <?php $dealMessage = ($dialog->type == 'project' && empty($_COOKIE['deal_help_hide']));?>
    <div class="top-header <?=$dealMessage? 'portal-deal-active' : ''?>">
        <div class="portal-deal-wrapper">
            <div class="alert alert-danger hide-wrapper portal-deal" style="position: relative;">
                Портал оказывает услугу сопровождение сделки
                <div class="refresh-button hide-block" data-cookie="deal_help_hide">
                    <i class="fa fa-close"></i>
                </div>
            </div>
        </div>
            <h4 class="headline">
                Тема: <?=$dialog->type == 'project' ? $dialog->project->name : $dialog->subject?>
                <span class="line"></span>
            </h4>
    </div>
<?endif?>
<?php
    if($dialog->type != 'chat'){
        $classMargin = 'title-margin';
        if($dealMessage){
            $classMargin .= ' portal-deal-margin';
        }
    } else {
        $classMargin = 'no-title-margin';
    }
?>
<div class="padding-md <?=$classMargin;?>" id="message-wrapper">
    <div class="chat-message" style="padding-bottom: 120px;">
        <ul class="chat">
            <?=CHtml::hiddenField('',$model->create_date, array('id' => 'update-ajax-time'));?>
            <?$this->renderPartial('_messages', array('models' => $models))?>
            <div id="new-ajax-message"></div>
        </ul>
        <?if($dialog->type == 'project') :?>
            <? $deal = $dialog->getDialForm();?>
            <?if(!is_null($deal)):?>
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'deal-form',
                        'enableAjaxValidation'=>false,
                        'htmlOptions' => array('class' => 'form-group'),
                        'action'=>$this->createUrl('message/deal')
                    )); ?>
                    <div class="alert alert-info margin-sm">
                        <?=$deal['text']?>
                        <div class="pull-right" style="margin-top: -2px;">
                            <?foreach($deal['action'] as $action => $text) {
                                echo CHtml::tag('button', array('class'=>"btn btn-xs btn-success", 'value' => $action, 'name' => 'action_id', 'type' => 'submit'), $text);
                            }?>
                        </div>
                    </div>

                    <?=CHtml::hiddenField('dialog_id', $dialog->id)?>
                    <?php $this->endWidget(); ?>
            <?endif?>
        <?endif?>
    </div>

    <div class="chat-panel panel panel-default fixed-chat-panel">
        <div class="overlay sending hidden"></div>
        <div class="panel-heading">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'message-form',
                'enableAjaxValidation'=>false,
                'htmlOptions' => array('class' => 'form-group'),
                'action'=>$this->createUrl($admin ? 'adminMessages/create' : 'message/create')
            )); ?>
                    <div class="hidden">
                    <?=$form->textField($answer,'subject',array('class'=>'form-control', 'placeholder' => 'Заголовок'))?>
                    <?=Candy::error($answer,'subject')?>
                    <br>
                    </div>
                    <?=$form->textArea($answer, 'text', array('style' => 'resize: none;', 'class' => 'form-control reply-message-textarea', 'placeholder' => 'Текст'))?>
                    <?=Candy::error($answer,'text')?>
                    <br>
                    <div class="button-panel">

                        <?=CHtml::ajaxSubmitButton(Yii::t('main','Отправить'), $this->createUrl('message/create'), array('success' => 'messagePart.successAjax'),array('class'=>"btn pull-right", 'onclick' => '$(".overlay.sending").removeClass("hidden");'));?>
                        <?=$this->renderPartial('application.views.message._uploadBootstrap',array('model'=>$model))?>

                        <div id="document_block">

                        </div>
                    </div>

                <?=$form->hiddenField($answer,'admin_type')?>
                <?=$form->hiddenField($answer,'user_to')?>
                <?=$form->hiddenField($answer,'dialog_id')?>
                <?php if(!empty($model->project_id)):?>
                    <?= CHtml::hiddenField('Message[project_id]',$model->project_id)?>
                <?php endif;?>
                <?php if(!empty($model->admin_type)):?>
                    <?= CHtml::hiddenField('Message[admin_type]',$model->admin_type)?>
                <?php endif;?>

            <?php $this->endWidget(); ?>
        </div>
            <!-- /.panel-body -->
    </div>

</div>