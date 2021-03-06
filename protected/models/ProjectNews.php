<?php

/**
 * This is the model class for table "ProjectNews".
 *
 * The followings are the available columns in table 'ProjectNews':
 * @property string $id
 * @property string $name
 * @property string $latin_name
 * @property string $announce
 * @property string $full_text
 * @property string $create_date
 * @property string $media_id
 * @property string $project_id
 *
 * The followings are the available model relations:
 * @property Media $media
 * @property Project $project
 */
class ProjectNews extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'ProjectNews';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('full_text, name, announce', 'required'),
            array('name, latin_name', 'length', 'max'=>255, 'tooLong' => "Поле  «{attribute}» слишком длинное."),
            array('media_id, project_id', 'length', 'max'=>10),
            array('announce, create_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, latin_name, announce, full_text, create_date, media_id, project_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'media' => array(self::BELONGS_TO, 'Media', 'media_id'),
            'project' => array(self::BELONGS_TO, 'Project', 'project_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('main','Заголовок новости'),
            'latin_name' => 'Latin Name',
            'announce' => Yii::t('main','Анонс'),
            'full_text' => Yii::t('main','Текст'),
            'create_date' => 'Create Date',
            'media_id' => 'Media',
            'project_id' => 'Project',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('latin_name',$this->latin_name,true);
        $criteria->compare('announce',$this->announce,true);
        $criteria->compare('full_text',$this->full_text,true);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('media_id',$this->media_id,true);
        $criteria->compare('project_id',$this->project_id,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProjectNews the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function createUrl(){
        $controller = Yii::app()->controller;
        return $controller->createUrl('project/newsDetail', array('id' => $this->id));
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->create_date = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }
}