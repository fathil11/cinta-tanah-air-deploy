@if (Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <span class="alert-inner--icon"><i class="ni ni-bell-55"></i></span>
    <span class="alert-inner--text"> {{ Session::get('success') }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@elseif (Session::has('error'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <span class="alert-inner--icon"><i class="ni ni-bell-55"></i></span>
    <span class="alert-inner--text"> {{ Session::get('error') }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@elseif ($errors->any())
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <div>
        @foreach ($errors->all() as $error)
        <li style="none">
            <span class="alert-inner--icon"><i class="ni ni-bell-55"></i></span>
            <span class="alert-inner--text">{{ $error }}</span>
        </li>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif
