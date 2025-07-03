<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run()
    {
        Faq::insert([
            [
                'question' => 'What programs does CTU offer?',
                'answer' => 'We offer a variety of technology-focused undergraduate and graduate programs.'
            ],
            [
                'question' => 'How do I apply to CTU?',
                'answer' => 'You can apply online through our admissions portal.'
            ],
            [
                'question' => 'Where is CTU located?',
                'answer' => 'We are located in Borg El-Arab, Alexandria Governorate, Egypt.'
            ],
        ]);
    }
}
