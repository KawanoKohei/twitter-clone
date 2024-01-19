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
                            @error('replyMessage')
                                <h5>{{ $message }}</h5>
                            @enderror
                            <div class="card-text">
                                <textarea name="replyMessage" cols="70" rows="5" value="{{ old('reply') ?? $reply->text }}"></textarea>
                            </div>
                            <button>保存</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection