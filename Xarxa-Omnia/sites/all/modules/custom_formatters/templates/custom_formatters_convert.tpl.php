<?php
// $Id: custom_formatters_convert.tpl.php,v 1.1.2.1 2010/06/09 10:41:10 deciphered Exp $
/**
 * @file
 * Theme for Custom Formatters Convert.
 *
 * Available variables:
 * - $code: A string containing the formatter code for conversion.
 */
?>
$code = "<?php print addslashes($code); ?>";

// Parse tokens.
return _custom_formatters_token_replace((object) array('code' => $code, 'field_types' => $element['#formatter']->field_types), $element);<?
