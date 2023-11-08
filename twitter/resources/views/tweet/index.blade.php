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
                                <!-- Button trigger modal -->
                                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#aaa" style="background: transparent; border: none; margin-left: 8px">
                                    <i class="fa-solid fa-reply" style="color: #080410;"></i>
                                </button>
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
                                
                                <!-- Modal -->
                                <form method="post" action="{{ route('reply.store',$tweet) }}">
                                    @csrf
                                    <div class="modal fade" id="aaa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="card w-100">
                                                        <div class="card" >
                                                            <div class="card-body">
                                                                <div class="modal-body">
                                                                    <textarea type="text" name="replyMessage" class="form-control" placeholder="なんて返す？"></textarea>
                                                                </div>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">リプライ</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </ul>
                        @endforeach
                        {{ $tweets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection