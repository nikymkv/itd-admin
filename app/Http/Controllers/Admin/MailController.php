<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\SettingsService;
use App\Services\Admin\MailService;
use App\Http\Requests\Admin\SaveMailSettingsRequest;
use App\Models\MailTemplate;

class MailController extends Controller
{
    protected $settingsService;

    public function __construct()
    {
        $this->settingsService = new SettingsService();
    }

    public function show()
    {
        $mailSettings = $this->settingsService->getMailSettings();
        return view('admin.settings.mail', compact('mailSettings'));
    }

    public function save(SaveMailSettingsRequest $request)
    {
        $this->settingsService->setMailSettings($request->validated());
        return back();
    }

    public function sendMail(Request $request, MailService $mailService)
    {
        $template = MailTemplate::firstWhere('name', 'Invite');
        $data = $request->only('name', 'event');
        $mailService->renderMail($template->html, $data);
        // $mailService->renderMail($request->get('html'), $request)
        $mailSettings = $this->settingsService->getMailSettings();
        $mailService->send('mail.feedback', $mailSettings, $request->all());
    }
}
