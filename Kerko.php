<html>
<head>
<title>Libraria Online</title>
<style>
ul.menu {
    list-style-type: none;
    margin-top:50px;
    padding-left: 15px;
    width: 200px;
}

li a {
    display: block;
    color: #000;
    padding: 8px 16px;
    text-decoration: none;
    box-sizing: border-box;
    border-radius: 25px;
    border:2px solid #82E0AA;
    margin-bottom:5px;
    margin-left:-8px;
    
}

li a:hover {
    background-color: #34495E;
    color: #EBF5FB;
}
input[type=text] {
    width: 100%;
    box-sizing: border-box;
    border-radius: 25px;
    border: 2px solid #82E0AA;
    padding: 20px; 
    width: 200px;
    height: 50px;
    margin-left:14px;
}
input[type=button], input[type=submit], input[type=reset] {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 10px 22px;
    text-decoration: none;
    margin: 10px 70px;
    cursor: pointer;
}
body
{
    background-color:#f1f1f1;
}
input[type=text]:focus, input:focus{
    outline: none;
}
header {
    background: #34495E;
    margin-bottom:40px;
    margin-left:-8px;
    margin-right:-8px;
    margin-top:-20px;
  }
  
  .headline {
    position: relative;
    height: 100px;
    padding-top:20px;
    background-size: cover;
    &:after {
      position: absolute;
      content: '';
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(#111, 0.5);
    }
  }
  
  .inner {
    position: absolute;
    top: 50%;
    left: 16%;
    opacity: 0;
    z-index: 10;
    transform: translateX(-50%) translateY(-50%);
    animation: fade-in 0.75s 0.25s ease-in forwards;
    h1 {
      margin: 0;
      font-size: 4em;
      line-height: 1.2em;
      font-family:Courier;
    }
    p {
      margin: 0;
      font-size: 1.4em;
      font-style: italic;
      font-family: serif;
    }
  }
  
.verticalLine {
  border-left:3px solid #82E0AA;
}

@keyframes fade-in {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

footer{
    background: #34495E;
    position:relative;
    bottom:-20px;
    margin-left:-8px;
    margin-right:-8px;
    margin-top:20px;
    height: 70px;
    padding-bottom:20px;
    
}
a.footer{
    text-decoration: none;
    color:#EBF5FB;
}



</style>
</head>
<body>
<?php include 'C:\xampp\htdocs\libraria\LidhjaDB.php'; ?>
<header> 
<div class="headline">
<div class="inner">
<a href="index.php"><img style="float:left" src="logo.svg" width="120px" height="100px"/></a>
<a href="index.php"><h1 style="color:#EBF5FB;float:right;padding-top:18px;">Libraria Online</h1></a>
</div>
<img style="float:right;margin-right:50px; margin-top:25px" width="30px" height="30px" src="cart2.svg" />
<img style="float:right;margin-right:20px; margin-top:25px" width="30px" height="30px" src="user3.svg" />
</div>
</header>
<div style="min-height:100%;position:relative;">
<div style="float:left;margin-left:30px;background-color: #f1f1f1;">
<form action="Kerko.php" method="GET">
<div style="margin-top:30px">
<input type="text" name="kerko"/><br>
<input type="submit" value="Kerko"/>
</div>
</form>


<?php $query="SELECT lib_kat.ID_Kat, Kategoria
              FROM lib_kat 
              INNER JOIN lib_klas on lib_kat.ID_Kat=lib_klas.ID_Kat
              GROUP BY lib_kat.ID_Kat, Kategoria
              ORDER BY Kategoria ASC;";


include_once("autoret.php");

if(!($result= $connection->query($query))){
    die ("Query nuk u ekzekutua: ".$connection->error);
}

$kategoria="kot";
if(isset($_GET["Kategoria"]))
$kategoria=$_GET["Kategoria"];
echo "<ul class='menu'>";
for($i = 0; $row=mysqli_fetch_row($result);++$i){
    if ($kategoria==$row[1])
    echo "<li><a style='background-color:#82E0AA' href='Kerko.php?ID_Kat=".$row[0]."&Kategoria=".$row[1]."'>".$row[1]."</a></li>";
    else
    echo "<li><a href='Kerko.php?ID_Kat=".$row[0]."&Kategoria=".$row[1]."'>".$row[1]."</a></li>";
  }
echo "</ul>";

  echo "</div>";

if (isset($_GET["kerko"]))
{
    $kerko=$_GET["kerko"];
    $search="SELECT DISTINCT d.Seria, Titulli, GROUP_CONCAT(DISTINCT ' ', Emri ,' ',Mbiemri), Pershkrimi, Cmimi
    FROM Lib_Autor a, Lib_Aut_Klas ba, Lib_Pershkrim d,
    Lib_Klas cb, Lib_Kat c
    WHERE a.ID_Autor = ba.ID_Autor
    AND ba.Seria = d.Seria
    AND d.Seria = cb.Seria
    AND c.ID_Kat = cb.ID_Kat
    AND (Kategoria = '$kerko'
    OR Titulli LIKE '%$kerko%'
    OR Pershkrimi LIKE '%$kerko%'
    OR Botuesi LIKE '%$kerko%' 
    OR concat_ws(' ', Emri, Mbiemri, Emri) LIKE '%$kerko%' )
    GROUP BY Titulli;";

if(!($result2= $connection->query($search)))
    die ("Query nuk u ekzekutua: ".$connection->error);

    $nrKerkimeve=mysqli_num_rows($result2);


    
    echo "<div style='text-align:center; color:red'>U gjeten ".$nrKerkimeve." libra qe permbajne '".$kerko."'</div><br>";
    echo "<div class='verticalLine' style='padding-left:40px;margin-left:300px;margin-right:80px'>";
for($i = 0; $row=mysqli_fetch_row($result2);++$i)
{   
    echo "<div><div>";
    echo "<span><b>".$row[1]."</b></span><br>";
    echo "<span>nga ".ListAuthors($row[0])."</span><br>";
    echo "</div><div>";
    echo "<img style='float:left; margin-right:5px' width='80px' height='100px' src='http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/bookimages/".$row[0].".01.THUMBZZZ.jpg'/>";
    $tekst=substr($row[3], 0, strpos($row[3], ' ', 500));
    echo "$tekst";
    echo "<a href='produkt.php?seria=".$row[0]."'> me shume...</a>";
    echo "</div></div><br><br><br>";
}
echo "</div>";
  

}
else if (isset($_GET["ID_Kat"]))
{
    $idkategori=$_GET["ID_Kat"];
    $kategoria=$_GET["Kategoria"];
    $browse="SELECT DISTINCT d.Seria, Titulli, GROUP_CONCAT(DISTINCT ' ', Emri ,' ',Mbiemri), Pershkrimi, Cmimi
    FROM Lib_Autor a, Lib_Aut_Klas ba, Lib_Pershkrim d,
    Lib_Klas cb, Lib_Kat c
    WHERE a.ID_Autor = ba.ID_Autor
    AND ba.Seria = d.Seria
    AND d.Seria = cb.Seria
    AND c.ID_Kat = cb.ID_Kat
    AND c.ID_Kat = '$idkategori'
    AND Kategoria = '$kategoria'
    GROUP BY Titulli;";

if(!($result2= $connection->query($browse)))
die ("Query nuk u ekzekutua: ".$connection->error);

$nrLibrave=mysqli_num_rows($result2);

echo "<div style='text-align:center; color:red'>U gjeten ".$nrLibrave." libra ne kategorine '".$kategoria."'</div><br>";
echo "<div class='verticalLine' style='padding-left:40px;margin-left:300px;margin-right:80px'>";
for($i = 0; $row=mysqli_fetch_row($result2);++$i)
{   
echo "<div><div>";
echo "<span><b>".$row[1]."</b></span><br>";
echo "<span>nga ".ListAuthors($row[0])."</span><br>";
echo "</div><div>";
echo "<img style='float:left; margin-right:5px' width='80px' height='100px' src='http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/bookimages/".$row[0].".01.THUMBZZZ.jpg'/>";
$tekst=substr($row[3], 0, strpos($row[3], ' ', 500));
echo "$tekst";
echo "<a href='produkt.php?seria=".$row[0]."'> me shume...</a>";
echo "</div></div><br><br><br>";
}
echo "</div>";


}

?>
</div>
<footer>
<div style="text-align:center;padding-top:35px">
<a class="footer" style="padding-right:25px" href="index.php">Faqja kyresore</a>
<a class="footer" style="padding-left:25px" href="rreth.php">Rreth ketij site</a>
</div>
</footer>

</body>
</html>