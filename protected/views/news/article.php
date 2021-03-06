<?
if($article['object']=='news'){
    if(empty($model->region_id) && $model->is_portal_news==0){
        $caption = Yii::t('main','Федеральные новости');
    }
    elseif(empty($model->region_id) && $model->is_portal_news==1){
        $caption = Yii::t('main','Новости iip.ru');
    }
    else{
        $caption = Yii::t('main','Новости региона');
    }
}
elseif($article['object'] == 'analytics'){
    $caption = Yii::t('main','Аналитика');
}
elseif($article['object'] == 'event'){
    $caption = Yii::t('main','События');
}
?>

<div class="news">
    <span class="news__type"><?=$caption;?></span>
    <div class="news__photo">
        <?=$model->media ? Candy::preview(array($model->media, 'scale' => '305x203', 'class' => 'image')):''?>
    </div><!--news__photo-->
    <p class="news__date"><?=Candy::formatDate($article['object']=='event'? $model->datetime : $model->create_date,'d/m/Y')?></p>
    <?=CHtml::link(CHtml::encode($model->name),$model->createUrl(), array('class' => 'news__link'))?>

    <p class="news__desc">
        <?=CHtml::encode($model->announce)?>
    </p>
    <?if(!empty($model->tags)):?>
        <div class="news-tags">
            <?foreach(explode(',', $model->tags) as $tag):?>
                <?=CHtml::link(CHtml::encode(trim($tag)), $this->createUrl('site/search', array('search'=>"#" . trim($tag))),array('class'=>'news__tag'))?>
            <?endforeach?>
        </div>
    <?endif?>
</div>