<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public function  afterAction($action)
    {
        Functions::genModel(ModelConfig::$config);
//        Functions::URLFixed();
        if(isset($_GET['developer'])) Yii::app()->session['developer'] = true;
        if(isset($_GET['clear_dev'])) Yii::app()->session->clear();
        if((Yii::app()->params['building'])&&($action->id!="building")&&(!isset(Yii::app()->session['developer']))) return $this->redirect(Yii::app()->request->baseUrl."/home/building");
        $this->init();
    }
	/**
	 * @var string the default layout for the controller view. Defaults to 'column1',
	 * meaning using a single column layout. See 'protected/views/layouts/layout.php'.
	 */
	public $layout='main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
}