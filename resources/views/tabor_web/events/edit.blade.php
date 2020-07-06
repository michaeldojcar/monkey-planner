@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <div>
            @if($event->isMainEvent())
                <span style="text-transform: uppercase">Hlavní událost</span>
            @else

                <span style="text-transform: uppercase">{{$event->getTypeString()}} {{$event->getTypeEmoji()}}</span>
            @endif

            <h1 class="h2">{{$event->name}}</h1>
        </div>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                {{--<a class="btn btn-sm btn-primary" href="{{route('organize.program', $group)}}">--}}
                {{--<i class="fas fa-arrow-alt-circle-left"></i> Zobrazit v programu--}}
                {{--</a>--}}
            </div>
        </div>
    </div>

    <style>
        .card {
            margin-bottom: 20px;
            border-radius: 0;

            border:        1px black solid;
        }


        .card-header, .card-body {
            padding:       8px 12px;
            border-radius: 0;
        }


        .card-header:first-child {
            border-radius: 0;
        }


        .card-header {
            background-color: #434343;
            color:            #e9e9e9;
            font-weight:      bold;
        }


        .table td {
            border-top: black 1px solid;
        }
    </style>

    <form action="{{route('organize.event.edit.store', ['group' => $group, 'event' => $event])}}"
          method="POST">
        @csrf
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        @if($event->isMainEvent())
                            Úprava hl. události
                        @else
                            Úprava události
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name"
                                   class="col-4 col-form-label">Název</label>
                            <div class="col-8">
                                <input id="name"
                                       name="name"
                                       value="{{$event->name}}"
                                       type="text"
                                       class="form-control"
                                       required="required">
                            </div>
                        </div>
                        @if(! $event->isMainEvent())
                            <div class="form-group row">
                                <label for="select"
                                       class="col-4 col-form-label">Typ události</label>
                                <div class="col-8">
                                    <select id="type"
                                            name="type"
                                            class="custom-select"
                                            required="required">
                                        <option value="0" {{ $event->type == 0 ? 'selected' : ''}}>Událost
                                        </option>
                                        <option value="1" {{ $event->type == 1 ? 'selected' : ''}}>Hra</option>
                                        <option value="2" {{ $event->type == 2 ? 'selected' : ''}}>Program
                                        </option>
                                        <option value="3" {{ $event->type == 3 ? 'selected' : ''}}>Režim
                                        </option>
                                        <option value="4" {{ $event->type == 4 ? 'selected' : ''}}>Přednáška
                                        </option>
                                        <option value="5" {{ $event->type == 5 ? 'selected' : ''}}>Duchovní
                                            program
                                        </option>
                                        <option value="6" {{ $event->type == 6 ? 'selected' : ''}}>Scénka
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="select1"
                                       class="col-4 col-form-label">Den</label>
                                <div class="col-8">
                                    <select id="day"
                                            name="day"
                                            class="custom-select">
                                        @for($x = 0; $x <= $days_count; $x++)
                                            <option value="{{$x}}"
                                                    {{-- Selected option --}}
                                                    @if($event->getDayNumber() == $x)
                                                    selected
                                                    @endif
                                            >{{$x}}.
                                                den @switch($group->mainEvent->countDateFromThisEventsDayNumber($x)->dayOfWeek)
                                                    @case(0)
                                                    <span>(NE)</span>
                                                    @break
                                                    @case(1)
                                                    <span>(PO)</span>
                                                    @break
                                                    @case(2)
                                                    <span>(ÚT)</span>
                                                    @break
                                                    @case(3)
                                                    <span>(ST)</span>
                                                    @break
                                                    @case(4)
                                                    <span>(ČT)</span>
                                                    @break
                                                    @case(5)
                                                    <span>(PÁ)</span>
                                                    @break
                                                    @case(6)
                                                    <span>(SO)</span>
                                                    @break
                                                @endswitch
                                            </option>
                                        @endfor
                                        <option value="all" {{!$event->is_scheduled ? 'selected' : ''}}>Není
                                            umístěno
                                            pevně v programu
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="select2"
                                       class="col-4 col-form-label">Od</label>
                                <div class="col-8">
                                    <input id="time_from"
                                           name="time_from"
                                           value="{{$event->from->format('H:i')}}"
                                           type="text"
                                           class="form-control"
                                           required="required">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="select2"
                                       class="col-4 col-form-label">Do</label>
                                <div class="col-8">
                                    <input id="time_to"
                                           name="time_to"
                                           value="{{$event->to->format('H:i')}}"
                                           type="text"
                                           class="form-control"
                                           required="required">
                                </div>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for="select2"
                                   class="col-4 col-form-label">Místo</label>
                            <div class="col-8">
                                <input id="place"
                                       name="place"
                                       value="{{$event->place}}"
                                       type="text"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Popis události</div>
                    <div class="card-body">
                        <textarea name="content"
                                  style="height: calc(100vh - 170px); font-size: 16px"
                                  title="">
                            {!! $event->content !!}
                        </textarea>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Globální upozornění na nástěnce</div>
                    <div class="card-body">
                        <textarea name="notice"
                                  style="height: calc(100vh - 170px); font-size: 16px"
                                  title="">
                            {!! $event->notice !!}
                        </textarea>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Zodpovědné osoby</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Autoři</label>
                                <input name="author_users"
                                       id="authors_magic"
                                       class="form-control mb-3">
                                <label>Skupiny</label>
                                <input name="author_groups"
                                       id="author_groups_magic"
                                       class="form-control mb-3">
                            </div>

                            <div class="col-sm-6">
                                <label>Garant na táboře</label>
                                <input name="garant_users"
                                       id="garants_magic"
                                       class="form-control mb-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">Možnosti události</div>
                    <div class="card-body">
                        <button style="width: 100%"
                                name="submit"
                                type="submit"
                                class="btn btn-primary mb-3">Uložit
                            změny
                        </button>
                        <div class="row">
                            <div class="col-5">
                                <a class="btn btn-outline-secondary"
                                   href="{{route('organize.event', [$group, $event])}}"
                                   style="width: 100%;">Storno
                                </a>
                            </div>
                            <div class="col-7">
                                <a class="btn btn-outline-danger"
                                   href="{{ route('organize.event.delete', [$group, $event]) }}"
                                   onclick=" return confirm('Událost bude ODSTRANĚNA i s veškerým obsahem, jste si jisti?')"
                                   style="width: 100%;">Odstranit tuto událost</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')

    @include('tabor_web.tasks.cycleJs')

    {{-- Magic suggest --}}
    <script>
        $(function () {
            Object.getPrototypeOf($("#authors_magic")).size = function () {
                return this.length;
            };

            $("#authors_magic").magicSuggest({
                data: @json($author_users),
                valueField: "id",
                displayField: 'whole_name',
                allowFreeEntries: false,
                value: @json($author_users_selected),
                useCommaKey: false
            });
        });

        $(function () {
            Object.getPrototypeOf($("#author_groups_magic")).size = function () {
                return this.length;
            };

            $("#author_groups_magic").magicSuggest({
                data: @json($author_groups),
                valueField: "id",
                displayField: 'name',
                allowFreeEntries: false,
                value: @json($author_groups_selected),
                useCommaKey: false
            });
        });

        $(function () {
            Object.getPrototypeOf($("#garants_magic")).size = function () {
                return this.length;
            }

            $("#garants_magic").magicSuggest({
                data: @json($garant_users),
                valueField: "id",
                displayField: 'whole_name',
                allowFreeEntries: false,
                value: @json($garant_users_selected),
                useCommaKey: false
            });
        });
    </script>

    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=sswwl70ugzhu17dxhj5in4tsfajhm4dz98jfrl75jla6s5fa"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: "link lists",
            toolbar: " undo redo | formatselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | link | numlist bullist outdent indent | removeformat | help",
            // language: 'cs',
        });
    </script>


@endpush