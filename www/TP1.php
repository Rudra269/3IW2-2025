<?php
/*
Tout le code doit se faire dans ce fichier PHP

Réalisez un formulaire HTML contenant :
- firstname
- lastname
- email
- pwd
- pwdConfirm

Créer une table "user" dans la base de données, regardez le .env à la racine et faites un build de docker
si vous n'arrivez pas à les récupérer pour qu'il les prenne en compte

Lors de la validation du formulaire vous devez :
- Nettoyer les valeurs, exemple trim sur l'email et lowercase (5 points)
- Attention au mot de passe (3 points)
- Attention à l'unicité de l'email (4 points)
- Vérifier les champs sachant que le prénom et le nom sont facultatifs
- Insérer en BDD avec PDO et des requêtes préparées si tout est OK (4 points)
- Sinon afficher les erreurs et remettre les valeurs pertinantes dans les inputs (4 points)

Le design je m'en fiche mais pas la sécurité

Bonus de 3 points si vous arrivez à envoyer un mail via un compte SMTP de votre choix
pour valider l'adresse email en bdd

Pour le : 22 Octobre 2025 - 8h
M'envoyer un lien par mail de votre repo sur y.skrzypczyk@gmail.com
Objet du mail : TP1 - 2IW3 - Nom Prénom
Si vous ne savez pas mettre votre code sur un repo envoyez moi une archive


$conn_string = "host=db port=5432 dbname=postgres user=devuser password=devpass";
$dbconn4 = pg_connect($conn_string);*/

$connexion = new PDO('pgsql:host=db;port=5432;dbname=postgres', 'devuser', 'devpass');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = trim(htmlspecialchars($_POST['prenom']));
    $nom = trim(htmlspecialchars($_POST['nom']));               
    $email = strtolower(trim(htmlspecialchars($_POST['email'])));
    $mot_de_passe = trim(htmlspecialchars($_POST['mot_de_passe']));
    $mot_de_passe_confirm = trim(htmlspecialchars($_POST['mot_de_passe_confirm']));

    // Vérifie que les deux mots de passe saisis sont identiques
    if ($mot_de_passe !== $mot_de_passe_confirm) {
        echo "<script>alert('Les mots de passe ne correspondent pas.');</script>";
    // Vérifie que le mot de passe contient au moins 12 caractères
    } else {
        // Vérifier si l'email existe déjà
        $stmt_check_email = $connexion->prepare("SELECT email FROM utilisateur WHERE email = :mail");
        $stmt_check_email->bindParam('mail', $email, PDO::PARAM_STR);
        $stmt_check_email->execute();
        if ($stmt_check_email->rowCount() > 0) {
            echo "<script>alert('Cet email est déjà utilisé.');</script>";
        } else {
                
            // Hache le mot de passe
            $mot_de_passe_hashed = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            // Insérer l'utilisateur
            $stmt = $connexion->prepare("INSERT INTO utilisateur VALUES (:mail, :prenom, :nom, :motdepasse)");
            if ($stmt === false) {
                echo "<script>alert('Erreur lors de la préparation de la requête : " . addslashes($connexion->error) . "');</script>";
            } else {
                $stmt->bindParam(':mail', $email, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                $stmt->bindParam(':motdepasse', $mot_de_passe_hashed, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    echo "<script>
                    alert('Inscription réussie !');
                    window.location.href = 'index.php';
                    </script>";
                    exit;
                } else {
                    echo "<script>alert('Erreur lors de l\'inscription : " . addslashes($stmt->error) . "');</script>";
                }
                $stmt->close();
            }
        }
    }
}



?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <h1>Hello, world!</h1>

    <form action="TP1.php" method="POST" onsubmit="return validateForm()">
            <div class="row">
                <div class="col">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom">     
                </div>
                <div class="col">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Adresse e-mail" required>
                    <label for="mot_de_passe">Mot de passe</label>
                    <div class="password-toggle">
                        <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" required onpaste="return false" oncopy="return false" oncontextmenu="return false">
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('mot_de_passe')"></i>
                    </div>
                    <label for="mot_de_passe_confirm">Confirmer le mot de passe</label>
                    <div class="password-toggle">
                        <input type="password" class="form-control" id="mot_de_passe_confirm" name="mot_de_passe_confirm" placeholder="Confirmer mot de passe" required onpaste="return false" oncopy="return false" oncontextmenu="return false">
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('mot_de_passe_confirm')"></i>
                    </div>
                </div>
            </div>
        <button type="submit" class="btn btn-primary btn-block mt-3">S'inscrire</button>
    </form>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->

    <script>

        function validateForm() {
            var prenom = document.getElementById("prenom").value.toLowerCase();
            var motDePasse = document.getElementById("mot_de_passe").value;
            var motDePasseConfirm = document.getElementById("mot_de_passe_confirm").value;

            if (motDePasse.length < 12) {
                alert("Le mot de passe doit contenir au moins 12 caractères.");
                return false;
            }
            if (motDePasse !== motDePasseConfirm) {
                alert("Les mots de passe ne correspondent pas.");
                return false;
            }
            if (prenom.length >= 4 && motDePasse.toLowerCase().match(new RegExp('\\b' + prenom.toLowerCase() + '\\b'))) {
                alert("Le mot de passe ne doit pas contenir le prénom.");
                return false;
            }
            if (!/[!@#$%^&*(),.?":{}|<>]/.test(motDePasse)) {
                alert("Le mot de passe doit contenir au moins un caractère spécial (!@#$%^&*(),.?\":{}|<>).");
                return false;
            }
            return true;
        }

        document.querySelectorAll('input[type="password"]').forEach(function(input) {
            input.oncontextmenu = function(e) {
                e.preventDefault();
                return false;
            };
        });
    </script>
</body>

</html>