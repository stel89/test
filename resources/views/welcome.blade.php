@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Добро пожаловать</div>

                <div class="panel-body">
                    Чтобы посмотреть курс валют пожалуйста зарегистрируйтесь. <p>
					@if(Session::has('message'))
{!!Session::get('message')!!}
@endif

					
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
