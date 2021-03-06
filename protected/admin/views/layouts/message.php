<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/adminLayout'); ?>
<?
/**
 * @var $this MessageController
 */
Yii::app()->clientScript->registerScript('init', 'messagePart.init("admin");', CClientScript::POS_READY);
Yii::app()->clientScript->registerPackage('jquery.ui');
$statistic = array('user'=>Message::getUnreadCount('admin'),'system'=>Message::getUnreadCount('system'));
$action = Yii::app()->controller->action->id;
?>

    <style>
        .red-box {
            background: #F00;
            font-size: 12px;
            line-height: 20px;
            width: 120px;
        }
    </style>
    <div id="general" class="message-page">
        <div class="content columns">
            <div class="side-column opacity-box">
                <h1><?= Yii::t('main','Мои сообщения')?></h1>

                <div class="side-menu-list">
                    <div class="side-menu-item">
                        <a class="<?if($action=='inbox' && empty($_GET['system'])):?>active<?php endif;?>" href="<?=$this->createUrl('adminMessages/inbox')?>"><i class="icon icon-inbox"></i><?= Yii::t('main','Входящие')?></a>

                        <?php if($statistic['user']>0):?>
                            <div class="new-count icon icon-blue-circle"><?=$statistic['user']?></div>
                        <?php endif;?>
                    </div>
                    <div  class="side-menu-item">
                        <a  class="<?if($action=='create'):?>active<?php endif;?>" href="<?=$this->createUrl('adminMessages/create')?>"><i class="icon icon-write"></i><?= Yii::t('main','Написать')?></a>
                    </div>
                    <div class="side-menu-item">
                        <a class="<?if($action=='sent'):?>active<?php endif;?>" href="<?=$this->createUrl('adminMessages/sent')?>">
                            <i class="icon icon-outbox"></i><?= Yii::t('main','Отправленные')?>
                        </a>
                    </div>
                    <div class="side-menu-item">
                        <a class="<?if($action=='recycle'):?>active<?php endif;?>" href="<?=$this->createUrl('adminMessages/recycle')?>">
                            <i class="icon icon-trash"></i><?= Yii::t('main','Корзина')?>
                        </a>
                    </div>
                </div>
            </div>
            <?php echo $content; ?>
        </div>
    </div>
<?php $this->endContent(); ?>