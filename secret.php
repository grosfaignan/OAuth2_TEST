<!--tutoriel OAuth : https://www.youtube.com/watch?v=I5tFlK5PPjc -->
<!-- page qui se dump sur la page connect.php si la connection reussi-->

<?php 
require 'vendor/autoload.php';

session_start();
if (!isset($_SESSION['email']))
{
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X_UA-Compatible" content="id=edge">
    <title>equivalent page secrete tuto https://www.youtube.com/watch?v=I5tFlK5PPjc </title>
</head>
<body>
    <h1> cette page ne devrait pas etre accessible</h1>
    
    <?php dump($_SESSION) ?>
</body>
</html>
