<?php
    require_once 'Bddconect.php';
    class Crud extends connexionDB{

        protected $date_cr;
        protected $compte;
        protected $libelle;
        protected $debit;
        protected $credit;


        function __constuct($date_cr,$compte,$libelle,$debit,$credit){
            
            parent :: __construct($serveur=NULL,$name=NULL,$login=NULL,$pass=NULL);
            $this->date_cr = $date_cr;
            $this->compte = $compte;
            $this->libelle = $libelle;
            $this->debit = $debit;
            $this->credit = $credit;

        }

        // table journal
        function Create($table){

            $BDD = parent :: connexion();
            $sql = "INSERT INTO ".$table."(date_cr,compte,libelle,debit,credit) VALUES(?,?,?,?,?)";
            $req = $BDD->prepare($sql);
            $req->execute(array($this->date_cr,$this->compte,$this->libelle,$this->debit,$this->credit));
            $rnum = $req->rowCount();
            return $rnum;
           
        }

        function Read($table){

            $BDD = parent :: connexion();
            $sql = "SELECT * FROM ".$table;
            return $req = $BDD->query($sql);
            
        }

        function Update(){
            $BDD = parent :: connexion();
        }

        function Delete(){
            $BDD = parent :: connexion();
        }
    }