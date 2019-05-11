@auth
<form action="{{ url('images/'.$image->id) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}

    <button type="submit" class="btn btn-danger my-3">
        Supprimer
    </button>
</form>
@endauth