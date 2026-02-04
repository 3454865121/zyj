<div style="width: 90%; margin: 10px auto; border: 1px solid #ccc; text-align: center">
    <?php
    error_reporting(0);
    $type=trim($_GET['type']);
    $page=isset($_GET['page'])?$_GET['page']:0;//从零开始
    $id=trim($_GET['id']);
    $imgnums = 3;    //每页显示的图片数
    $path="img";   //图片保存的目录
    
    if ($type=="del"){
        echo '确定清空所有照片？<br /><br />';
        echo "<a href=?type=dell&id=$id>确定</a> <a href=javascript:history.back(-1)>返回上一页</a> <br /><br />";
        exit;
    }elseif($type=="dell"){
        //清空照片函数
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
           list($filesname,$ext)=explode(".",$file);
           if($ext=="png" and explode('_', $filesname)[0]==$id) {
               if (!is_dir('./'.$file)) {
                  unlink('./img/'.$file);
               }
           }
        }
        echo '该ID下的所有照片已经清除！<br /><br />';
    }
    
    $handle = opendir($path);
    $i=0;
    while (false !== ($file = readdir($handle))) {
       list($filesname,$ext)=explode(".",$file);
       if($ext=="png" and explode('_', $filesname)[0]==$id) {
           if (!is_dir('./'.$file)) {
              $array[]=$file;//保存图片名称
              ++$i;
           }
       }
    }
    if($array){
       rsort($array);
       echo "<a href=?page=$page&id=$id&type=del>清空所有照片</a> <br /><br />";
    }
    else{
        echo "该ID下没有任何照片 <br /><br />";
    }
    for($j=$imgnums*$page; $j<($imgnums*$page+$imgnums)&&$j<$i; ++$j){
       echo '<div>';
       echo "<img src=".$path."/".$array[$j]."><br /><br />";
       echo '</div>';
    }
    $realpage = @ceil($i / $imgnums) - 1;
    $Prepage = $page-1;
    $Nextpage = $page+1;
    if($Prepage<0){
       echo "上一页 ";
       echo "<a href=?page=$Nextpage&id=$id>下一页</a> ";
       echo "<a href=?page=$realpage&id=$id>末页</a> ";
    }elseif($Nextpage >= $realpage){
       echo "<a href=?page=0&id=$id>首页</a> ";
       echo " <a href=?page=$Prepage&id=$id>上一页</a> ";
       echo " 下一页";
    }else{
       echo "<a href=?page=0&id=$id>首页</a> ";
       echo "<a href=?page=$Prepage&id=$id>上一页</a> ";
       echo "<a href=?page=$Nextpage&id=$id>下一页</a> ";
       echo "<a href=?page=$realpage&id=$id>末页</a> ";
    }
    ?>
</div>