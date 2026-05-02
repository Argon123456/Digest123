@push('scripts')
    <!-- Scripts -->
    <script src="{{ asset('js/subscription.js')}}"></script>
@endpush

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <h4 >Список "{{$list->name}}"</h4>
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target=".bd-example-modal-lg">Добавить в список</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="gridContainer" style="max-height: 75vh;"></div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить в список</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="gridContacts" style="max-height: 75vh;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="addContacts">Добавить выбранные</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
@endsection
