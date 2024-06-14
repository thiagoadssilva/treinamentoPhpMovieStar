<?php
require_once("templates/header.php");

require_once("models/User.php");
require_once("dao/UserDAO.php");

$user = new User();
$userDao = new UserDao($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);
?>

<div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md-4 new-movie-container">
        <h1 class="page-title">Adicionar Filme</h1>
        <p class="page-description">Adicione sua crítica e compartolhe com o mundo!</p>
        <form action="<?= $BASE_URL ?>movie_process.php" id="add-movie-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="create">
            <div class="form-group">
                <label for="title" style="margin-bottom: 10px; margin-top: 10px;">Titulo:</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Digite o titulo do seu filme">
            </div>
            <div class="form-group">
                <label for="image" style="margin-bottom: 10px; margin-top: 10px;">Image:</label><br>
                <input type="file" class="form-control-file" name="image" id="image">
            </div>
            <div class="form-group">
                <label for="length" style="margin-bottom: 10px; margin-top: 10px;">Duração:</label>
                <input type="text" class="form-control" name="length" id="length" placeholder="Digite a duração do filme">
            </div>
            <div class="form-group">
                <label for="category" style="margin-bottom: 10px; margin-top: 10px;">Categoria:</label>
                <select name="category" id="category" class="form-control">
                    <option value="">Selecione</option>
                    <option value="Ação">Ação</option>
                    <option value="Drama">Drama</option>
                    <option value="Comédia">Comédia</option>
                    <option value="Fantasia / Ficção">Fantasia / Ficção</option>
                    <option value="Romance">Romance</option>
                </select>
            </div>
            <div class="form-group">
                <label for="trailer" style="margin-bottom: 10px; margin-top: 10px;">Trailer:</label>
                <input type="text" class="form-control" name="trailer" id="trailer" placeholder="Insira o link do trailler">
            </div>
            <div class="form-group">
                <label for="description" style="margin-bottom: 10px; margin-top: 10px;">Descrição:</label>
                <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o filme..."></textarea>
            </div>
            <input type="submit" value="Adicionar Filme" class="btn card-btn">
        </form>
    </div>
</div>

<?php
require_once("templates/footer.php");
?>