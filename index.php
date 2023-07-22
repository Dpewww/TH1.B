<?php

// Xây dựng một interface có tên là IBook, mô tả property và method
// cần thiết cho các lớp dạng Book thực thi.
interface IBook {
    public function setName($name);
    public function setAuthor($author);
    public function setPublisher($publisher);
    public function setYear($year);
    public function setISBN($isbn);
    public function setChapters($chapters);
    public function getName();
    public function getAuthor();
    public function getPublisher();
    public function getYear();
    public function getISBN();
    public function getChapters();
    }

// Xây dựng lớp Book kế thừa từ IBook, thực hiện các mô tả trong IBook
// và các chi tiết riêng của Book.
class Book implements IBook {
    private $name;
    private $author;
    private $publisher;
    private $year;
    private $isbn;
    private $chapters;

    public function setName($name) {
    $this->name = $name;
    }

    public function setAuthor($author) {
    $this->author = $author;
    }

    public function setPublisher($publisher) {
    $this->publisher = $publisher;
    }

    public function setYear($year) {
    $this->year = $year;
    }

    public function setISBN($isbn) {
    $this->isbn = $isbn;
    }

    public function setChapters($chapters) {
    $this->chapters = $chapters;
    }

    public function getName() {
    return $this->name;
    }

    public function getAuthor() {
    return $this->author;
    }

    public function getPublisher() {
    return $this->publisher;
    }

    public function getYear() {
    return $this->year;
    }

    public function getISBN() {
    return $this->isbn;
    }

    public function getChapters() {
    return $this->chapters;
    }
}

// Xây dựng lớp BookList quản lý danh sách các đối tượng Book, lớp này chứa các
// thao tác trên danh sách các đối tượng Book.
class BookList {

    private $books = array();

    public function addBook(Book $book) {
    $this->books[] = $book;
    }

    public function getBooks() {
    return $this->books;
    }

    public function sortByName() {
    usort($this->books, function($a, $b) {
    return strcmp($a->getName(), $b->getName());
    });
    }

    public function sortByAuthor() {
    usort($this->books, function($a, $b) {
    return strcmp($a->getAuthor(), $b->getAuthor());
    });
    }

    public function sortByYear() {
    usort($this->books, function($a, $b) {
    return $a->getYear() - $b->getYear();
    });
    }
}
?>

<!--xây dựng Web-->

<!DOCTYPE html>
<html>
<head>
    <title>Quan li danh sach Sach</title>
</head>
<body>
<h1 style="text-align: center; color: #ec6029 ">Quan li Sach</h1>

<form method="post" class="form-me">
    <div class="box-form">
        <div class="name_label">
            <label>Name:</label>
        </div>
       <div class="content_input">
           <input type="text" name="name" required>
       </div>
    </div>
    <div class="box-form">
        <div class="name_label">
            <label>Author:</label>
        </div>
        <div class="content_input">
            <input type="text" name="author" required>
        </div>
    </div>
    <div class="box-form">
        <div class="name_label">
            <label>Publisher:</label>
        </div>
        <div class="content_input">
            <input type="text" name="publisher" required>
        </div>
    </div>
    <div class="box-form">
        <div class="name_label">
            <label>Year:</label>
        </div>
        <div class="content_input">
            <input type="number" name="year" required>
        </div>
    </div>
    <div class="box-form">
        <div class="name_label">
            <label>ISBN:</label>
        </div>
        <div class="content_input">
            <input type="text" name="isbn" required>
        </div>
    </div>
    <div class="box-form">
        <div class="name_label">
            <label>Chapters:</label>
        </div>
        <div class="content_input flex">
            <textarea name="chapters"></textarea>
            <input type="submit" name="submit" value="Add Book">
        </div>
    </div>

</form>

<?php
// Xử lý thêm sách mới
if(isset($_POST['submit'])) {
    $book = new Book();
    $bookList = new BookList();
    $book->setName($_POST['name']);
    $book->setAuthor($_POST['author']);
    $book->setPublisher($_POST['publisher']);
    $book->setYear($_POST['year']);
    $book->setISBN($_POST['isbn']);
    $book->setChapters(explode("\n", $_POST['chapters']));
    $bookList->addBook($book);
}

// Hiển thị danh sách các cuốn sách


$books = $bookList->getBooks();
if(count($books) > 0) {
    echo '<h2>Book List:</h2>';
    echo '<ul>';
    foreach($books as $book) {
        echo '<li>';
        echo $book->getName() . ' by ' . $book->getAuthor() . ', published by ' . $book->getPublisher() . ' in ' . $book->getYear();
        echo '</li>';
    }
    echo '</ul>';
}

// Sắp xếp danh sách theo tên tác giả, tên sách hoặc năm xuất bản

if(isset($_GET['sort'])) {
    switch($_GET['sort']) {
        case 'author':
            $bookList->sortByAuthor();
            break;
        case 'name':
            $bookList->sortByName();
            break;
        case 'year':
            $bookList->sortByYear();
            break;
    }
}
?>

<h2>Sort By:</h2>
<ul>
    <li><a href="?sort=author">Author</a></li>
    <li><a href="?sort=name">Name</a></li>
    <li><a href="?sort=year">Year</a></li>
</ul>
</body>
<style>
    .form-me .box-form {
        display: flex;

    }
    .form-me .name_label  {
        width: 200px;
    }
    .form-me .content_input {
        width: 300px;
        display: flex;
    }
    .form-me input, .form-me textarea {
        width: 100%;
    }
    .form-me .box-form:not(:last-child) {
        margin-bottom: 20px;
    }
    .flex {
        display: flex;
        flex-wrap: wrap;
    }
    .form-me .content_input.flex {
        row-gap: 20px;
    }
    .form-me .content_input.flex textarea, .form-me .content_input.flex input {
        width: 100%;
    }
</style>
</html>