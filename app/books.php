<?php

//plik do którego będzie łączył się JS

$dir = dirname(__FILE__); //zwraca aktualny katalog
//includujemy pliki połaczanie z baza i klase book
include($dir . '/src/Db.php');
include($dir . '/src/Book.php');

//laczymy sie bazą
$conn = DB::connect();

//plik zawsze zwraca JSONa
header('Content-Type: application/json');
//sprawdzamy w jaki sposob (typ) połączył się JS

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //zgodnie z REST GET zwraca dane
    if (isset($_GET['id']) && intval($_GET['id']) > 0) {
        //sprawdzilismy czy przeslane jest id pojedynczej ksiazki
        $books = Book::loadFromDB($conn, $_GET['id']);
        //zwraca tablicę 1 elementową
    } else {
        //pobieramy wszystkie książki
        $books = Book::loadFromDB($conn);
    }

    echo json_encode($books);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['title']) && strlen($_POST['title']) > 0 &&
            isset($_POST['author']) && strlen($_POST['author']) > 0 &&
            isset($_POST['description']) && strlen($_POST['description']) > 0) {

        $book = new Book;
        $book->setAuthor($_POST['author']);
        $book->setTitle($_POST['title']);
        $book->setDescription($_POST['description']);
        $book->addBook($conn);


        echo json_encode($book);
    }



    //zgodnie z rest POST dodaje dane
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //pobieramy przeslane dane
    parse_str(file_get_contents('php://input'), $put_vars);
    if (isset($put_vars['id']) &&
            (isset($put_vars['newAuthor']) && strlen($put_vars['newAuthor']) > 0 ) || (isset($put_vars['newDescription']) && strlen($put_vars['newDescription']) > 0 ) || (isset($put_vars['newTitle']) && strlen($put_vars['newTitle']) > 0 )) {
        $id = $put_vars['id'];
        $newAuthor = $put_vars['newAuthor'];
        $newDescription = $put_vars['newDescription'];
        $newtitle = $put_vars['newTitle'];
        
        $book->setAuthor($newAuthor);
        $book->setDescription($newDescription);
        $book->setTitle($newtitle);
        $book->seId($id);
        $book->addBook($connection);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        parse_str(file_get_contents('php://input'), $put_vars);
    
   Book::delete($conn, $toDel['id']);
        $confirmationDelete = ['statusToConfirm' => 'Ksiazka skasowana'];
    echo json_encode($confirmationDelete);
}




