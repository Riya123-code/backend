<?php


//will contain code to select from this table and more SQL Actions

function get_style_details($id){
    $user_id= $id;
    require "../the_connector/connect_area.php";
    $stmt = $connect->prepare("SELECT * FROM `style` WHERE `style_id`=?;");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if(!$stmt){
        echo "could not get the results";
        return array();
    }else{
        $row = $result->fetch_assoc();
        return $row;
    }
    $stmt->close();
}


function get_all_style(){
	require "../the_connector/connect_area.php";

	$result = array();
		//$category_ = 'driver';
		$stmt = $connect->prepare("SELECT `style_id`, `user_id`, `style_name`, `type`, `style_default`, `style_values`, `addon`, `description`, `likes`, `property`, `date_time` FROM `style`");
		$stmt->execute();
		$stmt->bind_result($style_id, $user_id, $style_name, $type, $style_default, $style_values, $addon, $description, $likes, $property, $date_time );

		if(!$stmt){
			$result = array("status"=>"false", "msg"=>"Could not get the coins symbols.");

		}elseif($stmt){
			while ($stmt->fetch()) {
				array_push($result, array( "id"=>$style_id, "user_id"=>$user_id, "style_name"=>$style_name, "type"=>$type, "style_default"=>$style_default, "style_values"=>$style_values, "addon"=>$addon, "description"=>$description, "likes"=>$likes, "property"=>$property, "date_time"=>$date_time) );
			}
	}
	
	$stmt->close();
	return $result;
}

function get_all_raw_style(){
    require "../the_connector/connect_area.php";

	$result = "";
    $stmt = $connect->prepare("SELECT `style_id`, `user_id`, `style_name`, `type`, `style_default`, `style_values`, `addon`, `description`, `likes`, `property`, `date_time` FROM `style`");
    $stmt->execute();
    $stmt->bind_result($style_id, $user_id, $style_name, $type, $style_default, $style_values, $addon, $description, $likes, $property, $date_time );

    if(!$stmt){
        $result = array("status"=>"false", "msg"=>"Could not get the coins symbols.");

    }elseif($stmt){
        while ($stmt->fetch()) {
            //array_push($result, array( "id"=>$style_id, "user_id"=>$user_id, "style_name"=>$style_name, "type"=>$type, "style_default"=>$style_default, "style_values"=>$style_values, "addon"=>$addon, "description"=>$description, "likes"=>$likes, "property"=>$property, "date_time"=>$date_time) );
            $styleDiv = `~<li class="each_item">
					<input onchange="style_changed('padding')" id="style_padding_status"  class="the_check_side" type="checkbox" checked value="yes" name="_padding_state">
					<label>Padding</label>
					<input onkeyup="style_changed('padding')" id="style_padding" class="the_input_side" type="text" name="style_padding_value">
				</li>`;
            $result = $result . $styleDiv; 
        }
	}
	
	$stmt->close();
	return $result;
}
	
if (isset($_GET['echo'])) {
    //print("entered here");
    if($_GET['echo'] == "json"){
        print( json_encode(["status"=>"true", "result"=>get_all_style(),  "msg"=>"Done Loading style."] ));
    }else if($_GET['echo'] == "raw"){
        print( json_encode(["status"=>"true", "result"=>get_all_raw_style(),  "msg"=>"Done Loading style."] ));
    }
}else{
	//echo(json_encode(["status"=>"false", "msg"=>"Parameters not complete"]));
    //can just be included as function in another php file.. 
}

?>