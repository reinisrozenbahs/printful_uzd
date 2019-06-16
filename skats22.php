<?php
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Skats2</title>

    <link rel="stylesheet" href="skats2.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    
    <nav class="navbar navbar-expand-sm bg-success navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="skats1.php">Active</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="skats1.php">Link</a>
    </li>
        </ul></nav>
    
    <div class="row">
        <div class="col-xs-6 form-group">
            <label>Label1</label>
            <input class="form-control" type="text"/>
        </div>
        
    
<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1); //kljuudu paraadiishana
    
    
include("sql_data.php");
    
    $sql="SELECT * FROM `uzdevumi`";
    $sqlrezultats = mysqli_query($connection, $sql);
    for($i=0;$i<mysqli_num_rows($sqlrezultats);$i++)
    {
        $rezultats[$i]=mysqli_fetch_array($sqlrezultats); //visaam datu baazee esoshajaam rindaam tiek pieskirta masiiva veertiiba
    }
    
ob_start();//noveersh output buffering /bija nepiecieshams, lai darbotos header veelaak/
    

for($i=count($rezultats)-1; $i>=0;$i--)//for cikls tiek veikts tik reizes, cik datubaazee ir rindu, pats cikls izvada aaraa visus datus no datubaazes
{
$j=$i+count($rezultats);//ar $j katrai datu formai /dati tiek izvadiiti formaas/ "ir/nav" izpildiits pogai tiek pieskirts savs vaards jeb name
// taa kaa katraa formaa ir divas pogas - labot un atziimet izpildiits -, tad katrai pogai buus savs unikaals vaards

$virsr=$rezultats[$i]['virsraksts'];//no katras rindas tiek ieguuti dati, kas tiek defineeti kaa mainiigie, lai ar tiem buutu vieglaak straadaat
$apr=$rezultats[$i]['apraksts'];
$ir=$rezultats[$i]['ir/nav'];

    if($ir==1) //1 defineejas kaa ir izpildiits, 0 kaa nav izpildiits
{
    $att="checkyes.png";
}
    else $att="checkno.png";
    
    $t1=strtotime($rezultats[$i]['datums1']);
    $t2=time();
    $t3=intval(($t2-$t1)/(60*60*24)); // apreekina laiku dienaas, pirms cik ilga laika dati tika ievadiiti
    if((intval($t2/(60*60*24)))==(intval($t1/(60*60*24))))
    {
        $t4="Šodien";
    }
    else if(intval($t2/(60*60*24))-intval($t1/(60*60*24))==1)
    {
        $t4="Vakar";
    }
    
    else
    {
        $t4="Pirms $t3 dienām";
    }
       
echo"
        
       
    <div><form method='post'> 
        <button type='submit' class='check' name='$j'>
        <img id='att1' src='$att'>
        </button>
        
        <textarea disabled type='text' class='virsraksts'>$virsr</textarea>
        
        <input disabled type='text' name='laiks' value='$t4'>
        <br>
        <textarea disabled type='text' class='apraksts' name='apraksts'>$apr</textarea>
        <input type='submit' name='$i' value='Labot'>
        </form></div>";
}

for($i=count($rezultats)-1; $i>=0;$i--)
{
    if(isset($_POST[$i+count($rezultats)]))
    {
    $nr=$rezultats[$i]['nr'];
    if($rezultats[$i]['ir/nav']==0)
    {
        
        $sqlupd="UPDATE `uzdevumi` SET `ir/nav` = '1' WHERE `uzdevumi`.`nr` = '$nr'";
        $sqlupdrezultats = mysqli_query($connection, $sqlupd);
        header("location:skats2.php");
    }
        
    else if($rezultats[$i]['ir/nav']==1)
    {
    $sqlupd="UPDATE `uzdevumi` SET `ir/nav` = '0' WHERE `uzdevumi`.`nr` = '$nr'";
    $sqlupdrezultats = mysqli_query($connection, $sqlupd);
    header("location:skats2.php");
    }
        
    }
    
    if(isset($_POST[$i]))
    {
        
    $virsraksts=$rezultats[$i]['virsraksts'];
    $apraksts=$rezultats[$i]['apraksts'];
    $_SESSION['virsraksts']="$virsraksts";
    $_SESSION['apraksts']="$apraksts";
    header("location:skats3.php");
        ob_end_flush();
    }
    
}

    ?>
<a href="skats1.php"><input type="button" id="poga2" value="Pievienot jaunu ierakstu!"></a>


</body>

</html>