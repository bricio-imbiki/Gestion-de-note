
<?php

    //conection a la base des donners
    require_once 'Model/Crud.php';
    $DB = new connexionDB();
    $BDD = $DB->connexion();
    require_once 'vue/head.php';

    //enregistrer les variable global post dans des variable locals

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //var_dump($_POST);


    if((isset($_POST['Date_cr']) && isset($_POST['Compte']) && isset($_POST['Libelle'])) && (isset($_POST['Debit']) || isset($_POST['Credit']))){
        
        $Date_cr = test_input($_POST['Date_cr']);
        $Compte = test_input($_POST['Compte']);
        $Libelle = test_input($_POST['Libelle']);
        $Debit = test_input($_POST['Debit']);
        $Credit = test_input($_POST['Credit']);

        /*$CRUD = new Crud($Date_cr,$Compte,$Libelle,$Debit,$Credit);
        //$CRUD = new Crud('$Date_cr','$Compte','$Libelle',6000000000000,00000000);*/



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
        
    }

    if(isset($_GET['t'])){
        $reset = $_GET['t'];
        if(!empty($reset)){
            $sql = "DELETE FROM journal";
            $req = $BDD->query($sql);
            header("location:index.php");
        }
        

    }

    //recuperer tout les donner de la table journal

    $SQL = "SELECT * FROM journal";
    $REQ = $BDD->query($SQL);
    $rnum = $REQ->rowCount();
    /*if($rnum > 0){
        $data = $REQ->fetchAll();
        var_dump($data);
    }*/

    //tout renitialiser de zero et revenier des le departs
    /** charge d'exploitation
     *  compte : 60 , 61 , 62 , 63 , 64 , 65 ,681
     * charge financiers 
     * compte : 66 , 686
     * charge exeptionnelle
     * compte : 67 , 687
     * charge liees aux impot sur les benefices
     * compte : 69
     * PRODUIT D'EXEPTION
     * COMPTE : 77
     *  **/
    
?>
    
<div class="row">
    <div class="col-12 mt-3 text-center">
        <form action="" method="post">
            <div class="row">
                        
                <div class="col-2" >
                    <label class= "form-label" for="Date"> Date : </label>
                    <input class = 'form-control date' type="date" name = "Date_cr" >
                </div>

                <div class="col-1" >
                    <label class= "form-label" for="Compte"> Compte : </label>
                    <input class = 'form-control compte' type="text" name = "Compte" >
                </div>

                <div class="col-3" >
                    <label class= "form-label" for="Libelle"> Libelle : </label>
                    <input class = 'form-control libelle' type="text" name = "Libelle" >
                </div>

                <div class="col-3" >
                    <label class= "form-label" for="Debit"> Debit : </label>
                    <input class = 'form-control debit' type="number" name = "Debit" >
                </div>

                <div class="col-3" >
                    <label class= "form-label" for="Credit"> Credit : </label>
                    <input class = 'form-control credit' type="number" name = "Credit" >
                </div>

                <div class="my-3" >
                    <button class="btn btn-outline-dark Enregister" id = 'Enregister' type = 'submit'>Enregister</button>
                    <a href="?t=ok">
                        <button class="btn btn-outline-danger my-3" type = "button" value="reset" name = "reset">Renitialiser</button>
                    </a>
                    
                </div>
            </div>
        </form>

    </div>
    <div class="col-12 text-center">
        <table class="my-4 table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Compte</th>
                    <th>Libelle</th>
                    <th>Debit</th>
                    <th>Credit</th>
                </tr>
            </thead>
            <tbody id = 'tbody'>
                <?php
                    while($ligne = $data = $REQ->fetch()){
                        ?><tr>
                            <td><?=$ligne[1]?></td>
                            <td><?=$ligne[2]?></td>
                            <td><?=$ligne[3]?></td>
                            <td><?=$ligne[4]?></td>
                            <td><?=$ligne[5]?></td>
                        </tr><?php
                    }
                ?>
                <tr>
                    <th><strong>TOTAL</strong></th>
                    <th></th>
                    <th></th>
                    <th><?php 
                        $Sdebit = "SELECT debit FROM journal";
                        $Sdebit = $BDD->query($Sdebit);
                        $rnum = $Sdebit->rowCount();
                        if($rnum > 0){
                            $somme = 0;
                            while($ligne = $data_debit = $Sdebit->fetch()){
                                //echo $somme;
                                $valeur = $ligne['debit'];
                                if($somme === 0){
                                    $somme = $valeur;
                                }else{
                                    $somme = $somme + $valeur;
                                }
                            }
                            echo $somme;
                            
                        }
                        
                    ?></th>
                    <th><?php 
                        $Scredit = "SELECT credit FROM journal";
                        $Scredit = $BDD->query($Scredit);
                        $rnum = $Scredit->rowCount();
                        if($rnum > 0){
                            $somme = 0;
                            while($ligne = $data_debit = $Scredit->fetch()){
                                //echo $somme;
                                $valeur = $ligne['credit'];
                                if($somme === 0){
                                    $somme = $valeur;
                                }else{
                                    $somme = $somme + $valeur;
                                }
                            }
                            echo $somme;
                            
                        }
                        
                    ?></th>
                </tr>
                        
            </tbody>
        </table>
                
    </div>
    <div class="col-12 ">
        <button class="btn btn-dark my-3">
            <a class = "text-light" href="/Gestionfi/vue/result.php">Traiter</a>
        </button>
        
    </div>
            
</div>

<?php
    require_once 'vue/head.php';
?>
    
            
    