<div id="main-content" class="text-center">
    <div class="thumbnail center-block" style="width: 60%; min-width: 500px; margin-top: 10px; padding: 20px; display: inline-block; vertical-align: top;">
        <div style="margin:10px 0px; text-align: left">
            <input class="search form-control" placeholder="<?php echo Functions::T("Keyword");?>" type="search">
        </div>
        <table class="tablesorter table table-bordered table-striped table-hover text-left">
            <thead>
            <tr class="bar-style red">
                <th><?php echo Functions::T("Group name");?></th>
                <th><?php echo Functions::T("Description");?></th>
                <th><?php echo Functions::T("Control");?></th>
            </tr>
            </thead>
            <?php
            foreach($list as $group){
                ?>
                <tr>
                    <td><?php echo $group['name'];?></td>
                    <td><?php echo $group['description'];?></td>
                    <td>
                        <span class="btn btn-default" style="height: 20px; line-height: 20px; padding: 0px 10px;" data-toggle="modal"
                              data-target="#permissionModal" onclick="javascript:setPermission('<?php echo Yii::app()->getBaseUrl(true);?>/admin/group/control/permission/id/<?php echo $group['id'];?>?goback=<?php echo Yii::app()->request->getUrl();?>','<?php echo json_encode(Functions::getListPermission($group['id']));?>')"><?php echo Functions::T("Permission");?></span>
                        <span class="btn btn-default" style="height: 20px; line-height: 20px; padding: 0px 10px;" data-toggle="modal"
                              data-target="#editModal" onclick="javascript:setInfo('<?php echo Yii::app()->getBaseUrl(true);?>/admin/group/control/edit/id/<?php echo $group['id'];?>?goback=<?php echo Yii::app()->request->getUrl();?>','<?php echo $group["name"];?>','<?php echo $group["description"];?>')"><?php echo Functions::T("Edit");?></span>
                        <a href="javascript:submit_c('<?php echo Functions::T("Are you want to delete user?"); ?>','<?php echo Yii::app()->getBaseUrl(true);?>/admin/group/control/delete/id/<?php echo $group['id'];?>')" class="btn btn-default" style="height: 20px; line-height: 20px; padding: 0px 10px;"><?php echo Functions::T("Delete");?></a>
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
        <form method="post" action="<?php echo Yii::app()->getBaseUrl(true);?>/admin/group">
            <input name="name" class="form-control" placeholder="<?php echo Functions::T("Group name");?>" style="margin-top: 10px;"/>
            <input name="description" class="form-control" placeholder="<?php echo Functions::T("Description");?>" style="margin-top: 10px;"/>
            <button type="submit" class="btn btn-danger pull-right" style="margin-top: 10px;"><?php echo Functions::T("Add group");?></button>
        </form>
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
                    <select name="permission[]" id="formPermission-select" class="selectpicker form-control" multiple>
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
    $.tablesorter.filter.bindSearch(table, $('.search'));
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
    $(".selectpicker").selectpicker();
    function setPermission(url, permission){
        var per_list = JSON.parse(permission);
        $("#formPermission-select option").each(function() {
            $(this).attr('selected',false);
            if(per_list.indexOf(parseInt($(this).val())) != -1) $(this).attr('selected',true);
        });
        $(".selectpicker").selectpicker('refresh');
        $("#formPermission").attr('action', url);
    }
</script>