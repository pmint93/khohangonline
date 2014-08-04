<?php
/**
 * Created by PhpStorm.
 * User: Buminta
 * Date: 2/23/14
 * Time: 1:04 PM
 */

class ErrorController extends Controller{
    public function init(){
    }
    public function actionIndex(){
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('index', array('message'=>Functions::T((isset(ErrorList::$httprequest[$error['code']])?ErrorList::$httprequest[$error['code']]:$error['message'])),'code'=>$error['code']));
        }
        else if(isset($_REQUEST['err'])){
            $error['code'] = $_REQUEST['err'];
            $error['message'] = Functions::T((isset(ErrorList::$httprequest[$error['code']])?ErrorList::$httprequest[$error['code']]:$error['message']));
            Yii::app()->session['notification'] = Functions::T($error['message']);
            if(Yii::app()->request->isAjaxRequest){
                echo Yii::app()->session['notification'];
            }
            else $this->render('index', array('message'=>Functions::T((isset(ErrorList::$httprequest[$error['code']])?ErrorList::$httprequest[$error['code']]:$error['message'])),'code'=>$error['code']));
        }
        else $this->render('index', array('message'=>Functions::T("Something error"), 'code'=>""));
    }
}