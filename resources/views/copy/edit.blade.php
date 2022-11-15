<form action="/api/copies/{{$copy->copy_id}}" method="post">
    @csrf
    {{method_field('PATCH')}}
    <!-- a name fontos, hogy a mező neve legyen! -->
    <p>Book_id: {{$copy->book_id}}</p>
    <!-- ha a könyvtárban van -->
    <select name="hardcovered">
        <option value=0>Puha kötésű</option>
        <option value=1>Kemény kötésű</option>
    </select>
    <label for="publication">Publikáció éve</label>
    <input type="number" min="1300" max="2099" step="1" value="2000" name="publication" id="publication">
    <select name="status">
        <option value=0>Könyvtárban van</option>
        <option value=1>Selejtezésre ítélve</option>
    </select>
    <input type="submit" value="Ok">
</form>
