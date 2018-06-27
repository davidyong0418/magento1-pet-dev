<?php
//include_once "../config/config.php";
class userPhotoUpload {
	private $image_type, $image, $ImageName, $ImageType, $ImageSize, $ImageTmpName, $UploadFolder;
	public function ImageName($value = "") {
		if (empty($value))
			return $this->ImageName;
		else
			$this->ImageName = $value;
	}
	public function ImageType($value = "") {
		if (empty($value))
			return $this->ImageType;
		else
			$this->ImageType = $value;
	}
	public function ImageSize($value = "") {
		if (empty($value))
			return $this->ImageSize;
		else
			$this->ImageSize = $value;
	}
	public function ImageTmpName($value = "") {
		if (empty($value))
			return $this->ImageTmpName;
		else
			$this->ImageTmpName = $value;
	}
	public function folder($value = "") {
		if (empty($value))
			return $this->folder;
		else
			$this->folder = $value;
	}
	public function ImageRootPath($value = "") {
		if (empty($value))
			return $this->ImageRootPath;
		else
			$this->ImageRootPath = $value . $this->folder() . "/";
	}
	public function ImageSizeArray($value = "") {
		if (empty($value))
			return $this->ImageSizeArray;
		else
			$this->ImageSizeArray = $value;
	}
	public function GetHeightWidth($value) {
		$findme = "x";
		$pos    = strpos($value, $findme);
		$width  = substr($value, 0, $pos);
		$height = substr($value, $pos + 1);
		$size   = array(
			$width,
			$height
		);

	}
	public function ImageUploadResult() {
		if (($this->ImageType() == "image/gif") || ($this->ImageType() == "image/png") || ($this->ImageType() == "image/jpeg") || ($this->ImageType() == "image/jpg")) {
			if ($this->ImageSize >0) {
				$findme     = '.';
				$pos        = strpos($this->ImageName, $findme);
				$extension  = substr($this->ImageName, $pos);
				$ran        = sha1(uniqid());
				$rootPath   = $this->ImageRootPath();
				$uploadPath = $ran . $extension;
				move_uploaded_file($this->ImageTmpName, $rootPath . $uploadPath);
				
			}
		}
		return $uploadPath;
	}	
}
?>