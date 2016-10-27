<html>
    <head>
        <title>Books Shelf</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <script src="js/script.js"></script>
    </head>
    <body>

<form>
    <label>
        Tytuł książki:
        <input id="addTitle" type="text" name="title">
    </label>
    <br>
    <label>
        Autor:
        <input id="addAuthor" type="text" name="author">
    </label>
    <br>
    <label>
        Opis:
        <input id="addDesc" type="text" name="description">
    </label>
    <br>
    <input id="addButton" type="submit" value="Dodaj książkę">
</form>

<form method="GET">
    <input id="showButton" type="submit" value="Pokaż książki">
</form>

<h1>Lista Książek: </h1>
<div id="bookList"></div>

</body>
</html>