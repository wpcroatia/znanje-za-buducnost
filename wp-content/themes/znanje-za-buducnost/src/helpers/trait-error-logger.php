<?php
/**
 * The object helper specific functionality for errors.
 *
 * @since   1.0.0
 * @package Znanje_za_buducnost\Helpers
 */

namespace Znanje_za_buducnost\Helpers;

/**
 * Error logger trait.
 *
 * @since 1.0.0
 */
trait Error_Logger {

  /**
   * Ensure correct response for rest using handler function.
   *
   * @param integer     $code   Response Status code.
   * @param string      $status Response Status name. (success/error).
   * @param string|null $msg    Response Message.
   * @param array|null  $data   Response additional data.
   *
   * @return \WP_Error|array \WP_Error instance with error message and status or array.
   */
  public function rest_response_handler( int $code, string $status, ?string $msg, ?array $data = null ) {
    $output = [
      'code'    => $code,
      'status'  => $status,
      'message' => $msg,
      'data'    => $data,
    ];

    if ( $code === 404 ) {
      return \rest_ensure_response( new \WP_Error( $output ) );
    }

    if ( $code === 200 ) {
      return \rest_ensure_response( wp_send_json_success( $output, $code ) );
    }

    return \rest_ensure_response( wp_send_json_error( $output, $code ) );
  }
}
