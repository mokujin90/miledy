<?php
    /* @var $this BaseController */
    Yii::app()->clientScript->registerCssFile('/css/normalize.css');
    Yii::app()->clientScript->registerCssFile('/css/style.css');
    Yii::app()->clientScript->registerCssFile('/css/vendor/jquery.fancybox.css');


    #JS
    Yii::app()->clientScript->registerScriptFile('/js/vendor/modernizr-2.6.2.min.js', CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerPackage('jquery.ui');
    Yii::app()->clientScript->registerCoreScript('ckeditor');
    Yii::app()->clientScript->registerCoreScript('sroller');
    Yii::app()->clientScript->registerScriptFile('/js/plugins.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile('/js/vendor/jquery.fancybox.pack.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile('/js/components.js', CClientScript::POS_END); //js-файл с основными компонентами-синглтонами
    Yii::app()->clientScript->registerScriptFile('/js/main.js', CClientScript::POS_END); //js-скрипт для внешней части сайта
    Yii::app()->clientScript->registerScriptFile('/js/confirmDialog.js', CClientScript::POS_END);
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="language" content="ru" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= CHtml::encode($this->pageTitle); ?></title>
        <meta name="description" content="">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    </head>
    <body>
        <style>
            #general {
                height: 100%;
                width: 1000px;
                margin: 0 auto;
            }
            footer{
                height: 262px;
            }
            #wrap{
                margin-bottom: -266px;
            }
        </style>
        <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div id="wrap">
            <div class="primary">
                <header>
                    <div id="bar-block">
                        <div class="main chain-block">
                            <?if(Yii::app()->user->isGuest):?>
                                <div class="item login point">
                                    <span>
                                        <?=CHtml::link(Yii::t('main','Войти'),'#auth-content',array('class'=>'auth-fancy'))?>
                                    </span>
                                     <span>
                                        <?=CHtml::link(Yii::t('main','Регистрация'),$this->createUrl('user/register'))?>
                                    </span>
                                </div>
                            <?else:?>
                                <div class="menu-slide item avatar point">
                                    <?=Candy::preview(array($this->user->logo, 'scale' => '26x26'))?>
                                    <span><?=$this->user->login?></span>
                                    <i class="icon icon-arrow"></i>
                                    <div class="dark slide">
                                        <?php echo CHtml::link(Yii::t('main','Лента'),array('user/index'),array())?>
                                        <?php echo CHtml::link(Yii::t('main','Профиль'),array('user/profile'),array())?>
                                        <?php echo CHtml::link(Yii::t('main','Проекты'),array('user/projectList'),array())?>
                                        <?php echo CHtml::link(Yii::t('main','Реклама'),array('banner/index'),array())?>
                                        <?php echo CHtml::link(Yii::t('main','Выйти'),array('user/logout'),array())?>
                                    </div>
                                </div>
                            <?endif;?>
                                <div id="my-project" class="menu-slide item project point">
                                    <?if(!Yii::app()->user->isGuest):?>
                                        <i class="icon icon-my-project"></i>
                                        <span><?= Yii::t('main','Мои проекты')?></span>
                                        <i class="icon icon-arrow"></i>
                                        <div class="box dark slide">
                                            <?$myProject = $this->user->projects;?>
                                            <div class="box inner">
                                                <div class="data">
                                                    <span class="count"><?=count($myProject)?></span>
                                                    <span class="header"><?= Yii::t('main','Выбор проекта')?></span>
                                                </div>
                                                <hr/>
                                                <div class="project-list">
                                                    <?foreach($myProject as $project):?>
                                                        <a data-project="<?=$project->id?>" data-status="<?=$project->getCompleteRank()?>" href="<?=$this->createUrl('project/detail',array('id'=>$project->id))?>" class="item <?if($project->complete==100):?>active<?endif;?>">
                                                            <?=Candy::preview(array($project->logo,'scale'=>'55x55','class'=>'project-logo'))?>

                                                            <span class="text"><?= CHtml::encode($project->name)?></span>
                                                        </a>
                                                    <?endforeach;?>
                                                </div>
                                            </div>
                                            <div class="status-block chain-block">
                                                <span class="text"><?= Yii::t('main','Степень выполнености')?></span>
                                                <div class="status-widget">
                                                    <div class="rank"></div>
                                                    <div class="rank"></div>
                                                    <div class="rank"></div>
                                                    <div class="rank"></div>
                                                    <div class="rank"></div>
                                                    <div class="rank"></div>
                                                    <div class="rank"></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?endif;?>
                                </div>
                                <a class="item favorites point" href="<?=$this->createUrl('user/favoriteList')?>">
                                    <?if(!Yii::app()->user->isGuest):?>
                                        <i class="icon icon-favorites"></i>
                                        <span><?= Yii::t('main','Избранное')?></span>
                                        <i class="icon icon-arrow"></i>
                                    <?endif;?>
                                </a>
                                <a class="item message point" href="<?=$this->createUrl('message/inbox')?>">
                                    <?if(!Yii::app()->user->isGuest):?>
                                        <i class="icon icon-balloon"><span><?=Message::getUnreadCount('all')?></span></i>
                                        <span><?= Yii::t('main','Сообщения')?></span>
                                        <i class="icon icon-arrow"></i>
                                    <?endif;?>
                                </a>
                                <?php $form=$this->beginWidget('CActiveForm', array(
                                    'action' => $this->createUrl('site/search'),
                                    'method' => 'get',
                                    'htmlOptions'=>array('class'=>'search-form'))); ?>
                                <div class="search chain-block">
                                    <?= CHtml::textField('search',$this->globalSearch)?>
                                    <div class="button"><?= CHtml::submitButton('',array('class'=>'image icon icon-search-gray', 'name' => ''))?></div>
                                </div>
                                <?php $this->endWidget(); ?>
                                <div id="language-list">
                                    <?php if($this->currentLanguage==BaseController::L_RUSSIA):?>
                                        <?= CHtml::link('RU<i class="icon icon-stick-down"></i>','#',array('class'=>'item active'))?>
                                        <?= CHtml::link('EN',array('site/changeLang','langId'=>BaseController::L_ENGLISH),array('class'=>'item hide'))?>
                                    <?php else:?>
                                        <?= CHtml::link('EN<i class="icon icon-stick-down"></i>','#',array('class'=>'item active'))?>
                                        <?= CHtml::link('RU',array('site/changeLang','langId'=>BaseController::L_RUSSIA),array('class'=>'item hide'))?>

                                    <?php endif;?>

                                </div>
                        </div>
                    </div>
                    <div id="logo-block">
                        <div class="main chain-block">
                            <a href="/"><?= CHtml::image('/images/markup/logo.png','',array('class'=>'logo'))?></a>
                            <div class="subscribe-block">
                                <?if(Yii::app()->user->isGuest):?>
                                <div class="header"><?= Yii::t('main','Подпишитесь!')?></div>
                                <div class="text"><?= Yii::t('main','Вы сможите получать самые актуальные данные инвест проектов')?></div>
                                <?else:?>
                                <div class="header"></div> <div class="text"></div>
                                <?endif;?>
                                <div class="subscribe-panel chain-block">
                                    <?php if(Yii::app()->user->isGuest):?>
                                        <?php $form=$this->beginWidget('CActiveForm', array(
                                            'htmlOptions'=>array('class'=>'subscribe-form form'))); ?>
                                        <?= CHtml::emailField('Subscribe[email]','',array('placeholder'=>Yii::t('main','введите e-mail')))?>
                                        <?= CHtml::submitButton(Yii::t('main','Подписаться'),array('class'=>'btn guest-subscribe'))?>
                                        <?php $this->endWidget(); ?>
                                    <?php endif;?>
                                    <ul class="social">
                                        <li><?= CHtml::link('','#',array('class'=>'icon icon-facebook'))?></li>
                                        <li><?= CHtml::link('','#',array('class'=>'icon icon-twitter'))?></li>
                                        <li><?= CHtml::link('','#',array('class'=>'icon icon-tumblr'))?></li>
                                        <li><?= CHtml::link('','#',array('class'=>'icon icon-odnoklassniki'))?></li>
                                        <li><?= CHtml::link('','#',array('class'=>'icon icon-vk'))?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="light-gray-gradient" id="nav-block">
                        <div class="main chain-block">
                            <div class="menu chain-block">
                                <div class="item"><?=CHtml::link(Yii::t('main','Контакты'), $this->createUrl('site/Contacts'))?></div><i class="icon icon-separator-blue"></i>
                                <?if(Yii::app()->user->isGuest){?>
                                    <div class="item"><?=CHtml::link(Yii::t('main','Обратная связь'), "#feedback-content",array('class'=>'feedback-fancy'))?></div><i class="icon icon-separator-blue"></i>
                                <?}else{?>
                                    <div class="item"><?=CHtml::link(Yii::t('main','Обратная связь'), $this->createUrl('message/create/system/feedback'))?></div><i class="icon icon-separator-blue"></i>
                                <?}?>
                                <div class="item"><?=CHtml::link(Yii::t('main','О проекте'), $this->createUrl('site/About'))?></div><i class="icon icon-separator-blue"></i>
                                <div class="item"><?=CHtml::link(Yii::t('main','Команда'), $this->createUrl('site/Command'))?></div><i class="icon icon-separator-blue"></i>
                                <div class="item"><?=CHtml::link(Yii::t('main','Конкурсы'), $this->createUrl('support-innovation/tenders'))?></div>
                            </div>
                            <div class="place chain-block">
                                <div class="region">
                                    <span class="name"><?=$this->getCurrentArea($this->region->district_id)?></span>
                                </div>
                                <div id="city-drop" style="z-index:500" class=" crud drop single" ajax="">
                                    <div class="elements city">
                                        <img id="show-region-list" class="button-down" src="/images/markup/crud/show-select.png" alt="">
                                    </div>
                                    <div class="selected city">
                                        <div class="option" data-val="<?=$this->getCurrentRegion()?>">
                                            <label class="drop-label" for="#"><?=Region::model()->findByPk($this->getCurrentRegion())->name?></label>
                                        </div>
                                    </div>

                                    <div id="ajax-region-content" class="mCustomScrollbar" data-mcs-theme="dark">
                                    </div>
                                </div>

                                <?=CHtml::hiddenField('currentController',Yii::app()->controller->getId(),array('id'=>'current-controller'))?>
                                <?=CHtml::hiddenField('currentAction',Yii::app()->controller->getAction()->getId(),array('id'=>'current-action'))?>
                            </div>
                        </div>
                    </div>
                    <div class="dark-gray-gradient line bottom <?if($this->interface['slim_menu']):?>slim<?endif;?>" id="menu-block">
                        <div class="main">
                            <a class="item i1" href="<?=$this->createUrl('investor/index')?>">
                                <?= CHtml::image('/images/sprites/investition.png','',array('class'=>'picture'))?>
                                <div class="name"><?=Yii::t('main','Инвесторы')?></div>
                            </a>
                            <a class="item i2" href="<?=$this->createUrl('project/index')?>">
                                <?= CHtml::image('/images/sprites/project.png','',array('class'=>'picture'))?>
                                <div class="name"><?=Yii::t('main','Проекты')?></div>
                            </a>
                            <a class="item i3" href="<?=$this->createUrl('region/social')?>">
                                <?= CHtml::image('/images/sprites/region.png','',array('class'=>'picture'))?>
                                <div class="name"><?=Yii::t('main','О регионе')?></div>
                            </a>
                            <a class="item i4" href="<?=$this->createUrl('law/index')?>">
                                <?= CHtml::image('/images/sprites/law.png','',array('class'=>'picture'))?>
                                <div class="name"><?=Yii::t('main','Законодательство')?></div>
                            </a>
                            <a class="item i5" href="<?=$this->createUrl('site/AnalyticsAndNews')?>">
                                <?= CHtml::image('/images/sprites/analitik.png','',array('class'=>'picture'))?>
                                <div class="name"><?=Yii::t('main','Аналитика и новости')?></div>
                            </a>
                            <a class="item i6" href="<?=$this->createUrl('library/index')?>">
                                <?= CHtml::image('/images/sprites/library.png','',array('class'=>'picture'))?>
                                <div class="name"><?=Yii::t('main','Библиотека')?></div>
                            </a>
                        </div>
                    </div>
                </header>
                <div id="base">
                    <?= $content; ?>
                </div>
            </div>
        </div>
        <footer>
            <div class="dark-gray-gradient line top <?if($this->footerContent):?>lazy-content<?endif;?>">
                <?if($this->footerContent):?>
                    <?=$this->footerContent;?>
                <?endif;?>
            </div>
            <div class="data">
                <div class="main chain-block">
                    <div class="col category">
                        <div class="header"><?= Yii::t('main','Направления')?> <span class="separator"></span></div>
                        <div class="list">
                            <a href="<?=$this->createUrl('investor/index')?>"><div class="picture"><i class="icon icon-investition-min"></i></div><span class="text"><?= Yii::t('main','Инвесторы')?></span></a>
                            <a href="<?=$this->createUrl('project/index')?>"><div class="picture"><i class="icon icon-project-min"></i></div><span class="text"><?= Yii::t('main','Проекты')?></span></a>
                            <a href="<?=$this->createUrl('region/list')?>"><div class="picture"><i class="icon icon-region-min"></i></div><span class="text"><?= Yii::t('main','Регионы')?></span></a>
                            <a href="<?=$this->createUrl('law/index')?>"><div class="picture"><i class="icon icon-law-min"></i></div><span class="text"><?= Yii::t('main','Законодательство')?></span></a>
                            <a href="<?=$this->createUrl('site/AnalyticsAndNews')?>"><div class="picture"><i class="icon icon-analitik-min"></i></div><span class="text"><?= Yii::t('main','Аналитика и новости')?></span></a>
                            <a href="<?=$this->createUrl('library/index')?>"><div class="picture"><i class="icon icon-library-min"></i></div><span class="text"><?= Yii::t('main','Библиотека')?></span></a>
                        </div>
                    </div>
                    <div class="col sitemap">
                        <div class="header"><span class="empty"></span> <span class="separator"></span></div>
                        <div class="list">
                            <?= CHtml::link(Yii::t('main','Контакты'),array('site/Contacts'))?>
                            <?if(Yii::app()->user->isGuest){?>
                                <?= CHtml::link(Yii::t('main','Обратная связь'),"#feedback-content",array('class'=>'feedback-fancy'))?>
                            <?}else{?>
                                <?= CHtml::link(Yii::t('main','Обратная связь'),array('message/create/system/feedback'))?>
                            <?}?>
                            <?= CHtml::link(Yii::t('main','О проекте'),array('site/About'))?>
                            <?= CHtml::link(Yii::t('main','Команда'),array('site/Command'))?>
                        </div>
                        <hr/>
                        <?php $form=$this->beginWidget('CActiveForm', array(
                            'action' => $this->createUrl('site/search'),
                            'method' => 'get',
                            'htmlOptions'=>array('class'=>'search-form'))); ?>
                        <div class="search chain-block">
                            <?= CHtml::textField('search','', array('placeholder' => Yii::t('main', 'Поиск')))?>
                            <div class="button"><?= CHtml::submitButton('',array('class'=>'image icon icon-search-gray', 'name' => ''))?></div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                    <div class="contact col">
                        <div class="header"><?= Yii::t('main','Адрес')?> <span class="separator"></span></div>
                        <div class="text address">125468, г. Москва, Ленинградский пр., 49</div>
                        <div class="header"><?= Yii::t('main','Тел./Факс')?> <span class="separator display-320"></span></div>
                        <div class="text phone">+7 (495) 744-34-72</div>
                        <div class="header"><?= Yii::t('main','E-mail')?> <span class="separator display-320"></span></div>
                        <div class="text email"><?= CHtml::mailto('info@iip.ru','info@iip.ru')?></div>
                    </div>
                    <div class="subscribe col">
                        <?php if(Yii::app()->user->isGuest):?>
                            <div class="header"><?= Yii::t('main','Подписаться на рассылку')?> <span class="separator"></span></div>
                            <?php $form=$this->beginWidget('CActiveForm', array(
                                'htmlOptions'=>array('class'=>'subscribe-form form'))); ?>

                            <?= CHtml::emailField('Subscribe[email]','',array('placeholder'=>Yii::t('main','введите e-mail')))?>
                            <?= CHtml::submitButton(Yii::t('main','Подписаться'),array('class'=>'btn guest-subscribe'))?>
                            <?php $this->endWidget(); ?>
                        <?php endif;?>
                        <ul class="social">
                            <li><?= CHtml::link('','#',array('class'=>'icon icon-vk-gray'))?></li>
                            <li><?= CHtml::link('','#',array('class'=>'icon icon-facebook-gray'))?></li>
                            <li><?= CHtml::link('','#',array('class'=>'icon icon-twitter-gray'))?></li>
                            <li><?= CHtml::link('','#',array('class'=>'icon icon-youtube-gray'))?></li>
                            <li><?= CHtml::link('','#',array('class'=>'icon icon-rss-gray'))?></li>
                            <div class="counter">
                                <a href="#" target="_blank">
                                    <img src="/images/assets/liveinternet.png" border="0" width="88" height="31" title="liveinternet.ru: показано количество просмотров и посетителей за 24 часа">
                                </a>
                            </div>
                        </ul>
                        <div class="abs copyright">Copyright © 2014</div>
                    </div>
                </div>
            </div>
            <div id="scroll-up" class="point"></div>
        </footer>
        <div class="hidden" id="feedback-content">
            <?php $feedback = new Feedback();?>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'action'=>'/user/feedback',
                'htmlOptions'=>array(
                    'class'=>'auth-form feedback-form'
                )
            )); ?>
            <div class="row text-center">
                <?= Yii::t('main','Обратная связь')?>
            </div>
            <div class="row">
                <?=$form->textField($feedback,'name',array('placeholder'=>Yii::t('main','Имя')))?>
                <?=Candy::error($feedback,'name')?>
            </div>
            <div class="row">
                <?=$form->textField($feedback,'phone',array('placeholder'=>Yii::t('main','Телефон')))?>
                <?=Candy::error($feedback,'phone')?>
            </div>
            <div class="row">
                <?=$form->textField($feedback,'skype',array('placeholder'=>Yii::t('main','Skype')))?>
                <?=Candy::error($feedback,'skype')?>
            </div>
            <div class="row">
                <?=$form->textField($feedback,'email',array('placeholder'=>Yii::t('main','E-mail')))?>
                <?=Candy::error($feedback,'email')?>
            </div>
            <div class="row">
                <?=$form->textArea($feedback,'text',array('placeholder'=>Yii::t('main','Текст сообщения')))?>
                <?=Candy::error($feedback,'text')?>
            </div>
            <div class="data">
                <?php echo
                CHtml::ajaxSubmitButton('Отправить',CHtml::normalizeUrl(array('user/feedback')),
                    array(
                        'dataType'=>'json',
                        'type'=>'post',
                        'success'=>'function(data)
                        {
                          form.ajaxError(data,".feedback-form",false,true);


                        }'
                    ),array('class' => 'btn','id' => 'feedback-action'));
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
        <div class="hidden" id="auth-content">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'action'=>'/user/login',
                'htmlOptions'=>array(
                    'class'=>'auth-form'
                )
            )); ?>
            <div class="row text-center">
                Авторизация
            </div>
            <div class="row">
                <?php echo CHtml::textField('LoginForm[username]','',array('placeholder'=>Yii::t('main','Логин')))?>
                <div class="errorMessage" id="LoginForm_username_em_" style="display: none;"></div>
            </div>
            <div class="row">
                <?php echo CHtml::passwordField('LoginForm[password]','',array('placeholder'=>Yii::t('main','Пароль')))?>
                <div class="errorMessage" id="LoginForm_password_em_" style="display: none;"></div>
            </div>
            <div class="data">
                <?php echo CHtml::checkBox('LoginForm[rememberMe]',true,array('id'=>'login_forget_me'))?>
                <?php echo CHtml::label(Yii::t('main','Запомнить меня'),'login_forget_me')?>
                <?php echo CHtml::link(Yii::t('main','Забыли пароль?'),array('user/restoreForm'),array('class'=>'is-forget fancy-open fancybox.ajax'))?>
            </div>
            <div class="data">
                <?php echo
                CHtml::ajaxSubmitButton('Войти',CHtml::normalizeUrl(array('user/login')),
                    array(
                        'dataType'=>'json',
                        'type'=>'post',
                        'success'=>'function(data)
                        {
                          form.ajaxError(data,".auth-form")
                        }'
                    ),array('class' => 'btn','id' => 'login-action'));
                ?>
                <?php  echo CHtml::link(Yii::t('main','Зарегистрироваться'),array('user/register'),array('class'=>'dash register'))?>
            </div>

            <?php $this->endWidget(); ?>

        </div>
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            /*(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
                function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
                e=o.createElement(i);r=o.getElementsByTagName(i)[0];
                e.src='//www.google-analytics.com/analytics.js';
                r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');*/
        </script>
    </body>
</html>
