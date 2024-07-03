@extends('layouts.layout')

@php
$title = '簡易日記';
@endphp

@section('content')
<div class="container">
    <h1 class="text-center mt-2 mb-5">簡易日記「アカウント作成」</h1>
    {{ Form::open(['url' => 'regist', 'method' => 'POST']) }}
    <div class="container">
        <div class="form-group row">
            <p class="col-sm-4 col-form-label">ニックネーム<span class="badge badge-danger ml-1">必須</span></p>
            <div class="col-sm-8">
                {{ Form::text('nickname', '', ['id' => 'nickname', 'class' => 'form-control'])}}
                @error('nickname')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

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
            <p class="col-sm-4 col-form-label">パスワード<span class="badge badge-danger ml-1">必須</span></p>
            <div class="col-sm-8">
                {{ Form::text('password', '', ['id' => 'password', 'class' => 'form-control'])}}
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <input type="submit" class="btn btn-primary form-btn" value="新規登録">
        </div>
    </div>
    {!! Form::close() !!}

@endsection
