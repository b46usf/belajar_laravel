@extends('template.mainDashboard')
@section('content')
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
            Dashboard    
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
                <a class="nav-link active" aria-current="page" href="#" data-action="/home">Home</a>
                @foreach($pages as $menu)
                    <a class="nav-link" href="#" data-action="{{$menu->url}}index">{{$menu->name}}</a>
                @endforeach
                <a class="nav-link text-danger" href="#" data-action="/logout">Logout</a>
            </div>
        </div>
    </div>
</nav>
@yield('container')
@endsection