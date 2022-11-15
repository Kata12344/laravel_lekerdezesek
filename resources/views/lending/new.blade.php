<form action="/api/lendings" method="post">
    @csrf
    
    <select name="user_id">
        @foreach ($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
        @endforeach
    </select>
    <select name="copy_id">
        @foreach ($copies as $copy)
                <option value="{{$copy->copy_id}}">{{$copy->copy_id}}</option>
        @endforeach
    </select>
    <label for="begin">Kölcsönzés kezdete:</label>
    <input type="date" name="start" id="begin">
    <input type="submit" value="Ok">
</form>