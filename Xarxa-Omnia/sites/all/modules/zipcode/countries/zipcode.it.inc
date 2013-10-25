<?php

// Copyright 2010 Thierry GUEGAN http://www.arvoriad.com

/**
 * @file
 * CCK Field for Italian zipcodes.
 */

/**
 * Verification for Italian zipcodes.
 *
 * @param string $text
 * @return boolean Returns boolean FALSE if the zipcode is not valid.
 * On success, returns a string containting the zipcode with some formatting.
 */
function valid_it_zipcode($zipcodestring) {
  $zipcodestring = drupal_strtoupper(trim($zipcodestring));

  if (!preg_match("/^(V-|I-|IT-)?[0-9]{5}$/", $zipcodestring)) {
    return FALSE;
  }
  //right now just do a quick check ==> has to be improved
  //need to check more precisely by doing a query on a zipcode table, ...
  else {
    return TRUE;
  }
}

/**
 * Formatting for zipcode.
 *
 * @param string $zipcodestring
 * @return string Returns a string containting the zipcode with some formatting.
 */
function format_it_zipcode($zipcodestring) {
  $zipcodestring = trim($zipcodestring);
  //do some formatting
  return $zipcodestring;
}
