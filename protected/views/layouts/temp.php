<?php
if(!isset($_REQUEST['htck'])) die("Invalid parameters");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta property="og:description" content="">
    <meta property="og:title" content="Coca cola">
    <meta property="og:image" content="<?php echo "http://".$_SERVER[HTTP_HOST]."/Coca/coca.png?htck=".$_REQUEST['htck']; ?>">
    <title></title>
</head>
<body>
<div id="fb-root"></div>
<div class="fb-share-button" data-href="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"></div>
<img src="<?php echo "http://".$_SERVER[HTTP_HOST]."/Coca/coca.png?htck=".$_REQUEST['htck']; ?>" />


<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=1472431506328153&version=v2.0";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

</body>
</html>