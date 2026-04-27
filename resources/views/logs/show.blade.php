@push('scripts')
    <!-- Scripts -->
    <script src="{{ asset('js/log.js?ver='.config('app.version')) }}"></script>
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <h4>Последние 500 писем</h4>
                <div class="col-md-6">
                    <a class="btn btn-primary my-4" href="{{ route('logDigest') }}" role="button">Статистика по виду дайджеста</a>
                    <a class="btn btn-primary my-4" href="{{ route('logContact') }}" role="button">Статистика по контактам</a>
                </div>
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
                    <h5 class="modal-title">Письмо</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="mailBody" style="overflow-y: hidden;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
