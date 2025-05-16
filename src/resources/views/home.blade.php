<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My online library</title>
</head>

<body>
    <h1>My library</h1>
    <form method="POST" action="{{ route('books.store') }}">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        @error('title')
            <div class="alert">{{ $message }}</div>
        @enderror
        <br>
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required>
        @error('author')
            <div class="alert">{{ $message }}</div>
        @enderror
        <br>
        <button type="submit">ADD</button>
    </form>
    <table id="booksTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Test Book</td>
                <td>Test Author</td>
                <td><button type="button">Delete</button></td>
            </tr>
        </tbody>
    </table>

</html>
