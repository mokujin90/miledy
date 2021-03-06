<?php

/**
 * This is the model class for table "ReferenceIndustry".
 *
 * The followings are the available columns in table 'ReferenceIndustry':
 * @property string $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Region2Industry[] $region2Industries
 */
class ReferenceIndustry extends CActiveRecord
{
	public static function getList()
	{
		$result = array();
		foreach(ReferenceIndustry::model()->findAll() as $model){
			$result[$model->id] = $model->name;
		}
		return $result;
	}

	static function getDrop()
	{
		$criteria = new CDbCriteria();
		$criteria->order='name';
		return CHtml::listData(self::model()->findAll($criteria), 'id', 'name');
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ReferenceIndustry';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>255, 'tooLong' => "Поле  «{attribute}» слишком длинное."),
			array('media_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
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
			'region2Industries' => array(self::HAS_MANY, 'Region2Industry', 'industry_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'media_id' => 'Медиа',
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReferenceIndustry the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
