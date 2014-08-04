<div id="main-content" style="padding-top: 10px; background: #fff; line-height: 14px;">
<?php
if(isset($_GET['control']) && ($_GET['control'] == "new")){
    ?>
    <div class="center-block text-right" style="width: 50%;"><a href="<?php echo Yii::app()->getBaseUrl(true)?>/admin/genform/id/<?php echo $_GET['id']?>"><div class="btn btn-default">Back</div></a></div>
    <form class="form-horizontal" role="form" style="width: 50%; margin: 10px auto;" method="post" action="<?php echo Yii::app()->getBaseUrl(true)?>/admin/genform/id/<?php echo $_GET['id']?>/control/new">
        <?php
        foreach ($obj->label as $key => $value) {
            ?>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $value['name'];?></label>
                <div class="col-sm-10">
                    <?php
                    if(strtoupper($value['type']) == "RELATION"){
                        $relationTable = ucfirst($value['table'])."Model";
                        $objRelation = new $relationTable();
                        $tmp = $objRelation->findAll();
                        ?>
                        <select class="form-control selectpicker" data-live-search="true" name="<?php echo $key;?>">
                            <option value="">Nothing...</option>
                            <?php
                            foreach($tmp as $i=>$val){
                                ?>
                                <option value="<?php echo $val['id'];?>"><?php echo $val[$objRelation->label_select];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    <?php
                    } else if(strtoupper($value['type']) == "STRING"){
                        ?>
                        <textarea class="form-control" name="<?php echo $key;?>" typeValue="<?php echo $value['type'];?>" placeholder="<?php echo $value['name'];?>"></textarea>
                    <?php
                    }
                    else{
                        ?>
                        <input class="form-control" name="<?php echo $key;?>" typeValue="<?php echo $value['type'];?>" placeholder="<?php echo $value['name'];?>">
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
<?php
}
else if(isset($_GET['control']) && ($_GET['control'] == "edit")){
    ?>
    <div class="center-block text-right" style="width: 50%;"><a href="<?php echo Yii::app()->getBaseUrl(true)?>/admin/genform/id/<?php echo $_GET['id']?>"><div class="btn btn-default">Back</div></a></div>
    <form class="form-horizontal" role="form" style="width: 50%; margin: 10px auto;" method="post" action="<?php echo Yii::app()->getBaseUrl(true)?>/admin/genform/id/<?php echo $_GET['id']?>/control/edit/child/<?php echo $_GET['child'];?>">
        <?php
        $data = $obj->find("id = ".$_GET['child']);
        foreach ($obj->label as $key => $value) {
            ?>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $value['name'];?></label>
                <div class="col-sm-10">
                    <?php
                    if(strtoupper($value['type']) == "RELATION"){
                        $relationTable = ucfirst($value['table'])."Model";
                        $objRelation = new $relationTable();
                        $tmp = $objRelation->findAll();
                        ?>
                        <select class="form-control selectpicker" data-live-search="true" name="<?php echo $key;?>">
                            <option value="">Nothing...</option>
                            <?php
                            foreach($tmp as $i=>$val){
                                ?>
                                <option value="<?php echo $val['id'];?>" <?php if($data[$key] == $val['id']) echo "selected";?>><?php echo $val[$objRelation->label_select];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    <?php
                    } else if(strtoupper($value['type']) == "STRING"){
                        ?>
                        <textarea class="form-control" name="<?php echo $key;?>" typeValue="<?php echo $value['type'];?>" placeholder="<?php echo $value['name'];?>"><?php echo $data[$key];?></textarea>
                    <?php
                    }
                    else{
                        ?>
                        <input class="form-control" name="<?php echo $key;?>" typeValue="<?php echo $value['type'];?>"  value="<?php echo $data[$key];?>" placeholder="<?php echo $value['name'];?>">
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
<?php
}
else if(isset($obj)){
    ?>
    <div class="center-block text-left" style="width: 80%;">
        <a href="<?php echo Yii::app()->getBaseUrl(true)?>/admin/genform/id/<?php echo $_GET['id']?>/control/new"><div class="btn btn-default">Add</div></a>
    </div>
    <div style="width: 80%; overflow-x: scroll; margin: 10px auto;">
        <div style="margin:10px 0px; text-align: left">
            <input class="search form-control" placeholder="<?php echo Functions::T("Keyword");?>" type="search">
        </div>
        <table class="table table-bordered tablesorter">
            <thead>
            <tr>
                <?php
                foreach ($obj->label as $key => $value) {
                    if(isset($obj->hashCode[$key]) || (isset($obj->label[$key]['hide']) && $obj->label[$key]['hide'])) continue;
                    ?>
                    <th ><?php echo $value['name']; ?></th>
                <?php
                }
                ?>
                <th>Control</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $list = $obj->findAll();
            foreach ($list as $key => $value) {
                ?>
                <tr>
                    <?php
                    foreach ($obj->label as $key => $val) {
                        if(isset($obj->hashCode[$key]) || (isset($obj->label[$key]['hide']) && $obj->label[$key]['hide'])) continue;
                        if(strtoupper($val['type']) == "RELATION"){
                            $relationTable = ucfirst($val['table'])."Model";
                            $objRelation = new $relationTable();
                            $tmp = false;
                            if($value[$key] != "")$tmp = $objRelation->find("id = ".$value[$key]);
                            ?>
                            <td style="word-wrap: break-word; max-width: 200px;"><?php echo $tmp?Functions::m_htmlchars($tmp[$objRelation->label_select]):"NULL";?></td>
                        <?php
                        }
                        else{
                            ?>
                            <td style="word-wrap: break-word; max-width: 200px;"><?php echo Functions::m_htmlchars($value[$key]); ?></td>
                        <?php
                        }
                    }
                    ?>
                    <td style="text-align: center; line-height: 40px;">
                        <a href="<?php echo Yii::app()->getBaseUrl(true)?>/admin/genform/id/<?php echo $_GET['id']?>/control/edit/child/<?php echo $value['id'];?>"><span class="btn btn-default">Edit</span></a>
                        <a href="<?php echo Yii::app()->getBaseUrl(true)?>/admin/genform/id/<?php echo $_GET['id']?>/control/delete/child/<?php echo $value['id'];?>"><span class="btn btn-default">Delete</span></a>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
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
<?php
}
else{
    ?>
    <div class="thumbnail text-center center-block" style="width: 60%;">
        <?php
        foreach(ModelConfig::$config['database'] as $table=>$value){
            ?>
            <a href="<?php echo Yii::app()->getBaseUrl(true);?>/admin/genform/id/<?php echo $table;?>" class="btn btn-default" style="margin: 5px;"><?php echo ucfirst($table);?> Model</a>
        <?php
        }
        ?>
    </div>
<?php
}
?>
<script>
    $(document).ready(function(){
        var input = $(".form-control");
        for(var i=0; i< input.length; i++){
            var type = "text";
            try{
                if($(input[i]).attr('typeValue').toUpperCase() == "DATETIME") $(input[i]).datetimepicker({
                    lang: 'en',
                    timepicker: true,
                    format: 'Y-m-d H:i:s'
                });
                if($(input[i]).attr('typeValue').toUpperCase() == "DATE") $(input[i]).datetimepicker({
                    lang: 'en',
                    timepicker: false,
                    format: 'Y-m-d'
                });
            }
            catch(e){
                //
            }
        }
    });
    $(".selectpicker").selectpicker();
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
</script>
</div>