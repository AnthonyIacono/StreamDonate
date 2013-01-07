<?php

Config::Import('lang');

class LanguageLocalizer extends Extendable {
    /**
     * @var LanguageLocalizer
     */
    public static $singleton = null;

    public static function changeSingleton(LanguageLocalizer $s) {
        self::$singleton = $s;
    }

    public $stack = array();
    public $phrases = array();

    public function push_language($lang) {
        $this->stack[] = $lang;
    }

    public function get_current_language() {
        if(empty($this->stack)) {
            return 'english';
        }

        return $this->stack[count($this->stack) - 1];
    }

    public function pop_language() {
        if(empty($this->stack)) {
            return;
        }

        $this->stack = array_slice($this->stack, 0, count($this->stack) - 1);
    }

    public function get_phrase($phrase, $language = null) {
        $language = $language === null ? $this->get_current_language() : $language;

        if(empty(Config::$Configs['lang'][$language][$phrase])) {
            return 'needs_translation_' . $phrase . '_' . $language;
        }

        return Config::$Configs['lang'][$language][$phrase];
    }
}

if(LanguageLocalizer::$singleton === null) {
    LanguageLocalizer::changeSingleton(new LanguageLocalizer());
}

function lang_get($phrase, $language = null, $languageLocalizer = null) {
    $languageLocalizer = $languageLocalizer === null ?
        LanguageLocalizer::$singleton : $languageLocalizer;

    return $languageLocalizer->get_phrase($phrase, $language);
}