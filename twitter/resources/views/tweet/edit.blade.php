@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-body">
                        <form method="post" action="{{ route('tweet.update',$tweet)}} ">
                            @csrf
                            @method('put')
                            @error('tweet')
                                <h5>{{ $message }}</h5>
                            @enderror
                            <div class="card-text">
                                <textarea name="tweet" cols="70" rows="5" value="{{ old('tweet') ?? $tweet->tweet }}"></textarea>
                            </div>
                            <input type="submit" value="保存">
                        </form>
                        <button onclick="location.href='{{ route('tweet.index') }}'">キャンセル</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection