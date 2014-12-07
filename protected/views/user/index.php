<?php
/**
 * @var UserController $this
 * @var CActiveForm $form
 */
?>

<div class="user-index-page">
    <div id="general">
        <div class="main bread-block">
            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'links'=>array(Yii::t('main','Проекты')=>$this->createUrl('project/index'),'Страница инициатора'),
                'htmlOptions' => array('class'=>'breadcrumb'),
                'homeLink'=>CHtml::link('Главная','/',array('class'=>'normal')),
                'separator'=>''
            )); ?>
        </div>

        <div class="content list-columns columns">
            <div class="side-column">
                <div class="base-block opacity-box relative">
                    <div id="logo_block" class="profile-image">
                        <span class="rel">
                            <?=Candy::preview(array($this->user->logo, 'scale' => '102x102'))?>
                        </span>
                    </div>
                    <div class="profile-text"><?= $this->user->name?></div>
                    <?$types = User::getUserType();?>
                    <div class="profile-name"><?= $types[$this->user->type]?></div>
                    <!--a class="btn" href="#"><?= Yii::t('main','изменить профиль')?></a>
                    <div>Баланс: 10 000 руб</div>
                    <a class="btn" href="#"><?= Yii::t('main','пополнить')?></a-->
                </div>
                <div class="opacity-box">
                    <h1><?= Yii::t('main','Тип площадок')?></h1>
                    <div class="side-menu-list">
                        <?
                        $sideMenu = array(
                            Project::T_INFRASTRUCT => Yii::t('main', 'Инфраструктурные'),
                            Project::T_INNOVATE => Yii::t('main', 'Иновационные'),
                            Project::T_INVEST => Yii::t('main', 'Инвестиционные'),
                            Project::T_SITE => Yii::t('main', 'Инвестиционные площадки'),
                            Project::T_BUSINESS => Yii::t('main', 'Бизнес'),
                        );
                        foreach ($sideMenu as $type => $name) {
                            $params = $_GET;
                            unset($params['page']);
                            if (empty($params['hide'][$type])) {
                                $params['hide'][$type] = $type;
                            } else {
                                unset($params['hide'][$type]);
                            }
                            ?>
                            <div class="side-menu-item overflow blue-label">
                                <?=Crud::checkBox("hide[$type]",empty($_GET['hide'][$type]),array('disabled' => true)) . CHtml::link($name, $this->createUrl('', $params))?>
                            </div>
                        <?}?>
                    </div>
                </div>
            </div>
            <div class="main-column">
                <div class="full-column" style="height: 290px; margin-bottom: 20px; padding: 0;">
                    <div id="chart" style="width: 322px;height: 290px;float: left;overflow: hidden;border-radius: 4px;">
                        <img src="/images/assets/chart.png">
                    </div>
                    <div class="box dark user-action-box bossy">
                        <div class="box inner">
                            <h1>Заказать услуги портала</h1>
                            <?= CHtml::link(Yii::t('main','Подобрать проект для инвестирования'),'#',array('class'=>'item'))?>
                            <?= CHtml::link(Yii::t('main','Подобрать инвесторов'),'#',array('class'=>'item'))?>
                            <?= CHtml::link(Yii::t('main','Подобрать кредит'),'#',array('class'=>'item'))?>
                            <?= CHtml::link(Yii::t('main','Задать вопрос юристу'),'#',array('class'=>'item'))?>
                        </div>
                    </div>
                </div>
                <div class="filter opacity-box">
                    <div class="pull-left condition">
                        <label>Сортировать по</label>
                        <select><option>Цене</option></select>
                    </div>
                    <div class="pull-right condition">
                        <label>Сортировать по</label>
                        <select><option>10</option></select>
                    </div>
                </div>
                <?$this->widget('CLinkPager', array('pages'=>$pages,));?>
                <? /*foreach($projects as $model) {
                    $this->renderPartial('projectItem/' . Project::$urlByType[$model->type], array('model' => $model));
                }*/?>
                <?foreach($data as $item):?>
                <div class="feed-item opacity-box">
                    <div class="top-stick"><?=FeedFilter::$type[$item['object_name']]?></div>
                    <div class="date"><?=Candy::formatDate($item['create_date'], 'd.m.Y H:m')?></div>
                    <a href="<?=$item['model']->createUrl()?>"><h2><?=$item['name']?></h2></a>
                    <hr>
                    <div class="feed-info">
                        <?if($item['object_name'] == 'project_comment'):?>
                            <div class="info-row">Добавлен новый комментарий</div>
                        <?endif?>
                        <?if($item['object_name'] == 'project_news'):?>
                            <div class="info-row">Добавлена новая <?=CHtml::link('новость', $item['alt_model']->createUrl())?></div>
                        <?endif?>
                    </div>
                    <div class="feed-data">
                        <?=$item['text']?>
                    </div>
                    <!--a class="comment-link" href="#"><i class="icon icon-balloon"><span>15</span></i> коммент.</a-->
                </div>
                <?endforeach?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>