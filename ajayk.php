<html>
<head>
<title>PHP File Upload example</title>
</head>
<body>
 
<form action="max.php" enctype="multipart/form-data" method="post">
Select image :
<input type="file" name="file"><br/>
<input type="submit" value="Upload" name="Submit1"> <br/>
 
 
</form>
<?php

function correctImageOrientation($filename) {
  if (function_exists('exif_read_data')) {
    $exif = exif_read_data($filename);
    if($exif && isset($exif['Orientation'])) {
      $orientation = $exif['Orientation'];
      if($orientation != 1){
        $img = imagecreatefromjpeg($filename);
        $deg = 0;
        switch ($orientation) {
          case 3:
            $deg = 180;
            break;
          case 6:
            $deg = 270;
            break;
          case 8:
            $deg = 90;
            break;
        }
        if ($deg) {
          $img = imagerotate($img, $deg, 0);        
        }
        // then rewrite the rotated image back to the disk as $filename 
       // imagejpeg($img, $filename, 95);
      } // if there is some rotation necessary
    } // if have the exif orientation info
  } // if function exists      
}

/*function imagecreatefromjpegexif($filename)
    {
        $img = imagecreatefromjpeg($filename);
        $exif = exif_read_data($filename);
        if ($img && $exif && isset($exif['Orientation']))
        {
            $ort = $exif['Orientation'];

            if ($ort == 6 || $ort == 5)
                $img = imagerotate($img, 270, null);
            if ($ort == 3 || $ort == 4)
                $img = imagerotate($img, 180, null);
            if ($ort == 8 || $ort == 7)
                $img = imagerotate($img, 90, null);

            if ($ort == 5 || $ort == 4 || $ort == 7)
                imageflip($img, IMG_FLIP_HORIZONTAL);
        }
        imagejpeg($img)
        return $img;
    }
*/

define ('SITE_ROOT', realpath(dirname(__FILE__)));

if(isset($_POST['Submit1']))
{ 
$filepath = SITE_ROOT."\images\\" . $_FILES["file"]["name"];
$path = $_FILES["file"]["name"];
 
if(move_uploaded_file($_FILES["file"]["tmp_name"], $filepath)) 
{
//echo "<img src='images/1.jpg' height=200 width=300 />";
//$new=imagecreatefromjpegexif($filepath);
correctImageOrientation($filepath);
//imagejpeg($new);
//echo '<img src="images/'. $path.'"  height=200 width=300/>';
} 
else 
{
echo "Error !!";
}
} 
?>
 
</body>
</html>