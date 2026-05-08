<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;
use App\Models\Service;
use App\Models\Project;
use App\Models\Brand;
use App\Models\SocialLink;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'nawaf@example.com'],
            ['name' => 'Nawaf Assaj', 'password' => Hash::make('password123')]
        );

        // [key => [ar_value, en_value]]
        $settings = [
            // Hero
            'hero_name'           => ['نواف عساج', 'Nawaf Asag'],
            'hero_title'          => ['مطور برمجيات', 'Software Developer'],
            'hero_subtitle'       => ['مطور برمجيات Full Stack', 'Full Stack Developer'],
            'hero_description'    => [
                'أبني تطبيقات ويب وموبايل احترافية وعالية الأداء باستخدام أحدث التقنيات. شغوف بتحويل الأفكار إلى حلول رقمية مبتكرة تخدم الأعمال.',
                'I build professional, high-performance web and mobile applications using modern technologies. Passionate about turning ideas into innovative digital solutions.',
            ],
            'typed_strings'       => [
                'مطور برمجيات|Full Stack Developer|Web & Mobile Developer|Laravel Expert',
                'Full Stack Developer|Web & Mobile Developer|Laravel Expert|API Builder',
            ],
            'hero_btn_projects'   => ['مشاهدة أعمالي', 'View My Work'],
            'hero_btn_cv'         => ['تحميل السيرة الذاتية', 'Download CV'],

            // Stats
            'stat_years_label'    => ['سنوات خبرة', 'Years of Experience'],
            'stat_projects_label' => ['مشروع منجز', 'Projects Completed'],
            'stat_services_label' => ['خدمة متخصصة', 'Specialized Services'],

            // About
            'about_text'          => [
                'مطور برمجيات متخصص في تطوير تطبيقات الويب الكاملة (Full Stack). أمتلك خبرة في بناء حلول برمجية متكاملة تجمع بين تصميم واجهات المستخدم الجذابة والبنية التحتية القوية للخوادم.',
                'Full Stack Developer specialized in building end-to-end web applications. Experienced in delivering complete software solutions that combine attractive UI design with a robust server-side architecture.',
            ],
            'about_tag'           => ['من أنا', 'About me'],
            'about_greeting'      => ['مرحباً، أنا', "Hi, I'm"],
            'about_btn_contact'   => ['تواصل معي', 'Contact Me'],
            'about_btn_projects'  => ['أعمالي', 'My Work'],
            'skills'              => [
                "bi-filetype-php|PHP & Laravel\nbi-filetype-js|JavaScript & Vue.js\nbi-database|MySQL & PostgreSQL\nbi-git|Git & DevOps\nbi-phone|Flutter & Mobile\nbi-server|REST API & GraphQL",
                "bi-filetype-php|PHP & Laravel\nbi-filetype-js|JavaScript & Vue.js\nbi-database|MySQL & PostgreSQL\nbi-git|Git & DevOps\nbi-phone|Flutter & Mobile\nbi-server|REST API & GraphQL",
            ],

            // Section titles
            'services_tag'        => ['ماذا أقدم', 'What I Offer'],
            'services_title'      => ['خدماتي المتخصصة', 'My Specialized Services'],
            'projects_tag'        => ['معرض الأعمال', 'Portfolio'],
            'projects_title'      => ['أبرز أعمالي', 'Featured Projects'],
            'contact_tag'         => ['تواصل معي', 'Get in touch'],
            'contact_title'       => ['لنتحدث عن مشروعك', "Let's discuss your project"],
            'contact_form_title'  => ['أرسل لي رسالة', 'Send me a message'],
            'contact_info_title'  => ['معلومات التواصل', 'Contact information'],
            'contact_btn'         => ['إرسال الرسالة', 'Send Message'],
            'filter_all'          => ['الكل', 'All'],
            'filter_web'          => ['مواقع ويب', 'Web'],
            'filter_mobile'       => ['تطبيقات موبايل', 'Mobile'],
            'featured_label'      => ['مميز', 'Featured'],
            'social_label'        => ['تابعني على منصات التواصل الاجتماعي', 'Follow me on social media'],

            // Contact
            'contact_location'    => ['المملكة العربية السعودية', 'Saudi Arabia'],

            // SEO
            'meta_title'          => [
                'نواف عساج - مطور برمجيات Full Stack | Laravel & Flutter',
                'Nawaf Asag - Full Stack Developer | Laravel & Flutter',
            ],
            'meta_description'    => [
                'نواف عساج — مطور برمجيات متخصص في Laravel وReact وFlutter. أبني تطبيقات ويب وموبايل احترافية وعالية الأداء. تواصل معي لمشروعك القادم.',
                'Nawaf Asag — Full Stack Developer specialized in Laravel, React, and Flutter. Building professional, high-performance web and mobile applications. Get in touch for your next project.',
            ],
            'meta_keywords'       => [
                'نواف عساج, مطور برمجيات, Laravel, React, Flutter, تطوير ويب, تطبيقات موبايل, Full Stack, مطور سعودي',
                'Nawaf Asag, software developer, Laravel, React, Flutter, web development, mobile apps, Full Stack, Saudi developer',
            ],
        ];

        foreach ($settings as $key => [$ar, $en]) {
            Setting::updateOrCreate(['key' => $key], ['value' => $ar, 'value_en' => $en]);
        }

        // Single-locale settings (no translation needed)
        $singles = [
            'cv_url'           => '#',
            'years_experience' => '3',
            'contact_email'    => 'nawaf@example.com',
            'contact_phone'    => '+966 5X XXX XXXX',
            'site_author'      => 'Nawaf Asag',
            'job_title_en'     => 'Full Stack Developer',
            'twitter_handle'   => '',
        ];
        foreach ($singles as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $services = [
            [
                'title' => 'تطوير الويب', 'title_en' => 'Web Development',
                'description'    => 'بناء مواقع وتطبيقات ويب متكاملة باستخدام أحدث التقنيات مثل Laravel وVue.js وReact مع ضمان أعلى معايير الجودة والأداء.',
                'description_en' => 'Building complete websites and web applications with modern technologies like Laravel, Vue.js, and React — ensuring top quality and performance.',
                'icon' => 'bi-code-slash', 'order' => 1,
            ],
            [
                'title' => 'تطوير API', 'title_en' => 'API Development',
                'description'    => 'تصميم وتطوير واجهات برمجية (APIs) قوية وآمنة وقابلة للتوسع لربط التطبيقات المختلفة وخدمات الطرف الثالث.',
                'description_en' => 'Designing and building robust, secure, and scalable APIs to connect applications and third-party services.',
                'icon' => 'bi-gear-wide-connected', 'order' => 2,
            ],
            [
                'title' => 'تطبيقات الموبايل', 'title_en' => 'Mobile Apps',
                'description'    => 'تطوير تطبيقات الهاتف المحمول عبر المنصات المختلفة باستخدام Flutter وReact Native لضمان تجربة مستخدم سلسة.',
                'description_en' => 'Cross-platform mobile app development with Flutter and React Native for a smooth user experience.',
                'icon' => 'bi-phone', 'order' => 3,
            ],
            [
                'title' => 'قواعد البيانات', 'title_en' => 'Databases',
                'description'    => 'تصميم وإدارة قواعد البيانات العلائقية وغير العلائقية وتحسين الأداء وضمان أمان البيانات وسلامتها.',
                'description_en' => 'Designing and managing relational and NoSQL databases — performance tuning, security, and data integrity.',
                'icon' => 'bi-database', 'order' => 4,
            ],
            [
                'title' => 'استشارات تقنية', 'title_en' => 'Tech Consulting',
                'description'    => 'تقديم استشارات تقنية متخصصة لمساعدة الشركات في اتخاذ القرارات الصحيحة واختيار التقنيات المناسبة لمشاريعها.',
                'description_en' => 'Specialized technical consulting to help companies make informed decisions and pick the right stack for their projects.',
                'icon' => 'bi-lightbulb', 'order' => 5,
            ],
            [
                'title' => 'صيانة وتطوير', 'title_en' => 'Maintenance & Upgrades',
                'description'    => 'صيانة المشاريع القائمة وتحديثها وإضافة ميزات جديدة مع ضمان استقرار النظام وأداؤه العالي.',
                'description_en' => 'Maintaining existing projects, shipping updates, and adding new features while keeping the system stable and fast.',
                'icon' => 'bi-tools', 'order' => 6,
            ],
        ];
        foreach ($services as $s) {
            Service::updateOrCreate(['title' => $s['title']], array_merge($s, ['active' => true]));
        }

        $projects = [
            [
                'title' => 'منصة التجارة الإلكترونية', 'title_en' => 'E-commerce Platform',
                'description'    => 'منصة تسوق متكاملة مع نظام إدارة المخزون ولوحة تحكم شاملة ونظام دفع آمن.',
                'description_en' => 'Full e-commerce platform with inventory management, comprehensive admin dashboard, and secure payment integration.',
                'category' => 'web', 'technologies' => 'Laravel, Vue.js, MySQL, Redis, Stripe', 'project_url' => '#', 'github_url' => '#', 'order' => 1, 'featured' => true, 'year_from' => 2024,
            ],
            [
                'title' => 'تطبيق إدارة المهام', 'title_en' => 'Task Management App',
                'description'    => 'تطبيق ويب لإدارة المهام والمشاريع مع تتبع الوقت والتقارير التفصيلية.',
                'description_en' => 'Web application for task and project management with time tracking and detailed reporting.',
                'category' => 'web', 'technologies' => 'Laravel, React, PostgreSQL, WebSockets', 'project_url' => '#', 'github_url' => '#', 'order' => 2, 'featured' => true, 'year_from' => 2023,
            ],
            [
                'title' => 'تطبيق توصيل الطعام', 'title_en' => 'Food Delivery App',
                'description'    => 'تطبيق جوال متكامل لتوصيل الطعام مع تتبع الطلبات في الوقت الفعلي.',
                'description_en' => 'Complete mobile app for food delivery with real-time order tracking.',
                'category' => 'mobile', 'technologies' => 'Flutter, Laravel API, Firebase, Google Maps', 'project_url' => '#', 'github_url' => '#', 'order' => 3, 'featured' => false, 'year_from' => 2023,
            ],
            [
                'title' => 'نظام إدارة المستشفيات', 'title_en' => 'Hospital Management System',
                'description'    => 'نظام شامل لإدارة المستشفيات يشمل ملفات المرضى والمواعيد والفواتير.',
                'description_en' => 'Complete hospital management system covering patient records, appointments, and billing.',
                'category' => 'web', 'technologies' => 'Laravel, jQuery, MySQL, Bootstrap', 'project_url' => '#', 'github_url' => '#', 'order' => 4, 'featured' => false, 'year_from' => 2022,
            ],
            [
                'title' => 'API بوابة الدفع', 'title_en' => 'Payment Gateway API',
                'description'    => 'واجهة برمجية لدمج بوابات الدفع المختلفة مع تشفير عالي الأمان.',
                'description_en' => 'API to integrate multiple payment gateways with high-grade encryption.',
                'category' => 'api', 'technologies' => 'Laravel, JWT, MySQL, SSL', 'project_url' => '#', 'github_url' => '#', 'order' => 5, 'featured' => false, 'year_from' => 2024,
            ],
            [
                'title' => 'موقع شركة عقارية', 'title_en' => 'Real Estate Website',
                'description'    => 'موقع إلكتروني احترافي لشركة عقارية مع نظام بحث متقدم وخرائط تفاعلية.',
                'description_en' => 'Professional website for a real estate company with advanced search and interactive maps.',
                'category' => 'web', 'technologies' => 'Laravel, JavaScript, MySQL, Google Maps API', 'project_url' => '#', 'github_url' => '#', 'order' => 6, 'featured' => false, 'year_from' => 2024,
            ],

            // ===== Tech Support entries (3 systems) =====
            [
                'title'          => 'نظام أونكم (Onkom)',
                'title_en'       => 'Onkom System',
                'description'    => 'دعم فني شامل ومتابعة مستمرة لنظام أونكم لإدارة المنشآت الحكومية، حل المشاكل التقنية، تدريب المستخدمين، وضمان استمرارية التشغيل.',
                'description_en' => 'Comprehensive ongoing technical support for the Onkom system used to manage government facilities — troubleshooting, user training, and operational continuity.',
                'category'       => 'support',
                'technologies'   => 'Onkom, Oracle, SQL Server',
                'project_url'    => '#',
                'github_url'     => '#',
                'order'          => 7,
                'featured'       => false,
                'year_from'      => 2021,
                'year_to'        => null,
            ],
            [
                'title'          => 'نظام ERP المحاسبي',
                'title_en'       => 'Accounting ERP System',
                'description'    => 'تقديم الدعم الفني لنظام تخطيط موارد المؤسسات (ERP) المحاسبي، إعداد التقارير المالية، حل مشاكل القيود، وتدريب فرق المحاسبة.',
                'description_en' => 'Technical support for an accounting ERP system — financial reporting setup, journal-entry issues, and training accounting teams.',
                'category'       => 'support',
                'technologies'   => 'ERP, MySQL, Crystal Reports',
                'project_url'    => '#',
                'github_url'     => '#',
                'order'          => 8,
                'featured'       => false,
                'year_from'      => 2020,
                'year_to'        => null,
            ],
            [
                'title'          => 'نظام إدارة الموارد البشرية',
                'title_en'       => 'HR Management System',
                'description'    => 'دعم فني لنظام HR متكامل: الرواتب، الإجازات، الحضور والانصراف، حل مشاكل التكامل مع البصمة وإصدار التقارير الإدارية.',
                'description_en' => 'Technical support for a complete HR system — payroll, leaves, attendance, biometric integration issues, and management reports.',
                'category'       => 'support',
                'technologies'   => 'HR System, MS SQL, Power BI',
                'project_url'    => '#',
                'github_url'     => '#',
                'order'          => 9,
                'featured'       => false,
                'year_from'      => 2022,
                'year_to'        => null,
            ],
        ];
        foreach ($projects as $p) {
            Project::updateOrCreate(['title' => $p['title']], array_merge($p, ['active' => true]));
        }

        $brands = [
            ['name' => 'Saudi Aramco',  'website' => '#', 'contribution' => 'تطوير لوحة تحكم داخلية', 'contribution_en' => 'Internal admin dashboard development',     'order' => 1],
            ['name' => 'STC',           'website' => '#', 'contribution' => 'تطوير API للعملاء',     'contribution_en' => 'Customer-facing API development',          'order' => 2],
            ['name' => 'Almosafer',     'website' => '#', 'contribution' => 'تطوير منصة حجوزات',      'contribution_en' => 'Booking platform development',             'order' => 3],
            ['name' => 'Hungerstation', 'website' => '#', 'contribution' => 'تطبيق توصيل طلبات',     'contribution_en' => 'Order delivery application',               'order' => 4],
            ['name' => 'Riyad Bank',    'website' => '#', 'contribution' => 'تطوير بوابة دفع',         'contribution_en' => 'Payment gateway development',              'order' => 5],
            ['name' => 'Tabby',         'website' => '#', 'contribution' => 'تطوير SDK الدفع',         'contribution_en' => 'Payment SDK development',                  'order' => 6],
            ['name' => 'Jahez',         'website' => '#', 'contribution' => 'تطوير لوحة التجار',       'contribution_en' => 'Merchant dashboard development',           'order' => 7],
            ['name' => 'Noon',          'website' => '#', 'contribution' => 'تطوير ميزات المتجر',     'contribution_en' => 'Storefront feature development',           'order' => 8],
        ];
        foreach ($brands as $b) {
            Brand::updateOrCreate(['name' => $b['name']], array_merge($b, ['active' => true]));
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
