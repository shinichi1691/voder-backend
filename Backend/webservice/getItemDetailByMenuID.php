<?php
    $response= array();
    $response['function'] = 'fncGetItemDetail';
    $screenID = "";
    if($_POST['screenID'] != 'undefined'){
        $screenID = $_POST['screenID'];
    }
    $response['screenID'] = $screenID;
    
    require_once __DIR__ .'/db_connect.php';
    $db= new DB_CONNECT();

    $menuID = $_POST['menuID'];
    $sql = " select * from item_detail where menuID = $menuID and inactive = 0 ";
    $query = mysql_query($sql);
    if(mysql_num_rows($query) > 0){
        $response["responseCode"] = 1;
        $response["msg"] = "Successful";        
        $response["data"] = array();
        
        while($row = mysql_fetch_array($query,MYSQL_ASSOC)){
            array_push($response["data"],$row);
        }
        echo json_encode($response);
    }else {
        $response["responseCode"]=0;
        $response["msg"]="No record found";
        $response["data"] = null;
        echo json_encode($response);
    }
?>