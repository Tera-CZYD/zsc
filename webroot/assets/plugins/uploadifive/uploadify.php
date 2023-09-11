<?php

// Define a destination
$targetFolder = $_POST['path'] . '/webroot/uploads';// Relative to the root

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$newName = $_FILES['Filedata']['name'];
        $part = explode("." , $newName);
        $name1 = $part[0];
        $ext = $part[1];
        $newName = ($name1).".".$ext;
        date_default_timezone_set('Asia/Manila');
        $newName = $_POST['filename'] .'-'. date('Ymd-His').".".$ext;
	$targetFile = rtrim($targetPath,'/') . '/' . $newName;
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		echo $newName;
	} else {
		echo 'Invalid file type.';
	}
}
