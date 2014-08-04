<div id="main-content" class="text-center">
    <div class="thumbnail center-block" style="width: 60%; min-width: 500px; margin-top: 10px; padding: 20px; display: inline-block; vertical-align: top;">
        <div style="margin:10px 0px; text-align: left">
            <input class="search form-control" placeholder="<?php echo Functions::T("Keyword");?>" type="search">
        </div>
        <table class="tablesorter table table-bordered table-striped table-hover text-left">
            <thead>
                <tr class="bar-style red">
                    <th><?php echo Functions::T("Username");?></th>
                    <th><?php echo Functions::T("Is ban");?></th>
                    <th><?php echo Functions::T("Control");?></th>
                </tr>
            </thead>
            <?php
                foreach($list as $user){
                    ?>
                    <tr>
                        <td><?php echo $user['username'];?></td>
                        <td><a href="<?php echo Yii::app()->getBaseUrl(true);?>/admin/user/control/<?php echo ($user['baned'] == 1)?'unban':'ban';?>/id/<?php echo $user['id'];?>?goback=<?php echo Yii::app()->request->getUrl();?>" class="btn btn-default" style="height: 20px; line-height: 20px; padding: 0px 10px;"><?php echo ($user['baned'] == 1)?Functions::T("Remove ban"):Functions::T("Ban");?></a></td>
                        <td>
                            <span class="btn btn-default" style="height: 20px; line-height: 20px; padding: 0px 10px;" data-toggle="modal"
                                  data-target="#groupModal" onclick="javascript:setGroup('<?php echo Yii::app()->getBaseUrl(true);?>/admin/user/control/group/id/<?php echo $user['id'];?>?goback=<?php echo Yii::app()->request->getUrl();?>','<?php echo json_encode(Functions::getListGroup($user['id']));?>')"><?php echo Functions::T("Group");?></span>
                            <span class="btn btn-default" style="height: 20px; line-height: 20px; padding: 0px 10px;" data-toggle="modal"
                                  data-target="#editModal" onclick="javascript:setURL('<?php echo Yii::app()->getBaseUrl(true);?>/admin/user/control/edit/id/<?php echo $user['id'];?>?goback=<?php echo Yii::app()->request->getUrl();?>')"><?php echo Functions::T("Reset password");?></span>
                            <a href="javascript:submit_c('<?php echo Functions::T("Are you want to delete user?"); ?>','<?php echo Yii::app()->getBaseUrl(true);?>/admin/user/control/delete/id/<?php echo $user['id'];?>')" class="btn btn-default" style="height: 20px; line-height: 20px; padding: 0px 10px;"><?php echo Functions::T("Delete");?></a>
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </table>
        <div id="pager" class="pager">
            <form>
                <span class="first glyphicon glyphicon-fast-backward" style="cursor: pointer;"></span>
                <span class="prev glyphicon glyphicon-backward" style="cursor: pointer;"></span>
                <input type="text" class="pagedisplay form-control" style="display: inline-block; width: 200px;"/>
                <span class="next glyphicon glyphicon-forward" style="cursor: pointer;"></span>
                <span class="last glyphicon glyphicon-fast-forward" style="cursor: pointer;"></span>
                <select class="pagesize form-control" style="display: inline-block; width: 50px; padding: 5px 5px;">
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                </select>
            </form>
        </div>
    </div>
    <div class="thumbnail center-block" style="width: 30%; min-width: 200px; margin-top: 10px; padding: 20px; display: inline-block; vertical-align: top;">
        <form method="post" action="<?php echo Yii::app()->getBaseUrl(true);?>/admin/user">
            <input name="username" class="form-control" placeholder="<?php echo Functions::T("Username");?>" style="margin-top: 10px;"/>
            <input name="password" class="form-control" placeholder="<?php echo Functions::T("Password");?>" type="password" style="margin-top: 10px;"/>
            <input name="confirm_password" class="form-control" placeholder="<?php echo Functions::T("Confirm password");?>" type="password" style="margin-top: 10px;"/>
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
                    <select name="group[]" id="formGroup-select" class="selectpicker form-control" multiple>
                        <?php
                        foreach($group_list as $group){
                            ?>
                            <option value="<?php echo $group['id'];?>"><?php echo $group['name'];?></option>
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
<script>
    var table = $(".tablesorter").tablesorter({
        widgets: ["zebra", "filter", "resizable"],
        widgetOptions: {
            filter_anyMatch: true,
            filter_columnFilters: false,
            filter_reset: '.reset'
        }
    }).tablesorterPager({
            container: $("#pager"),
            size: 20
        });
    $(".selectpicker").selectpicker();
    $.tablesorter.filter.bindSearch(table, $('.search'));
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
        $(".selectpicker").selectpicker('refresh');
        $("#formGroup").attr('action', url);
    }
</script>