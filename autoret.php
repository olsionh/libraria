<?php


function ListAuthors($ISBN) {
    include 'C:\xampp\htdocs\libraria\LidhjaDB.php';
        $AuthorList=""; 
        $sql = "SELECT Emri, Mbiemri
                FROM lib_autor, lib_aut_klas
                WHERE lib_aut_klas.Seria = '$ISBN'
                AND lib_autor.ID_Autor = lib_aut_klas.ID_Autor
                ORDER BY Mbiemri";

    if(!($result= $connection->query($sql))){
        die ("Query nuk u ekzekutua: ".$connection->error);
    }


        while ($row = mysqli_fetch_array($result)) {
            $emri = $row[0];
            $mbiemri = $row[1];
            $AuthorList .= "<a href='Kerko.php?kerko=".
                            "$emri'>$mbiemri $emri</a>, ";
}

        //remove the last comma
        return substr_replace($AuthorList, "",-2);
   }
?>