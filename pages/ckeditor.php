
<?php

include '../config/general.php';

$file = "../content/upload/".$_GET['name'].".".$_GET['type']."";

/*if(isset($_GET['name'])){
	echo $_GET['name'];
}
*/	

?>

<script src="../ckeditor/ckeditor.js"></script>





<form name="ckeditor" method="post" action="<?php echo $_SERVER['PHP_SELF']."?type=".$_GET['type']."&name=".$_GET['name'];?>">
<textarea id="editor1" name="tekst" class="ckeditor"> <?php  echo @file_get_contents($file);  ?></textarea>
<br>
<input name="type" type="hidden" value ="<?php echo $_GET['type'];?>"/>
<input name="name" type="hidden" value ="<?php echo $_GET['name'];?>"/>
<input name="Save" type="submit" value="Save" />

<input name="Cancel" type="submit" value="Cancel" />
<input name="UpdateT" type="submit" value="Update Thumbnails" />
</form>


 

    <?php
     if ($_POST["UpdateT"]){
    	$file = $filesLocation . $_POST['name'] . '.' . $_POST['type'];

       if ($_POST['type'] == 'html'){
		$convertopdf = 'xvfb-run --server-args="-screen 0, 800x600x24" wkhtmltopdf ' . $filesLocation . $_POST['name'] . '.' . $_POST['type'].' ' . $filesLocation . $_POST['name'] . '.pdf';
		$convertopng = 'convert ' . $filesLocation . $_POST['name'] . '.pdf[0] ' . $filesLocation . $_POST['name'] . '.png';
		exec($convertopdf,$output,$ret);
		if ($ret) {
			echo "Error fetching screen dump for $file\n";
			die;
		}
		exec('rm -f ' . $filesLocation . $_POST['name'] . '.png',$output,$ret);
		if ($ret){
			echo "Error deleting $file pdf file\n";
			die;
		}

		exec($convertopng,$output,$ret);
		if ($ret){
			echo "Error converting $file to png\n";
			die;
		}
		exec('rm -f ' . $filesLocation . $_POST['name'] . '.pdf',$output,$ret);
		if ($ret){
			echo "Error deleting $file pdf file\n";
			die;
		}
		
	}
	else if ($_POST['type'] == 'txt')
	{
		// First, make an HTML page with the content in it
		$file = '/var/www/emvi/content/upload/'. $_POST['name'] . '.html';
		$fcontent = "<pre>" . file_get_contents($filesLocation. $_POST['name'] . '.txt') . "</pre>";
		file_put_contents($file,$fcontent);
		
		$convertopdf = 'xvfb-run --server-args="-screen 0, 800x600x24" wkhtmltopdf ' . $filesLocation . $_POST['name'] . '.html ' . $filesLocation . $_POST['name'] . '.pdf';
		$convertopng = 'convert ' . $filesLocation . $_POST['name'] . '.pdf[0] ' . $filesLocation . $_POST['name'] . '.png';
		exec($convertopdf,$output,$ret);
		if ($ret) {
			echo "Error fetching screen dump for $file\n";
			die;
		}
		exec($convertopng,$output,$ret);
		if ($ret){
		echo "Error converting $file to png\n";
		die;
		}
		exec('rm ' . $filesLocation . $_POST['name'] . '.pdf',$output,$ret);
		if ($ret){
			echo "Error deleting $file pdf file\n";
			die;
		}
		
	}
      ?>
       <script type='text/javascript'>
   			 self.close();
		</script>

       <?php
 
    }

   
    if ($_POST["Save"])
    {
    	$file = "../content/upload/".$_POST['name'].".".$_POST['type']."";

    	$data = $_POST["tekst"];
        @file_put_contents($file, $data);
        sleep(5);
      
	 ?>
       <script type='text/javascript'>
   			 self.close();
		</script>

       <?php


 
    }
    if ($_POST["Cancel"])
    {
       ?>
       <script type='text/javascript'>
   			 self.close();
		</script>

       <?php
 
    }

    ?>
