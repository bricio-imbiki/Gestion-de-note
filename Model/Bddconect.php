<?php
    //declaration d'une classe
    class connexionDB{
        protected $serveur = "localhost";
        protected $name = "gestion_financiere";
        protected $login = "root";
        protected $pass = "";
        protected $connexion;

        function __construct($serveur = NULL,$name = NULL,$login = NULL,$pass = NULL){
            if($serveur != null){
                $this->serveur = $serveur;
                $this->name = $name;
                $this->login = $login;
                $this->pass = $pass;
            }
            //conection a la base de donner maintanant
            try{
                $this->connexion = new PDO("mysql:host={$this->serveur};dbname={$this->name}",
                        $this->login,$this->pass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                        //echo "true";
            }
            catch(PDOException $e){
                //echo "false";
                die('Erreur de connection'.$e->getMessage());
            }
        }

        public function connexion(){
            //echo "conection bien efectuer";
            return $this->connexion;
        }
        
    }

    

?>