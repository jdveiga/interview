<?php
	
	
    /**
     * draw a particular level of the hourglass and printout on screen
     * @param type $height
     * @param type $n
     * @param type $t
     * @param type $top
     */
    function drawLevel($height,$n,$t,$top = true){
        $start = ($top) ? "\\" : "/";
        $stop = ($top) ? "/" : "\\";

        echo str_repeat("&nbsp;",$height-$n).$start.fillLevel($n,$t).$stop.str_repeat("&nbsp;",$height-$n)."<br/>";
    }
	
	/**
	 * Draw bottom portion of hourglass
	 * @param type $height - height of hourglass
	 * @param int $downCapacity - capacity of sand to fill down portion of hour glass
	 */
	function drawBottomLevel($height,$downCapacity){
		for($i=1;$i<=$height;$i++){
			drawLevel($height,$i,$downCapacity,false);
			$downCapacity -= $i;
		}
	}
	/**
         * Draw top portion of hourglass
         * @param type $height - height of hourglass
         * @param type $upCapacity - capacity of sand to fill top portion of hour glass
         */
	function drawTopLevel($height,$upCapacity){
            for($i=$height;$i>=1;$i--){
				drawLevel($height,$i,$upCapacity);
				$upCapacity -= $i;
            }
	}
	
	/**
	 * fill level of hourglass with sand
	 * @param type $n - current level of hourglass
	 * @param type $capacity - capacity to fill with sand at current hourglass level
	 * @return type
	 */
	function fillLevel($n,$capacity){
		$fill = ($capacity > $n) ? $n : $capacity;
		$spaces = ($fill > 0)? $n - $fill : $n;
		$text = "";

		if($fill >0){
			$text .= str_repeat("x",$fill);
		}

		if($spaces >0){
			$text .= str_repeat("&nbsp;",$spaces*2);
		}
		return $text;
		
	}
	
	/**
	 * Calculate total spaces in entire hourglass
	 * @param type $numLevels
	 * @return type
	 */
	function totalSpaces($numLevels){
		return (($numLevels * ($numLevels +1))/2) *2;
	}
	
	$errors = "";
	$height = 0;
	$capacity = 0;
	
	if(isset($_GET["height"])){
	
		$height = trim($_GET["height"]);
		
		if(!is_numeric($height) || (int)$height < 2){
			$errors .= 'Height must be greater than 1';
		}
		else{
			$height = (int) $height;
		}
	}
	
	if(isset($_GET["capacity"])){
		$capacity = trim($_GET["capacity"]);
		
		if(!is_numeric($capacity) || (int)$capacity < 0 && (int) $capacity > 100)){
			$errors .= 'Capacity must be between 0 to 100';
		}
		else{
			$capacity = (int) $capacity;
		}
	}

	
	$totalSpaces = totalSpaces($height);
	
	$upSpace = $totalSpaces/2;
	
	$downspace = $upSpace;

	$fillCapacity =  (int) (($capacity/100) * $totalSpaces);
	
	$upCapacity = ($fillCapacity > $upSpace) ? $upSpace : $fillCapacity;
	
	$downCapacity = ($upCapacity >= $upSpace) ? $fillCapacity - $upCapacity : 0;

?>

<!DOCTYPE html>
<html>

	<head>

	</head>

	<body>
		
		<div style="color:red;font-size:14px;"><?php echo $errors;?></div><br/><br/>
		
		<form action="." method="get">
		
			<label>Height of Hourglass </label>
			<input type="text" name="height" value="<?php echo $height;?>"/><br/><br/>
				
			<label>Capacity of Sand % </label>
			<input type="text" name="capacity" value="<?php echo $capacity;?>"/><br/><br/>
			
			<input type="submit" value="Draw Hourglass" />
				
		</form><br/><br/>
		
		<?php if($errors ==''){
		
			drawTopLevel($height,$upCapacity);
	
			drawBottomLevel($height,$downCapacity);
		}?>
		
	</body>

</html>

