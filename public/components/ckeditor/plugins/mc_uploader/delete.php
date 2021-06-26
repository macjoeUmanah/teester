<?php 
if(isset($_POST['file']) && !empty($_POST['file'])){
  $file = $_POST['file'];
  if(is_file($file)){
    unlink($file);
    echo "deleted";
  } else{
    echo $_POST['file']." has not been found!";
  }
}
?>
