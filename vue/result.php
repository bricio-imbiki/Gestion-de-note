<?php
    require_once 'head.php';
    require_once '../Model/Crud.php';
    require_once '../Model/Bddconect.php';

    $DB = new connexionDB();
    $BDD = $DB->connexion();
    //$CRUD = new Crud();

    /*$sql = "SELECT * FROM journal";
    $req = $BDD->query($sql);

    $data = $req->fetchAll();
    echo "<tr>";
    var_dump($data);*/

    
    /*echo '<pre>';
    var_dump($donne);*/
        

    //recupere tout les donner du journal
    $sql = "SELECT * FROM journal";
    $req = $BDD->query($sql);
    $rnum = $req->rowCount();

    if($rnum > 0){
        while($ligne = $data = $req->fetch()){
            $compte = $ligne["compte"];
            //savoir si le compte est de class 6 ou 7
            $Scompte = strval($compte);
            if(strpos($Scompte,'6') === 0){
                $div = substr($Scompte,0,2);
                if(($div === '60') ||($div === '61') || ($div === '62') || ($div === '63') || 
                ($div === '64') || ($div === '65') ||  ($compte === 681)){
                    $id = $ligne['id_journal'];
                    $sql = "UPDATE journal SET Class_type = ?,detail = ? WHERE id_journal = ?";
                    $requete = $BDD->prepare($sql);
                    $requete->execute(array('CHARGE','CH_E',$id));
                    
                }
            }
           
                                    
            //savoir si le compte est de class 6 ou 7
            $Scompte = strval($compte);
            if(strpos($Scompte,'7') === 0){
                $div = substr($Scompte,0,1);
                if(($div === '7')){
                    $id = $ligne['id_journal'];
                    $sql = "UPDATE journal SET Class_type = ?,detail = ? WHERE id_journal = ?";
                    $requete = $BDD->prepare($sql);
                    $requete->execute(array('PRODUIT','PR_FS',$id));
                    
                }
            }

            $Scompte = strval($compte);
            if(strpos($Scompte,'6') === 0){
                /* charge financiers 
                * compte : 66 , 686*/
                $div = substr($Scompte,0,2);
                if(($div === '66') || ($compte === 686)){
                    $id = $ligne['id_journal'];
                    $sql = "UPDATE journal SET Class_type = ?,detail = ? WHERE id_journal = ?";
                    $requete = $BDD->prepare($sql);
                    $requete->execute(array('CHARGE','CH_FS',$id));
                    
                }
            }

            if(strpos($Scompte,'7') === 0){
                /* PRODUIT D'EXPLOITATION
                * compte : 77*/
                $div = substr($Scompte,0,2);
                if(($div === '70') || ($div === '71') || ($div === '72') || ($div === '73') || ($div === '74') || ($div === '75')){
                    $id = $ligne['id_journal'];
                    $sql = "UPDATE journal SET Class_type = ?,detail = ? WHERE id_journal = ?";
                    $requete = $BDD->prepare($sql);
                    $requete->execute(array('PRODUIT','PR_E',$id));
                   
                }
            }

        }

        
    }



?>
<div class="row">

<!--Compte des produit et de charge-->
    <div class="col-12 text-center">
        <h2><strong>Compte des produits et des chargers de votre entreprise</strong></h2>
            <table class="my-4 table table-bordered">
                <thead>
                    <tr>
                        <td>Compte</td>
                        <td>Libelle</td>
                        <td>Montant</td>
                    </tr>
                </thead>
                <tbody id = 'tbody'>
                    <tr>
                        <th></th>
                        <th>I- PRODUITS D’EXPLOITATION</th>
                    </tr>
                    <?PHP
                    $SEL = "SELECT * FROM journal WHERE detail = ?";
                    $req = $BDD->prepare($SEL);
                    $req->execute(array('PR_E'));
                    $donne = $req->fetchAll();
                                //var_dump($donne);

                                    ?>
                                    <tr>
                                        <td><?=$donne[0]['compte']?></td>
                                        <td><?=$donne[0]['libelle']?></td>
                                        <td><?=$donne[0]['debit']+$donne[0]['credit']?></td>
                                    </tr>
                                    
                                    <?php
                                
                    ?>
                    

                    <tr>
                        <td></td>
                        <th>TOTAL 1</th>
                        <th></th>
                    </tr>
                        
                    <tr>
                        <th></th>
                        <th>II- CHARGES D’EXPLOITATION</th>
                    </tr>

                    <?PHP
                        $SEL = "SELECT * FROM journal WHERE detail = ?";
                        $req = $BDD->prepare($SEL);
                        $req->execute(array('CH_E'));
                        $R = $req->rowCount();
                        
                            $donneC = $req->fetchAll();
                            ?>
                                    <tr>
                                        <td><?=$donneC[0]['compte']?></td>
                                        <td><?=$donneC[0]['libelle']?></td>
                                        <td><?=$donneC[0]['debit']+$donneC[0]['credit']?></td>
                                    </tr>
                                    
                                    <?php
                                
                        
                    ?>
                    <tr>
                        <td></td>
                        <th>TOTAL 2</th>
                        <th><?='0'?></th>
                    </tr>
                    <tr>
                        <td></td>
                        <th>III- RÉSULTAT D’EXPLOITATION (I-II)</th>
                        <th></th>
                    </tr>

                    <tr>
                        <td></td>
                        <th>IV- PRODUITS FINANCIERS</th>
                    </tr>
                    
                    <?php

                        
                    ?>
                    <tr>
                        <td></td>
                        <th>TOTAL 3</th>
                        <th></th>
                    </tr>

                    <tr>
                        <td></td>
                        <th>V- CHARGES FINANCIÈRES</th>
                    </tr>
                    <?php

                        
                    ?>

                    <tr>
                        <td></td>
                        <th>VI- RÉSULTAT FINANCIER (IV-V)</th>
                        <th></th>
                    </tr>

                    <tr>
                        <td></td>
                        <th>VII- RÉSULTAT COURANT (III+VI)</th>
                        <th></th>
                    </tr>

                    <tr>
                        <td></td>
                        <th>VIII- PRODUITS NON COURANTS</th>
                    </tr>

                    <tr>
                        <td></td>
                        <th>IX- CHARGES NON COURANTES</th>
                    </tr>

                    <tr>
                        <td></td>
                        <th>X- RÉSULTAT NON COURANT (VIII-IX)</th>
                        <th></th>
                    </tr>

                    <tr>
                        <td></td>
                        <th>XI- RÉSULTAT AVANT IMPÔT </th>
                        <th></th>
                    </tr>

                    <tr>
                        <td></td>
                        <th>XIII- RÉSULTAT NET (XI-XII)</th>
                        <th></th>
                    </tr>
                </tbody>
        </table>
    
                
    </div>

<!--SIG-->
    <div class="col-12 text-center">
    <table class="my-4 table table-bordered">
        <h2><strong>TABLEAU DE FORMATION DES RESULTATS</strong></h2>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>EXERCICE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td>1</td>
                    <td></td>
                    <td>LIBELE</td>
                    <td>EXO</td>
                </tr>

                <tr>
                    <td>I</td>
                    <td></td>
                    <td>=</td>
                    <th>Marge brute sur vente en l’état</th>
                    <th></th>
                </tr>

                <tr>
                    <td>II</td>
                    <td></td>
                    <td>+</td>
                    <th>Production de l’exercice (3+4+5)</th>
                    <th></th>
                </tr>

                <tr>
                    <td>III</td>
                    <td></td>
                    <td>-</td>
                    <th>Consommation de l’exercice (6+7)</th>
                    <th></th>
                </tr>

                <tr>
                    <td>IV</td>
                    <td></td>
                    <td>=</td>
                    <th>Valeurs ajoutée (I+II-III)</th>
                    <th></th>
                </tr>

                <tr>
                    <td>V</td>
                    <td></td>
                    <td>+</td>
                    <th>Excédent brut d’exploitation (E.B.E.)</th>
                    <th></th>
                </tr>

                <tr>
                    <td>VI</td>
                    <td></td>
                    <td>=</td>
                    <th>Résultat d’exploitation (±)</th>
                    <th></th>
                </tr>

                <tr>
                    <td>VII</td>
                    <td></td>
                    <td>±</td>
                    <th>Résultat financier</th>
                    <th></th>
                </tr>

                <tr>
                    <td>VIII</td>
                    <td></td>
                    <td>=</td>
                    <th>Résultat courant (±)</th>
                    <th></th>
                </tr>

                <tr>
                    <td>IX</td>
                    <td></td>
                    <td>±</td>
                    <th>Résultat non courant</th>
                    <th></th>
                </tr>

                <tr>
                    <td>X</td>
                    <td></td>
                    <td>=</td>
                    <th>Résultat net de l’exercice (±)</th>
                    <th></th>
                </tr>
            </tbody>
    </div>
</div>
<?php
    require_once 'head.php';
?>