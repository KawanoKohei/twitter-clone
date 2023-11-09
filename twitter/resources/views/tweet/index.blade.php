@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @elseif(session('info'))
                            <div class="alert alert-info" role="alert">
                                {{ session('info') }}
                            </div>
                        @endif
                        <h5 class="card-title">ツイート一覧</h5>
                        <form method="get" action="{{ route('tweet.search') }}">
                            @error('searchWord')
                                <div class="alert alert-info">
                                    <p>{{ $message }}</p>
                                </div>
                            @enderror
                            <div class="col-auto">
                                <input type="text" name="searchWord" class="form-control" placeholder="検索ワードを入力" >
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-3">検索</button>
                            </div>
                        </form>
                        @foreach ($tweets as $tweet)
                            <ul class="list-group list-group-flush">
                                <a href="{{ route('tweet.detail', $tweet) }}" class="text-decoration-none">
                                    <li class="list-group-item">
                                        {{ $tweet->user->name }}<br><br>
                                        {{ $tweet->tweet }}
                                    </li>
                                </a>
                                @if($tweet->isFavorite)
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
                            </ul>
                        @endforeach
                        {{ $tweets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection