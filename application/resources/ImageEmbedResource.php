<?php

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

class ImageEmbedResource extends AppResource {
    public function execute() {
        $campaign = ViewQueryFactory::$singleton->getCampaignModelByShortUrl($this->route->named['short_url']);

        $bg_color = empty($_GET['bg_color']) ? BusinessRules::$singleton->default_bg_color : $_GET['bg_color'];
        $text_color = empty($_GET['text_color']) ? BusinessRules::$singleton->default_text_color : $_GET['text_color'];
        $font_size = empty($_GET['font_size']) ? BusinessRules::$singleton->default_font_size : (int)$_GET['font_size'];
        $input_width = empty($_GET['width']) ? null : (int)$_GET['width'];
        $input_height = empty($_GET['height']) ? null : (int)$_GET['height'];
        $kerning = empty($_GET['kerning']) ? 2 : (int)$_GET['kerning'];
        $est_width_delta = empty($_GET['est_width_delta']) ? 0 : (int)$_GET['est_width_delta'];
        $est_height_delta = empty($_GET['est_height_delta']) ? 0 : (int)$_GET['est_height_delta'];
        $x = empty($_GET['x']) ? 0 : (int)$_GET['x'];
        $y = empty($_GET['y']) ? 0 : (int)$_GET['y'];
        $padding_x = empty($_GET['padding_x']) ? 0 : (int)$_GET['padding_x'];
        $padding_y = empty($_GET['padding_y']) ? 0 : (int)$_GET['padding_y'];

        $format = empty($_GET['format']) ?
            (empty($campaign->goal_usd) ? '{total_usd}' : '{total_usd} / {goal_usd}') : $_GET['format'];

        if(null === $campaign) {
            return new NotFoundResponse($this);
        }

        $string = str_replace('{br}', "\n", $format);
        $string = str_replace('{total_usd}', '$' . number_format($campaign->total_usd, 2), $string);
        $string = str_replace('{goal_usd}', '$' . number_format($campaign->goal_usd, 2), $string);
        $strings = explode("\n", $string);

        $longest_line_count = 0;

        foreach($strings as $str) {
            $len = strlen($str);

            $longest_line_count = $len > $longest_line_count ? $len : $longest_line_count;
        }

        return new Response(array(
            'headers' => array(
                'Content-Type' => 'image/png'
            ),
            'body' => ViewRenderingService::$singleton->renderView('ImageEmbedTool',
                array('campaign' => $campaign, 'bg_color' => $bg_color, 'text_color' => $text_color,
                    'font_size' => $font_size, 'input_width' => $input_width, 'input_height' => $input_height,
                    'strings' => $strings, 'kerning' => $kerning, 'longest_line_count' => $longest_line_count,
                    'est_width_delta' => $est_width_delta, 'est_height_delta' => $est_height_delta,
                    'x' => $x, 'y' => $y, 'padding_x' => $padding_x, 'padding_y' => $padding_y))
        ));
    }
}