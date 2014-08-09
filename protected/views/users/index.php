<div class="page-header">
    <h1>
        Tài khoản
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="table-header">Danh sách tài khoản</div>
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
                        <th><?php echo Functions::T("Username");?></th>
                        <th><?php echo Functions::T("First name");?></th>
                        <th><?php echo Functions::T("Birthday");?></th>
                        <th><?php echo Functions::T("Address");?></th>
                        <th><?php echo Functions::T("Is ban");?></th>
                        <th><?php echo Functions::T("Control");?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($list as $user){
                        ?>
                        <tr>
                            <td class="center">
                                <label>
                                    <input type="checkbox" value="<?php echo $user['id'];?>" class="ace"/>
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td><?php echo $user['username'];?></td>
                            <td><?php echo $user['last_name']." ".$user['first_name'];?></td>
                            <td><?php echo $user['birthday'];?></td>
                            <td><?php echo $user['address'];?></td>
                            <td>
                                <a href="<?php echo Yii::app()->getBaseUrl(true);?>/users/index/control/<?php echo ($user['baned'] == 1)?'unban':'ban';?>/id/<?php echo $user['id'];?>?goback=<?php echo Yii::app()->request->getUrl();?>" class="label label-warning">
                                    <i class="icon-warning-sign bigger-120"></i>
                                    <?php echo ($user['baned'] == 1)?Functions::T("Remove ban"):Functions::T("Ban");?>
                                </a>
                            </td>
                            <td>
                                <span style="margin-left: 5px;" data-toggle="modal" data-target="#groupModal" onclick="javascript:setGroup('<?php echo Yii::app()->getBaseUrl(true);?>/users/index/control/group/id/<?php echo $user['id'];?>?goback=<?php echo Yii::app()->request->getUrl();?>','<?php echo json_encode(Functions::getListGroup($user['id']));?>')">
                                    <span class="blue">
                                        <i class="icon-group bigger-120"></i>
                                    </span>
                                </span>
                                <span style="margin-left: 5px;" data-toggle="modal" data-target="#editModal" onclick="javascript:setURL('<?php echo Yii::app()->getBaseUrl(true);?>/users/index/control/edit/id/<?php echo $user['id'];?>?goback=<?php echo Yii::app()->request->getUrl();?>')">
                                    <span class="green">
                                        <i class="icon-key bigger-120"></i>
                                    </span>
                                </span>
                                <a style="margin-left: 5px;" href="javascript:submit_c('<?php echo Functions::T("Are you want to delete user?"); ?>','<?php echo Yii::app()->getBaseUrl(true);?>/users/index/control/delete/id/<?php echo $user['id'];?>')">
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
        <button class="btn btn-inverse btn-xs" onclick="javascript:banList();">
            <i class="icon-lock"></i>
            Ban
        </button>
        <button class="btn btn-success btn-xs" onclick="javascript:unbanList();">
            <i class="icon-lock"></i>
            Unban
        </button>
        <button class="btn btn-danger btn-xs" onclick="javascript:delList();">
            <i class="icon-trash"></i>
            Delete
        </button>
        <div class="thumbnail center-block pull-right" style="width: 400px; margin-top: 10px; padding: 20px; display: inline-block; vertical-align: top;">
            <form method="post" action="<?php echo Yii::app()->getBaseUrl(true);?>/users/index">
                <input name="username" type="text" class="form-control" placeholder="<?php echo Functions::T("Username");?>" style="margin-top: 10px;"/>
                <input name="password" class="form-control" placeholder="<?php echo Functions::T("Password");?>" type="password" style="margin-top: 10px;"/>
                <input name="confirm_password" class="form-control" placeholder="<?php echo Functions::T("Confirm password");?>" type="password" style="margin-top: 10px;"/>
                <div class="input-group" style="margin-top: 10px;">
                    <input name="birthday" class="form-control date-picker" id="id-date-picker-1" type="text" value="1990-01-01" data-date-format="yyyy-mm-dd" />
                    <span class="input-group-addon" onclick="$('#id-date-picker-1').focus();">
                        <i class="icon-calendar bigger-110"></i>
                    </span>
                </div>
                <input name="first_name" class="form-control" placeholder="<?php echo Functions::T("First name");?>" type="text" style="margin-top: 10px;"/>
                <input name="last_name" class="form-control" placeholder="<?php echo Functions::T("Last name");?>" type="text" style="margin-top: 10px;"/>
                <input name="address" class="form-control" placeholder="<?php echo Functions::T("Address");?>" type="text" style="margin-top: 10px;"/>
                <button type="submit" class="btn btn-danger pull-right" style="margin-top: 10px;"><?php echo Functions::T("Add user");?></button>
            </form>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog list_drop" style="width: 300px; margin:80px auto;">
        <div class="modal-content">
            <form id="formChangePass" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo Functions::T("Reset password"); ?></h4>
                </div>
                <div class="modal-body" style="line-height: 20px;">
                    <input name="password" class="form-control" placeholder="<?php echo Functions::T("Password");?>" type="password" style="margin-top: 10px;"/>
                    <input name="confirm_password" class="form-control" placeholder="<?php echo Functions::T("Confirm password");?>" type="password" style="margin-top: 10px;"/>
                    <input type="submit" class="btn btn-danger pull-right" style="margin-top: 10px;" value="<?php echo Functions::T("Submit");?>"/>
                    <div class="clr"></div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="groupModalLabel"
aria-hidden="true">
<div class="modal-dialog list_drop" style="width: 300px; margin:80px auto;">
    <div class="modal-content">
        <form id="formGroup" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo Functions::T("Change Group"); ?></h4>
            </div>
            <div class="modal-body" style="line-height: 20px;">
                <select multiple="" class="width-80 chosen-select" name="group[]" id="formGroup-select">
                        <?php
                        foreach($group_list as $group){
                            ?>
                            <option value="<?php echo $group['id'];?>"><?php echo $group['name'];?></option>
                        <?php
                        }
                        ?>
                </select>
                <div class="clr"></div>
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
<script>
    function delList(){
        if(confirm("Bạn có muốn xoá những tài khoản này")){
            var list = $("input[type=checkbox]:checked");
            var data = "(";
            for(var i=0; i<list.length; i++){
                var tmp = $(list[i]).val();
                if(tmp != "on") data += tmp+",";
            }
            data += "0)";
            window.location.href = "<?php echo Yii::app()->getBaseUrl(true)?>/users/index/control/dellist/id/"+data+"?goback=<?php echo Yii::app()->request->URL;?>";
        };
    }
    function banList(){
        if(confirm("Bạn có muốn chặn những tài khoản này")){
            var list = $("input[type=checkbox]:checked");
            var data = "(";
            for(var i=0; i<list.length; i++){
                var tmp = $(list[i]).val();
                if(tmp != "on") data += tmp+",";
            }
            data += "0)";
            window.location.href = "<?php echo Yii::app()->getBaseUrl(true)?>/users/index/control/banlist/id/"+data+"?goback=<?php echo Yii::app()->request->URL;?>";
        };
    }
    function unbanList(){
        if(confirm("Bạn có muốn bỏ chặn những tài khoản này")){
            var list = $("input[type=checkbox]:checked");
            var data = "(";
            for(var i=0; i<list.length; i++){
                var tmp = $(list[i]).val();
                if(tmp != "on") data += tmp+",";
            }
            data += "0)";
            window.location.href = "<?php echo Yii::app()->getBaseUrl(true)?>/users/index/control/unbanlist/id/"+data+"?goback=<?php echo Yii::app()->request->URL;?>";
        };
    }
    $(document).ready(function(){
        $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
    });
    function setURL(url){
        $("#formChangePass").attr('action', url);
    }
    function submit_c(msg, url){
        if(confirm(msg)){
            window.location.href = url+"?goback=<?php echo Yii::app()->request->getUrl();?>"
        }
    }
    function setGroup(url, group){
        var group_list = JSON.parse(group);
        $("#formGroup-select option").each(function() {
            $(this).attr('selected',false);
            if(group_list.indexOf(parseInt($(this).val())) != -1) $(this).attr('selected',true);
        });
        $(".chosen-select").chosen('destroy');
        $(".chosen-select").chosen();
        $("#formGroup_select_chosen").css('width', '100%');
        $("#formGroup").attr('action', url);
    }
</script>