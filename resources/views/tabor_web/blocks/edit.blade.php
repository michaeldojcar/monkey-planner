@extends('tabor_web.layout')

@section('content')
    <style>
        .h1-input {
            border:           none;
            background-color: transparent;
            outline:          none;
            font-weight:      500;
            line-height:      1.2;
            font-size:        2rem;

            width:            100%;
        }
    </style>

    <form action="{{ route('organize.blocks.update', [$main_event, $block]) }}"
          method="POST">
        @csrf
        <div class="border-bottom"
             style="margin-bottom: 20px; padding-bottom: 10px">
            @if(isset($block->event->name))
                <span>SEKCE UDÁLOSTI {{$block->event->name}}:</span>
            @endif
            <input name="title"
                   class="h1-input"
                   value="{{$block->title}}"
                   placeholder="název sekce?"
                   autofocus>
        </div>

        <div class="row">
            <div class="col-sm-9 mb-2">
        <textarea name="content"
                  style="height: calc(100vh - 170px); font-size: 16px">
            {!! $block->content !!}
        </textarea>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header">Možnosti</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"
                                 style="margin-bottom: 20px">
                                <input style="width: 100%;"
                                       type="submit"
                                       class="btn btn-primary"
                                       value="Uložit sekci">
                            </div>
                            <div class="col-5">
                                <a class="btn btn-outline-secondary"
                                   href="{{route('organize.events.show', [$main_event, $block->event])}}"
                                   style="width: 100%;">Storno
                                </a>
                            </div>
                            <div class="col-7">
                                <a class="btn btn-outline-danger"
                                   href="{{ route('organize.blocks.delete', [$main_event, $block]) }}"
                                   onclick=" return confirm('Sekce bude ODSTRANĚNA i s obsahem, jste si jisti?')"
                                   style="width: 100%;">Odstranit tuto sekci</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
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
