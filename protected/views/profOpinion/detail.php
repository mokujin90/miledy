<div class="news-page">
    <div id="general">
        <div class="main bread-block">
            <?$this->renderPartial('/partial/_breadcrumbs')?>
        </div>
        <div class="content list-columns columns">
            <div class="full-column">
                <div class="news-item opacity-box">
                    <div class="data">
                        <div class="date"><?=Candy::formatDate($model->create_date)?></div>
                        <div class="name"><?=CHtml::encode($model->name)?></div>
                        <div class="announce">
                            <i><?=CHtml::encode($model->announce)?></i>
                        </div>
                        <?=$model->media?Candy::preview(array($model->media, 'scale' => '100x100', 'class' => 'image-block float-left')):''?>
                        <div class="full-text">
                            <?=CHtml::encode($model->full_text)?>
                        </div>
                        <?if(!empty($model->tags)):?>
                            <div class="tags">
                                <b>Теги:</b>
                                <?foreach(explode(',', $model->tags) as $tag):?>
                                <?=CHtml::link(CHtml::encode(trim($tag)), $this->createUrl('profOpinion/index', array('tag'=>trim($tag))))?>
                                <?endforeach?>
                            </div>
                        <?endif?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>