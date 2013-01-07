<?php

class ViewRenderingService extends Extendable {
    /**
     * @var ViewRenderingService
     */
    public static $singleton = null;

    public static function changeSingleton(ViewRenderingService $s) {
        self::$singleton = $s;
    }

    public function __construct($properties = array()) {
        parent::__construct($properties);
    }

    public function renderView($view, $variables = array(), $layout = array()) {
        $viewResponse = new ViewResponse(array(
            'view' => $view,
            'layout' => $layout,
            'variables' => $variables
        ));

        ob_start();
        $viewResponse->render();
        $viewContents = ob_get_contents();
        ob_end_clean();

        return $viewContents;
    }
}

if(ViewRenderingService::$singleton === null) {
    ViewRenderingService::changeSingleton(new ViewRenderingService());
}