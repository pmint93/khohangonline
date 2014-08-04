<div id="main-content" class="text-center">
    <?php
    $menu = Auth::getMenu(Yii::app()->session['auth_user']);
    foreach ($menu as $cat => $act) {
        ?>
        <div class="thumbnail center-block" style="width: 300px; margin-top: 20px; padding: 20px; display: inline-block; vertical-align: top;">
            <div class="text-center text-warning"><b><?php echo $cat; ?></b></div>
            <?php
            foreach ($act as $key => $value) {
                ?>
                <a class="btn btn-google-plus form-control" href="<?php echo Yii::app()->getBaseUrl(true) . "/" . $value['controller'] . "/" . $value['action']; ?>" style="margin-top: 5px;"><?php echo $key; ?></a>
            <?php
            }
            ?>
            <div class="clr"></div>
        </div>
    <?php
    }
    ?>
</div>