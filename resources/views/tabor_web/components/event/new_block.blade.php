{{-- New block --}}
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
                    id="exampleModalLabel">Nová sekce události: {{lcfirst($event->name)}}</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST"
                  action="{{route('organize.blocks.store', ['event' => $main_event, 'sub_event' => $event])}}">
                @csrf
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="name"
                               class="col-4 col-form-label">Název sekce</label>
                        <div class="col-8">
                            <div class="input-group">
                                <input id="title"
                                       name="title"
                                       type="text"
                                       class="form-control"
                                       aria-describedby="nameHelpBlock"
                                       required="required">
                            </div>
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
