<html>
    
<head>
    <meta charset="utf-8">
    <title>Skats1</title>
    <link rel="stylesheet" href="skats1.css">
</head>

<body>
    
    <table id="a"><tr><td class="1"><a href="skats2.php"><img id="back" src="back.png"></a></td><td id="to">To do list</td><td class="1"></td></tr></table> 
    <div>
    
        <form name="form1" method="post" onSubmit="required()">
        <name2>Virsraksts:</name2><br>
        
       <input type="text" id="virsraksts" class="virsraksts" name="virsraksts" placeholder="Virsraksts">
        <br>
        <name2>Apraksts:</name2><br>
        <textarea class="apraksts" name="apraksts" placeholder="Apraksts"></textarea>
        <br>
        <input type="submit" name="submit" value="Pievienot ierakstu">
            <br>
      </form>
    </div>
    
    
 <script>
    
    function required()// f-ja paarbauda, vai virsraksts ir iestatiits
{
if (document.getElementById("virsraksts").value == "")
    {
        alert("Please input a Value");
    }
}
    
</script>
    
<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1); //paraada kljuudas kodaa
    
    if(isset($_POST['submit'])) //ja forma ir "submitota"
    {
    $_POST["apraksts"]=trim($_POST["apraksts"]); //droshiibas f-ja
    $_POST["virsraksts"]=trim($_POST["virsraksts"]);
        
    $virsraksts=$_POST['virsraksts']; //mainiigo pieskir, lai peectam vieglaak straadaat
    $apraksts=$_POST["apraksts"];
    
    if($virsraksts=="")
{
        //nedara neko, ja nav ievadiits virsraksts
        
}
        
    else
{
    include("sql_data.php"); //datubaazes dati
    
    $sqli= "INSERT INTO `$table` (`nr`, `virsraksts`, `apraksts`, `datums1`, `ir/nav`) VALUES (NULL, '$virsraksts', '$apraksts', CURRENT_TIMESTAMP, '0');";
    $process=mysqli_query($connection, $sqli);//ievada datus datubaazee
        echo header("location:skats2.php"); //pārvieto uz galveno lapu
}
    
    }
    ?>

</body>
</html>
