<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Book</title>
</head>
<body>
  <h1>Edit Book</h1>

  <form action="{{route('books.update', $book->id)}}" method="POST">
  @csrf
  @method ('PUT')
  <div>
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" value="{{$book->title}}">
  </div>
  <div>
    <label for="author">Author:</label>
    <input type="text" name="author" id="author" value="{{$book->author}}">
  </div>
  <div>
    <label for="year">Year:</label>
    <input type="text" name="year" id="year" value="{{$book->year}}">
  </div>
  <div>
    <button type="submit">Update</button>
  </div>
  </form>
</body>
</html>