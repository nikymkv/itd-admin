<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\MailTemplate;

class MailTemplateController extends Controller
{
    public function index()
    {
        $templates = MailTemplate::all();
        
        return view('admin.mail.templates.index', \compact('templates'));
    }

    public function create()
    {
        return view('admin.mail.templates.create');
    }

    public function show(MailTemplate $template)
    {
        return view('admin.mail.templates.show', \compact('template'));
    }

    public function store(Request $request)
    {
        dd($request->all());
        $template = MailTemplate::findOrCreate('code', []);
        if ( ! $template) { // return with errors
            return back();
        }

        return back();
    }

    public function update(Request $request, MailTemplate $template)
    {

        dd($request->all());
        $template->update($request->validated());

        return back();
    }

    public function destroy(MailTemplate $template)
    {
        $template->delete();
        
        return redirect()->route('admin.mail.index');
    }
}
