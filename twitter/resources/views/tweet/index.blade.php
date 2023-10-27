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
                        <form method="get" action="{{ route('tweet.search') }}">
                            @csrf
                            @error('searchWord')
                                <div class="alert alert-danger">
                                    {{-- ここのメッセージが指定したメッセージにならない --}}
                                    <h5>{{ $message }}</h5>
                                </div>
                            @enderror
                            <div class="col-auto">
                                <input type="textarea" name="searchWord" class="form-control" placeholder="検索ワードを入力" value="{{ old('searchWord') }}" >
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
                            </ul>
                        @endforeach
                        {{ $tweets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection