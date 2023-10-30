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
                        @endif
                        <h5 class="card-title">ツイート一覧</h5>
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
                                        <input type="submit" value="いいね解除">
                                    </form>
                                @else
                                    <form method="post" action="{{ route('user.favorite', $tweet->id) }}">
                                        @csrf
                                        <input type="submit" value="いいね">
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