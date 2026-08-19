<?php

if (!function_exists('lroute')) {
    /**
     * Generate a locale-aware route URL.
     * Automatically prepends the current app locale to route parameters.
     *
     * @param string $name
     * @param array|mixed $parameters
     * @param bool $absolute
     * @return string
     */
    function lroute(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        $locale = app()->getLocale();

        if (!is_array($parameters)) {
            $parameters = [$parameters];
        }

        return route($name, array_merge(['locale' => $locale], $parameters), $absolute);
    }
}

if (!function_exists('locale_switch_url')) {
    /**
     * Generate a URL to switch to the given locale while staying on the same page.
     *
     * @param string $targetLocale
     * @return string
     */
    function locale_switch_url(string $targetLocale): string
    {
        try {
            $currentRoute = request()->route();
            if (!$currentRoute) {
                return url('/' . $targetLocale);
            }

            $routeName   = $currentRoute->getName();
            $params      = $currentRoute->parameters();

            // Merge in the new locale
            $params['locale'] = $targetLocale;

            return route($routeName, $params);
        } catch (\Exception $e) {
            return url('/' . $targetLocale);
        }
    }
}
