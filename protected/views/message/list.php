<?php
/**
 * Единый центр со списком сообщений, входящих или исходящих
 * @var MessageController $this
 * @var Message[] $models
 */
$action = $this->actionName;  # inbox или sent
if($action == 'sent'){
    $detailLink = 'message/view';
    $userRelation = 'userTo';
}
elseif($action == 'inbox'){
    $detailLink = 'message/detail';
    $userRelation = 'userFrom';
}
?>
<?$this->widget('CLinkPager', array('pages'=>$pages));?>
<div class="main-column">
    <div class="full-column opacity-box overflow">
        <?if(!empty($models)):?>
            <div class="row">
                <a href="#" class="btn delete-message"><?= Yii::t('main','Удалить выбранные')?></a>
            </div>
        <?endif?>
        <div class="table-header">
            <span class="user-info"><?= $action != 'sent' ? Yii::t('main','От кого') :  Yii::t('main','Кому')?></span>
            <span><?= Yii::t('main','Тема письма')?></span>
        </div>
        <div class="row message list clear">
            <?if(empty($models)):?>
                <p><?= Yii::t('main','Сообщений нет')?></p>
            <?endif?>
            <table>
            <?foreach($models as $model):?>
                <tr class="item <?if($model->is_read==0 && $action != 'sent'):?>new<?endif;?>">
                    <td class="user-info">
                        <?=Crud::checkBox('',false,array('value'=>$model->id))?>
                        <span class="from">
                           <?=$model->$userRelation->name?>
                        </span>
                    </td>
                    <td>
                        <a class="subject full-td" href="<?=$this->createUrl($detailLink,array('id'=>$model->id))?>">
                            <?=$model->subject?>
                        </a>
                    </td>
                </tr>
            <?endforeach?>
            </table>
        </div>
        <?if(!empty($models)):?>
            <div class="row">
                <a href="#" class="btn delete-message"><?= Yii::t('main','Удалить выбранные')?></a>
            </div>
        <?endif?>
        <div class="clear"></div>
    </div>
</div>
<?$this->widget('CLinkPager', array('pages'=>$pages,));?>
<?=CHtml::hiddenField('action',$this->actionName,array('id'=>'action-name'))?>