<?php

Lib::Import('mysql/mysql_pool');

Config::Import('mysql');

class AppResource extends Resource {
    /**
     * @var MySQLDatabase
     */
    public $database;

    public function __construct($properties = array()) {
        parent::__construct($properties);

        $this->init_vars();

        $this->database = MySQLPool::$singleton->database(Config::$Configs['mysql']);

        $b = new MySQLQueryBenchmark($this->database);
        $this->database->installBenchmarker($b);

        $language = 'english';

        $timezone = Config::$Configs['application']['server_timezone'];

        $userModel = AuthenticationService::$singleton->user;

        if(null !== $userModel) {
            $language = $userModel->preferences->language;

            $timezone = empty($userModel->preferences->timezone) ? Config::$Configs['application']['server_timezone'] : $userModel->preferences->timezone;
        }

        LanguageLocalizer::$singleton->push_language($language);
        TimezoneLocalizer::$singleton->push_timezone($timezone);
    }

    public function smart_redirect($url) {
        if($this->request->async) {
            $url = json_encode($url);

            return new Response(array(
                'body' => <<<HTML
<script type="text/javascript">
document.location = $url;
</script>
HTML
            ));
        }

        return new RedirectResponse(array(
            'location' => $url
        ));
    }

    public function first_truth() {
        $arguments = func_get_args();

        foreach($arguments as $arg) {
            if(!empty($arg)) {
                return $arg;
            }
        }

        return null;
    }

    public function message_box($title, $message, $buttons = array(), $after = null) {
        if(empty($buttons)) {
            $buttons = array('ok' => array(
                'text' => 'OK'
            ));
        }

        return new AppViewResponse($this, array(
            'view' => 'messagebox',
            'layout' => 'ajax',
            'variables' => array(
                'title' => $title,
                'message' => $message,
                'buttons' => $buttons,
                'after' => null === $after ? '' : $after
            )
        ));
    }

    public function generic_prompt($title, $message, $yes, $no = null, $cancel = false, $after = null) {
        $buttons = array();

        if($yes !== false) {
            $buttons['yes'] = array(
                'text' => 'Yes',
                'color' => 'FlatBlue',
                'click' => null === $yes ? '' : $yes
            );
        }

        if($no !== false) {
            $buttons['no'] = array(
                'text' => 'No',
                'color' => 'FlatRed',
                'click' => null === $no ? '' : $no
            );
        }

        if($cancel !== false) {
            $buttons['cancel'] = array(
                'text' => 'Cancel',
                'color' => 'FlatGrey',
                'click' => null === $cancel ? '' : $cancel
            );
        }

        return $this->message_box($title, $message, $buttons, $after);
    }

    public function generic_dialog($title = 'Notice', $message = 'There was an issue with your request.', $click = null, $after = null) {
        return $this->message_box($title, $message, array(
            'ok' => array(
                'text' => 'OK',
                'click' => null === $click ? '' : $click
            )
        ), $after);
    }

    public function first_key($a) {
        $keys = array_keys($a);

        return $keys[0];
    }

    public function first_error($errors) {
        return $errors[$this->first_key($errors)][0];
    }

    public function generic_error($errors, $after = null){
        $after = null === $after ? '' : $after;

        $first_key = $this->first_key($errors);

        return $this->generic_dialog(lang_get('message_box_error_title'), $this->first_error($errors), <<<JS
$('#{$first_key},:input[name="{$first_key}"]').eq(0).focus();

{$after}

JS
        );
    }

    public function parse_float_from_usd($usd) {
        $usd = str_replace('$', '', $usd);

        return (float)$usd;
    }

    public function init_vars() {
    }
}