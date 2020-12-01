
<form action="/{{$firstURISegment}}/{{$model->id}}/favorite" id="favorite-question-{{ $model->id }}" method="POST" style="display: none" >
    @csrf 
    @if ($model->is_favorited)
        @method('DELETE')
    @endif
</form>                         

