@if (session('success'))
    <div class="alert alert-success alet-dismissible fade show" role="alert">
        <strong>Uspesno!</strong> {{session('success')}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif