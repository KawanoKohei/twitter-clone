@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">フォロー</h5>
                        @foreach ($users as $user)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="card-text">
                                        <p>{{ $user->name }}</p>
                                    </div>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection