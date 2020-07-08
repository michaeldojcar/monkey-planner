@extends('tabor_web.layout')

@section('content')
    <form method="POST"
          action="{{route('organize.tasks.update', [$main_event, $task])}}">
        @csrf

        <div class="flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            @if($task->type == 0)
                <span style="text-transform: uppercase; display:block">Úkol</span>
            @elseif($task->type == 1)
                <span style="text-transform: uppercase; display:block">Role v programu</span>
            @else
                <span style="text-transform: uppercase; display:block">Potřebná rekvizita</span>
            @endif
            <input name="name"
                   class="h1-input"
                   value="{{$task->name}}"
                   placeholder="název úkolu?"
                   autofocus>
        </div>

        @if($task->type == 0)
            <h5>Poznámky k úkolu</h5>
        @elseif($task->type == 1)
            <h5>Stručný popis role</h5>
        @elseif($task->type == 2)
            <h5>Info k dané věci</h5>
        @endif

        <div class="row mb-3">
            <div class="col-md-9 mb-3">
                <textarea name="content"
                          style="height: calc(100vh - 170px); font-size: 16px">
                    {!! $task->content !!}
                </textarea>
            </div>


            <div class="col-md-3">
                <div class="card card-block">
                    <div class="card-header">Možnosti úkolu</div>
                    <div class="card-body">
                        @if($task->type == 1)
                            <span>Požadovaný počet lidí:</span>
                        @elseif($task->type == 2)
                            <span>Požadovaný počet kusů:</span>
                        @endif

                        @if($task->type != 0)
                            <input name="required_count"
                                   class="form-control mb-3"
                                   type="number"
                                   min="1"
                                   max="5000"
                                   value="{{$task->required_count}}">
                        @endif

                        <span>Patří k programu:</span>

                        <input name="events"
                               id="events_magicsuggest"
                               class="form-control mb-5">

                        <div class="form-group">
                            <label>Typ úkolu</label>
                            <select class="form-control mb-3"
                                    name="type">
                                <option value="0" {{$task->type == 0 ? 'selected' : 0}}>Úkol</option>
                                <option value="1" {{$task->type == 1 ? 'selected' : 0}}>Role v programu</option>
                                <option value="2" {{$task->type == 2 ? 'selected' : 0}}>Požadavek na věc
                                </option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <input style="width: 100%; margin-top: 5px;"
                                       type="submit"
                                       class="btn btn-primary mb-3"
                                       value="Uložit úkol">
                            </div>

                            <div class="col-5">
                                <a class="btn btn-outline-secondary"
                                   href=""
                                   style="width: 100%;">Storno
                                </a>
                            </div>
                            <div class="col-7">
                                <a class="btn btn-outline-danger"
                                   href="{{ route('organize.tasks.delete', [$task]) }}"
                                   onclick=" return confirm('Úkol bude ODSTRANĚN i s obsahem, jste si jisti?')"
                                   style="width: 100%;">Odstranit úkol</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-block">
                    <div class="card-header card-header-green">Garanti úkolu</div>
                    <div class="card-body">
                        <span><b>Skupina</b>, pod kterou úkol spadá:</span>

                        <input name="groups"
                               id="groups_magicsuggest"
                               style="margin-bottom: 20px"
                               class="form-control mb-5">

                        <span>Konkrétní <b>člověk</b>, kt. to má na starost:</span>

                        <input name="users"
                               id="users_magicsuggest"
                               class="form-control mb-5">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')

    @include('tabor_web.tasks.cycleJs')

    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=sswwl70ugzhu17dxhj5in4tsfajhm4dz98jfrl75jla6s5fa"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: "link",
            toolbar: "forecolor backcolor link"
        });
    </script>

    {{-- Magic suggest --}}
    <script>
        $(function () {
            Object.getPrototypeOf($("#events_magicsuggest")).size = function () {
                return this.length;
            }

            $("#events_magicsuggest").magicSuggest({
                data: @json($events),
                valueField: "id",
                displayField: 'name',
                allowFreeEntries: false,
                value: @json($events_selected),
                useCommaKey: false
            });
        });

        $(function () {
            Object.getPrototypeOf($("#users_magicsuggest")).size = function () {
                return this.length;
            }

            $("#users_magicsuggest").magicSuggest({
                data: @json($users),
                valueField: "id",
                displayField: 'whole_name',
                allowFreeEntries: false,
                value: @json($users_selected),
                useCommaKey: false
            });
        });

        $(function () {
            Object.getPrototypeOf($("#groups_magicsuggest")).size = function () {
                return this.length;
            }

            $("#groups_magicsuggest").magicSuggest({
                data: @json($groups),
                valueField: "id",
                displayField: 'name',
                allowFreeEntries: false,
                value: @json($groups_selected),
                useCommaKey: false
            });
        });
    </script>

@endpush
