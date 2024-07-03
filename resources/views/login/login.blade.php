@extends('layouts.layout')

@php
$title = '簡易日記';
@endphp

@section('content')
<div class="container">
    <h1 class="text-center mt-2 mb-5">簡易日記「ログイン」</h1>
    {{ Form::open(['url' => 'execlogin', 'method' => 'POST']) }}
    <div class="container">
        <div class="form-group row">
            <p class="col-sm-4 col-form-label">メールアドレス<span class="badge badge-danger ml-1">必須</span></p>
            <div class="col-sm-8">
                {{ Form::text('mail_address', '', ['id' => 'mail_address', 'class' => 'form-control'])}}
                @error('mail_address')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <p class="col-sm-4 col-form-label">パスワード</p>
            <div class="col-sm-8">
                {{ Form::text('password', '', ['id' => 'password', 'class' => 'form-control'])}}
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <input type="submit" class="btn btn-primary form-btn" value="ログイン">
        </div>
    </div>
    {!! Form::close() !!}
    {{ Form::open(['url' => 'account', 'method' => 'POST']) }}
    <div class="container">
        <div class="text-center">
            <input type="submit" class="btn btn-primary form-btn" value="アカウント作成">
        </div>
    </div>
    {!! Form::close() !!}


@endsection
