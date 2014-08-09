<script>
    $("head").append('<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/css/select2.css" />');
    $("head").append('<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/css/chosen.css" />');
    $("head").append('<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/css/datepicker.css" />');
</script>
<?php
if (!isset($default)) $default = array(
    'name' => "",
    'category_id' => "",
    'quantity' => "",
    'default_price' => "",
    'description' => "",
    'user_name' => "pmint"
);
?>
<div class="page-header">
    <h1>
        Giao dịch
        <small>
            <i class="icon-double-angle-right"></i>
            Nhập hàng
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
?>
<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <form name="receipt-form" class="form-horizontal" method="post" onsubmit="return false;">
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Ngày</label>

                <div class="input-group col-xs-12 col-sm-3">
                    <input class="form-control date-picker " name="date" type="text" data-date-format="dd-mm-yyyy"
                           disabled="disabled" value="<?php echo $default['date']; ?>"/>
                <span class="input-group-addon">
                    <i class="icon-calendar bigger-110"></i>
                </span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="user_name">Nhân viên thực
                    hiện</label>

                <div class="input-group col-xs-12 col-sm-3">
                    <input id="user_name" class="form-control date-picker " type="text" name="user_name"
                           disabled="disabled" value="<?php echo $default['user_name']; ?>"/>
                <span class="input-group-addon">
                    <i class="icon-group bigger-110"></i>
                </span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="provider">Nhà cung cấp</label>

                <div class="col-xs-12 col-sm-9">
                    <select id="provider" name="provider" class="select2" data-placeholder="Nhấn vào để chọn...">
                        <?php
                        foreach ($providers as $provider) {
                            echo '<option
                                data-code="' . $provider['code'] . '"
                                value="' . $provider['id'] . '" '
                                . ((isset($default['provider_id']) && $default['provider_id'] == $provider['provider_id']) ? 'selected' : '') . '>'
                                . $provider['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="description">Ghi chú</label>

                <div class="col-xs-12 col-sm-9">
                    <div class="clearfix">
                        <textarea class="input-xlarge" name="description" id="description"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="clearfix">
                        <div class="widget-box">
                            <div class="widget-header widget-header-blue widget-header-flat">
                                <h4 class="lighter">
                                    <i class="icon-info-sign"></i>Chi tiết hàng nhập</h4>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">

                                </div>
                                <!-- /widget-main -->
                            </div>

                            <div class="widget-header widget-header-blue widget-header-flat">
                                <h4 class="lighter">
                                    <button class="btn btn-xs btn-success" onclick="addProductForm();">
                                        <i class="icon-plus"></i>Thêm
                                    </button>
                                </h4>
                                <div class="widget-toolbar">
                                    <label>
                                        <small>Tổng:</small>
                                        <input type="text" id="order-total" class="input-sm red" value="0" readonly="">
                                        <small class="green">
                                            <span class="label label-primary arrowed-in arrowed"> nghìn đồng</span>
                                        </small>
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </div>

                            <!-- /widget-body -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-4"></div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <input type="hidden" name="submited">
                    <button class="btn btn-info" type="button"
                            onclick="javascript: document.forms['receipt-form'].submit()">
                        <i class="icon-ok bigger-110"></i>
                        Đồng ý
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="icon-undo bigger-110"></i>
                        Nhập lại
                    </button>
                </div>
            </div>
            <!-- PAGE CONTENT ENDS -->
    </div>
    <!-- /.col -->
</div>

<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/js/fuelux/fuelux.spinner.min.js"></script>
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/js/select2.min.js"></script>

<script type="text/javascript">
    jQuery(function ($) {
        $('.date-picker').datepicker({autoclose: true}).next().on(ace.click_event, function () {
            $(this).prev().focus();
        });
        $('[data-rel=tooltip]').tooltip();
        $("#provider").select2({allowClear: false})
            .on('change', function () {

            });
    });
    function addProductForm() {
        var html = '\
            <div class="alert alert-info">\
                <button type="button" class="close" data-dismiss="alert">\
                    <i class="icon-remove"></i>\
                </button>\
                <div>\
                    <div class="input-group col-xs-5">\
                        <select name="transfer[name][]" class="select2" style="width:100%" data-placeholder="Nhấn vào để chọn...">\
                            <option value="">&nbsp</option>\
                            <?php
                            foreach ($products as $product) {

                            ?>\
                                <option value="<?php echo $product['id'] ?>"\
                                <?php echo ((isset($default['product_id']) && $default['product_id'] == $product['id']) ? 'selected' : '') ?>>\
                                    <?php echo $product['name'] ?>\
                                 </option>\
                            <?php
                            }
                            ?>\
                        </select>\
                    </div>\
                    <div class="input-group col-xs-2">\
                        <input name="transfer[quantity][]" type="text" class="spinner-input input-sm form-control" value="" maxlength="9" data-rel="tooltip" title="Số lượng" value="0">\
                    </div>\
                    <div class="input-group col-xs-2">\
                        <input name="transfer[price][]" type="text" class="spinner-input input-sm form-control" value="" maxlength="9" data-rel="tooltip" title="Giá nhập" value="0">\
                    </div><small> <div class="space-4"></div>nghìn đồng </small>\
                </div><br>\
            </div>';
        $(".widget-main").append(html);
        var newObj = $(".widget-main").children().last();
        newObj.find('[name="transfer[name][]"]').select2();
        newObj.find('[name="transfer[quantity][]"]').ace_spinner({value: 0, min: 0, max: 999999999, step: 1, btn_up_class: 'btn-info', btn_down_class: 'btn-info'})
            .on('change', function () {
                var total = 0;
                $(".widget-main").children().each(function(){
                    total += $(this).find('[name="transfer[quantity][]"]').val() * $(this).find('[name="transfer[price][]"]').val();
                });
                $("#order-total").val(total);
            });
        newObj.find('[name="transfer[price][]"]').ace_spinner({value: 0, min: 0, max: 999999999, step: 1, btn_up_class: 'btn-info', btn_down_class: 'btn-info'})
            .on('change', function () {
                var total = 0;
                $(".widget-main").children().each(function(){
                    total += $(this).find('[name="transfer[quantity][]"]').val() * $(this).find('[name="transfer[price][]"]').val();
                });
                $("#order-total").val(total);
            });
        newObj.find('[data-rel=tooltip]').tooltip();
        return false;
    }
    addProductForm();
</script>