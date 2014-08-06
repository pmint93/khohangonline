<?php
$THISPAGE = Yii::app()->getBaseUrl(true) . "/category/delete";
if (!isset($renderForm)) $renderForm = false;
if (!isset($default)) $default = array(
    'name' => "",
    'description' => ""
);
?>
    <div class="page-header">
        <h1>
            Nhóm hàng
            <small>
                <i class="icon-double-angle-right"></i>
                Xóa
            </small>
        </h1>
    </div>
<?php
if (isset($successMsg) && $successMsg) {
    ?>
    <div class="alert alert-block alert-success">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <p>
            <strong>
                <i class="icon-ok"></i>
                Thành công!
            </strong>
            <?php echo $successMsg; ?>
        </p>
    </div>
<?php
} else if (isset($failedMsg) && $failedMsg) {
    ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>

        <strong>
            <i class="icon-remove"></i>
            Thất bại!
        </strong>
        <?php echo $failedMsg; ?>
        <br/>
    </div>
<?php
} else if (isset($warningMsg) && $warningMsg) {
    ?>
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>

        <strong>
            <i class="icon-remove"></i>
            Cẩn thận !
        </strong>
        <?php echo $warningMsg; ?>
        <br/>
    </div>
<?php
}
if ($renderForm) {

    ?>
    <div class="row">
        <div class="col-xs-12">
            <ul class="list-unstyled spaced">
                <li>
                    <span class="label">Tên</span>
                    <?php echo $default['name']; ?>
                    <i class="icon-remove bigger-110 red"></i>
                </li>
                <li>
                    <span class="label">Mô tả</span>
                    <?php echo $default['description']; ?>
                    <i class="icon-remove bigger-110 red"></i>
                </li>
            </ul>
            <div class="space-4"></div>
            <form name="category-form" class="form-horizontal" role="form" method="post">
                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <input type="hidden" name="submited">
                        <button class="btn btn-danger" type="button"
                                onclick="javascript: document.forms['category-form'].submit()">
                            <i class="icon-bolt bigger-110"></i>
                            Xóa
                        </button>

                        &nbsp; &nbsp; &nbsp;
                        <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/category" class="btn">
                            <i class="icon-undo bigger-110"></i>
                            Hủy
                        </a>
                    </div>
                </div>

                <div class="hr hr-24"></div>
            </form>
        </div>
    </div>
<?php

} else {
    ?>
    <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/category" class="btn">
        <i class="icon-undo bigger-110"></i>
        Trở lại
    </a>
<?php

}
?>