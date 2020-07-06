<div class="modal fade"
     id="itemTaskAssignModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog"
         role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="exampleModalLabel">Potřebná rekvizita - {{$event->name}}</h5>
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
                           value="2">

                    <div class="form-group row">
                        <label for="name"
                               class="col-4 col-form-label">Jméno rekvizity</label>
                        <div class="col-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-box-open"></i>
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
                                  class="form-text text-muted">Název věci nebo rekvizity, kterou je potřeba vzít.</span>
                        </div>
                    </div>
                    {{--                    <div class="form-group row">--}}
                    {{--                        <label for="content" class="col-4 col-form-label">Popis</label>--}}
                    {{--                        <div class="col-8">--}}
                    {{--                                <textarea id="content" name="content" cols="40" rows="5"--}}
                    {{--                                          aria-describedby="contentHelpBlock" class="form-control"></textarea>--}}
                    {{--                            <span id="contentHelpBlock" class="form-text text-muted">Nepovinné, pokud není potřeba, můžete ponechat prázdné.</span>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="form-group row">
                        <label for="text1"
                               class="col-4 col-form-label">Počet kusů*</label>
                        <div class="col-8">
                            <input id="text1"
                                   name="required_count"
                                   type="number"
                                   value="1"
                                   required
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="select"
                               class="col-4 col-form-label">Zodpovědné PT</label>
                        <div class="col-8">
                            <select id="group_id"
                                    name="group_id"
                                    class="custom-select">
                                <option value="0">Zatím nepřiřazovat</option>
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