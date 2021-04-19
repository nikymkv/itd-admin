@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col"></div>
    <div class="col-6">
        <div class="card">
            <div class="card-header text-center">
                Профиль пользователя {{ Auth::user()->name }}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col"></div>
                    <div class="col-6">
                        <form action="{{ route('admin.update-profile') }}" method="post">
                            @csrf
                            @method('PUT')
                                <div class="form-group">
                                    <label for="input_name">Имя</label>
                                    <input type="text" class="form-control" name="name" id="input_name"
                                        value="{{ $user->name ?? '' }}" placeholder="ФИО">
                                </div>
                                <div class="form-group">
                                    <label for="input_email">Почта</label>
                                    <input type="text" class="form-control" name="email" id="input_email"
                                        value="{{ $user->email ?? '' }}" placeholder="example@mail.com">
                                </div>
                                <div class="form-group">
                                    <label for="input_password">Пароль</label>
                                    <input type="password" class="form-control" name="password" id="input_password"
                                        placeholder="example999">
                                </div>
                                <div class="form-group">
                                    <label for="confirmed_password">Подтверждение пароля</label>
                                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                                        aria-describedby="passwordHelpBlock">
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
