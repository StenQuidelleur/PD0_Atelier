<?php
    include('layout/head.php');

    require 'connec.php';
    $pdo = new PDO (DSN,USER,PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

if($pdo === false){
        echo "Connection error :" .$pdo->error_log();
    } else {
        $request = "SELECT * FROM article";
        try {
            $sendRequest = $pdo->query($request);
            $articles = $sendRequest->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            $error =$e->getMessage();
        }
    }


?>
<?php foreach($articles as $article){ ?>
<main role="main" class="container">
    <div class="jumbotron">
            <h1><?php echo $article['title'] ?> </h1>
            <p class="lead">
                <?= $article['content'] ?>
            </p>
            <p class="lead">
                <?= $article['author'] ?>
            </p>
        <a class="btn btn-lg btn-primary" href=<?="edit.php?id=" .$article['id'] ?> role="button">Edit</a>
        <a class="btn btn-lg btn-primary" href=<?="delete.php?id=" .$article['id'] ?> role="button">Delete</a>
    </div>
</main>
<?php } ?>

<?php include('layout/footer.php');
