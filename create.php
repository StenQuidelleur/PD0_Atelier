<?php

    include('layout/head.php');
    require 'connec.php';
    $pdo = new PDO (DSN,USER,PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


if($pdo === false){
        echo "Connection error :" .$pdo->error_log();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['author'])) {
            try {
                $statement = $pdo->prepare('INSERT INTO article (title, content, author) VALUES (:title,:content,:author)');

                $statement->execute(['title' => $_POST['title'], 'content' => $_POST['content'], 'author' => $_POST['author']]);
                return header('Location: http://localhost:8888/PDO_Atelier/index.php');
            } catch (PDOException $event){
                $error = $event->getMessage();
            }
        }
        else {
            echo " Tout les champs sont obligatoires !";
        }
    }

    if(isset($error)){
        echo $error;
    }
?>


    <form method="POST" class="col-6">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" class="form-control" id="author" name="author">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

<?php include('layout/footer.php');