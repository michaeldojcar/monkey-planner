@extends('admin.layout')

@section('title', 'Správa uživatelů')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            @if(! isset($user))
                <h1 class="h2">Nový uživatel</h1>
            @else
                <h1 class="h2">Úprava uživatele {{$user->getWholeName()}}</h1>
            @endif
        </div>


        <form method="post"
              action="{{ ! isset($user) ? route('admin.users.store') : route('admin.users.update',$user)}}">
            @if(! isset($user))
            @else
                @method('PUT')
            @endif

            @csrf

            <div class="row">
                <div class="col-7">
                    <div class="card">
                        <div class="card-header">Údaje uživatele</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name"
                                       class="col-3 col-form-label">Jméno uživatele</label>
                                <div class="col-9">
                                    <input id="name"
                                           name="name"
                                           type="text"
                                           class="form-control"
                                           value="{{old('name', $user->name)}}"
                                           required="required">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="surname"
                                       class="col-3 col-form-label">Příjmení</label>
                                <div class="col-9">
                                    <input id="surname"
                                           name="surname"
                                           type="text"
                                           class="form-control"
                                           value="{{old('surname', $user->surname, 'aho')}}"
                                           required="required">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name_5"
                                       class="col-3 col-form-label">Oslovení v 5. pádě</label>
                                <div class="col-9">
                                    <input id="name_5"
                                           name="name_5"
                                           type="text"
                                           class="form-control"
                                           aria-describedby="name_5HelpBlock"
                                           value="{{old('name_5', $user->name_5)}}"
                                           required="required">
                                    <span id="name_5HelpBlock"
                                          class="form-text text-muted">Použije se v automatických zprávách a v některých zobrazeních webu.</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email"
                                       class="col-3 col-form-label">Emailová adresa</label>
                                <div class="col-9">
                                    <input id="email"
                                           name="email"
                                           placeholder="@"
                                           type="email"
                                           class="form-control"
                                           value="{{old('email', $user->email)}}"
                                           required="required">
                                </div>
                            </div>

                            {{--Heslo--}}
                            <div class="card"
                                 style="margin-bottom: 20px">
                                <div class="card-header">Nastavení hesla</div>
                                <div class="card-body">
                                    <div>
                                        Resetovat uživatelské heslo <input name="reset_password"
                                                                           type="checkbox">

                                        <hr>
                                        <small>Po resetu bude nastaveno dočasné heslo: 123456</small>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="phone"
                                       class="col-3 col-form-label">Telefonní číslo</label>
                                <div class="col-9">
                                    <input id="phone"
                                           name="phone"
                                           type="text"
                                           class="form-control"
                                           value="{{old('phone', $user->phone)}}"
                                           aria-describedby="phoneHelpBlock">
                                    <span id="phoneHelpBlock"
                                          class="form-text text-muted">Ve formátu +420 XXX XXX XXX nebo pouze XXX XXX XXX.</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="text"
                                       class="col-3 col-form-label">Ulice a č.p.</label>
                                <div class="col-9">
                                    <input id="street"
                                           name="street"
                                           type="text"
                                           class="form-control"
                                           aria-describedby="textHelpBlock"
                                           value="{{old('street', $user->street)}}">
                                    <span id="textHelpBlock"
                                          class="form-text text-muted">Volitelné.</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="town"
                                       class="col-3 col-form-label">Obec</label>
                                <div class="col-9">
                                    <input id="town"
                                           name="town"
                                           type="text"
                                           class="form-control"
                                           value="{{old('town', $user->town)}}"
                                           aria-describedby="townHelpBlock">
                                    <span id="townHelpBlock"
                                          class="form-text text-muted">Volitelné.</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="postal"
                                       class="col-3 col-form-label">PSČ</label>
                                <div class="col-9">
                                    <input id="postal"
                                           name="postal"
                                           type="text"
                                           class="form-control"
                                           aria-describedby="postalHelpBlock"
                                           value="{{old('postal', $user->postal)}}">
                                    <span id="postalHelpBlock"
                                          class="form-text text-muted">Volitelné.</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="country"
                                       class="col-3 col-form-label">Země</label>
                                <div class="col-9">
                                    <select id="country"
                                            name="country"
                                            class="custom-select"
                                            aria-describedby="countryHelpBlock"
                                            required="required">
                                        <option value="Česká republika">Česká republika</option>
                                        <option value="Slovensko">Slovensko</option>
                                    </select>
                                    <span id="countryHelpBlock"
                                          class="form-text text-muted">Volitelné.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card">
                        <div class="card-header">Možnosti</div>
                        <div class="card-body">
                            @if(! isset($user))
                                <input type="submit"
                                       class="btn btn-primary"
                                       value="Vytvořit uživatele">

                                <a class="btn btn-warning"
                                   href="{{route('admin.users.index')}}"
                                   onclick="return confirm('Pozor! Při stornu nebude záznam vytvořen. Chcete pokračovat?')">Storno</a>
                            @else
                                <input type="submit"
                                       class="btn btn-primary"
                                       value="Uložit změny">

                                <a class="btn btn-warning"
                                   href="{{route('admin.users.groups', $user)}}">Nastavení
                                    skupin</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
