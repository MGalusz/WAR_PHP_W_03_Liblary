<?php

//klasa reprezentująca pojedynczą książkę
class Book implements JsonSerializable {

    private $id;
    private $title;
    private $author;
    private $description;

    public function __construct() {
        $this->id = -1;
        $this->title = '';
        $this->author = '';
        $this->description = '';
    }
    
    public function addBook(mysqli $connection ){
        if($this->id ==-1){
            $qurey = "INSERT INTO books(id,title,author,description)"
                    . "VALUES('$this->id','$this->title','$this->description')";
                 if ($connection->query($query)) {
                     var_dump($query);
                     
                $this->id = $connection->insert_id;
                return TRUE;
            } else {
                return FALSE;
            }
        }else{
             $query = "UPDATE Tweet"
                     . "SET title = '$this->title',author='$this->author',description='$this->description'"
                     . "WHERE id= $this->id";
            
        }
    }
    
    public function delete(mysqli $connetion) {
        if ($this->id != -1) {
            $query = "DELETE FROM book WHERE id = $this->id";
            if ($connetion->query($query)) {
                $this->id = -1;
                return TRUE;
            } else {
                return false;
            }
        }return TRUE;
    }




    //id nie podane zwroci all books a podane pojedyncza ksiazke
    public static function loadFromDB(mysqli $conn, $id = null) {
        if (is_null($id)) {
            //pobieramy all books
            $result = $conn->query('SELECT * FROM books');
        } else {
            //pobieramy pojedyncza książkę
            $result = $conn->query("SELECT * FROM books WHERE id='" . intval($id) . "'");
        }

        $bookList = [];

        if ($result && $result->num_rows > 0) {//sprawdzamy czy db coś zwrociła
            foreach ($result as $row) {
                $dbBook = new Book();
                $dbBook->id = $row['id'];
                $dbBook->author = $row['author'];
                $dbBook->title = $row['title'];
                $dbBook->description = $row['description'];

                $bookList[] = json_encode($dbBook); //bez interfejsu tak NIE ZADZIAŁA
            }
        }

        return $bookList;
    }

    public function jsonSerialize() {
        //funkcja zwraca nam dane z obiketu do json_encode
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'description' => $this->description
        ];
    }

    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }

    function getAuthor() {
        return $this->author;
    }

    function getDescription() {
        return $this->description;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setAuthor($author) {
        $this->author = $author;
    }

    function setDescription($description) {
        $this->description = $description;
    }

}
