@extends('inventory.layout.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <div>
            <h4>Nový záznam ve skladu</h4>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                {{--                <a class="btn btn-sm btn-outline-secondary" href="{{route('admin.users.create')}}">+ Nový sklad</a>--}}
            </div>
        </div>
    </div>

    <form action="{{route('inventory.items.store', $group)}}"
          method="POST">
        @csrf

        <div class="form-group">
            <label>Co chcete přidat</label>
            <select class="form-control"
                    id="select_item_type" name="select_item_type">
                <option value="new">Nová položka</option>
                <option value="existing">Přidat další záznam k existující položce</option>
            </select>
        </div>

        <div class="form-group"
             id="input_create_item">
            <label>Název položky</label>
            <input class="form-control"
                   name="name"
                   required>
        </div>

        <div class="form-group d-none"
             id="input_choose_item">
            <label>Vyberte položku</label>
            <input class="form-control"
                   id="items_magic"
                   name="existing_item_id"
                   required>
        </div>

        <div class="form-group">
            <label>Místo</label>
            <input class="form-control"
                   id="places_magic"
                   name="place_id"
                   required>
        </div>

        <input type="submit"
               class="btn btn-primary">
    </form>

@endsection

@push('scripts')
    <script>
        $(function () {
            Object.getPrototypeOf($("#items_magic")).size = function () {
                return this.length;
            };

            $("#items_magic").magicSuggest({
                data: @json($available_items),
                valueField: "id",
                displayField: 'name',
                allowFreeEntries: false,
                {{--value: @json($author_users_selected),--}}
                useCommaKey: false,
                maxSelection: 1,
                required: true,
            });
        });

        $(function () {
            Object.getPrototypeOf($("#places_magic")).size = function () {
                return this.length;
            };

            $("#places_magic").magicSuggest({
                data: @json($available_places),
                valueField: "id",
                displayField: 'name',
                allowFreeEntries: false,

                maxSelection: 1,
                required: true,

                @if($place)
                value: [@json($place)],
                @endif
                useCommaKey: false
            });
        });

        // Toggle form inputs
        $(function () {
            $('#select_item_type').change(function (el) {
                if ($(this).val() === 'existing') {
                    $('#input_create_item').addClass('d-none');
                    $('#input_choose_item').removeClass('d-none');
                }
                else {
                    $('#input_create_item').removeClass('d-none');
                    $('#input_choose_item').addClass('d-none');
                }


            });

        });
    </script>
@endpush
