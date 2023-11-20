@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- ツイート --}}
                <div class="tweet-container">
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
                            {{-- 編集、削除ボタン --}}
                            @if ($tweet->user_id === Auth::id())
                                <div class="d-flex justify-content-end">
                                    <button class="btn border-0" onclick="location.href='{{ route('tweet.edit', $tweet) }}'">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form method="post" action="{{ route('tweet.delete', $tweet) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn border-0" onclick="confirmDelete()">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                            <p class="card-text">{{ $tweet->user->name }}</p>
                            <p class="card-text">{{ $tweet->tweet }}</p>
                            <div class="icon-container">
                                <div class="d-flex justify-content-start">
                                    {{-- リプライアイコン --}}
                                    <div class="reply-container">
                                        <button onclick="location.href='{{ route('tweet.detail', $tweet) }}'" class="btn border-0">
                                            <i class="fa-solid fa-reply" style="color: #080410;"></i>
                                        </button>
                                        <span class="reply-count"> {{ $tweet->replies_count}}</span>
                                    </div>
                                    {{-- いいね機能 --}}
                                    @if($tweet->favorites_exists)
                                        <form method="post" action="{{ route('tweet.unfavorite', $tweet) }}">
                                            @csrf
                                            @method('delete')
                                            <div class="favorite-container">
                                                <button type="submit" class="btn border-0" ><i class="fa-solid fa-heart" style="color: #f0056b;"></i></button>
                                                <span class="like-count"> {{ $tweet->favorites_count }}</span>
                                            </div>
                                        </form>
                                    @else
                                        <form method="post" action="{{ route('tweet.favorite', $tweet) }}">
                                            @csrf
                                            <div class="favorite-container">
                                                <button type="submit" class="btn border-0"><i class="far fa-heart fa-fw"></i></button>
                                                <span class="like-count"> {{ $tweet->favorites_count }}</span>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- リプライ機能 --}}
                <form method="post" action="{{ route('reply.store',$tweet) }}">
                    @csrf
                    <textarea type="text" name="replyMessage" class="form-control" placeholder="なんて返す？"></textarea>
                    <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-outline-primary" >リプライ</button>
                    </div>
                </form>
                {{-- リプライ --}}
                <div class="reply-container">
                    @foreach ($replies as $reply)
                        <div class="card text-center mb-3">
                            {{-- 編集、削除ボタン --}}
                            @if ($reply->user_id === Auth::id())
                                <div class="d-flex justify-content-end">
                                    <button class="btn border-0" onclick="location.href='{{ route('reply.edit', $reply) }}'">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form method="post" action="{{ route('reply.delete', $reply) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn border-0" onclick="confirmDelete()">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                            <div class="card-body">
                                <p class="card-text">{{ $reply->user->name }}</p>
                                <p class="card-text">{{ $reply->reply }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
