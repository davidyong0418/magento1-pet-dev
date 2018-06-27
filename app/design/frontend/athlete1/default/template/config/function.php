<?php

function validateAdmin() {
	if (!isset($_SESSION['login']['id']) && !isset($_SESSION['login']['name']) && strlen($_SESSION['login']['id']) <= 0 && strlen($_SESSION['login']['name']) <= 0 && $_SESSION['login']['mode'] != "admin") {
		
		?>
		<script>document.location="index.php";</script>
		
<?php	
	} 
}
function validateUser() {
	if (isset($_SESSION['login']['id']) && isset($_SESSION['login']['name']) && strlen($_SESSION['login']['id']) > 0 && strlen($_SESSION['login']['email']) > 0 && $_SESSION['login']['mode'] == "user") {
	} else {
		$_SESSION['error'] = "Access Denied";
		header('location:index.php');
	}
}
function logout() {
	session_start();
	session_unset();
	if (session_destroy()) {
		$status = "true";
	} else {
		$status = "false";
	}
}
function unlink_image($file, $folder) {
	@unlink(ROOT_PATH . UPLOAD_FOLDER . "/" . $folder . "/" . $file);
}
function getSelected($var1 = "", $var2 = "") {
	if ($var1 == $var2) {
		return 'selected=selcted';
	} else
		return '';
}
function userToServerdate($year, $month, $day, $hour, $minute, $meridium) {
	//echo $year.",". $month.",".$day.",".$hour.",".$minute.",".$meridium;
	//exit;
	if ($meridium == 'am') {
		$hour = $hour + 12;
		$date = $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":00";
	} else {
		$date = $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":00";
	}
	return $date;
}
if (!function_exists('enc_id')) {
	function enc_id($id) {
		if ($id != '') {
			$new_id = base64_encode($id) . "eml";
			return $new_id;
		}
	}
}
if (!function_exists('dec_id')) {
	function dec_id($id) {
		if ($id != '') {
			$new_id = base64_decode(substr($id, 0, -3));
			return $new_id;
		}
	}
}
if (!function_exists('getRealIpAddr')) {
	function getRealIpAddr() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}
if (!function_exists('payDate')) {
	function payDate($paydate) {
		$payd        = explode(" ", $paydate);
		$monthName   = $payd[1];
		$date        = date_parse($monthName);
		$monthNumber = $date['month'];
		$day         = explode(",", $payd[2]);
		$setdate     = $payd[3] . "-" . $monthNumber . "-" . $day[0] . " " . $payd[0];
		return $setdate;
	}
}
if (!function_exists('getweekend')) {
    function getweekend(){
            $time = mktime();
            $found = false;
            while(!$found) {
            $d = date('N', $time);
            if($d == 6 || $d == 7) {
                $found = true;
                $weekend = date('d/m/Y G:i:s', $time);
            }
            $time += 86400;
        }
        echo("Weekend begins on: $weekend");
    }
}
if (!function_exists('cms_filter_string')) {
	function cms_filter_string($string, $nohtml='', $save='') { 
		$string = str_ireplace(array("\r","\n",'\r','\n'),'', $string);
		if(!empty($nohtml)) { 
			$string = trim($string); 
			if(!empty($save)) $string = htmlentities(trim($string), ENT_QUOTES, 'ISO-8859-15'); 
			else $string = html_entity_decode($string, ENT_QUOTES, 'ISO-8859-15'); 
		} 
		if(!empty($save)) $string = mysql_real_escape_string($string); 
		else $string = stripslashes($string); 
		
		$string = preg_replace('/\s+/',' ', $string );
		return $string; 
	} 
}


 function ShowDate($date_arg) {
		$alonedate = explode('-', $date_arg);
		$date      = $alonedate[2];
		$year      = $alonedate[0];
		$month     = $alonedate[1];
		switch ($month) {
			case '01':
				$month = "Jan";
				break;
			case '02':
				$month = "Feb";
				break;
			case '03':
				$month = "Mar";
				break;
			case '04':
				$month = "Apr";
				break;
			case '05':
				$month = "May";
				break;
			case '06':
				$month = "Jun";
				break;
			case '07':
				$month = "Jul";
				break;
			case '08':
				$month = "Aug";
				break;
			case '09':
				$month = "Sep";
				break;
			case '10':
				$month = "Oct";
				break;
			case '11':
				$month = "Nov";
				break;
			case '12':
				$month = "Dec";
				break;
		}
		$date_new_res = $month . " " . $date . ", " . $year;
		return $date_new_res;
	}
	
 function ShowDate1($date_arg) {
		$alonedate = explode('-', $date_arg);
		$date      = $alonedate[2];
		$year      = $alonedate[0];
		$month     = $alonedate[1];
		switch ($month) {
			case '01':
				$month = "Jan";
				break;
			case '02':
				$month = "Feb";
				break;
			case '03':
				$month = "Mar";
				break;
			case '04':
				$month = "Apr";
				break;
			case '05':
				$month = "May";
				break;
			case '06':
				$month = "Jun";
				break;
			case '07':
				$month = "Jul";
				break;
			case '08':
				$month = "Aug";
				break;
			case '09':
				$month = "Sep";
				break;
			case '10':
				$month = "Oct";
				break;
			case '11':
				$month = "Nov";
				break;
			case '12':
				$month = "Dec";
				break;
		}
		$date_new_res = $month . " " . $date;
		return $date_new_res;
	}
		
	
function Select($table){
	global $mysqli;
	$sql = "select * from ".$table;
	$result =$mysqli->query($sql);
	return $result; 
		
	
}
function subwords($str, $int, $strAppend='...') {
    if (strlen($str) > $int) {
        $arr = str_word_count($str, 2);
        $blubb = false;
        foreach ($arr as $intPos => $strWord) {
            if ($blubb) return substr($str, 0, $intPos).$strAppend;
                if ($intPos > $int) $blubb = true;
        }
    }
 
    return $str;
}

?>