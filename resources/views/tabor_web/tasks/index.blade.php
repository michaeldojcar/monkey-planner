@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3>{{ucfirst($main_event->name)}} -
            {{ $group->isTopLevel() ? 'všechny úkoly' : 'úkoly týmu ' . $group->name}}</h3>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button class="btn btn-sm btn-success"
                        data-toggle="modal"
                        data-target="#exampleModal"><i class="fa fa-plus"></i> Nový úkol
                </button>
            </div>
        </div>
    </div>

    <style>
        .table-header {
            background-color: #525252;
            color: white;
            font-weight: bold;
        }
    </style>

    <div class="table-responsive">
        <table class="table table-bordered"
               id="data-table">
            <thead>
            <tr class="table-header">
                <th>Zodpovědnost</th>
                <th>Přípr. team</th>
                <th>Garant</th>
                <th>Patří k</th>
                <th>Vytvořeno</th>
                <th>Upraveno</th>
            </tr>
            </thead>

            <tbody>
            @foreach($main_event->tasks as $task)

                <tr>
                    <td><a style="color: black"
                           href="{{route('organize.tasks.show', ['event' => $main_event, 'task' => $task] )}}">{{$task->name}}</a>
                    </td>
                    <td>
                        @include('tabor_web.components.task.garant_groups')
                    </td>
                    <td>
                        @include('tabor_web.components.task.garant_users')
                    </td>
                    <td>
                        @forelse($task->events->where('id','!=',$main_event->id) as $task_event)
                            <span style="color: #00a6b0; text-transform: uppercase; font-weight: bold">
                                <a href="{{route('organize.events.show',[$main_event, $task_event])}}">{{$task_event->getTypeEmoji()}} {{$task_event->name}}</a>
                            </span>
                            <br>
                        @empty
                            -
                        @endforelse
                    </td>
                    <td>{{$task->created_at}}</td>
                    <td>{{$task->updated_at}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- New task --}}
    <!-- Modal -->
    <div class="modal fade"
         id="exampleModal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog"
             role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="exampleModalLabel">Nový úkol</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST"
                      action="{{route('organize.tasks.store', $main_event)}}">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="name"
                                   class="col-4 col-form-label">Název úkolu</label>
                            <div class="col-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-check-square"></i>
                                        </div>
                                    </div>
                                    <input id="name"
                                           name="name"
                                           type="text"
                                           class="form-control"
                                           aria-describedby="nameHelpBlock"
                                           required="required">
                                </div>
                                <span id="nameHelpBlock"
                                      class="form-text text-muted">Název úkolu by měl být co nejvýstižnější.</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="content"
                                   class="col-4 col-form-label">Popis</label>
                            <div class="col-8">
                                <textarea id="content"
                                          name="content"
                                          cols="40"
                                          rows="5"
                                          aria-describedby="contentHelpBlock"
                                          class="form-control"></textarea>
                                <span id="contentHelpBlock"
                                      class="form-text text-muted">Nepovinné, pokud není potřeba, můžete ponechat prázdné.</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="select"
                                   class="col-4 col-form-label">Zodpovědné PT</label>
                            <div class="col-8">
                                <select id="group_id"
                                        name="group_id"
                                        class="custom-select">
                                    <option value="0">Zatím nechat nepřiřazené</option>
                                    <option value="{{$group->id}}">Celý táborový tým</option>
                                    @foreach($group->childGroups as $subgroup)
                                        <option value="{{$subgroup->id}}">{{$subgroup->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal">Zrušit
                        </button>
                        <button name="submit"
                                type="submit"
                                class="btn btn-primary">Přidat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @include('tabor_web.tasks.cycleJs')

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
