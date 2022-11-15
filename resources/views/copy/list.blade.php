<h1>A példányok száma: {{$copies->count()}}</h1>
<h2>A kikölcsönözhető példányok száma: {{$copies->where('status', '0')->count()}}</h2>
<h2>A selejtezendő példányok száma: {{$copies->where('status', '2')->count()}}</h2>
@foreach ($copies as $copy)
    @if ($copy->status !=2)
        <form action="/api/copies/{{$copy->copy_id}}" method="post">
            @csrf
            {{method_field('GET')}}
            <div>
                <input type="submit" value="{{$copy->copy_id}}">
            </div>
        </form>
    @endif
@endforeach 
