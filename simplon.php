
<?php
    $serveur = "localhost"; $dbname = "p_simplon"; $user = "root"; $pass = "root";
    
    $nom = valid_donnees($_POST["nom"]);
    $prenom = valid_donnees($_POST["prenom"]);
    $numero = valid_donnees($_POST["numero"]);
    $email = valid_donnees($_POST["email"]);

    function valid_donnees($donnees){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }
    
    /*Si les champs nom, prenom, numero et email ne sont pas vides et si les donnees ont
     *bien la forme attendue...*/
    if (!empty($nom)
        && strlen($nom) <= 20
        && preg_match("^[A-Za-z '-]+$",$nom)
        && empty($prenom)
        && strlen($prenom) <= 20
        && preg_match("^[A-Za-z '-]+$",$prenom)
        && empty($numero)
        && filter_var($numero, FILTER_VALIDATE_EMAIL)){
        && empty($email)
        && filter_var($email, FILTER_VALIDATE_EMAIL)){
    
        try{
            //On se connecte à la BDD
            $dbco = new PDO("mysql:host=$localhos;dbname=$p_simplon",$user,$pass);
            $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //On insère les données reçues
            $sth = $dbco->prepare("
                INSERT INTO form(nom,prenom, numero, email)
                VALUES(:nom, :prenom, :numero, :email)");
            $sth->bindParam(':nom',$nom);
            $sth->bindParam(':prenom',$prenom);
            $sth->bindParam(':numero',$numero);
            $sth->bindParam(':email',$email);
            $sth->execute();
            //On renvoie l'utilisateur vers la page
            header("http://localhost/prisca_simplon/projetsimplon.html");
        }
        catch(PDOException $e){
     echo 'Erreur : '.$e->getMessage();
        }
    }else{
        header("http://localhost/prisca_simplon/projetsimplon.html");
    }
?>

