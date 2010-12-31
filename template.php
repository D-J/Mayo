<?php
// $Id$

/**
 * @file
 * Contains theme override functions and preprocess functions
 */

/**
 * Return a themed breadcrumb links
 *
 * @param $breadcrumb
 *  An array containing the breadcrumb links.
 * @return
 *  A string containing the breadcrumb output.
 */
function mayo_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  // remove 'Home'
  if (is_array($breadcrumb)) {
    array_shift($breadcrumb);
  }
  if (!empty($breadcrumb)) {
    $breadcrumb_separator = ' > ';
    $breadcrumb_str = implode($breadcrumb_separator, $breadcrumb);
    $breadcrumb_str .= $breadcrumb_separator;
    $out = '<div class="breadcrumb">' . $breadcrumb_str . '</div>';
    return $out;
  }
  return '';
}
    
/**
 * Custom search block form
 *  No 'submit button'
 *  Use javascript to show/hide the 'search this site' prompt inside of the text field
 */
function mayo_preprocess_search_block_form(&$variables) {
  $prompt = t('search this site');
  $variables['search'] = array();
  $hidden = array();

  unset($variables['form']['actions']['submit']);
  unset($variables['form']['actions']['#children']);

  $variables['form']['search_block_form']['#value'] = $prompt;
  $variables['form']['search_block_form']['#size'] = 28;
  $variables['form']['search_block_form']['#attributes'] = array(
    'onblur'  => "if (this.value == '') { this.value = '$prompt'; }",
    'onfocus' => "if (this.value == '$prompt') { this.value = ''; }" );

  // we should use 'render' instead of 'drupal_render' since the form is already rendered once.
  foreach (element_children($variables['form']) as $key) {
    $type = $variables['form'][$key]['#type'];
    if ($type == 'hidden' || $type == 'token') {
      $hidden[] = render($variables['form'][$key]);
    }
    else {
      $variables['search'][$key] = render($variables['form'][$key]);
    }
  }
  $variables['search']['hidden'] = implode($hidden);
  $variables['search_form'] = implode($variables['search']);
}

/**
 * Implements hook_process_page().
 */
function mayo_process_page(&$variables) {
  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($variables);
  }
}

/**
 * Implements hook_preprocess_maintenance_page().
 */
function mayo_preprocess_maintenance_page(&$variables) {
  drupal_add_css(drupal_get_path('theme', 'mayo') . '/css/maintenance-page.css');
}

/**
 * Implements hook_preprocess_html().
 */
function mayo_preprocess_html(&$variables) {

  // Add conditional stylesheet for IE
  drupal_add_css(path_to_theme() . '/css/ie.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 8', '!IE' => FALSE), 'preprocess' => FALSE));
  drupal_add_css(path_to_theme() . '/css/ie6.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'IE 6', '!IE' => FALSE), 'preprocess' => FALSE));

  $options = array(
    'type' => 'file',
    'group' => CSS_THEME,
    'weight' => 10,
  );

  // Add optional stylesheets

  if (theme_get_setting('dark_messages')) {
    // add dark.css if it's selected at the theme setting page.
    drupal_add_css(drupal_get_path('theme', 'mayo') . '/css/dark.css', $options);
  }

  $round_corners = theme_get_setting('round_corners');
  if ($round_corners == 1 || $round_corners == 3) {
    drupal_add_css(drupal_get_path('theme', 'mayo') . '/css/round-sidebar.css', $options);
  }
  if ($round_corners == 2 || $round_corners == 3) {
    drupal_add_css(drupal_get_path('theme', 'mayo') . '/css/round-node.css', $options);
  }

  if (theme_get_setting('menubar_style') == 2) {
    drupal_add_css(drupal_get_path('theme', 'mayo') . '/css/black-menu.css', $options);
  }

  $options = array(
    'type' => 'inline',
    'group' => CSS_THEME,
    'weight' => 10,
  );

/*
  $font_family = array(
    0 => "font-family: Georgia, 'Palatino Linotype', 'Book Antiqua', 'URW Palladio L', Baskerville, serif; ",
    1 => "font-family: Verdana, Geneva, Arial, 'Bitstream Vera Sans', 'DejaVu Sans', sans-serif; ",
  );
*/
  $font_family = array(
    // Added Japanese font support
    0 => "font-family: Georgia, 'Palatino Linotype', 'Book Antiqua', 'URW Palladio L', Baskerville, Meiryo, 'Hiragino Mincho Pro', 'MS PMincho', serif; ",
    1 => "font-family: Verdana, Geneva, Arial, 'Bitstream Vera Sans', 'DejaVu Sans', Meiryo, 'Hiragino Kaku Gothic Pro', 'MS PGothic', Osaka, sans-serif; ",
  );

  // Add font related stylesheets
  $base_font_size = theme_get_setting('base_font_size');
  $style = 'font-size: ' . $base_font_size . '; ';
  $base_font_family = theme_get_setting('base_font_family');
  $style .= $font_family[$base_font_family];
  drupal_add_css("body {" . $style . "}", $options);

  $heading_font_family = theme_get_setting('heading_font_family');
  $style = $font_family[$heading_font_family];
  drupal_add_css("h1,h2,h3,h4,h5 {" . $style . "}", $options);

  if ($heading_font_family == 1) {
    // in case of san-serif fonts, make heading font sizes slightly smaller
    drupal_add_css(".sidebar h2 { font-size: 1.2em; }", $options);
    drupal_add_css("#content .node h2 { font-size: 1.4em; }", $options);
  }
}

/**
 * Implements hook_process_html().
 */
function mayo_process_html(&$variables) {
  // Hook into color.module
  if (module_exists('color')) {
    _color_html_alter($variables);
  }
}
