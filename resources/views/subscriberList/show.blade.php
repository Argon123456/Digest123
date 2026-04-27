@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h4 >Список "{{$list->name}}"</h4>

                <a class="btn btn-primary" href="/subscriber/{{$list->id}}/create" role="button">Добавить в список</a>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ФИО</th>
                        <th scope="col">Компания</th>
                        <th scope="col">Должность</th>
                        <th scope="col">Email</th>
                        <th scope="col">Ред.</th>
                        <th scope="col">Удал.</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($list->subscribers as $key => $sub)
                            <tr>
                                <th scope="row">{{$key + 1}}</th>
                                <td>{{$sub->name}}</td>
                                <td>{{$sub->company}}</td>
                                <td>{{$sub->position}}</td>
                                <td>{{$sub->email}}</td>
                                <td><button type="button" class="btn btn-outline-primary">Редактирвать</button></td>
                                <td><button type="button" class="btn btn-outline-danger">Удалить</button></td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
