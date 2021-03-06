<?php

/**
 * This is the model class for table "Message".
 *
 * The followings are the available columns in table 'Message':
 * @property string $id
 * @property string $user_from
 * @property string $user_to
 * @property string $subject
 * @property string $text
 * @property string $create_date
 * @property integer $is_read
 * @property integer $delete_by_userfrom
 * @property integer $delete_by_userto
 * @property string $admin_type
 * @property string $project_id
 *
 * The followings are the available model relations:
 * @property Project $project
 * @property User $userFrom
 * @property User $userTo
 * @property Media[] $medias
 */
class Message extends ActiveRecord
{

    const USER_ADMINISTRATOR = 'Администрация сайта';
    const USER_SYSTEM = 'Системное сообщение';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'Message';
    }

    protected function beforeSave()
    {
        parent::beforeSave();
        if($this->user_to == $this->user_from){
            $this->addError('user_to', Yii::t('main', 'Нельзя отправлять сообщение самому себе'));
            return false;
        }
        if ($this->maybeNull('subject')) {
            $this->subject = Yii::t('main', 'Без темы');
        }
        if (!$this->dialog_id && !$this->admin_type) { //ищем диалог в который записать сообщение, если диалог не указан.
            if($this->project_id){
                $sql = "
                    SELECT Dialog.id FROM
                    User2Dialog U2D
                    LEFT JOIN User2Dialog U2D_TO ON (U2D.dialog_id = U2D_TO.dialog_id)
                    LEFT JOIN Dialog ON (U2D.dialog_id = Dialog.id)
                    WHERE U2D.user_id = :from  AND U2D_TO.user_id = :to AND Dialog.type = 'project' AND Dialog.project_id = :project
                ";
                $dialog = Yii::app()->db->createCommand($sql)->bindValues(array('from' => $this->user_from, 'to' => $this->user_to, 'project' => $this->project_id))->queryScalar();
            } else {
                $sql = "
                    SELECT Dialog.id FROM
                    User2Dialog U2D
                    LEFT JOIN User2Dialog U2D_TO ON (U2D.dialog_id = U2D_TO.dialog_id)
                    LEFT JOIN Dialog ON (U2D.dialog_id = Dialog.id)
                    WHERE U2D.user_id = :from  AND U2D_TO.user_id = :to AND Dialog.type = 'chat'
                ";
                $dialog = Yii::app()->db->createCommand($sql)->bindValues(array('from' => $this->user_from, 'to' => $this->user_to))->queryScalar();

            }
            if($dialog){
                $this->dialog_id = $dialog;
            }
        }
        return true;
    }

    public function scopes()
    {
        return array(
            'admin' => array(
                'condition' => 't.admin_type IS NOT NULL',
            ),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_to', 'required', 'on' => 'chat'),
            array('create_date', 'required'),
            array('is_read,admin_type, delete_by_userfrom, delete_by_userto', 'numerical', 'integerOnly' => true),
            array('user_from, user_to', 'length', 'max' => 10),
            array('subject', 'length', 'max' => 255, 'tooLong' => "Поле  «{attribute}» слишком длинное."),
            array('text,project_id,dialog_id', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_from, user_to, subject, text, create_date, is_read, delete_by_userfrom, delete_by_userto, admin_type, project_id', 'safe', 'on' => 'search'),
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
            'userFrom' => array(self::BELONGS_TO, 'User', 'user_from'),
            'userTo' => array(self::BELONGS_TO, 'User', 'user_to'),
            'medias' => array(self::MANY_MANY, 'Media', 'Message2Media(message_id, media_id)'),
            'files' => array(self::HAS_MANY, 'Message2Media', 'message_id'),
            'project' => array(self::BELONGS_TO, 'Project', 'project_id'),
            'dialog' => array(self::BELONGS_TO, 'Dialog', 'dialog_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_from' => 'От кого',
            'user_to' => 'Кому',
            'subject' => 'Тема',
            'text' => 'Текст',
            'create_date' => 'Create Date',
            'is_read' => 'Is Read',
            'delete_by_userfrom' => 'Delete By Userfrom',
            'delete_by_userto' => 'Delete By Userto',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_from', $this->user_from, true);
        $criteria->compare('user_to', $this->user_to, true);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('create_date', $this->create_date, true);
        $criteria->compare('is_read', $this->is_read);
        $criteria->compare('delete_by_userfrom', $this->delete_by_userfrom);
        $criteria->compare('delete_by_userto', $this->delete_by_userto);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Message the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Отправить системное сообщение
     * @param $userTo
     * @param $subject
     * @param $body
     */
    public static function sendSystemMessage($userTo, $subject, $body)
    {
        $new = new self();
        $new->user_from = NULL;
        $new->user_to = $userTo;
        $new->subject = $subject;
        $new->text = $body;
        return $new->save();
    }

    /**
     * Получить критерию для непрачитанных сообщений для текущего (или любого другого) пользователя
     * @param 'all'|'system'| 'user' какие сообщения засчитывать
     * @return $criteria CDbCriteria
     */
    private static function getUnreadCriteria($type, $userId)
    {
        if (is_null($userId)) {
            $userId = Yii::app()->user->id;
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition('user_to = :userId AND is_read = 0 AND delete_by_userto = 0');
        $criteria->params = array(':userId' => $userId);
        if ($type == 'user') {
            $criteria->addCondition('(user_from IS NOT NULL) OR (user_from IS NULL and admin_type IS NOT NULL)');
        } elseif ($type == 'system') {
            $criteria->addCondition('user_from IS NULL AND admin_type IS NULL');
        } elseif ($type == 'admin') {
            $criteria = new CDbCriteria();
            $criteria->addCondition('user_to IS NULL  AND is_read = 0 ');
        }
        return $criteria;
    }

    public static function getUnreadList($type = 'user', $userId = null)
    {
        $criteria = self::getUnreadCriteria($type, $userId);
        return self::model()->findAll($criteria);
    }

    public static function getUnreadCount($type = 'user', $userId = null)
    {
        $criteria = self::getUnreadCriteria($type, $userId);
        return self::model()->count($criteria);
    }

    public function checkRead()
    {
        $this->is_read = 1;
        $this->save();
    }

    public function getFromUserLabel($userRelation)
    {
        if($this->dialog->type == 'feedback'){
            if($this->from_admin){
                $return = self::USER_ADMINISTRATOR;
            } else {
                $return = $this->dialog->email;
            }
        }
        elseif (!$this->$userRelation && !isset($this->admin_type))
            $return = self::USER_SYSTEM;
        elseif (!$this->$userRelation && isset($this->admin_type))
            $return = self::USER_ADMINISTRATOR;
        else
            $return = $this->$userRelation->name;
        return $return;
    }

    /**
     * Удален ли текущим пользователем
     */
    public function isDeletedForYou()
    {
        return ($this->user_from == Yii::app()->user->id && $this->delete_by_userfrom == 1) ||
        ($this->user_to == Yii::app()->user->id && $this->delete_by_userto == 1);
    }


    public function afterSave()
    {
        if (!$this->dialog_id) { //если диалога нет, то создаем.
            $dialog = new Dialog();
            $dialog->subject = $this->subject;
            $type = 'chat';
            if(!is_null($this->admin_type)){
                $type = 'admin';
            } elseif($this->project_id){
                $type = 'project';
                $this->project->reply_count+=1;
                $this->project->update();
            }
            $dialog->type =  $type;
            $dialog->admin_type = $this->admin_type;
            $dialog->project_id = $this->project_id;
            if ($dialog->save()) {
                $userFromDialog = new User2Dialog();
                $userFromDialog->dialog_id = $dialog->id;
                $userFromDialog->user_id = $this->user_from;
                $userFromDialog->save();
                if ($this->user_to) { //если отпаравляем админу, то собеседника не добавляем в User2Dialog;
                    $userToDialog = new User2Dialog();
                    $userToDialog->dialog_id = $dialog->id;
                    $userToDialog->user_id = $this->user_to;
                    $userToDialog->save();
                }
                $this->isNewRecord = false;
                $this->dialog_id = $dialog->id;
                $this->save();
            }
        } elseif($this->dialog_id && $this->isNewRecord) { //при сохранении нового сообщения обновляем диалог.
            $this->dialog->update_date = date('Y-m-d H:i:s');
            $this->dialog->save();
        }
        if($this->isNewRecord && !empty($this->from_admin) && !empty($this->dialog->email)) {
            Mail::send($this->dialog->email,Mail::S_FEEDBACK,'feedback',array('model'=>$this));
        }
        parent::afterSave();
    }
}
