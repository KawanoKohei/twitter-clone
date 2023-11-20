@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-body">
                        <h1>Error 404</h1>
                        <p>探しているページはないぞ！！</p>
                        <button onclick="location.href='{{ route('tweet.index') }}'">戻る</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection