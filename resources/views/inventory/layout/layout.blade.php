@extends('layouts.fullscreen')


@section('title', 'Monkey planner')


@push('css')
    <link rel="stylesheet"
          type="text/css"
          href="https://cdn.datatables.net/v/bs4/dt-1.10.18/fh-3.1.4/r-2.2.2/datatables.min.css"/>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/magicsuggest/2.1.4/magicsuggest-min.css"/>
@endpush

@section('navbar_top')
    @include('inventory.layout.navbar_top')
@endsection

@section('sidebar')
    @include('inventory.layout.sidebar')
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magicsuggest/2.1.4/magicsuggest-min.js"></script>

    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4/dt-1.10.18/fh-3.1.4/r-2.2.2/datatables.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#data-table").DataTable();
        });

        $("#data-table").DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Czech.json'
            }
        });
    </script>
@endpush
