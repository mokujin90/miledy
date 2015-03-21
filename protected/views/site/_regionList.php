<?php
/**
 *
 * @var SiteController $this
 * @var PsiWhiteSpace $data
 * @var array $districtList
 * @var #A#M#C\BaseController.actionRegionList.0|? $district
 */
?>
<div id="region-drop-inner">
    <div class="rel">


        <div class="header tab">
            <span data-sort="0" class="ajax <?if(!$district):?>active<?endif;?>"><?= Yii::t('main','По алфавиту')?></span>
            <span class="separator">|</span>
            <span data-sort="1" class="ajax <?if($district):?>active<?endif;?>"><?= Yii::t('main','По федеральным округам')?></span>
            <?=CHtml::textField('find-city-text','',array('id'=>'find-city-text','placeholder'=>Yii::t('main','Введите название региона')))?>
        </div>
        <div class="list chain-block">
            <?if($district):?>
                <?$showDistrict = array();?>
                <?foreach($data as $column):?>
                    <div class="column">
                        <?foreach($column as $destrictId=>$items):?>

                            <?if(!array_key_exists($destrictId,$showDistrict)):?>
                                <div class="district"><?=$districtList[$destrictId]?></div>
                            <?endif;?>
                            <?$showDistrict[$destrictId] = 1;?>
                            <?foreach($items as $regionId=>$regionName):?>
                                <div class="region"><?=CHtml::link($regionName,'#')?></div>
                            <?endforeach;?>

                        <?endforeach;?>
                    </div>
                <?endforeach;?>
            <?else:?>
                <?foreach($data as $column):?>
                    <div class="column">
                        <?foreach($column as $regionId=>$regionName):?>
                            <div class="region"><?=CHtml::link($regionName,'#',array('data-region'=>$regionId))?></div>
                        <?endforeach;?>
                    </div>
                <?endforeach;?>
            <?endif;?>
        </div>
        <div class="abs background"></div>
    </div>
</div>