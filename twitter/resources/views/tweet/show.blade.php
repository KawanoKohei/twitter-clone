@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center mb-3">
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
                        @if ($tweet->user_id == Auth::id())
                            <div class="d-flex justify-content-end">
                                <div class="dropdown">
                                    <i class="fa-solid fa-bars dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <button class="dropdown-item" onclick="location.href='{{ route('tweet.edit', $tweet) }}'">編集</button>
                                        <form method="post" action="{{ route('tweet.delete', $tweet) }}">
                                            @csrf
                                            @method('delete')
                                            <input class="dropdown-item" type="submit" value="削除">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <p class="card-text">{{ $tweet->user->name }}</p>
                        <p class="card-text">{{ $tweet->tweet }}</p>
                        {{-- リプライアイコン --}}
                        <div class="reply-container">
                            <button onclick="location.href='{{ route('tweet.detail', $tweet) }}'" class="btn p-0 border-0">
                                <i class="fa-solid fa-reply" style="color: #080410;"></i>
                            </button>
                            <span class="reply-count"> {{ $tweet->replies_count}}</span>
                        </div>
                        {{-- いいね機能 --}}
                        @if($tweet->favorites_exists)
                            <form method="post" action="{{ route('user.unfavorite', $tweet) }}">
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
                        {{-- リプライ機能 --}}
                        <form method="post" action="{{ route('reply.store',$tweet) }}">
                            @csrf
                            <textarea type="text" name="replyMessage" class="form-control" placeholder="なんて返す？"></textarea><br>
                            <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-primary">リプライ</button>
                            </div>
                        </form>
                    </div>
                </div>
                @foreach ($replies as $reply)
                    <div class="card text-center mb-3">
                        <div class="card-body">
                            <p class="card-text">{{ $reply->user->name }}</p>
                            <p class="card-text">{{ $reply->reply }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
