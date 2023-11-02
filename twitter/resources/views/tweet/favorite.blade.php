@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">いいねツイート一覧</h5>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @foreach ($tweets as $tweet)
                            <ul class="list-group list-group-flush">
                                <a href="{{ route('tweet.detail', $tweet) }}" class="text-decoration-none">
                                    <li class="list-group-item">
                                        {{ $tweet->user->name }}<br><br>
                                        {{ $tweet->tweet }}
                                    </li>
                                </a>
                                @if($favorite->isFavorite(Auth::id(), $tweet->id))
                                    <form method="post" action="{{ route('user.unfavorite', $tweet->id) }}">
                                        @csrf
                                        @method('delete')
                                        <div class="favorite-container">
                                            <button type="submit" class="btn p-0 border-0" ><i class="fa-solid fa-heart" style="color: #f0056b;"></i></button>
                                            <span class="like-count"> {{ $tweet->favoriteUsers()->count()}}</span>
                                        </div>
                                    </form>
                                @else
                                    <form method="post" action="{{ route('user.favorite', $tweet->id) }}">
                                        @csrf
                                        <div class="favorite-container">
                                            <button type="submit" class="btn p-0 border-0"><i class="far fa-heart fa-fw"></i></button>
                                            <span class="like-count"> {{ $tweet->favoriteUsers()->count()}}</span>
                                        </div>
                                    </form>
                                @endif
                            </ul>
                        @endforeach
                        {{ $tweets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection