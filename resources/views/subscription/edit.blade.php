@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h4 >Обновить список рассылки</h4>
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="/subscriptions/{{$subscription->id}}/update" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Полное название списка</label>
                        <input type="text" name="name" placeholder="Название" id="name" class="form-control" value="{{$subscription->name}}">
                    </div>

                    <div class="form-group">
                        <label for="short">Кратное название</label>
                        <input type="text" name="short" placeholder="Прим. ТР" id="short" class="form-control" value="{{$subscription->short}}">
                    </div>

                    <button type="submit" class="btn btn-success">Отправить</button>
                </form>

            </div>
        </div>
    </div>
@endsection
