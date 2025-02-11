<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Connexion à la base de données
    $conn = new mysqli('localhost', '', ' ', 'formulaire');

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }

    // Insérer les données dans la base de données
    $stmt = $conn->prepare("INSERT INTO utilisateurs (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    $stmt->execute();
    $stmt->close();

    // Fermer la connexion
    $conn->close();

    // Préparer l'email
    $to = "dallervelli@gmail.com";
    $email_subject = "Nouveau formulaire soumis: $subject";
    $email_body = "Vous avez reçu un nouveau message.\n\n".
                  "Nom: $name\n".
                  "Email: $email\n".
                  "Sujet: $subject\n".
                  "Message:\n$message";
    $headers = "From: noreply@example.com";

    // Envoyer l'email
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "Email envoyé avec succès";
    } else {
        echo "Échec de l'envoi de l'email";
    }
}
?>
