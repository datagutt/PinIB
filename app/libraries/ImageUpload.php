<?php
namespace PinIB;
use \PinIB\Input;

define('UPLOAD_PATH', PINIB_PATH . 'public/images');

class ImageUpload{
	public function codeToMessage($error){
		switch($error){
			case UPLOAD_ERR_FORM_SIZE:
			case UPLOAD_ERR_INI_SIZE:
				return 'File is too large!';
			break;

			case UPLOAD_ERR_PARTIAL:
				return 'File is only partially uploaded!';
			break;

			case UPLOAD_ERR_NO_FILE:
				return 'No file was sent!';
			break;

			case UPLOAD_ERR_NO_TMP_DIR:
				return 'No temporary directory!';
			break;

			case UPLOAD_ERR_CANT_WRITE:
				return 'Can\'nt write file!';
			break;

			case UPLOAD_ERR_EXTENSION:
				return 'That is not a valid extension!';
			break;
		}
	}
	
	public function upload($file, $new){
		$free = @disk_free_space(realpath('.'));
		if($free === FALSE) {
			$isFull = false;
		}else{
			$isFull = $free < 100*1024*1024;
		}
		// If diskspace is < 100MB, abort
		if($isFull){
			throw new ImageException('No more space left!');
		}

		if(isset($file) && is_file($file['tmp_name']) && is_readable($file['tmp_name']) && @getimagesize($file['tmp_name']) > 0){
			if($file['error'] == UPLOAD_ERR_OK){
				$imageData = @getimagesize($file['tmp_name']);
				$mimeType = image_type_to_mime_type($imageData[2]);
				$extension = image_type_to_extension($imageData[2]);

				if($mimeType == 'image/png'
					|| $mimeType == 'image/jpeg'){
					$newPath = UPLOAD_PATH . '/' . $new . $extension;
					$imagepng = imagepng(imagecreatefromstring(file_get_contents($file['tmp_name'])), $newPath);
					if(file_exists($newPath)) chmod($newPath, 0664);
				}else{
					throw new ImageException('Invalid extension! Only PNG and JPG is allowed.');
				}
			}else{
				throw new ImageException($this->codeToMessage($file['error']));
			}
		}else{
			throw new ImageException('That is not a valid image!');
		}
	}
}
class ImageException extends \Exception{}