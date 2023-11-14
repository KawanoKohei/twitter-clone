@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-body">
                        @if(session('message'))
                                <div class="alert alert-danger">
                                    {{ session('message') }}
                                </div>
                        @endif
                        <form method="post" action="{{ route('reply.update',$reply)}} ">
                            @csrf
                            @method('put')
                            @error('reply')
                                <h5>{{ $message }}</h5>
                            @enderror
                            <div class="card-text">
                                <textarea name="reply" cols="70" rows="5" value="{{ old('reply') ?? $reply->reply }}"></textarea>
                            </div>
                            <input type="submit" value="保存">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection