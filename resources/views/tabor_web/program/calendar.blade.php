@extends('tabor_web.layout')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h3>{{$main_event->name}} - kalendář</h3>
            <div class="btn-toolbar mb-2 mb-md-0">

                <div class="btn-group mr-2 mt-2 mt-md-0">
                    <button class="btn btn-sm btn-success"
                            data-toggle="modal"
                            data-target="#exampleModal">
                        <i class="fas fa-plus"></i> Nový blok programu
                    </button>
                </div>
            </div>
        </div>

        <calendar :eventId="{{$main_event}}"></calendar>
    </div>

    {{-- Modal --}}
    @include('tabor_web.program.components.add_new_event_modal')
@endsection
