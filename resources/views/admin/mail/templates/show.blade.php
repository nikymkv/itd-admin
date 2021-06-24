@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col"></div>
    <div class="col-6">
        <div class="card">
            <h5 class="card-header text-center">Шаблон письма "{{ $template->name ?? 'Новый шаблон' }}"</h5>
            <div class="card-body">
                <form action="{{ route('admin.mail.templates.update', ['template' => $template]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="name">Имя шаблона</label>
                      <input type="text" class="form-control" id="name" value="{{ $template->name }}" placeholder="Имя шаблона">
                    </div>
                    <div class="form-group">
                      <label for="subject">Тема письма</label>
                      <input type="text" class="form-control" name="subject" id="subject" value="{{ $template->subject }}" placeholder="Тема письма">
                    </div>
                    <div class="form-group">
                      <label for="description">Описание</label>
                      <div>
                        <textarea name="description" id="description" style="width: 100%">{{ $template->description }}</textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="editor">Текст письма</label>
                      <div>
                        <textarea name="html" id="editor">{{ $template->html }}</textarea>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
            </div>
            <form action="{{ route('send-mail') }}" method="post">
              @csrf
              <input type="text" name="name" value="Test Name">
              <input type="text" name="event" value="Test Event">
              <input type="submit" value="Send">
            </form>
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
