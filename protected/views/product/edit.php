<?php
if (!isset($renderForm)) $renderForm = false;
if (!isset($default)) $default = array(
    'name' => "",
    'category_id' => "",
    'quantity' => "",
    'default_price' => "",
    'description' => ""
);
?>
    <div class="page-header">
        <h1>
            Sản phẩm
            <small>
                <i class="icon-double-angle-right"></i>
                Sửa
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
}
if ($renderForm) {

    ?>
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->

            <form name="product-form" class="form-horizontal" role="form" method="post">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tên </label>

                    <div class="col-sm-9">
                        <input type="text" name="name" class="col-xs-10 col-sm-5"
                               value="<?php echo $default["name"]; ?>">
                    </div>
                </div>
                <div class="space-4"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nhóm hàng </label>

                    <div class="col-sm-9">
                        <select name="category_id" class="col-xs-10 col-sm-4 chosen-select" id="form-field-select-3"
                                data-placeholder="Chọn một nhóm hàng">
                            <option value="">&nbsp;</option>
                            <?php
                            foreach ($rows as $row) {
                                echo '<option value="' . $row['id'] . '" ' . ($default['category_id'] == $row['id'] ? "selected" : "") . '>' . $row['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="space-4"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Giá mặc định </label>

                    <div class="col-sm-9">
                        <input id="spinner1" type="text" name="default_price" class="col-xs-10 col-sm-5"
                               value="<?php echo $default["default_price"]; ?>">
                    </div>
                </div>
                <div class="space-4"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Mô tả chi tiết </label>

                    <div class="col-sm-3">
                        <textarea class="form-control col-xs-10 col-sm-5"
                                  name="description"><?php echo $default["description"]; ?></textarea>
                    </div>
                </div>

                <div class="space-4"></div>

                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <input type="hidden" name="submited">
                        <button class="btn btn-info" type="button"
                                onclick="javascript: document.forms['product-form'].submit()">
                            <i class="icon-ok bigger-110"></i>
                            Sửa
                        </button>

                        &nbsp; &nbsp; &nbsp;
                        <button class="btn" type="reset">
                            <i class="icon-undo bigger-110"></i>
                            Nhập lại
                        </button>
                    </div>
                </div>

                <div class="hr hr-24"></div>
            </form>
        </div>
    </div>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/js/chosen.jquery.min.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/js/fuelux/fuelux.spinner.min.js"></script>
    <script>
        jQuery(function($) {
            $(".chosen-select").chosen();
            $('#spinner1').ace_spinner({value:$('#spinner1').val(),min:0,max:999999999,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
                .on('change', function(){
                    //console.log(this.value)
                });
        });
    </script>
<?php

}
?>