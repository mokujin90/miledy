<div class="attach-wrap">
    <div class="attach-btn icon icon-attach"></div>
    <div class="attach-menu">
        <div data-type="document" class="attach-action doc-action btn btn-success"><i class="fa fa-file fa-fw"></i><?= Yii::t('main','Документ')?></div>
    </div>
</div>

<div id="photo" style="display: none;">
    <?php
    $this->widget('application.components.MediaEditor.MediaEditor',
        array('data' => array(
                'items' => null,
                'field' => 'photo_fake',
                'item_container_id' => 'document_block',
                'button_image_url' => '/images/markup/logo.png',
                'button_width' => 1,
                'button_height' => 1,
            ),
            'scale' => '102x102',
            'scaleMode' => 'in',
            'needfields' => 'false',
            'callback'=>'message',
        ));
    ?>
</div>
<div id="document" style="display: none;">
    <?php
    $this->widget('application.components.MediaEditor.MediaEditor',
        array(
            'data' => array(
                'items' => null,
                'field' => 'document_fake',
                'item_container_id' => 'document_block',
                'button_image_url' => '/images/markup/logo.png',
                'button_width' => 1,
                'button_height' => 1,
            ),
            'callback'=>'message',
            'fileTypes'=>'doc,docx,pdf,txt,zip',
            'scale' => '102x102',
            'scaleMode' => 'in',
            'needfields' => 'false'));
    ?>
</div>

<div id="document_block">
    <?foreach($model->region2Files as $file):?>
        <span id="wrap_photo_fake2" style="display: inline;">
            <span class="uploaded-file-name"><?=$file->name?>
                <?=CHtml::hiddenField("file_id[$file->media_id][id]",$file->media_id)?>
                <?=CHtml::hiddenField("file_id[$file->media_id][old_name]",$file->name)?>
                <?= $file->media->type == 0 ? CHtml::textField("file_id[$file->media_id][title]",$file->title, array('class' => 'form-control', 'placeholder' => 'Описание')) : ''?>
                <a href="#" class="delete-file">Удалить</a>
            </span>
        </span>
    <?endforeach;?>
</div>