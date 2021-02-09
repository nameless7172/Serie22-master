<?php


Class Model{




    private $pdo;
    




    public function __construct($values){
        try {

            $this->pdo = new PDO(
                sprintf(
                    'mysql:host=%s;dbname=%s;port=%s;charset=%s',
                    $values->hn,
                    $values->db,
                    $values->port,
                    $values->charset,
                ),
               $values->un,
               $values->pw,
                
            );
            //$pdo = new PDO('sqlite:'.dirname(__FILE__).'/database.sqlite');
          
          } catch (PDOException $e) {
              echo "Error: " . $e->getMessage();
              exit;
          }

    }


    public function delete(){
        if(isset($_POST['supprimer'])){
            try {
              $isbn = $this->get_post( 'isbn');
              $query = "DELETE FROM classiques WHERE isbn= :isbn";
          
              $statement = $this->pdo->prepare($query);
              $statement->bindValue(':isbn', $isbn, PDO::PARAM_STR_CHAR);
              $statement->execute();
            } catch (PDOException $e) {
              echo "Error: ".$e->getMessage();
            }
        }
          
    }
    public function insert(){
        
        if (isset($_POST['ajouter'])   &&
        isset($_POST['auteur'])    &&
        isset($_POST['titre'])     &&
        isset($_POST['categorie']) &&
        isset($_POST['annee'])     &&
        isset($_POST['isbn']))
            {
                
               $auteur    = $this->get_post( 'auteur');
               $titre     = $this->get_post( 'titre');
               $categorie = $this->get_post( 'categorie');
               $annee     = $this->get_post( 'annee');
               $isbn      = $this->get_post( 'isbn');
                

        
        
       

        try {
        $statement = $this->pdo->prepare('INSERT INTO classiques (auteur,titre,categorie,annee,isbn) VALUES (:auteur, :titre, :categorie, :annee, :isbn)');
        $statement->bindValue(':auteur', $auteur, PDO::PARAM_STR);
        $statement->bindValue(':titre', $titre, PDO::PARAM_STR);
        $statement->bindValue(':categorie', $categorie, PDO::PARAM_STR);
        $statement->bindValue(':annee', $annee, PDO::PARAM_INT);
        $statement->bindValue(':isbn', $isbn, PDO::PARAM_STR);
        $statement->execute();

        } catch (PDOException $e) {
        echo "Error: ".$e->getMessage();
        }

        }
    }
        
        public function modify(){
            

            //MODIFICATION SUR ISBN
            if (isset($_POST['modifier'])   &&
            isset($_POST['auteur'])    &&
            isset($_POST['titre'])     &&
            isset($_POST['categorie']) &&
            isset($_POST['annee'])     &&
            isset($_POST['isbn']))
            {
            
            $auteur1    = $this->get_post( 'auteur');
            $titre1     = $this->get_post( 'titre');
            $categorie1 = $this->get_post( 'categorie');
            $annee1     = $this->get_post( 'annee');
            $isbn1      = $this->get_post( 'isbn');

            

            try{
            
            $statement = $this->pdo->prepare('UPDATE classiques SET `auteur` = :auteur, `titre` = :titre, `categorie` = :categorie, `annee` = :annee  WHERE isbn = :isbn');
            $statement->bindValue(':isbn', $isbn1, PDO::PARAM_STR); 
            $statement->bindValue(':auteur', $auteur1, PDO::PARAM_STR);
            $statement->bindValue(':titre', $titre1, PDO::PARAM_STR);
            $statement->bindValue(':categorie', $categorie1, PDO::PARAM_STR);
            $statement->bindValue(':annee', $annee1, PDO::PARAM_INT);
            $statement->bindValue(':isbn', $isbn1, PDO::PARAM_STR);
            $statement->execute();
            echo "<br>";
            
            
            
            }catch(PDOException $e){
                echo "Error: ".$e->getMessage();
            }  
        }
    }
        public function clone(){

                        //CLONER

            if (isset($_POST['cloner']) && isset($_POST['isbn'])) {
                
                try {
                
                $isbn = $this->get_post('isbn');
                $sql = 'SELECT * FROM classiques WHERE isbn = isbn';
                $statement = $this->pdo->prepare($sql);
                $statement->execute();
                $row = $statement->fetch(PDO::FETCH_BOTH);
                  
                $auteur2    = $this->get_post( 'auteur');
                $titre2    = $this->get_post( 'titre');
                $categorie2 = $this->get_post( 'categorie');
                $annee2    = $this->get_post( 'annee');
                $isbn2=uniqid(); 


            
                $query = 'INSERT INTO classiques (auteur,titre,categorie,annee,isbn) VALUES (:auteur, :titre, :categorie, :annee, :isbn)';
                $st = $this->pdo->prepare($query);
                $st->bindValue(':isbn', $isbn2, PDO::PARAM_STR); 
                $st->bindValue(':auteur', $auteur2, PDO::PARAM_STR);
                $st->bindValue(':titre', $titre2, PDO::PARAM_STR);
                $st->bindValue(':categorie', $categorie2, PDO::PARAM_STR);
                $st->bindValue(':annee', $annee2, PDO::PARAM_INT);
                $st->execute();


                } catch (PDOException $e) {
                echo "Error: ".$e->getMessage();
                }
             }
          }
                            
        public function gettab(){
            
                try{
                    $sql = 'SELECT * FROM classiques';
                    $statement = $this->pdo->prepare($sql);
                    $statement->execute();
                    
                    while (($row = $statement->fetch(PDO::FETCH_BOTH)) !== false) {
                    echo <<<_END
                    <pre>
                    Auteur $row[0]
                    Titre $row[1]
                    Catégorie $row[2]
                    Année $row[3]
                    ISBN $row[4]
                    </pre>
                    <form action="" method="post">
                
                    <input type="hidden" name="supprimer" value="yes">
                    <input type="hidden" name="isbn" value="$row[4]">
                    <input type="submit" id="sup" name = 'supprimer' value="SUPPRIMER FICHE">
                    </form>
                
                    <form action="" method="post">
                
                    <input type="hidden" name="cloner" value="yes">
                    <input type="hidden" name="isbn" value="$row[4]">
                    <input type="hidden" name="auteur" value="$row[0]">
                    <input type="hidden" name="titre" value="$row[1]">
                    <input type="hidden" name="annee" value="$row[3]">
                    <input type="hidden" name="categorie" value="$row[2]">
                    <input type="submit" id="sup" name = 'cloner' value="DUPLIQUER FICHE">
                    </form>
                    
                
                _END;
                    }
                } catch (PDOException $e) {
                    echo "Error: ".$e->getMessage();
                }
                
      
               
        }
                        
                        
          public function get_post($var)
                        {
                            return $_POST[$var];
                        }            
                        
                        
}        
 ?>
