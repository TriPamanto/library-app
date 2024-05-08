<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Book</title>
</head>
<body>
  <h1>Add New Book</h1>
  <form action="{{ route('books.store')}}" method="POST">
  @csrf
  <div>
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="">
  </div>
  <div>
    <label for="author">Author:</label>
    <input type="text" id="author" name="author" value="">
  </div>
  <div>
    <label for="year">Year:</label>
    <input type="text" id="year" name="year" value="">
  </div>
  <div>
    <button type="submit">Add</button>
  </div>
  </form>
</body>
</html>