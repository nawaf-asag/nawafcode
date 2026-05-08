<?php

namespace App\Models\Concerns;

trait HasTranslations
{
    /**
     * Returns the localized value of a field — uses the `{$field}_en` column
     * when current locale is "en" and the value is not empty; otherwise falls
     * back to the base field. Use in views: {{ $model->localized('title') }}
     */
    public function localized(string $field): ?string
    {
        $locale = app()->getLocale();

        if ($locale === 'en') {
            $en = $this->{$field . '_en'} ?? null;
            if (filled($en)) {
                return $en;
            }
        }

        return $this->{$field} ?? null;
    }
}
