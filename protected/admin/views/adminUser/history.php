<?php
/**
 *
 * @var AdminUserController $this
 * @var array $data
 * @var User $user
 */
Yii::app()->clientScript->registerScript('history', 'historyPart.init();', CClientScript::POS_READY);
?>
<div class="padding-md">
    <div class="panel panel-default table-responsive">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'region-content-form',
            'enableAjaxValidation'=>false,
        )); ?>
            <div class="panel-heading">
                Пользователь: <?=$user->name?>
            </div>
            <div id="history" class="content columns">
                <div class="main-column">
                    <div class="full-column opacity-box overflow" style="padding: 30px;">
                        <div class="row project list">
                            <?if(empty($data)):?>
                                <p>Список пуст</p>
                            <?else:?>
                                <table class="table table-striped table-hover">
                                        <thead>
                                            <th><?= Yii::t('main','Тип транзакции')?></th>
                                            <th><?= Yii::t('main','Разница')?></th>
                                            <th><?= Yii::t('main','Дата')?></th>
                                            <th><?= Yii::t('main','Описание')?></th>
                                            <th><?= Yii::t('main','Отменить')?></th>
                                        </thead>
                                    <?foreach($data as $item):?>
                                        <tr class="item">
                                            <td><?=BalanceHistory::getType($item['object_type'])?></td>
                                            <td><?=$item['delta']?></td>
                                            <td><?=$item['date']?></td>
                                            <td><?=$item['description']?></td>
                                            <td>
                                                <?php if($item['object_type']=='retention'):?>
                                                    <?=CHtml::link(Yii::t('main','Вернуть'),array('unretention','id'=>$item['id']))?>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                    <?endforeach?>
                                </table>
                            <?endif?>
                        </div>
                        <div class="row">
                            <b>Итого: <?=Balance::get($user->id)->value?></b>
                        </div>
                        <div class="row buttons text-center">
                           <?=CHtml::link(Yii::t('main','Добавить'),'#add-content',array('class'=>'btn balance btn-success'))?>
                           <?=CHtml::link(Yii::t('main','Списать'),'#sub-content',array('class'=>'btn  balance btn-danger'))?>
                           <?=CHtml::link(Yii::t('main','Зарезервировать'),'#retention-content',array('class'=>'btn balance btn-warning'))?>
                        </div>
                    </div>
                </div>
            </div>
        <? $this->endWidget(); ?>
        <div id="add-content" style="display: none;" class="padding-md panel panel-default">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'action'=>$this->createUrl('add'),
                'htmlOptions'=>array('class'=>'auth-form form-horizontal no-margin form-border')
            )); ?>
            <div class="row text-center">
                Добавить средств на счет
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('cost','',array('class' => 'form-control', 'placeholder'=>Yii::t('main','Сумма')))?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('description','',array('class' => 'form-control', 'placeholder'=>Yii::t('main','Описание')))?>
            </div>
            <?php echo CHtml::hiddenField('userId',$user->id)?>

            <div class="data form-group">
               <?php echo CHtml::submitButton('Добавить средства',array('class'=>'btn'))?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
        <div id="sub-content" style="display: none;" class="padding-md panel panel-default">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'action'=>$this->createUrl('sub'),
                'htmlOptions'=>array('class'=>'auth-form form-horizontal no-margin form-border')
            )); ?>
            <div class="row text-center">
                Списать средства со счета
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('cost','',array('class' => 'form-control', 'placeholder'=>Yii::t('main','Сумма')))?>
            </div>
            <div class="form-group">
                <?php echo CHtml::textField('description','',array('class' => 'form-control', 'placeholder'=>Yii::t('main','Описание')))?>
            </div>
            <?php echo CHtml::hiddenField('userId',$user->id)?>

            <div class="data form-group">
                <?php echo CHtml::submitButton('Списать средства',array('class'=>'btn'))?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
        <div id="retention-content" style="display: none;" class="padding-md panel panel-default">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'action'=>$this->createUrl('retention'),
                'htmlOptions'=>array('class'=>'auth-form form-horizontal no-margin form-border')
            )); ?>
                <div class="row text-center">
                    Зарезервировать средства со счета
                </div>
                <div class="form-group">
                    <?php echo CHtml::textField('cost','',array('class' => 'form-control', 'placeholder'=>Yii::t('main','Сумма')))?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::textField('description','',array('class' => 'form-control', 'placeholder'=>Yii::t('main','Описание')))?>
                </div>
                <?php echo CHtml::hiddenField('userId',$user->id)?>

                <div class="data form-group">
                    <?php echo CHtml::submitButton('Зарезервировать средства',array('class'=>'btn'))?>
                </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>