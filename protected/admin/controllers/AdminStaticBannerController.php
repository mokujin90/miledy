<?php
class AdminStaticBannerController extends AdminBaseController
{
    public $defaultAction = 'index';

    protected function beforeAction($action){
        parent::beforeAction($action);
        $this->mainMenuActiveId = 'static';
        $this->pageCaption = 'Статические баннеры';
        $this->activeMenu = array('adv', 'stat-banner');
        if(!$this->user->can('adv')) throw new CHttpException(403, Yii::t('main', 'Ошибка доступа'));
        return true;
    }

    public function actionIndex()
    {
        $this->updatePageSize();
        $model = new StaticBanner('search');
        $model->unsetAttributes();
        if (isset($_GET['StaticBanner']))
            $model->attributes = $_GET['StaticBanner'];

        $this->render('index', array('model' => $model));
    }

    public function actionEdit($id)
    {
        $model = StaticBanner::model()->findByPk($id);

        if (Yii::app()->request->isPostRequest && isset($_POST['StaticBanner'])) {
            $model->media_id = empty($_POST['media_id']) ? null : $_POST['media_id'];
            CActiveForm::validate($model);
            if ($model->save() && !isset($_POST['update'])) {
                $this->redirect(array('adminStaticBanner/index'));
            }
        }
        $this->render('_edit', array('model' => $model));
    }

}

?>
