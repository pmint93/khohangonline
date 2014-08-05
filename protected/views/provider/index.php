<div class="page-header">
    <h1>
        Nhà cung cấp
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php
        $tableheader = "Không có nhà cung cấp nào";
        if(!isset($providers) || count($providers) <= 0){
            $providers = array();
        } else {
            echo "Danh sách các nhà cung cấp";
        }
        ?>
        <div class="table-header"><?php echo $tableheader; ?></div>
        <div class="table-responsive">
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                <?php

                foreach ($providers as $key => $provider){

                ?>
                <tr>
                    <th class="center">
                        <label>
                            <input type="checkbox" class="ace"/>
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>Mã</th>
                    <th>Tên</th>
                    <th class="hidden-480">Mô tả chi tiết</th>

                    <th>
                        <i class="icon-time bigger-110 hidden-480"></i>
                        Ngày tạo
                    </th>
                    <th class="hidden-480">Thao tác</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td class="center">
                        <label>
                            <input type="checkbox" class="ace"/>
                            <span class="lbl"></span>
                        </label>
                    </td>

                    <td>
                        <a href="#">app.com</a>
                    </td>
                    <td>$45</td>
                    <td class="hidden-480">3,330</td>
                    <td>Feb 12</td>
                    <td>
                        <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                            <a class="blue" href="#">
                                <i class="icon-zoom-in bigger-130"></i>
                            </a>

                            <a class="green" href="#">
                                <i class="icon-pencil bigger-130"></i>
                            </a>

                            <a class="red" href="#">
                                <i class="icon-trash bigger-130"></i>
                            </a>
                        </div>

                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                            <div class="inline position-relative">
                                <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-caret-down icon-only bigger-120"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                                    <li>
                                        <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
																				<span class="blue">
																					<i class="icon-zoom-in bigger-120"></i>
																				</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
																				<span class="green">
																					<i class="icon-edit bigger-120"></i>
																				</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
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
    })
</script>