/**
 * Created by Zhanght on 2016/12/12.
 */
$(function () {
    $(".list_tag").click(function () {
        $_i=this.attr("name");
        //console.debug($_i);
        console.debug("1111111");
    });
})


function choose(){
    var m=0;
<?php
        $check_3 = "SELECT a.art_id,t.mg_type,t.mg_id from total t JOIN artmuseum a WHERE
    a.mg_id=t.mg_id";
    $select = mysql_query($check_3);
    $_i = 1;
    while($row = mysql_fetch_assoc($select)){
            ?>
        if(<?php $row["mg_type"] ?>==3){

            while(m<l){

            };
        <?}?>
    }

}