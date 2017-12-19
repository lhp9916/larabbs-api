@extends('layouts.app')

@section('title',$user->name.'的个人中心')

@section('content')
    <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
            <div class="panel panel-default">
                <di class="panel-body">
                    <div class="media">
                        <div align="center">
                            <img src="https://avatars1.githubusercontent.com/u/10591282?s=460&v=4"
                                 class="img-responsive thumbnail" width="300px" height="300px">
                        </div>

                        <div class="media-body">
                            <hr>
                            <h4><strong>个人简介</strong></h4>
                            <p>这个人很懒，什么也没有留下。</p>
                            <hr>
                            <h4><strong>注册于</strong>ong</h4>
                            <p>2017-12-11</p>
                        </div>
                    </div>
                </di>
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                <span>
                    <h1 class="panel-title pull-left" style="font-size: 30px;">{{ $user->name }}
                        <small>{{ $user->email }}</small></h1>
                </span>
                </div>
            </div>
            <hr>

            {{--用户发布的内容--}}
            <div class="panel panel-default">
                <div class="panel-body">
                    暂无数据
                </div>
            </div>
        </div>
    </div>
@stop
