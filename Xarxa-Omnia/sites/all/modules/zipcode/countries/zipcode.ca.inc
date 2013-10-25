<?php

// Copyright 2008 Thierry GUEGAN http://www.arvoriad.com

/**
 * @file
 * CCK Field for Canadian zipcodes.
 */

/**
 * Verification for Canadian zipcodes.
 *
 * @param string $text
 * @return boolean Returns boolean TRUE if postal code is valid, otherwise FALSE.
 */
function valid_ca_zipcode($zipcodestring) {
  $zipcodestring = drupal_strtoupper(trim($zipcodestring));

  // Some letters are not used in postal codes, hence the complicated regex. See:
  // https://secure.wikimedia.org/wikipedia/en/wiki/Postal_codes_in_Canada#Number_of_possible_postal_codes
  if (preg_match('/^[ABCEGHJKLMNPRSTVXY][0-9][ABCEGHJKLMNPRSTVWXYZ] ?[0-9][ABCEGHJKLMNPRSTVWXYZ][0-9]$/', $zipcodestring)) {
    return TRUE;
  }
  else {
    return FALSE;
  }
}

/**
 * Formatting for zipcode.
 *
 * @param string $zipcodestring
 * @return string Returns a string containting the zipcode with some formatting.
 */
function format_ca_zipcode($zipcodestring) {
  $zipcodestring = drupal_strtoupper(trim($zipcodestring));

  //do some formatting
  if (drupal_strlen($zipcodestring) == 6) {
    $zipcodestring = drupal_substr($zipcodestring, 0, 3) . ' ' . drupal_substr($zipcodestring, 3, 3);
  }

  return $zipcodestring;
}
