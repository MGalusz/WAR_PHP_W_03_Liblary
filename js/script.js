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
                    bookDiv.html('<h3 data-id="' + book.id + '">' + book.title + '</h3><div class="description"></div>' + '<div class="toDel"> Usun</div>');
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
            data: toSend,
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
    $('#bookList').on('click', '.singleBook', function () {
        event.preventDefault();
        console.log('metoda GET');
        var book = [];
        book.id = $(this).find('h3').data('id');
        console.log(book.id);
        var bookInfo = $(this).find('.description');
        $.ajax({
            url: 'app/books.php',
            type: 'GET',
            data: {id: book.id},
            dataType: 'json',
            success: function (result) {
                console.log(result);
                var resultParase = JSON.parse(result);
                var toDiv = 'Autor: ' + resultParase.author
                        + '<br>'
                        + 'Opis: ' + resultParase.description + '<br>'
                        + '<div id = "changes">'
                        + '<label><input id = "Newauthor" type = "text" name = "Newdauthor"><input id="addButton" type="submit" value="zmien autora "></label>'
                        + '<label><input id = "NewDesc" type = "text" name = "Newdescription"><input id="addButton" type="submit" value="zmien desc "></label>'
                        + '<label><input id = "NewTitle" type = "text" name = "Newdtitle"><input id="addButton" type="submit" value="zmien tytul "></label>'
                        + '</div>';
                console.log(toDiv);
                bookInfo.html(toDiv).slideToggle('slow');
            },
            error: function (err) {
                console.log('blad 2');
                console.log(err);
            },
            complete: function () {
                console.log('complete 2');
            }

        });
    });
    $('#bookList').on('click', '#changes', function (event) {
        event.preventDefault();
        event.stopPropagation();
        var bookId = $(this).parent().find('h3').data('id');
        var changeAuthor = $(this).find('#Newauthor').val();
        var changeTitle = $(this).find('#NewTitle').val();
        var changeDesc = $(this).find('#NewDesc').val();
        $.ajax({
            url: 'app/books.php',
            type: 'PUT',
            data: {id: bookId, newAuthor:changeAuthor,newTitle: changeTitle, newDescriptions: changeDesc},
            dataType: 'json',
            success: function (result) {
                console.log(result);
                var resultParase = JSON.parse(result);
                var divToChange = $(this).parent().find('h3');
                var toDiv = 'Autor: ' + resultParase.newAutho
                        + '<br>'
                        + 'Opis: ' + resultParase.newDescriptions + '<br>';
                divToChange.text()=resultParase.newTitle;
                divToChange.find('.description').html(toDiv).slideToggle('slow');
            },
            error: function (err) {
                console.log('blad 2');
                console.log(err);
            },
            complete: function () {
                console.log('complete 2');
            }
        });
    });
        $('#bookList').on('click', '.toDel', function (event) {
        event.stopPropagation();

        var idToDel = [];
        idToDel.id =$(this).parent().find('h3').data('id');
        console.log(idToDel);
        

        $.ajax({
            url: 'app/books.php',
            type: 'DELETE',
            data: {id : idToDel.id},
            dataType: 'json',
            success: function (result) {
               console.log(result['statusToConfirm']);
            },
            error: function (err) {
                console.log('blad DELETE ');
                ;
            },
            complete: function () {
                console.log('complete DELETE');
            }
        });
});
});

