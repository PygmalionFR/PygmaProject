<?php $page = 'index' ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/indexcss.css">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php 
        include "php/header.php"
    ?>

    <div>
        <?php 
            include "php/flux.php"
        ?>
    </div>
    <script>
    $(document).ready(function() {
        $(".voir-commentaires").click(function(e) {
        e.preventDefault();
        alert("Vous devez être connecté pour voir les commentaires.");
        });
    });
    </script>

</body>
</html>