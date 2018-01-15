<?php
session_start();
$sakte = 0;
for($i=0;$i <$_SESSION['nrPyetjeve'];$i++){
    ?>
    <p>Pyetja: <?php echo $i+1 ?> eshte e: <b><?php if($_SESSION['pyetja-'.$i]== 0 ){

        echo 'Gabuar!';
            }else{
        $sakte++;
        echo 'Sakte!';
            }
            ?></b></p>
<?php
}
?>
<span style="color: red;">Ju gjetet <?php echo number_format((float)(($sakte*100)/$_SESSION['nrPyetjeve']), 2, '.', '');?> % te pyetjeve!</span>

<?php session_destroy();?>
<a href="phpQuizzer.php">Take Quiz Again?</a>
