<div class="modal fade"
     id="userAssignModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog"
         role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="exampleModalLabel">Přidání někoho, kdo je potřeba</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST"
                  action="{{route('organize.event.task.create', $event)}}">
                @csrf
                <div class="modal-body">
                    <input type="hidden"
                           name="type"
                           value="1">

                    <div class="form-group row">
                        <label for="text"
                               class="col-4 col-form-label">Název role</label>
                        <div class="col-8">
                            <input id="text"
                                   name="name"
                                   type="text"
                                   class="form-control"
                                   placeholder="např. rozhodčí / černý rytíř">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="text1"
                               class="col-4 col-form-label">Kolik lidí je potřeba</label>
                        <div class="col-8">
                            <input id="text1"
                                   name="required_count"
                                   type="number"
                                   value="1"
                                   required
                                   class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Close
                    </button>
                    <input type="submit"
                           class="btn btn-primary"
                           value="Přidat roli">
                </div>
            </form>
        </div>
    </div>
</div>