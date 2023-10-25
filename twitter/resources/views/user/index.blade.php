@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">登録ユーザー</h5>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @elseif (session('already'))
                            <div class="alert alert-warning">
                                {{ session('already') }}
                            </div>
                        @endif
                        @foreach ($users as $user)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="card-text">
                                        <p>{{ $user['name'] }}</p>
                                    </div>
                                    @if(Auth::id() !== $user->id)
                                        @if(Auth::user()->isFollowing(Auth::id(), $user->id))
                                            <form method="post" action="{{ route('user.unfollow', $user) }}">
                                                @csrf
                                                @method('delete')
                                                <input type="submit" value="フォロー解除">
                                            </form>
                                        @else
                                            <form method="post" action="{{ route('user.follow', $user) }}">
                                                @csrf
                                                <input type="submit" value="フォロー">
                                            </form>
                                        @endif
                                    @endif
                                </li>
                            </ul>
                        @endforeach
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection