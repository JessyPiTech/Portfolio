<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $to = "j.piquerel.p@gmail.com"; 
    $subject = "Nouveau message de " . $name;
    $body = "Nom: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "<script>alert('Merci, votre message a été envoyé avec succès.');</script>";
    } else {
        echo "<script>alert('Désolé, une erreur s\'est produite lors de l\'envoi du message.');</script>";
    }
} else {
    echo "<script>alert('Formulaire non soumis.');</script>";
}
?>