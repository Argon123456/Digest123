@push('scripts')
    <!-- Scripts -->
    <script src="{{ asset('js/companies.js')}}"></script>
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h4>Список компаний</h4>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div id="gridCompanies" style="max-height: 85vh;"></div>
            </div>
        </div>
    </div>

@endsection
