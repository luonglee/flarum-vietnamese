<?php
// Copyright © 2015 Toby Zerner and Flarum
// Copyright © 2015 Johann Rodríguez and Flarum en Español
// ---
// All rights reserved

use Flarum\Event\ConfigureClientView;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\Event\ConfigureLocales;

return function (Dispatcher $events) {
    $events->subscribe('Spanish');
};

class Spanish {
    protected $settings;

    public function __construct(SettingsRepositoryInterface $settings) {
        $this->settings = $settings;
    }

    public function subscribe(Dispatcher $events) {
        $events->listen(ConfigureClientView::class, [$this, 'addSettingsPage']);
        $events->listen(ConfigureLocales::class, [$this, 'addLocale']);
    }

    public function addSettingsPage(ConfigureClientView $event) {
        if ($event->isAdmin()) {
            $event->addAssets([
                __DIR__ . '/js/admin/dist/extension.js'
            ]);
            $event->addBootstrapper('flarumes/spanish/main');
        }
    }

    public function addLocale(ConfigureLocales $event) {
        $name = $title = basename(__DIR__);

        if (file_exists($manifest = __DIR__.'/composer.json')) {
            $json = json_decode(file_get_contents($manifest), true);

            if (empty($json)) {
                throw new RuntimeException("Error parsing composer.json in $name: ".json_last_error_msg());
            }

            $locale = array_get($json, 'extra.flarum-locale.code');
            $title = array_get($json, 'extra.flarum-locale.title', $title);
        }

        if (! isset($locale)) {
            throw new RuntimeException("Language pack $name must define \"extra.flarum-locale.code\" in composer.json.");
        }

        $event->locales->addLocale($locale, $title);
        $mode = $this->settings->get('flarumes-spanish.mode') ? $this->settings->get('flarumes-spanish.mode') : 'formal';

        if (! is_dir($localeDir = __DIR__.'/locale/' . $mode)) {
            throw new RuntimeException("Language pack $name must have a \"locale\" subdirectory.");
        }

        if (file_exists($file = $localeDir.'/config.js')) {
            $event->locales->addJsFile($locale, $file);
        }

        foreach (new DirectoryIterator($localeDir) as $file) {
            if ($file->isFile() && in_array($file->getExtension(), ['yml', 'yaml'])) {
                $event->locales->addTranslations($locale, $file->getPathname());
            }
        }
    }
}