@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h4 >Создать новый список рассылки</h4>
                <form action="/subscriptions" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Полное название списка</label>
                        <input type="text" name="name" placeholder="Название" id="name" class="form-control" value="">
                        <div class="text-danger">{{$errors->first('name')}}</div>
                    </div>

                    <div class="form-group">
                        <label for="short">Кратное название</label>
                        <input type="text" name="short" placeholder="Прим. ТР" id="short" class="form-control" value="">
                        <div class="text-danger">{{$errors->first('short')}}</div>
                    </div>

                    <button type="submit" class="btn btn-success">Отправить</button>
                </form>

            </div>
        </div>
    </div>
@endsection
