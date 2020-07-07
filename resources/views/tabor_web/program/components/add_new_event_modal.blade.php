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
                    id="exampleModalLabel">Nový blok programu</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST"
                  action="{{route('organize.program', $main_event)}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name"
                               class="col-4 col-form-label">Název</label>
                        <div class="col-8">
                            <input id="name"
                                   name="name"
                                   type="text"
                                   class="form-control"
                                   required="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="select"
                               class="col-4 col-form-label">Typ programu</label>
                        <div class="col-8">
                            <select id="type"
                                    name="type"
                                    class="custom-select"
                                    required="required">
                                <option value="0">Událost</option>
                                <option value="1">Hra</option>
                                <option value="2">Program</option>
                                <option value="3">Režim</option>
                                <option value="4">Přednáška</option>
                                <option value="5">Duchovní</option>
                                <option value="6">Scénka</option>
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
                                    <option value="{{$x}}">{{$x}}.
                                        den @switch($main_event->countDateFromThisEventsDayNumber($x)->dayOfWeek)
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
                                <option value="all">Každý den</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="select2"
                               class="col-4 col-form-label">Hrubé umístění ve dni</label>
                        <div class="col-8">
                            <select id="time"
                                    name="time"
                                    class="custom-select">
                                <option value="7:00">7:00</option>
                                <option value="8:00">8:00</option>
                                <option value="9:00">9:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="12:00">12:00</option>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                                <option value="17:00">17:00</option>
                                <option value="18:00">18:00</option>
                                <option value="19:00">19:00</option>
                                <option value="20:00">20:00</option>
                                <option value="21:00">21:00</option>
                                <option value="22:00">22:00</option>
                                <option value="23:00">23:00</option>
                                <option value="0:00">0:00</option>
                                <option value="1:00">1:00</option>
                                <option value="2:00">2:00</option>
                                <option value="3:00">3:00</option>
                                <option value="4:00">4:00</option>
                                <option value="5:00">5:00</option>
                                <option value="6:00">6:00</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Zavřít
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
