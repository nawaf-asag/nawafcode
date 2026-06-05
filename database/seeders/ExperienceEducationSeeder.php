<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;
use App\Models\Education;

/**
 * Seeds ONLY the Experience & Education records.
 *
 * Safe to run on production — it uses updateOrCreate (idempotent, no
 * duplicates) and never touches settings/services/projects, so it won't
 * overwrite your live content.
 *
 *   php artisan db:seed --class=ExperienceEducationSeeder --force
 */
class ExperienceEducationSeeder extends Seeder
{
    public function run(): void
    {
        $experiences = [
            [
                'role'           => 'مهندس دعم فني أول للمؤسسات',
                'role_en'        => 'Senior Enterprise Technical Support Engineer',
                'company'        => 'شركة الحلول النهائية — جدة، السعودية',
                'company_en'     => 'Final Solutions Co. — Jeddah, Saudi Arabia',
                'description'    => 'تقديم الدعم المتقدم والصيانة لنظام Onyx ERP وأنظمة الفنادق. تحديث قواعد البيانات (Oracle & SQL Server)، وتصميم التقارير المالية، وفحص وحل مشاكل العملاء لضمان كفاءة العمل المستمرة.',
                'description_en' => 'Advanced support and maintenance for the Onyx ERP system and hotel management systems. Updating databases (Oracle & SQL Server), designing financial reports, and diagnosing and resolving client issues to ensure continuous operational efficiency.',
                'year_from'      => 2023, 'year_to' => null, 'is_current' => true,
                'technologies'   => 'Onyx ERP, Oracle, SQL Server', 'order' => 1,
            ],
            [
                'role'           => 'مطور ويب متكامل Full Stack',
                'role_en'        => 'Full Stack Web Developer',
                'company'        => 'قبول سوفت للحلول البرمجية',
                'company_en'     => 'Qabool Soft Software Solutions',
                'description'    => 'تصميم وتطوير تطبيقات ويب متكاملة، وبناء واجهات مستخدم متجاوبة، وتأسيس خدمات الـ REST APIs في بيئة Laravel، وربط بوابات الدفع الإلكترونية.',
                'description_en' => 'Designing and developing full-stack web applications, building responsive user interfaces, establishing REST APIs in a Laravel environment, and integrating online payment gateways.',
                'year_from'      => 2022, 'year_to' => null, 'is_current' => false,
                'technologies'   => 'Laravel, REST API, Payments', 'order' => 2,
            ],
            [
                'role'           => 'مطور ويب متكامل Full Stack',
                'role_en'        => 'Full Stack Web Developer',
                'company'        => 'يمن سايت — صنعاء',
                'company_en'     => "Yemen Site — Sana'a",
                'description'    => 'برمجة وتصميم مواقع وحلول ويب مخصصة لعملاء الأعمال والشركات، بدءاً من تخطيط قواعد البيانات ووصولاً للواجهات الأمامية وتحسين الـ SEO.',
                'description_en' => 'Programming and designing custom websites and web solutions for business and corporate clients, from database planning to front-end interfaces and SEO optimization.',
                'year_from'      => 2021, 'year_to' => 2022, 'is_current' => false,
                'technologies'   => 'Web, Databases, SEO', 'order' => 3,
            ],
        ];
        foreach ($experiences as $e) {
            Experience::updateOrCreate(
                ['role' => $e['role'], 'company' => $e['company']],
                array_merge($e, ['active' => true])
            );
        }

        $education = [
            [
                'degree'         => 'بكالوريوس في هندسة البرمجيات',
                'degree_en'      => "Bachelor's in Software Engineering",
                'institution'    => 'جامعة العلوم والتكنولوجيا — صنعاء',
                'institution_en' => "University of Science & Technology — Sana'a",
                'note'           => 'تقدير امتياز مع مرتبة الشرف وبمعدل 92%',
                'note_en'        => 'Excellent with First-Class Honors — GPA 92%',
                'year_from'      => 2020, 'year_to' => 2021, 'is_current' => false, 'order' => 1,
            ],
        ];
        foreach ($education as $ed) {
            Education::updateOrCreate(
                ['degree' => $ed['degree'], 'institution' => $ed['institution']],
                array_merge($ed, ['active' => true])
            );
        }
    }
}
