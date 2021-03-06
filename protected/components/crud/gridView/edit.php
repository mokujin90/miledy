<?
/**
 * @var $this Grid
 */
?>
<div class="grid-widget">
    <?=CHtml::openTag('table',$this->htmlOptions)?>
        <?php if(count($this->header)):?>
            <thead>
                <?php foreach($this->header as $line => $tr):?>
                    <tr class="row">
                        <?=$this->drawLine($tr,false)?>
                    </tr>
                <?php endforeach;?>
            </thead>
        <?php endif;?>
        <tbody>
        <?if($this->withChartMeta):?>
            <tr class="row">
                <?=$this->drawMetaLine()?>
            </tr>
        <?endif?>
            <?php foreach($this->data as $line => $tr):?>
                <tr class="row">
                    <?=$this->drawLine($tr,true)?>
                </tr>
            <?php endforeach;?>

        </tbody>
        <?php if($this->options['button']):?>
            <tfoot>
                <tr class="row hidden">
                    <?=$this->drawLine($this->header[0],true,true)?>
                </tr>
            </tfoot>
        <?php endif;?>
    <?=CHtml::closeTag('table')?>
    <?php if($this->options['button']):?>
        <br>
        <?=CHtml::button(Yii::t('main','Создать строку'),array('class'=>'btn btn-success btn-xs blue grid new-line'))?>
        <?=CHtml::button(Yii::t('main','Удалить строки'),array('class'=>'btn btn-danger btn-xs blue grid remove-button'))?>
    <?php endif;?>
</div>