<?php
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Skats2</title>
<link rel="stylesheet" href="skats2.css">
    
      
</head>

<body>
    <div id="div2">Darāmo lietu saraksts</div>
    <a href="skats1.php"><input type="button" id="newrec" value="Jauns ieraksts"></a>

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
    $att="ir";
    $ir="Izdarīts";
}
    else 
    {
    $att="nav";
    $ir="Atzīmēt";
    }
    
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
        
       
        <form method='post'> 
        <div id='div1' class='$ir'>        
        <input type='submit' class='$att' name='$j' value='$ir'>
        <input disabled type='text' name='laiks' value='$t4'>
        </div>
        <br>
        <input disabled type='text' class='virsraksts' value='$virsr'>
        <br>
        <textarea disabled type='text' class='apraksts' name='apraksts'>$apr</textarea>
        <br>
        <button type='submit' class='submit' name='$i'>Labot</button>
        <br>
        </form>"; //izvada aaraa visus datus no datu baazes formu veidaa
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
        header("location:skats2.php"); // maina ir/nav no nav uz ir
    }
        
    else if($rezultats[$i]['ir/nav']==1)
    {
    $sqlupd="UPDATE `uzdevumi` SET `ir/nav` = '0' WHERE `uzdevumi`.`nr` = '$nr'";
    $sqlupdrezultats = mysqli_query($connection, $sqlupd);
    header("location:skats2.php");// maina ir/nav no ir uz nav
    }
        
    }
    
    if(isset($_POST[$i]))// ja nolemj autjauninaat kaadu no formaam, tad taalaaka informaacija lai formai piekljuutu tiek nodota sesijas veidaa
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




</body>

</html>