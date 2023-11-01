@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">プロフィール</h5>
                        <p class="card-text">名前：{{ $user_detail->name }}</p>
                        <p class="card-text">メール：{{ $user_detail->email }}</p>
                        <div class="nav-scroller py-1 mb-2">
                            <nav class="nav d-flex justify-content-between">
                                <a href="{{ route('user.follows') }}">フォロー</a>
                                <a href="{{ route('user.followers') }}">フォロー</a>
                                <a href="{{ route('tweet.favorite') }}">いいね</a>
                            </nav>
                        </div>                        
                        <form method="get" action="{{ route('user.edit') }}">
                            <input type="submit" value="編集">
                        </form>
                        <form method="post" action="{{ route('user.delete') }}">
                            @csrf
                            @method('delete')
                            <input type="submit" value="削除">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
