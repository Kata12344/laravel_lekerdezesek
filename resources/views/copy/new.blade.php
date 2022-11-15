<form action="/api/copies" method="post">
    @csrf
    
    <select name="book_id">
        @foreach ($books as $book)
                <option value="{{$book->book_id}}">{{$book->author}}: {{$book->title}}</option>
        @endforeach
    </select>
    <select name="hardcovered">
        <option value=0>Puha kötésű</option>
        <option value=1>Kemény kötésű</option>
    </select>
    <label for="publication">Publikáció éve</label>
    <input type="number" min="1300" max="2099" step="1" value="2000" name="publication" id="publication">
    <input type="submit" value="Ok">
</form>