<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <i class="icon-leaf"></i>
                    Quản lý kho hàng
                </small>
            </a><!-- /.brand -->
        </div><!-- /.navbar-header -->

        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <span class="user-info">
                         <small>Welcome,</small>
                         <?php echo Yii::app()->session['username']?Yii::app()->session['username']:"Guest";?>
                     </span>

                     <i class="icon-caret-down"></i>
                 </a>
                 <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                     <?php if(Yii::app()->session['username']){
                        ?>
                        <li>
                            <a href="#">
                                <i class="icon-user"></i>
                                Profile
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="<?php echo Yii::app()->getBaseUrl(true)?>/home/logout">
                                <i class="icon-off"></i>
                                Logout
                            </a>
                        </li>
                        <?php
                    }
                    else{
                        ?>
                        <li>
                            <a href="<?php echo Yii::app()->getBaseUrl(true)?>/home/login">
                                <i class="icon-user"></i>
                                Login
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                 </ul>
            </ul>
        </li>
    </ul><!-- /.ace-nav -->
</div><!-- /.navbar-header -->
</div><!-- /.container -->
</div>


<!-- basic scripts -->

<!--[if !IE]> -->

<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo Yii::app()->getBaseUrl(true)?>/assets/js/typeahead-bs2.min.js"></script>

<!-- page specific plugin scripts -->

<!-- ace scripts -->

<script src="<?php echo Yii::app()->getBaseUrl(true)?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo Yii::app()->getBaseUrl(true)?>/assets/js/ace.min.js"></script>

<!-- inline scripts related to this page -->
