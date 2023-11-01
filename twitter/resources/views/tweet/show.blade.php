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
                        @elseif(session('message'))
                            <div class="alert alert-danger">
                                {{ session('message') }}
                            </div>
                        @endif
                        <p class="card-text">{{ $tweet->user->name }}</p>
                        <p class="card-text">{{ $tweet->tweet }}</p>
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
                        @if ($tweet->user_id == Auth::id())
                            <button onclick="location.href='{{ route('tweet.edit', $tweet) }}'">編集</button>
                            <form method="post" action="{{ route('tweet.delete', $tweet) }}">
                                @csrf
                                @method('delete')
                                <input type="submit" value="削除">
                            </form>
                        @endif
                        <button onclick="location.href='{{ route('tweet.index') }}'">戻る</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
