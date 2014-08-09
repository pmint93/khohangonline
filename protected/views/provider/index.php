<?php
    $THISPAGE = Yii::app()->getBaseUrl(true) . "/provider";
?>
<div class="page-header">
    <h1>
        Nhà cung cấp
    </h1>
</div>

<div class="row">
    <p class="col-xs-12">
        <a href="<?php echo $THISPAGE ?>/add" class="btn btn-sm btn-info">Thêm mới</a>
        <a href="javascript: deleteSelected();" class="btn btn-sm btn-danger">Xóa</a>
    </p>
    <div class="col-xs-12">
        <?php
        if (!isset($rows) || count($rows) <= 0) {
            echo '<div class="table-header">Chưa có nhà cung cấp nào</div>';
        } else {

            ?>
            <div class="table-header">Danh sách nhà cung cấp</div>
            <div class="table-responsive">
                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="center">
                            <label>
                                <input type="checkbox" class="ace"/>
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>Mã</th>
                        <th>Tên</th>
                        <th>Mô tả chi tiết</th>

                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            Lần sửa cuối
                        </th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php

                    foreach ($rows as $i => $row) {

                        ?>
                        <tr>
                            <td class="center">
                                <label>
                                    <input type="checkbox" class="ace" data-id="<?php echo $row['id']; ?>"/>
                                    <span class="lbl"></span>
                                </label>
                            </td>

                            <td><?php echo $row["code"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["description"]; ?></td>
                            <td><?php echo $row["modify_on"]; ?></td>
                            <td>
                                <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                    <a class="green" href="<?php echo $THISPAGE."/edit/".$row["id"] ?>" title="Sửa">
                                        <i class="icon-pencil bigger-130"></i>
                                    </a>

                                    <a class="red" href="<?php echo $THISPAGE."/delete/".$row["id"] ?>" title="Xóa">
                                        <i class="icon-trash bigg er-130"></i>
                                    </a>
                                </div>

                                <div class="visible-xs visible-sm hidden-md hidden-lg">
                                    <div class="inline position-relative">
                                        <button class="btn btn-minier btn-yellow dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="icon-caret-down icon-only bigger-120"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">

                                            <li title="Sửa">
                                                <a href="<?php echo $THISPAGE."/edit/".$row["id"] ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                    <span class="green">
                                                        <i class="icon-edit bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li title="Xóa">
                                                <a href="<?php echo $THISPAGE."/delete/".$row["id"] ?>" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                    <span class="red">
                                                        <i class="icon-trash bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
    jQuery(function ($) {
        var oTable1 = $('#sample-table-2').dataTable({
            "aoColumns": [
                { "bSortable": false },
                null,
                null,
                null,
                null,
                { "bSortable": false }
            ]
        });

        $('table th input:checkbox').on('click', function () {
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function () {
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });

        });


        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            var w2 = $source.width();

            if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
            return 'left';
        }
    });

    function deleteSelected(){
        /*
        Rest API
         */
        var checkedIds = [];
        $('table th input:checkbox').closest('table').find('tr > td:first-child input:checkbox:checked')
            .each(function(){
                if($(this).attr('data-id')) checkedIds.push($(this).attr('data-id'));
            })
        if(checkedIds.length){
            if(!confirm("Xóa tất cả các nhà cung cấp đã chọn ?")) return;
            $.ajax({
                url: "<?php echo Yii::app()->getBaseUrl(true); ?>/provider/deleteAll",
                method: "POST",
                data: {
                    ids: checkedIds
                },
                beforeSend: function(){

                },
                success: function(response){
                    try{
                        response = JSON.parse(response);
                        if(!response.status){
                            alert("Xóa thành công");
                            if(confirm("Tải lại trang ?")) window.location.reload();
                        }
                    } catch (ex){
                        alert("Xóa không thành công");
                        throw ex;
                    }
                }
            })
        } else {
            alert("Chọn ít nhất 1 nhà cung cấp !");
        }
    }
</script>