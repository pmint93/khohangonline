<?php
/**
 * Created by PhpStorm.
 * User: Buminta
 * Date: 1/22/14
 * Time: 9:58 PM
 */

class UploadController extends Controller{
    public $size = 1048576;
    public $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'zip');
    public $output_dir = "/files/";
    public function init(){
        if(!isset(Yii::app()->session['auth_user']) || (Yii::app()->session['auth_user'] == "")){
            return $this->redirect(Yii::app()->getBaseUrl(true)."/error");
        }
    }
    public function actionIndex(){
        echo json_encode("Hello upload");
    }
    public function actionAddfile(){
        if(isset($_FILES["myfile"]))
            {
                $ret = array();
                $date = new DateTime();
                $key = md5($date->format("YmdHis"));
                $error  =$_FILES["myfile"]["error"];
                //You need to handle  both cases
                //If Any browser does not support serializing of multiple files using FormData()
                if(!is_array($_FILES["myfile"]["name"])) //single file
                {
                    if ($_FILES["myfile"]["size"] > $this->size){
                        $error = array('error'=>'Tệp tin vượt quá 1MB');
                        echo json_encode($error);
                        return 0;
                    };
                    $fileName = $key.".".$_FILES["myfile"]["name"];
                    $fileParts = pathinfo($_FILES['myfile']['name']);
                    if (in_array(strtolower($fileParts['extension']), $this->fileTypes)) {
                        move_uploaded_file($_FILES["myfile"]["tmp_name"],Yii::getPathOfAlias('webroot').$this->output_dir.$fileName);
                        $ret[]= $fileName;
                    }
                }
                else  //Multiple files, file[]
                {
                    $fileCount = count($_FILES["myfile"]["name"]);
                    for($i=0; $i < $fileCount; $i++)
                    {
                        if ($_FILES["myfile"]["size"][$i] > $this->size){
                            $error = array('error'=>'Tệp tin vượt quá 1MB');
                            echo json_encode($error);
                            return 0;
                        };
                        $fileName = $key.".".$_FILES["myfile"]["name"][$i];
                        $fileParts = pathinfo($_FILES['myfile']['name'][$i]);
                        if (in_array(strtolower($fileParts['extension']), $this->fileTypes)) {
                            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],Yii::getPathOfAlias('webroot').$this->output_dir.$fileName);
                            $ret[]= $fileName;
                        }
                    }

                }
                echo json_encode($ret);
            }
    }

    public function actionDelete(){
        if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']))
        {
            try{
                $fileName =$_POST['name'];
                $filePath = Yii::getPathOfAlias('webroot').$this->output_dir. $fileName;
                if (file_exists($filePath))
                {
                    unlink($filePath);
                }
                echo $filePath;
            }
            catch(Exception $e){
                echo $e;
            }
        }
    }
}