<?php
include('layout/head.php');

require 'connec.php';
$pdo = new PDO (DSN,USER,PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

if($pdo === false) {
    echo 'Connection Error :' . $pdo->error_log();
}

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $request = "SELECT * FROM article WHERE id=" . $id;
    $sendRequest = $pdo->query($request);
    if ($sendRequest === false) {
        $pdo->errorInfo();
    }
    $article = $sendRequest->fetchObject();
}

if(isset($_POST) && !empty($_POST)){
    if(!empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['author'])){
        try{
            $id = $_GET['id'];
            $editArticle = $pdo->prepare("UPDATE article SET title=:title, content=:content, author=:author WHERE id=:id");
            $editArticle->execute([
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'author' => $_POST['author'],
                'id' => $id
            ]);
            return header('Location: http://localhost:8888/PDO_Atelier/index.php');
        } catch (PDOException $e){
            echo $error = $e->getMessage();
        }
    } else {
        echo 'TOUS LES CHAMPS SONT REQUIS';
    }
}

if (isset($error)){
    echo $error;
}

?>


<form method="POST" class="col-6">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" value="<?= $article->title ?>">
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea class="form-control" id="content" name="content" rows="3" value="<?= $article->content ?>"></textarea>
    </div>
    <div class="form-group">
        <label for="author">Author</label>
        <input type="text" class="form-control" id="author" name="author" value="<?= $article->author ?>">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php
    include('layout/footer.php');
?>