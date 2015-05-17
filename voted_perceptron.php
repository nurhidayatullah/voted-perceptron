<?php
/* Author : Nur Hidayatullah
 * Created : 22 Apr 2015
 */
class Voted_perceptron{
	
	function train($data_latih,$label,$max_epoh){ //fungsi pelatihan untuk mencari nilai v,c,dan k
		$v = array(array_fill(0,count($data_latih[0]),0));
		$k = 0;
		$c = array(1);
		for($iterasi = 0;$iterasi <= $max_epoh;$iterasi++){
			$cek= "";
			for($x = 0;$x<count($data_latih);$x++){
				$y = $this->dot_product($data_latih[$x],$v[$k]);
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
			$ck = strpos($cek,"0");
			if($ck===FALSE){
				$iterasi = $max_epoh;
			}
		}
		$out = array('v'=>$v,'c'=>$c,'k'=>$k);
		return $out;
	}
	function sign($y_in){ // aktivasi
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
		return $this->sign($y_in);	
	}
	function classifier($data,$v,$c,$k){ // fungsi untuk klasifikasi
		$s = 0;
		for($x = 0;$x <= $k;$x++){
			$y_in = 0;
			$row = 0;
			for($y=0;$y<count($v[$x]);$y++){
				$y_in = $y_in +($v[$x][$y]*$data[$y]);
				$row++;
			}
			$s = $s +($c[$x]*$this->sign($y_in));
		}
		return $this->sign($s);
	}
}
$data = array(array(1,1),array(1,-1),array(-1,1),array(-1,-1)); // data latih
$label = array(1,-1,-1,-1); // target label data latih
$voted = new Voted_perceptron;
$out = $voted->train($data,$label,5); //melakukan proses training
//hasil training
/*echo "<pre>";
print_r($out);
echo "</pre>";*/
//------------
$uji = array(array(-1,-1),array(-1,1),array(1,-1),array(1,1));	//data uji
for($x=0;$x<count($uji);$x++){
	$hasil = $voted->classifier($uji[$x],$out['v'],$out['c'],$out['k']); //melakukan klasifikasi
	echo "Data ".($x+1)." ";
	print_r($uji[$x]);
	echo "  Hasil : ".$hasil."</br>";
}
?>