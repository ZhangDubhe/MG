<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/16
 * Time: 1:24
 */
?>
<script>
	console.clear();
	var j = 0;
	var k = 0;
	var l = 0;
	var point_1=new Array();
	var point_2=new Array();
	var point_3=new Array();
	var point_all=new Array();
	var allIcon = {
		radius: 8,
		fillColor: "#ff7800",
		color: "#000",
		weight: 1,
		opacity: 1,
		fillOpacity: 0.8
	};

	var themeIcon ={
		fillColor: "#ff2148",
		color: "#000",
		radius: 8,
		weight: 1,
		opacity: 1,
		fillOpacity: 0.8
	};
	var artIcon ={
		fillColor: "#78ff02",
		color: "#000",
		radius: 8,
		weight: 1,
		opacity: 1,
		fillOpacity: 0.8
	};
	function only_on() {
		var Obj1=document.getElementById('Checkbox1');
		var Obj2=document.getElementById('Checkbox2');
		var Obj3=document.getElementById('Checkbox3');


		if(Obj1.checked==true){
			if(j==0){only_1_on();}
		}
		else {
			while(j>0){
				point_1[j].remove();
				j=j-1;
			};
		}
		if(Obj2.checked==true){
			if(k==0){only_2_on();}
		}
		else
		{
			while(k>0){
				point_2[k].remove();
				k--;
			}
		}
		if(Obj3.checked==true ){
			if(l==0){only_3_on();}
		}
		else
		{
			while(l>0){
				point_3[l].remove();
				l=l-1;
			}
		}
		function only_1_on() {
            <?php
            $sql = "SELECT * FROM total where `mg_type`=1";
            $check_name = mysql_query($sql);
            $_i = 1;
            while($row = mysql_fetch_assoc($check_name)){
            ?>
			j=<?php echo $_i;$_i++ ?>;
			point_1[j] = L.circleMarker([<?php echo($row['lat']) ?>,<?php echo($row['lon']) ?>],allIcon)
				.bindPopup("<?php
                    $p_name = $row['mg_name'];
                    echo("<span onclick='check_here(".$p_name.");change_heart()'class='glyphicon glyphicon-heart'><h5><a class='pop_a' target='blank'  href='".$row['website']."' >".$row['mg_name']."</a></h5></span>");
                    echo("<br/>地址：");
                    echo($row['address']);
                    echo("<br/>");
                    echo($row['price_text']);
                    echo("<br/>开放时间：");
                    echo($row['opening_time'])
                    ?>");//待打开的pop及marker
			point_1[j].addTo(map);
            <?php } ?>

		}
		function only_2_on() {
            <?php
            $sql = "SELECT * FROM total where `mg_type`=2";
            $check_name = mysql_query($sql);
            $_i = 1;
            while($row = mysql_fetch_assoc($check_name)){
            ?>
			k=<?php echo $_i;$_i++ ?>;
			point_2[k] = L.circleMarker([<?php echo($row['lat']) ?>,<?php echo($row['lon']) ?>],themeIcon)
				.bindPopup("<?php
                    $p_name = $row['mg_name'];
                    echo("<span onclick='check_here($p_name);change_heart()'class='glyphicon glyphicon-heart'><h5><a class='pop_a' target='blank'  href='".$row['website']."' >".$row['mg_name']."</a></h5></span>");
                    echo("<br/>地址：");
                    echo($row['address']);
                    echo("<br/>");
                    echo($row['price_text']);
                    echo("<br/>开放时间：");
                    echo($row['opening_time'])
                    ?>");//待打开的pop及marker
			point_2[k].addTo(map);
            <?php } ?>
		}
		function only_3_on() {
            <?php
            $sql = "SELECT * FROM total where `mg_type`=3";
            $check_name = mysql_query($sql);
            $_i = 1;
            while($row = mysql_fetch_assoc($check_name)){
            ?>
			l=<?php echo $_i ;$_i++?>;
			point_3[l] = L.circleMarker([<?php echo($row['lat']) ?>,<?php echo($row['lon']) ?>],artIcon)
				.bindPopup("<?php
                    $p_name = $row['mg_name'];
                    echo("<span onclick='check_here($p_name);change_heart()'class='glyphicon glyphicon-heart'><h5><a class='pop_a' target='blank'  href='".$row['website']."' >".$row['mg_name']."</a></h5></span>");
                    echo("<br/>地址：");
                    echo($row['address']);
                    echo("<br/>");
                    echo($row['price_text']);
                    echo("<br/>开放时间：");
                    echo($row['opening_time'])
                    ?>");//待打开的pop及marker
			point_3[l].addTo(map);
			console.log(point_3[l])
            <?php } ?>

		}


	}


	var list_id=0;
    <?php
    $sql = "SELECT * FROM total ";//查询所有的地点，并标记为id
    $check_name = mysql_query($sql);
    while($row = mysql_fetch_assoc($check_name)){?>
	list_id= <?php  echo($row['mg_id']) ?>;
	point_all[list_id] = L.marker([<?php echo($row['lat']) ?>,<?php echo($row['lon']) ?>])
		.bindPopup("<?php
            $p_name = $row['mg_name'];
            echo("<span onclick='check_here($p_name);change_heart()'class='glyphicon glyphicon-heart'><h5><a class='pop_a' target='blank'  href='".$row['website']."' >".$row['mg_name']."</a></h5></span>");
            echo("<br/>地址：");
            echo($row['address']);
            echo("<br/>");
            echo($row['price_text']);
            echo("<br/>开放时间：");
            echo($row['opening_time'])
            ?>");//待打开的pop及marker

    <?php } ?>
</script>
