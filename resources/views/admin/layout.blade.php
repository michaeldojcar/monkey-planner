@extends('layouts.fullscreen')

@section('title', 'Administrace - Monkey planner')

@push('css')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/dt-1.10.18/fh-3.1.4/r-2.2.2/datatables.min.css"/>
@endpush

@section('navbar_top')
    @include('admin.layout.navbar_top')
@endsection

@section('sidebar')
    @component('layouts.menu-item')
        Nástěnka
        @slot('href', route('admin.dashboard'))
        @slot('active_url', 'admin')
        @slot('icon', 'home')
    @endcomponent

    @component('layouts.menu-item')
        Uživatelé
        @slot('href', route('admin.users.index'))
        @slot('active_url', 'admin/users')
    @endcomponent

    @component('layouts.menu-item')
       Týmy
        @slot('href', route('admin.groups.index'))
        @slot('active_url', 'admin/groups')
    @endcomponent

{{--    @component('layouts.menu-item')--}}
{{--        Události--}}
{{--        @slot('active_url', 'admin/events')--}}
{{--    @endcomponent--}}
@endsection

{{-- Scripts --}}
@push('scripts')
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
