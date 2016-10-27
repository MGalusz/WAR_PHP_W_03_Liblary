$(function () {
    
    var addBook = $('#addButton');
    
    function loadAllBooks() {
        $.ajax({
            url: 'app/books.php',
            type: 'GET',
            dataType: 'json',
            success: function (result) {
                //w result jest lista ksiazek
                for (var i = 0; i < result.length; i++) {
                    //obiekt js z pojed ksiązką
                    var book = JSON.parse(result[i]);
                    var bookDiv = $('<div>');
                    bookDiv.addClass('singleBook');
                    bookDiv.html('<h3 data-id="' + book.id + '">' + book.title + '</h3><div class="description"></div>');
                    //wpinamy książke na stronę
                    $('#bookList').append(bookDiv);
                }
            },
            error: function () {
                console.log('Wystąpił błąd');
            }
        });
    }
   loadAllBooks();
    $(addBook).on('click', function (event) {
        event.preventDefault();
        $('bookList').empty();
        var addTitle = $('#addTitle').val();
        var addAuthor = $('#addAuthor').val();
        var addDesc = $('#addDesc').val();

        var toSend = {};
        toSend.title = addTitle;
        toSend.author = addAuthor;
        toSend.description = addDesc;
        console.log(toSend);

        $.ajax({
            url: 'app/books.php',
            type: 'POST',
            data: toSend ,
            dataType: 'json',
            success: function (result) {
                console.log('sukces post');
                loadAllBooks();
            },
            error: function () {
                console.log('blad Post');
            },
            complete: function () {
                console.log('complete Post');
            }

        });
    });

});

