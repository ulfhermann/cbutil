<?php

/**
 * CSS minifier that is mainly based on regular expressions (since CSS is
 * relatively easy to parse).
 *
 * @author Johannes Wüller <jw@heimat.de>
 */
class CbCssMin {

   /**
    * Stores the unmodified css.
    */
   protected $input = '';

   /**
    * Minifies CSS.
    *
    * @param $css code
    * @return minified code
    */
   public static function minify($css) {
      $minifier = new CbCssMin($css);
      return $minifier->min();
   }

   /**
    * Creates a new minifier.
    *
    * @param $input code
    */
   public function __construct($input) {
      $this->input = $input;
   }

   /**
    * Does the actual minification.
    *
    * @return minified input
    */
   public function min() {
      $output = $this->input;

      // Remove comments.
      $output = preg_replace('/\/\*.*?\*\//s', '', $output);

      // Minimize whitespaces.
      $output = trim($output);
      $output = preg_replace('/\s\s+/', ' ', $output);

      // Remove spaces before and after semicolons, commas, colons, curly
      // braces, parens and the child selector.
      $output = preg_replace('/\s?([;,:\(\)\{\}\>])\s?/', '$1', $output);

      // The space after a media query "and" keyword is required, so put one
      // there to make sure that they will continue to work.
      $output = preg_replace('/\band\(/i', 'and (', $output);

      // Remove semicolons in front of a right curly brace.
      $output = str_replace(';}', '}', $output);

      return $output;
   }

}
