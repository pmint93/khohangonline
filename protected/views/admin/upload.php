<div style="text-align: center;">
    <div class="box upload">
        <span id="fileuploader" class="box upload">+</span>
    </div>
    <div class="box link">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 200px;">Name</th>
                    <th style="width: 400px;">Link</th>
                </tr>
            </thead>
            <tbody id="body">

            </tbody>
        </table>
    </div>
</div>
<script>
    $("#fileuploader").uploadFile({
        url:"<?php echo Yii::app()->getBaseUrl(true)?>/upload/addfile",
        fileName:"myfile",
        showDone: false,
        showDelete: true,
        deleteCallback: function(data,pd)
        {
            data = JSON.parse(data);
            console.log(data)
            for(var i=0;i<data.length;i++)
            {
                $.post("<?php echo Yii::app()->getBaseUrl(true)?>/upload/delete",{op:"delete",name:data[i]},
                    function(resp, textStatus, jqXHR)
                    {
                        for(var i = 0; $("#body").children().length; i++){
                            if($($("#body").children()[i]).attr('value') == data[i]) $($("#body").children()[i]).remove();
                        }
                    });
            }
            pd.statusbar.hide(); //You choice to hide/not.

        },
        allowedTypes: "jpg,png,gif,jpeg,zip",
        onSuccess:function(files,data,xhr)
        {
            data = JSON.parse(data);
            for(var i = 0; i< data.length; i++){
                var arr = data[i].split(".");
                $("#body").append("<tr value='"+data[i]+"'>" +
                    "<td>"+arr[1]+"</td>"+
                    "<td><?php echo Yii::app()->getBaseUrl(true)?>/download/files/id/"+data[i]+"</td>"+
                    "</tr>")
            }
        }
    });
</script>