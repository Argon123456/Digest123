@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a class="btn btn-primary my-4" href="/digest/create" role="button">Создать новый дайджест</a>
            <div class="card">
                <div class="card-header">Дайджесты</div>
                <ul class="list-group list-group-flush">
                    @foreach($digests as $digest)
                        <li class="list-group-item"><a href="/digest/{{$digest->id}}">{{$digest->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <a class="btn btn-primary my-4" href="/contacts" role="button">Контакты</a>
            <a class="btn btn-primary my-4" href="{{ route('companies') }}" role="button">Компании</a>
            <a class="btn btn-primary my-4" href="{{ route('subscription.create') }}" role="button">Создать список</a>
            <a class="btn btn-primary my-4" href="{{ route('log') }}" role="button">Лог</a>
            <div class="card">
                <div class="card-header">Списки получателей</div>
                <ul class="list-group list-group-flush">
                    @foreach($subscriptions as $sub)
                        <a href="{{ route('subscription', $sub->id) }}" class="list-group-item">
                            {{$sub->name}} ({{$sub->short}})
                            @if($sub->id != 1)
                                <form action="{{ route('subscription.destroy', $sub) }}" method="POST"
                                      style="display: inline;"
                                      onsubmit="return confirm('Вы уверены, что хотите удалить этот список?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-dark btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
