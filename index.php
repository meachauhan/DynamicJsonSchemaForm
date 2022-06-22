
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Json Schema form Generater</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<style>
    .container{
        background-color: rgba(255, 255, 255, .15);  
        backdrop-filter: blur(5px);
        position: absolute;
        left: 29%;
        top: 8%;
        border-radius: 5%;
        padding: 50px;
        width: 40em;
    }
  body,html {
    height: 100%;
    margin: 0;
    width: 100%;
    background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);
    background-repeat: no-repeat;
    background-attachment: fixed;
    position: relative;
   }
   @media only screen and (max-width: 600px) {
    .container{

        background-color: rgba(255, 255, 255, .15);  
        backdrop-filter: blur(5px);
        position: absolute;
        left: 7%;
         padding: 50px;
         border-radius: 5%;
         top: 10%;
         width: 20em;
         z-index: 100;
  
    }
  }
</style>
</head>
<body>
    <div class="container">
    <div >
<form action="" method="post" class="mb-3" enctype="multipart/form-data">
<label class="form-label">Upload JSON Schema</label>
<input type="file" name="file" size="50"  class="form-control" required/>
<br>
<input type="submit" value="Upload" name="upload" class="btn btn-primary"/>
</form>
<form action="" method="" class="mb-3" enctype="multipart/form-data">
<?php

if(isset($_POST['upload'])){
$targetfolder = "Jsons/";

 $targetfolder = $targetfolder . basename( $_FILES['file']['name']) ;
 move_uploaded_file($_FILES['file']['tmp_name'], $targetfolder);

$json = file_get_contents($targetfolder); 
 $obj = json_decode($json,true);
 $fields=$obj['fields'];


 usort($fields, function($a, $b) { //Sort the array using a user defined function
    return $a['order'] < $b['order'] ? -1 : 1; //Compare the orders
});  


 for($i=0;$i<count($fields);$i++){
    $inputs=$fields[$i];
    $type=$inputs['type'];
    $label=$inputs['label'];
    $id=$inputs['key'];
    $readonly=$inputs['isReadonly'];
    if(array_key_exists('isRequired',$inputs)){
    $required=$inputs['isRequired'];
    }else{
        $required=null;
    }
    if($required==1){
        $required="required";
    }else{
        $required="";
    }
    if($readonly==1){
        $readonly="readonly";
    }else{
        $readonly="";
    }
    if($type=="dropdown" ){
        $options=$inputs['items'];
         ?>
         <div class="mb-3">
    <label class="form-label"><?php echo $label; ?></label>
    <select type="<?php echo $type; ?>" id= "<?php echo $id; ?>"  <?php echo $required; ?> class="form-control">
        <?php for($j=0;$j<count($options);$j++){
            $op1=$options[$j];
            ?>
            
            <option value="<?php echo $op1['value'];?>"><?php echo $op1['text']?></option>

            <?php } ?>
    </select>
         </div>
    <?php }  else{
        ?>
        <div class="mb-3">
        <label class="form-label"><?php echo $label; ?></label>
        <input type="<?php echo $type; ?>" id= "<?php echo $id; ?>"  <?php echo $readonly; ?> <?php echo $required; ?> class="form-control">
        </div>
    <?php }

    }
?>
<input type="submit" value="Submit" class="btn btn-primary">
<?php } ?>
</form>
</div>
</div>
</body>
</html>
