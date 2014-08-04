<?php
/**
 * Created by PhpStorm.
 * User: Buminta
 * Date: 2/26/14
 * Time: 10:37 PM
 */
class DownloadController extends Controller{
    public function init(){

    }
    public function actionGetFile(){
        Functions::logs();
        $filename = $_GET['id'];
        $this->layout = "backend";
        $this->render("index", array(
            'filename'=>$filename
        ));
    }
    public function actionFiles(){
        $filename = $_GET['id'];
        if($filename != ""){
            $file = Yii::getPathOfAlias('webroot')."/files/".$filename;
            $arr = explode(".",$filename);
            $extension = $arr[count($arr)-1];
            $name = $arr[count($arr)-2];
        }
        else{
            $file = Yii::getPathOfAlias('webroot')."/assets/images/logo_cp.png";
            $extension = "png";
            $name = "logo";
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$name.".".$extension);
        $seconds_to_cache = 3600;
        $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
        header('Expires: '.$ts);
        header('Cache-Control: max-age='.$seconds_to_cache);
        header('Pragma: cache');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
}