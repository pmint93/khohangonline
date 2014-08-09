<div class="page-header">
    <h1>
        Nhóm tài khoản
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="table-header">Danh sách nhóm</div>
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
                        <th><?php echo Functions::T("Group name");?></th>
                        <th><?php echo Functions::T("Description");?></th>
                        <th><?php echo Functions::T("Control");?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($list as $group){
                        ?>
                        <tr>
                            <td class="center">
                                <label>
                                    <input type="checkbox" value="<?php echo $group['id'];?>" class="ace"/>
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td><?php echo $group['name'];?></td>
                            <td><?php echo $group['description'];?></td>
                            <td>
                                <span style="margin-left: 5px;" data-toggle="modal" data-target="#permissionModal" onclick="javascript:setPermission('<?php echo Yii::app()->getBaseUrl(true);?>/users/group/control/permission/id/<?php echo $group['id'];?>?goback=<?php echo Yii::app()->request->getUrl();?>','<?php echo json_encode(Functions::getListPermission($group['id']));?>')">
                                    <span class="blue">
                                        <i class="icon-key bigger-120"></i>
                                    </span>
                                </span>
                                <span style="margin-left: 5px;" data-toggle="modal" data-target="#editModal" onclick="javascript:setInfo('<?php echo Yii::app()->getBaseUrl(true);?>/users/group/control/edit/id/<?php echo $group['id'];?>?goback=<?php echo Yii::app()->request->getUrl();?>','<?php echo $group["name"];?>','<?php echo $group["description"];?>')">
                                    <span class="green">
                                        <i class="icon-edit bigger-120"></i>
                                    </span>
                                </span>
                                <a style="margin-left: 5px;" href="javascript:submit_c('<?php echo Functions::T("Are you want to delete user?"); ?>','<?php echo Yii::app()->getBaseUrl(true);?>/users/group/control/delete/id/<?php echo $group['id'];?>')">
                                    <span class="red">
                                        <i class="icon-trash bigger-120"></i>
                                    </span>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <button class="btn btn-danger btn-xs" onclick="javascript:delList();">
            <i class="icon-trash"></i>
            Delete
        </button>
        <div class="thumbnail center-block pull-right" style="width: 400px; margin-top: 10px; padding: 20px; display: inline-block; vertical-align: top;">
            <form method="post" action="<?php echo Yii::app()->getBaseUrl(true);?>/users/group">
                <input name="name" type="text" class="form-control" placeholder="<?php echo Functions::T("Name");?>" type="text" style="margin-top: 10px;"/>
                <input name="description" class="form-control" placeholder="<?php echo Functions::T("Description");?>" type="text" style="margin-top: 10px;"/>
                <button type="submit" class="btn btn-danger pull-right" style="margin-top: 10px;"><?php echo Functions::T("Add group");?></button>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
     aria-hidden="true">
    <div class="modal-dialog list_drop" style="width: 300px; margin:80px auto;">
        <div class="modal-content">
            <form id="formChange" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo Functions::T("Change Description"); ?></h4>
                </div>
                <div class="modal-body" style="line-height: 20px;">
                    <input id="formChange-name" name="name" class="form-control" placeholder="<?php echo Functions::T("Name");?>" style="margin-top: 10px;"/>
                    <input id="formChange-description" name="description" class="form-control" placeholder="<?php echo Functions::T("Description");?>" style="margin-top: 10px;"/>
                    <input type="submit" class="btn btn-danger pull-right" style="margin-top: 10px;" value="<?php echo Functions::T("Submit");?>"/>
                    <div class="clr"></div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="permissionModalLabel"
     aria-hidden="true">
    <div class="modal-dialog list_drop" style="width: 300px; margin:80px auto;">
        <div class="modal-content">
            <form id="formPermission" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo Functions::T("Change Permission"); ?></h4>
                </div>
                <div class="modal-body" style="line-height: 20px;">
                    <select name="permission[]" id="formPermission-select"  multiple="" class="width-80 chosen-select">
                        <?php
                            $menu = Auth::getAllMenu();
                            foreach($menu as $cat => $act){
                                ?>
                                <optgroup label="<?php echo $cat?>">
                                <?php
                                foreach ($act as $key => $value) {
                                ?>
                                <option value="<?php echo $value['id'];?>"><?php echo $key;?></option>
                                <?php
                                }
                                ?>
                                </optgroup>
                                <?php
                            }
                        ?>
                    </select>
                    <input type="submit" class="btn btn-danger pull-right" style="margin-top: 10px;" value="<?php echo Functions::T("Submit");?>"/>
                    <div class="clr"></div>
                </div>
            </form>
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
<script>
    function delList(){
        if(confirm("Bạn có muốn xoá những nhóm khoản này")){
            var list = $("input[type=checkbox]:checked");
            var data = "(";
            for(var i=0; i<list.length; i++){
                var tmp = $(list[i]).val();
                if(tmp != "on") data += tmp+",";
            }
            data += "0)";
            window.location.href = "<?php echo Yii::app()->getBaseUrl(true)?>/users/group/control/dellist/id/"+data+"?goback=<?php echo Yii::app()->request->URL;?>";
        };
    }
    function submit_c(msg, url){
        if(confirm(msg)){
            window.location.href = url+"?goback=<?php echo Yii::app()->request->getUrl();?>"
        }
    }
    function setInfo(url,name,des){
        $("#formChange").attr('action', url);
        $("#formChange-name").val(name);
        $("#formChange-description").val(des);
    }
    function setPermission(url, permission){
        var per_list = JSON.parse(permission);
        $("#formPermission-select option").each(function() {
            $(this).attr('selected',false);
            if(per_list.indexOf(parseInt($(this).val())) != -1) $(this).attr('selected',true);
        });
        $(".chosen-select").chosen('destroy');
        $(".chosen-select").chosen();
        $("#formPermission_select_chosen").css('width', '100%');
        $("#formPermission").attr('action', url);
    }
</script>