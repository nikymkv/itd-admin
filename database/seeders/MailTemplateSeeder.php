<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MailTemplate;

class MailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailTemplate::insert([
            [
                'name' => 'Invite',
                'subject' => 'You were invited to an event',
                'description' => 'Some description',
                'html' => <<<EOT
                    <div>
                    Дорогой {{ name }}, 
                    приглашаем тебя на {{ event }}!
                    </div>
                EOT,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}