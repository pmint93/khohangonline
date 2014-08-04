<div class="text-center">
    <?php if(file_exists(Yii::getPathOfAlias('webroot')."/files/".$filename) && $filename!=""){
        ?>
        <a href="<?php echo Yii::app()->getBaseUrl(true)?>/download/files/id/<?php echo $filename;?>"  class="btn btn-danger" style="margin: 10px auto;">DOWNLOAD NOW</a>
        <?php
    }
    else{
        ?>
        <span class="text-warning">404 File not found</span>
        <?php
    }?>

</div>