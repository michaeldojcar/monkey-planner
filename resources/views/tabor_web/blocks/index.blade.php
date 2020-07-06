@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ucfirst($group->mainEvent->name)}} -
            informace {{ $group->isTopLevel() ? 'pro celý tým' : 'pro PT' }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary"
                        data-toggle="modal" data-target="#exampleModal">Nový úkol
                </button>
                {{--<button class="btn btn-sm btn-outline-secondary">Export</button>--}}
            </div>
        </div>
    </div>


    <table class="table table-striped">
        @foreach($blocks as $block)
            <tr>
                <td>{{$block->name}}</td>
            </tr>
        @endforeach
    </table>

    {{-- New task --}}
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nový úkol</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route('organize.blocks', $group)}}">
                    @csrf
                    <div class="modal-body">

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection