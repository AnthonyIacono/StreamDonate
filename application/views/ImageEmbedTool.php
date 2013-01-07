<?php
/**
 * @var CampaignModel $campaign
 */

$rgb_bg_color = hex2rgb($bg_color);
$rgb_text_color = hex2rgb($text_color);

$est_width_per_char = $font_size * 0.78;

$est_width = ($est_width_per_char * $longest_line_count) + ($padding_x * 2);
$est_height = ((count($strings) - 1) * ($font_size + $kerning)) + $font_size + ($padding_y * 2);

$est_width += $est_width_delta;
$est_height += $est_height_delta;

$real_width = max($est_width, (int)$input_width);
$real_height = max($est_height, (int)$input_height);

$image = imagecreatetruecolor ($real_width,$real_height);
$bg_color_resource = imagecolorallocate ($image,$rgb_bg_color[0],$rgb_bg_color[1],$rgb_bg_color[2]);
$text_color_resource = imagecolorallocate ($image,$rgb_text_color[0], $rgb_text_color[1], $rgb_text_color[2]);
imagefill($image,0,0,$bg_color_resource);

$font_file = Config::$Configs['application']['paths']['fonts'] . 'ariblk.ttf';

$x += $padding_x;
$y += $padding_y;

$y += $font_size;

foreach($strings as $str) {
    imagettftext($image, $font_size, 0, $x, $y, $text_color_resource, $font_file, $str);
    $y += $font_size + $kerning;
}

imagepng($image);
imagedestroy($image);