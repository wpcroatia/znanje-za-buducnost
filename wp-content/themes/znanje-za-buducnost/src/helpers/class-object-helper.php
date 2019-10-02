<?php
/**
 * The object helper specific functionality inside classes.
 * Used in admin or theme side but only inside a class.
 *
 * @since   1.0.0
 * @package Znanje_za_buducnost\Helpers
 */

namespace Znanje_za_buducnost\Helpers;

/**
 * Class Object Helper
 *
 * @since 1.0.0
 */
trait Object_Helper {

  /**
   * Check if XML is valid file used for svg.
   *
   * @param xml $xml Full xml document.
   * @return boolean
   *
   * @since 1.0.0
   */
  public function is_valid_xml( $xml ) {
    libxml_use_internal_errors( true );
    $doc = new \DOMDocument( '1.0', 'utf-8' );
    $doc->loadXML( $xml );
    $errors = libxml_get_errors();
    return empty( $errors );
  }

  /**
   * Check if json is valid
   *
   * @param string $string String to check.
   *
   * @return boolean
   *
   * @since 1.0.0
   */
  public static function is_json( $string ) {
    json_decode( $string );
    return ( json_last_error() === JSON_ERROR_NONE );
  }
}
