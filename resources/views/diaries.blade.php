@extends('layouts.layout')

@php
$title = '簡易日記';
@endphp

@section('content')
<div class="container">
    <h1 class="text-center mt-2 mb-5">簡易日記</h1>
    {{ Form::open(['url' => '/logout', 'method' => 'POST']) }}
        @csrf
        <button>ログアウト</button>
    {!! Form::close() !!}
    {{ Form::open(['url' => '/create', 'method' => 'POST', 'files' => true]) }}
    <div class="container">
        <div class="form-group row">
            <p class="col-sm-4 col-form-label">日記タイトル<span class="badge badge-danger ml-1">必須</span></p>
            <div class="col-sm-8">
                {{ Form::text('title', '', ['id' => 'title', 'class' => 'form-control'])}}
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <p class="col-sm-4 col-form-label">日記内容<span class="badge badge-danger ml-1">必須</span></p>
            <div class="col-sm-8">
                {{ Form::text('contents', '', ['id' => 'contents', 'class' => 'form-control'])}}
                @error('contents')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <p class="col-sm-4 col-form-label">天気</p>
            <div class="col-sm-8">
                <select class="form-control" name="weather_id">
                    @foreach($ViewData["weathers_list"] as $Weather1)
                        <option value="{{$Weather1->id}}">{{$Weather1->weather_name}}</option>
                    @endforeach
                </select>
                @error('weather_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <p class="col-sm-4 col-form-label">画像</p>
            <div class="col-sm-8">
                {{ Form::file('images') }}
                <br>※ 画像ファイルは、jpgまたはpngのみ対応しております。
                @error('images')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
        </div>
        </div>

        <div class="text-center">
            <input type="submit" class="btn btn-primary form-btn" value="新規投稿">
        </div>
    </div>
    {!! Form::close() !!}

        <!-- Modal -->
        <div class="modal fade" id="editModalCenter" tabindex="-1" role="dialog" aria-labelledby="editModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalCenterTitle">編集</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(['url' => '/edit', 'id' => 'modal-edit', 'method' => 'POST', 'files' => true]) }}
                            <div class="form-group row">
                                <p class="col-sm-4 col-form-label">日記タイトル</p>
                                <div class="col-sm-8">
                                    {{ Form::text('title', '', ['id' => 'edit_title', 'size' => 30, 'maxlength' => 200])}}
                                    <div id="error_edit_title" class="alert alert-danger" style="display:none;"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <p class="col-sm-4 col-form-label">日記内容</p>
                                <div class="col-sm-8">
                                    {{ Form::text('contents', '', ['id' => 'edit_contents', 'size' => 30, 'maxlength' => 200])}}
                                    <div id="error_edit_contents" class="alert alert-danger" style="display:none;"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <p class="col-sm-4 col-form-label">天気</p>
                                <div class="col-sm-8">
                                    <select class="form-control" name="weather_id" id="edit_weather_id">
                                        @foreach($ViewData["weathers_list"] as $Weather2)
                                            <option value="{{$Weather2->id}}">{{$Weather2->weather_name}}</option>
                                        @endforeach
                                    </select>
                                    <div id="error_edit_weather_id" class="alert alert-danger" style="display:none;"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <p class="col-sm-4 col-form-label">画像</p>
                                <div class="col-sm-8">
                                    {{ Form::file('images') }}
                                    <br>※ 画像ファイルは、jpgまたはpngのみ対応しております。
                                    <div id="error_edit_images" class="alert alert-danger" style="display:none;"></div>
                                </div>
                            </div>

                            {{ Form::hidden('edit_id', '', ['id' => 'edit_diaries_id']) }}

                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                                {{ Form::submit('編集する', ['name' => 'submit', 'id' => 'editBtn', 'class' => 'btn btn-primary']) }}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="delModalCenter" tabindex="-1" role="dialog" aria-labelledby="delModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="delModalCenterTitle">削除</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(['url' => '/delete', 'id' => 'modal-delete', 'method' => 'POST']) }}
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <p class="col-sm-4 col-form-label">日記タイトル</p>
                                <div class="col-sm-8">
                                    <p class="modal-diaries-title"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <p class="col-sm-4 col-form-label">日記内容</p>
                                <div class="col-sm-8">
                                    <p class="modal-diaries-contents"></p>
                                </div>
                            </div>

                            {{ Form::hidden('delete_id', '', ['id' => 'delete_diaries_id']) }}

                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                                {{ Form::submit('削除する', ['name' => 'submit', 'class' => 'btn btn-primary']) }}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-left">
        暗号化前テキスト：{{ $ViewData["defaultText"] }}<br />
        暗号化テキスト：{{ $ViewData["encryptText"] }}<br />
        復号化テキスト：{{ $ViewData["decryptText"] }}<br />
        暗号化前テキストCrypt：{{ $ViewData["defaultText2"] }}<br />
        暗号化テキストCrypt：{{ $ViewData["encryptText2"] }}<br />
        復号化テキストCrypt：{{ $ViewData["decryptText2"] }}<br />
    </div>


    <br>
    {{$ViewData["diaries_list"]->links('pagination.layout')}}
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr><th>投稿番号</th><th>ニックネーム</th><th>投稿タイトル</th><th>画像</th><th>投稿内容</th><th>天気</th><th>投稿日<br>更新日</th><th colspan="2"></th></tr>
        </thead>
        <tbody>
        @foreach($ViewData["diaries_list"] as $ViewData)
            <tr>
                <td>{{$ViewData->id}}</td>
                <td>{{$ViewData->nickname}}</td>
                <td>{{$ViewData->title}}</td>
                <td>
                    @if(!empty($ViewData->file_name))
                        <img src="{{ asset('storage/diary_images/' . $ViewData->id . '/' . $ViewData->file_name) }}" alt="{{$ViewData->file_name}}" width="200px">
                    @endif
                </td>
                <td>{{$ViewData->contents}}</td>
                <td>{{$ViewData->weather_name}}</td>
                <td>{{$ViewData->created_at}}<br>{{$ViewData->updated_at}}</td>
                <td>
                    <button type="button" class="btn btn-primary form-btn"
                        data-id="{{$ViewData->id}}" data-title="{{$ViewData->title}}" data-contents="{{$ViewData->contents}}" data-weather_id="{{$ViewData->weather_id}}"
                        data-toggle="modal" data-target="#editModalCenter">
                        編集
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger form-btn"
                        data-id="{{$ViewData->id}}" data-title="{{$ViewData->title}}" data-contents="{{$ViewData->contents}}" data-weather_id="{{$ViewData->weather_id}}"
                        data-toggle="modal" data-target="#delModalCenter">
                        削除
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
