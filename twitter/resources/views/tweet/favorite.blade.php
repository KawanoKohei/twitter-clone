@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center mb-3">
                    <div class="card-body">
                        <h5 class="card-title">いいねツイート一覧</h5>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <ul class="list-group list-group-flush">
                            @foreach ($tweets as $tweet)
                                <a href="{{ route('tweet.detail', $tweet) }}" class="text-decoration-none">
                                    <li class="list-group-item">
                                        {{ $tweet->user->name }}<br><br>
                                        {{ $tweet->tweet }}
                                    </li>
                                </a>
                                @if($tweet->favorites_exists)
                                    <form method="post" action="{{ route('tweet.unfavorite', $tweet) }}">
                                        @csrf
                                        @method('delete')
                                        <div class="favorite-container">
                                            <button type="submit" class="btn p-0 border-0" ><i class="fa-solid fa-heart" style="color: #f0056b;"></i></button>
                                            <span class="like-count"> {{ $tweet->favorites_count }}</span>
                                        </div>
                                    </form>
                                @else
                                    <form method="post" action="{{ route('tweet.favorite', $tweet) }}">
                                        @csrf
                                        <div class="favorite-container">
                                            <button type="submit" class="btn p-0 border-0"><i class="far fa-heart fa-fw"></i></button>
                                            <span class="like-count"> {{ $tweet->favorites_count }}</span>
                                        </div>
                                    </form>
                                @endif
                            @endforeach
                        </ul>
                        {{ $tweets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection