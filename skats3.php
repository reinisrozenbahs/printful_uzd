<?php
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Skats3</title>

<link rel="stylesheet" href="skats3.css">
</head>

<body>
<?php
    ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
    
$sesijavirs= $_SESSION["virsraksts"];
$sesijaapr= $_SESSION["apraksts"];
?> 
    

       <table id="a"><tr><td class="mala"><a href="skats2.php"><img id="back" src="back.png"></a></td><td id="to">Ieraksta labošana</td><td class="mala"></td></tr></table> 
    <div>
    
        <form name="form1" method="post" onSubmit="required()">
        <name2>Virsraksts:</name2><br>
        
       <input type="text" id="virsraksts" class="virsraksts" name="virsraksts" value="<?php echo $sesijavirs; ?>">
        <br>
        <name2>Apraksts:</name2><br>
        <textarea class="apraksts" name="apraksts"><?php echo $sesijaapr;?></textarea>
        <br>
        <input type="submit" class="submit"name="submit" value="Labot ierakstu">
            <input type="submit" class="delete" name="delete" value="Dzēst">
            <br>
      </form>
    </div>
<?php
    
    if(isset($_POST['submit']))
    {
    $apraksts=$_POST["apraksts"];
    $virsraksts=$_POST['virsraksts'];
    
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = 'root';
    $db_name = 'printful_uzd';
    $table='uzdevumi';
    $connection= mysqli_connect( $db_host, $db_username, $db_password, $db_name);
if(!$connection)
    {
    die("Connectionn failed:".mysqli_connect_error());
    echo "Servera kļūda! Lūdzu, mēģiniet vēlāk!";
    }
        
        
    $selectsql= "SELECT * FROM `$table` WHERE `virsraksts` LIKE '$sesijavirs' AND `apraksts` LIKE '$sesijaapr'";
    $process=mysqli_query($connection, $selectsql);
    $row = mysqli_fetch_array($process);
    $count = mysqli_num_rows($process);
    $nr=$row['nr'];
    $updatesql= "UPDATE `uzdevumi` SET `virsraksts` = '$virsraksts', `apraksts` = '$apraksts' WHERE `uzdevumi`.`nr` = '$nr'";
    $qwerty=mysqli_query($connection, $updatesql);
    echo header("location:skats2.php");
    }
    
if(isset($_POST['delete']))
    {
    $apraksts=$_POST["apraksts"];
    $virsraksts=$_POST['virsraksts'];

    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = 'root';
    $db_name = 'printful_uzd';
    $table='uzdevumi';
    $connection= mysqli_connect( $db_host, $db_username, $db_password, $db_name);
if(!$connection)
    {
    die("Connectionn failed:".mysqli_connect_error());
    echo "Servera kļūda! Lūdzu, mēģiniet vēlāk!";
    }
        
        
    $selectsql= "SELECT * FROM `$table` WHERE `virsraksts` LIKE '$sesijavirs' AND `apraksts` LIKE '$sesijaapr'";
    $process=mysqli_query($connection, $selectsql);
    $row = mysqli_fetch_array($process);
    $count = mysqli_num_rows($process);
    $nr=$row['nr'];
    $updatesql= "DELETE FROM `uzdevumi` WHERE `uzdevumi`.`nr` = '$nr'";
    $qwerty=mysqli_query($connection, $updatesql);
    echo header("location:skats2.php");
    }

    ?>

</body>

</html>

