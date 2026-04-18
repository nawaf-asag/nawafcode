<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;
use App\Models\Service;
use App\Models\Project;
use App\Models\SocialLink;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'nawaf@example.com'],
            ['name' => 'Nawaf Assaj', 'password' => Hash::make('password123')]
        );

        $settings = [
            // Hero
            'hero_name'           => 'نواف عساج',
            'hero_title'          => 'مطور برمجيات',
            'hero_subtitle'       => 'Full Stack Developer',
            'hero_description'    => 'أبني تطبيقات ويب احترافية وعالية الأداء باستخدام أحدث التقنيات. شغوف بتحويل الأفكار إلى حلول رقمية مبتكرة.',
            'typed_strings'       => 'مطور برمجيات|Full Stack Developer|Web & Mobile Developer|Laravel Expert',
            'hero_btn_projects'   => 'مشاهدة أعمالي',
            'hero_btn_cv'         => 'تحميل السيرة الذاتية',
            'cv_url'              => '#',
            // Stats
            'years_experience'    => '3',
            'stat_years_label'    => 'سنوات خبرة',
            'stat_projects_label' => 'مشروع منجز',
            'stat_services_label' => 'خدمة متخصصة',
            // About
            'about_text'          => 'مطور برمجيات متخصص في تطوير تطبيقات الويب الكاملة (Full Stack). أمتلك خبرة في بناء حلول برمجية متكاملة تجمع بين تصميم واجهات المستخدم الجذابة والبنية التحتية القوية للخوادم.',
            'about_tag'           => 'من أنا',
            'about_greeting'      => 'مرحباً، أنا',
            'about_btn_contact'   => 'تواصل معي',
            'about_btn_projects'  => 'أعمالي',
            'skills'              => "bi-filetype-php|PHP & Laravel\nbi-filetype-js|JavaScript & Vue.js\nbi-database|MySQL & PostgreSQL\nbi-git|Git & DevOps\nbi-phone|Flutter & Mobile\nbi-server|REST API & GraphQL",
            // Section titles
            'services_tag'        => 'ماذا أقدم',
            'services_title'      => 'خدماتي المتخصصة',
            'projects_tag'        => 'معرض الأعمال',
            'projects_title'      => 'أبرز أعمالي',
            'contact_tag'         => 'تواصل معي',
            'contact_title'       => 'لنتحدث عن مشروعك',
            'contact_form_title'  => 'أرسل لي رسالة',
            'contact_info_title'  => 'معلومات التواصل',
            'contact_btn'         => 'إرسال الرسالة',
            'filter_all'          => 'الكل',
            'filter_web'          => 'مواقع ويب',
            'filter_mobile'       => 'تطبيقات موبايل',
            'featured_label'      => 'مميز',
            'social_label'        => 'تابعني على منصات التواصل الاجتماعي',
            // Contact
            'contact_email'       => 'nawaf@example.com',
            'contact_phone'       => '+966 5X XXX XXXX',
            'contact_location'    => 'المملكة العربية السعودية',
            // SEO
            'meta_title'          => 'نواف عساج - مطور برمجيات',
            'meta_description'    => 'موقع نواف عساج الشخصي - مطور برمجيات متخصص في تطوير تطبيقات الويب',
        ];
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $services = [
            ['title' => 'تطوير الويب', 'description' => 'بناء مواقع وتطبيقات ويب متكاملة باستخدام أحدث التقنيات مثل Laravel وVue.js وReact مع ضمان أعلى معايير الجودة والأداء.', 'icon' => 'bi-code-slash', 'order' => 1],
            ['title' => 'تطوير API', 'description' => 'تصميم وتطوير واجهات برمجية (APIs) قوية وآمنة وقابلة للتوسع لربط التطبيقات المختلفة وخدمات الطرف الثالث.', 'icon' => 'bi-gear-wide-connected', 'order' => 2],
            ['title' => 'تطبيقات الموبايل', 'description' => 'تطوير تطبيقات الهاتف المحمول عبر المنصات المختلفة باستخدام Flutter وReact Native لضمان تجربة مستخدم سلسة.', 'icon' => 'bi-phone', 'order' => 3],
            ['title' => 'قواعد البيانات', 'description' => 'تصميم وإدارة قواعد البيانات العلائقية وغير العلائقية وتحسين الأداء وضمان أمان البيانات وسلامتها.', 'icon' => 'bi-database', 'order' => 4],
            ['title' => 'استشارات تقنية', 'description' => 'تقديم استشارات تقنية متخصصة لمساعدة الشركات في اتخاذ القرارات الصحيحة واختيار التقنيات المناسبة لمشاريعها.', 'icon' => 'bi-lightbulb', 'order' => 5],
            ['title' => 'صيانة وتطوير', 'description' => 'صيانة المشاريع القائمة وتحديثها وإضافة ميزات جديدة مع ضمان استقرار النظام وأداؤه العالي.', 'icon' => 'bi-tools', 'order' => 6],
        ];
        foreach ($services as $s) {
            Service::updateOrCreate(['title' => $s['title']], array_merge($s, ['active' => true]));
        }

        $projects = [
            ['title' => 'منصة التجارة الإلكترونية', 'description' => 'منصة تسوق متكاملة مع نظام إدارة المخزون ولوحة تحكم شاملة ونظام دفع آمن.', 'category' => 'web', 'technologies' => 'Laravel, Vue.js, MySQL, Redis, Stripe', 'project_url' => '#', 'github_url' => '#', 'order' => 1, 'featured' => true],
            ['title' => 'تطبيق إدارة المهام', 'description' => 'تطبيق ويب لإدارة المهام والمشاريع مع تتبع الوقت والتقارير التفصيلية.', 'category' => 'web', 'technologies' => 'Laravel, React, PostgreSQL, WebSockets', 'project_url' => '#', 'github_url' => '#', 'order' => 2, 'featured' => true],
            ['title' => 'تطبيق توصيل الطعام', 'description' => 'تطبيق جوال متكامل لتوصيل الطعام مع تتبع الطلبات في الوقت الفعلي.', 'category' => 'mobile', 'technologies' => 'Flutter, Laravel API, Firebase, Google Maps', 'project_url' => '#', 'github_url' => '#', 'order' => 3, 'featured' => false],
            ['title' => 'نظام إدارة المستشفيات', 'description' => 'نظام شامل لإدارة المستشفيات يشمل ملفات المرضى والمواعيد والفواتير.', 'category' => 'web', 'technologies' => 'Laravel, jQuery, MySQL, Bootstrap', 'project_url' => '#', 'github_url' => '#', 'order' => 4, 'featured' => false],
            ['title' => 'API بوابة الدفع', 'description' => 'واجهة برمجية لدمج بوابات الدفع المختلفة مع تشفير عالي الأمان.', 'category' => 'api', 'technologies' => 'Laravel, JWT, MySQL, SSL', 'project_url' => '#', 'github_url' => '#', 'order' => 5, 'featured' => false],
            ['title' => 'موقع شركة عقارية', 'description' => 'موقع إلكتروني احترافي لشركة عقارية مع نظام بحث متقدم وخرائط تفاعلية.', 'category' => 'web', 'technologies' => 'Laravel, JavaScript, MySQL, Google Maps API', 'project_url' => '#', 'github_url' => '#', 'order' => 6, 'featured' => false],
        ];
        foreach ($projects as $p) {
            Project::updateOrCreate(['title' => $p['title']], array_merge($p, ['active' => true]));
        }

        $socials = [
            ['platform' => 'GitHub',   'url' => 'https://github.com',        'icon' => 'bi-github',    'order' => 1],
            ['platform' => 'LinkedIn', 'url' => 'https://linkedin.com',      'icon' => 'bi-linkedin',  'order' => 2],
            ['platform' => 'Twitter',  'url' => 'https://twitter.com',       'icon' => 'bi-twitter-x', 'order' => 3],
            ['platform' => 'WhatsApp', 'url' => 'https://wa.me/966500000000','icon' => 'bi-whatsapp',  'order' => 4],
            ['platform' => 'Telegram', 'url' => 'https://t.me/username',     'icon' => 'bi-telegram',  'order' => 5],
        ];
        foreach ($socials as $s) {
            SocialLink::updateOrCreate(['platform' => $s['platform']], array_merge($s, ['active' => true]));
        }
    }
}
