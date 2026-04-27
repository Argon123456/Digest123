@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Списки получателей</div>
                    <ul class="list-group list-group-flush">
                        @foreach($subscriberList as $list)
                            <li class="list-group-item"><a href="/subscriberlist/{{$list->id}}">{{$list->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
