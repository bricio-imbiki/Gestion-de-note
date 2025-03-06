<?php
//conection a la base des donners
require_once '../Model/Crud.php';
$DB = new connexionDB();
$BDD = $DB->connexion();

//enregistrer les variable global post dans des variable locals

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

var_dump($_POST);


if((isset($_POST['Date_cr']) && isset($_POST['Compte']) && isset($_POST['Libelle'])) && (isset($_POST['Debit']) || isset($_POST['Credit']))){
    
    $Date_cr = test_input($_POST['Date_cr']);
    $Compte = test_input($_POST['Compte']);
    $Libelle = test_input($_POST['Libelle']);
    $Debit = test_input($_POST['Debit']);
    $Credit = test_input($_POST['Credit']);

    //$CRUD = new Crud($Date_cr,$Compte,$Libelle,$Debit,$Credit);
    //$CRUD = new Crud('$Date_cr','$Compte','$Libelle',6000000000000,00000000);
    echo "<br>";
    echo $Date_cr."<br>";

    echo $Compte."<br>";

    echo $Libelle."<br>";

    echo $Debit."<br>";

    echo $Credit."<br>";



    if((!empty($Compte) && isset($Libelle)) && (!empty($Debit) || !empty($Credit))){
        //$insert = $CRUD->Create('journal');
        $sql = "INSERT INTO journal(date_cr,compte,libelle,debit,credit) VALUES(?,?,?,?,?)";
        $req = $BDD->prepare($sql);
        $req->execute(array($Date_cr,$Compte,$Libelle,$Debit,$Credit));
        $rnum = $req->rowCount();
        if($rnum > 0){
            echo 'enregistrement efectuer';
            
        }
    }
    else{
        echo 'noooooooo';
        
    }
}
header('../index.php');
?>