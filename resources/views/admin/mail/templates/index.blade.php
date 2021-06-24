@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col"></div>
    <div class="col-6">
        <div class="table-responsive">
            <table class="table mail-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Тема письма</th>
                        <th scope="col">Создано</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    @foreach ($templates as $key => $template)
                        <tr onclick="window.location.href='{{ route('admin.mail.templates.show', ['template' => $template]) }}'; return false">
                            <th scope="row">{{ $key+1 }}</th>
                            <td>{{ $template->name }}</td>
                            <td>{{ $template->subject }}</td>
                            <td>{{ $template->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
