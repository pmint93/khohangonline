<a class="menu-toggler" id="menu-toggler" href="#">
    <span class="menu-text"></span>
</a>


<div class="sidebar" id="sidebar">
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <i class="icon-desktop"></i>
        <span>Menu</span>
    </div>

    <ul class="nav nav-list">
        <li class="<?php echo (Yii::app()->controller->id == 'home')?'active':'';?>">
            <a href="<?php echo Yii::app()->getBaseUrl(true);?>">
                <i class="icon-dashboard"></i>
                <span class="menu-text"> Bảng điều kiển </span>
            </a>
        </li>
        <?php
        $menu = Auth::getMenu(Yii::app()->session['auth_user']);
        foreach ($menu as $cat => $act) {
            ?>
            <li id="parent-menu-<?php echo Functions::locDau($cat);?>">
                <a href="#" class="dropdown-toggle">
                    <i class="icon-edit"></i>
                    <span class="menu-text"><?php echo $cat;?></span>
                    <b class="arrow icon-angle-down"></b>
                </a>
                <ul class="submenu">
                    <?php
                    foreach ($act as $key => $value) {
                        ?>
                        <?php if(Yii::app()->params['action-menu'] == $value['controller'].$value['action']){
                            ?>
                            <script>
                                $("#parent-menu-<?php echo Functions::locDau($cat);?>").addClass("active open");
                            </script>
                            <?php
                        }?>
                        <li class="<?php echo (Yii::app()->params['action-menu'] == $value['controller'].$value['action'])?"active":""?>">
                            <a href="<?php echo Yii::app()->getBaseUrl(true) . "/" . $value['controller'] . "/" . $value['action']; ?>">
                                <i class="icon-double-angle-right"></i>
                                <?php echo $key; ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </li>
            <?php
        }
        ?>

    </ul><!-- /.nav-list -->

    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
    </div>

    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
</div>
