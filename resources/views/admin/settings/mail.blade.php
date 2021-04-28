@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col"></div>
    <div class="col-6">
        <div class="card">
            <div class="card-header text-center">
                Настройки почтового сервиса
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col"></div>
                    <div class="col-6">
                        <form action="{{ route('admin.settings.mail.save') }}" method="post">
                            @csrf
                                <div class="form-group">
                                    <label for="name_from">Имя отправителя</label>
                                    <input type="text" class="form-control" name="settings[name_from]" id="name_from"
                                        value="{{ $mailSettings->settings['name_from'] ?? '' }}" placeholder="Имя">
                                </div>
                                <div class="form-group">
                                    <label for="address_from">Адрес отправителя</label>
                                    <input type="text" class="form-control" name="settings[address_from]" id="address_from"
                                        value="{{ $mailSettings->settings['address_from'] ?? '' }}" placeholder="example@mail.com">
                                </div>
                                <div class="form-group">
                                    <label for="send_method">Метод</label>
                                    <input type="text" class="form-control" name="settings[send_method]" id="send_method" value="{{ $mailSettings->settings['send_method'] ?? '' }}" placeholder="SMTP">
                                </div>
                                <div class="form-group">
                                    <label for="smtp_port">Порт</label>
                                    <input type="number" class="form-control" name="settings[smtp_port]" id="smtp_port" value="{{ $mailSettings->settings['smtp_port'] ?? '' }}" placeholder="587">
                                </div>
                                <div class="form-group">
                                    <label for="encrypt_protocol">Протокол шифрования</label>
                                    <select name="settings[encrypt_protocol]" id="encrypt_protocol">
                                        <option value="tls" {{ $mailSettings->settings['encrypt_protocol'] == 'tls' ? 'selected' : '' }}>TLS</option>
                                        <option value="ssl" {{ $mailSettings->settings['encrypt_protocol'] == 'ssl' ? 'selected' : '' }}>SSL</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="server_name">Сервер исходящей почты</label>
                                    <input type="text" id="server_name" class="form-control" name="settings[server_name]" value="{{ $mailSettings->settings['server_name'] ?? '' }}" placeholder="smtp.domain.org">
                                </div>
                                <div class="form-group">
                                    <label for="server_login">Логин сервера авторизации</label>
                                    <input type="text" id="server_login" class="form-control" name="settings[server_login]" value="{{ $mailSettings->settings['server_login'] ?? '' }}" placeholder="Логин">
                                </div>
                                <div class="form-group">
                                    <label for="server_password">Пароль сервера авторизации</label>
                                    <input type="password" id="server_password" class="form-control" name="settings[server_password]" value="{{ $mailSettings->settings['server_password'] ?? '' }}" placeholder="Пароль">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Сохранить</button>
                        </form>
                    </div>
                    <div class="col"></div>
                </div>
            </div>
        </div>
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
        @endforeach
        @endif
    </div>
    <div class="col"></div>
</div>
@endsection
