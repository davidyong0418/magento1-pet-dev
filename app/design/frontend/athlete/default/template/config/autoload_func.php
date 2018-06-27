<?php
function F_SAFE_INSERT2($string) {
	if (is_string($string)) {
		if (USE_DATABASE) {
			global $mysqli;
			if (function_exists('mysqli_real_escape_string')) {
				return mysqli_real_escape_string($mysqli, trim($string));
			} elseif (function_exists('mysqli_escape_string')) {
				return mysqli_escape_string($mysqli, trim($string));
			}
		}
		return addslashes(nl2br($string));
	}
}
function F_PREVENT_SQL_INJECTION() {
	foreach (array_merge($_GET, $_POST) AS $name => $value) {
		if (!is_numeric($value)) {
			$pattern = '/(and|or)[\s\(\)\/\*]+(update|delete|select)\W|(select|update).+\.(password|email)|(select|update|delete).+users/im';
			if (is_array($value)) {
				foreach ($value as $key => $val) {
					if (is_array($value[$key])) {
						while (preg_match($pattern, $value[$key])) {
							if (isset($_GET[$name])) {
								$value = $_GET[$name] = $_REQUEST[$name] = preg_replace($pattern, '', $value[$key]);
							} else {
								$value = $_POST[$name] = $_REQUEST[$name] = preg_replace($pattern, '', $value[$key]);
							}
						}
					}
				}
			} else {
				while (preg_match($pattern, $value)) {
					if (isset($_GET[$name])) {
						$value = $_GET[$name] = $_REQUEST[$name] = preg_replace($pattern, '', $value);
					} else {
						$value = $_POST[$name] = $_REQUEST[$name] = preg_replace($pattern, '', $value);
					}
				}
			}
		}
	}
}
function F_ALL_REQUEST_VARS() {
	global $_REQUEST;
	reset($_REQUEST);
	F_PREVENT_SQL_INJECTION();
	while (list($key, $value) = each($_REQUEST)) {
		if (is_array($value)) {
			while (list($k, $v) = each($value)) {
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					$_POST[$key . '[' . $k . ']'] = F_SAFE_INSERT2($v);
				} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
					$_GET[$key . '[' . $k . ']'] = F_SAFE_INSERT2($v);
				}
			}
		} else {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$_POST[$key] = F_SAFE_INSERT2($value);
			} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
				$_GET[$key] = F_SAFE_INSERT2($value);
			}
		}
	}
}
F_ALL_REQUEST_VARS();
?>