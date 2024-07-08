@foreach($types as $type)
<li><a href="{{ route('getbytype',['id'=>$type->id]) }}">{{ $type->name }}</a></li>
@endforeach