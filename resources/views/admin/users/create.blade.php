@extends('admin.layout')

@section('title', 'Správa uživatelů')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Nový uživatel</h1>
        </div>


        <form method="post"
              action="{{ route('admin.users.store') }}">
            @csrf

            <div class="row">
                <div class="col-7">
                    <div class="card">
                        <div class="card-header">Údaje uživatele</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-3 col-form-label">Jméno uživatele</label>
                                <div class="col-9">
                                    <input id="name" name="name" type="text" class="form-control"
                                           value="{{old('name')}}" required="required">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="surname" class="col-3 col-form-label">Příjmení</label>
                                <div class="col-9">
                                    <input id="surname" name="surname" type="text" class="form-control"
                                           value="{{old('surname')}}" required="required">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name_5" class="col-3 col-form-label">Oslovení v 5. pádě</label>
                                <div class="col-9">
                                    <input id="name_5" name="name_5" type="text" class="form-control"
                                           aria-describedby="name_5HelpBlock" value="{{old('name_5')}}"
                                           required="required">
                                    <span id="name_5HelpBlock" class="form-text text-muted">Použije se v automatických zprávách a v některých zobrazeních webu.</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-3 col-form-label">Emailová adresa</label>
                                <div class="col-9">
                                    <input id="email" name="email" placeholder="@" type="email" class="form-control"
                                           value="{{old('email')}}" required="required">
                                </div>
                            </div>

                            {{--Heslo--}}
                            <div class="card" style="margin-bottom: 20px">
                                <div class="card-header">Nastavení hesla</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        Uživatel si heslo nastaví sám <input name="keep_empty_pwd" checked type="checkbox">
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-3 col-form-label">Heslo</label>
                                        <div class="col-9">
                                            <input id="password" name="password" type="password"
                                                   class="form-control"
                                                   aria-describedby="passwordHelpBlock" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password_confirmation" class="col-3 col-form-label">Heslo pro
                                            kontrolu</label>
                                        <div class="col-9">
                                            <input id="password_confirmation" name="password_confirmation"
                                                   type="password"
                                                   class="form-control"
                                                   aria-describedby="passwordConfirmationHelpBlock" required>
                                            <span id="passwordConfirmationHelpBlock" class="form-text text-muted">Hesla se musí shodovat.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="phone" class="col-3 col-form-label">Telefonní číslo</label>
                                <div class="col-9">
                                    <input id="phone" name="phone" type="text" class="form-control"
                                           value="{{old('phone')}}" aria-describedby="phoneHelpBlock">
                                    <span id="phoneHelpBlock" class="form-text text-muted">Ve formátu +420 XXX XXX XXX nebo pouze XXX XXX XXX.</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="text" class="col-3 col-form-label">Ulice a č.p.</label>
                                <div class="col-9">
                                    <input id="street" name="street" type="text" class="form-control"
                                           aria-describedby="textHelpBlock" value="{{old('street')}}">
                                    <span id="textHelpBlock" class="form-text text-muted">Volitelné.</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="town" class="col-3 col-form-label">Obec</label>
                                <div class="col-9">
                                    <input id="town" name="town" type="text" class="form-control"
                                           value="{{old('town')}}" aria-describedby="townHelpBlock">
                                    <span id="townHelpBlock" class="form-text text-muted">Volitelné.</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="postal" class="col-3 col-form-label">PSČ</label>
                                <div class="col-9">
                                    <input id="postal" name="postal" type="text" class="form-control"
                                           aria-describedby="postalHelpBlock" value="{{old('postal')}}">
                                    <span id="postalHelpBlock" class="form-text text-muted">Volitelné.</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="country" class="col-3 col-form-label">Země</label>
                                <div class="col-9">
                                    <select id="country" name="country" class="custom-select"
                                            aria-describedby="countryHelpBlock" required="required">
                                        <option value="Česká republika">Česká republika</option>
                                        <option value="Slovensko">Slovensko</option>
                                    </select>
                                    <span id="countryHelpBlock" class="form-text text-muted">Volitelné.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card">
                        <div class="card-header">Možnosti</div>
                        <div class="card-body">
                            <input type="submit" class="btn btn-primary" value="Vytvořit uživatele">

                            <a class="btn btn-warning" href="{{route('admin.users.index')}}"
                               onclick="return confirm('Pozor! Při stornu nebude záznam vytvořen. Chcete pokračovat?')">Storno</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
