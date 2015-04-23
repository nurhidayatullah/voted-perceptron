<?php
class Voted_perceptron{
	
	function train($data_latih,$label,$max_epoh){
		$v = array(array_fill(0,count($data_latih[0]),0));
		$k = 0;
		$c = array(0);
		for($iterasi = 0;$iterasi < $max_epoh;$iterasi++){
			$cek= "";
			for($x = 0;$x<count($data_latih);$x++){
				$y = $this->sign($data_latih[$x],$v[$k]);
				if($y ==$label[$x]){
					$c[$k] = $c[$k]+1;
					$cek .=1;
				}else{
					$vk = array();
					for($a = 0;$a < count($data_latih[$x]);$a++){
						$vk[$a] = $v[$k][$a]+($label[$x]*$data_latih[$x][$a]);
					}
					array_push($v,$vk);
					array_push($c,1);
					$k = $k + 1;
					$cek .=0;
				}
			}
			$y = strpos($cek,"0");
			if(empty($y)){
				$iterasi = $max_epoh;
			}
		}
		echo "V : ";
		print_r($v);
		echo "</br>";
		echo "Bobot : ";
		print_r($c);
		echo "</br>K : ".$k;
	}
	function sign($data,$v){
		$y_in = $this->dot_product($data,$v);
		if($y_in > 0){
			$y = 1;
		}else{
			$y = -1;
		}
		return $y;
	}
	function dot_product($data,$v){
		$y_in = 0;
		for($x = 0;$x < count($data);$x++){
			$y_in = $y_in + ($data[$x]*$v[$x]);
		}
		return $y_in;		
	}
}
$data = array(array(-1,-1,-1),array(-1,1,-1),array(1,1,-1),array(1,1,1));
$label = array(-1,-1,-1,1);
$voted = new Voted_perceptron;
$voted->train($data,$label,5);
?>