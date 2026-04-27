@push('scripts')
    <!-- Scripts -->
    <script src="{{ asset('js/logContacts.js?ver='.config('app.version')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/3.3.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <h4>Статистика по контактам</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="option">
                    <div id="autoExpand" class="mb-2"></div>
                </div>
                <div id="gridContainer" style="max-height: 75vh;"></div>
            </div>
        </div>
    </div>

@endsection
