@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h4 >Добавление пользователя в список "{{$list->name}}"</h4>
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="/subscriber/submit" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$list->id}}">
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" name="name" placeholder="Имя" id="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="company">Компания</label>
                        <input type="text" name="company" placeholder="Компания" id="company" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="position">Должность</label>
                        <input type="text" name="position" placeholder="Должность" id="position" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="text" name="email" placeholder="email" id="email" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-success">Отправить</button>
                </form>

            </div>
        </div>
    </div>
@endsection
