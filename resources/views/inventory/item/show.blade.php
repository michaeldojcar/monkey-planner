@extends('inventory.layout.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <div>
            <h4>{{$item->name}}</h4>

            {{--            <p>--}}
            {{--                <a href="{{route('inventory.items.index', $group)}}">{{$group->name}}</a>--}}

            {{--                --}}{{--                @if($place->parent_item_place)--}}
            {{--                --}}{{--                    → <a href="{{route('inventory.item_places.show', ['group_id' => $place->group, $place->parent_place_id])}}">{{$place->parent_item_place->name}}</a>--}}
            {{--                --}}{{--                @endif--}}

            {{--                → {{$item->name}}--}}
            {{--            </p>--}}
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a class="btn btn-sm btn-outline-secondary"
                   href="{{route('inventory.items.edit', [$group, $item])}}">Upravit položku</a>

                {{--                <a class="btn btn-sm btn-outline-secondary"--}}
                {{--                   href="{{route('inventory.items.create', [$group, 'place_id'=>$place])}}">+ Nová položka</a>--}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            @if($item->description)
                <p>{{ $item->description }}</p>
            @endif

            <div class="d-flex justify-content-between mb-2">
                <h5>Umístění</h5>

                <a class="btn btn-sm btn-outline-secondary "
                   href="{{route('inventory.items.create', [$group, 'item_id'=>$item->id])}}">+ Přidat další kusy</a>
            </div>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Místo</th>
                    <th>Množství</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($item->item_states as $state)
                    <tr>
                        <td>
                            <a href="{{route('inventory.item_places.show', [$group, $state->item_place])}}">{{$state->item_place->name}}</a>
                        </td>
                        <td>{{$state->count}} {{$item->count_unit}}</td>
                        <td>
                            <form action="{{route('inventory.item-states.destroy', ['group_id'=> $group, 'item_state' => $state])}}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger">Odstranit
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            @if($item->photos->count())
                <a data-fancybox="gallery"
                   href="{{$item->photos->first()->url()}}">
                    <img src="{{$item->photos->first()->size(350, 350)}}"
                         width="100%">
                </a>

                <div class="row mt-2">
                    @php
                        $first_key = $item->photos->keys()->first();
                        $gallery = $item->photos->forget($first_key);;
                    @endphp

                    @foreach($gallery as $photo)
                        <div class="col-4">
                            <a data-fancybox="gallery"
                               href="{{$photo->url()}}">
                                <img src="{{$photo->size(100, 100)}}"
                                     width="100%">
                            </a>
                        </div>
                    @endforeach

                    <div class="col-4">
                        <form action="{{route('inventory.items.upload-photo', [$group])}}"
                              id="photo_upload_form"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            <input type="hidden"
                                   name="item_id"
                                   value="{{$item->id}}">

                            <div class="embed-responsive embed-responsive-1by1 border-dashed border-radius">
                                <label for="photo_upload_input"
                                       class="embed-responsive-item d-flex justify-content-center flex-column text-center">
                                    <p style="font-size: 40px; cursor: pointer; color: grey">+</p>
                                    <input class="d-none"
                                           type="file"
                                           name="photo"
                                           id="photo_upload_input">
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <form action="{{route('inventory.items.upload-photo', [$group])}}"
                      id="photo_upload_form"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <input type="hidden"
                           name="item_id"
                           value="{{$item->id}}">

                    <div class="embed-responsive embed-responsive-1by1 border-dashed border-radius">
                        <label for="photo_upload_input"
                               class="embed-responsive-item d-flex justify-content-center flex-column text-center">
                            <p>Přidejte první fotografii.</p>
                            <input class="d-none"
                                   type="file"
                                   name="photo"
                                   id="photo_upload_input">
                        </label>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#photo_upload_input').change(function () {
                $("#photo_upload_form").submit();
            })
        });
    </script>
@endpush
