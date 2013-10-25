<div class="filtres">

<?php

$title = 'Filtres de cerca';
$output = "<div class='filtre-form'>";

$output .= "<div id='filtre-anyinici' class='filtre'><div class='form-label'>" . $label[0] . " " . $row[0] . "</div>" . $box[0]; // Any d'inici del punt omnia
$output .= "<div id='filtre-municipi' class='filtre'><div class='form-label'>" . $label[1] . " " . $row[1] . "</div>" . $box[1] . "</td>"; // vegueria-comarca-municipi
$output .= "<div id='filtre-puntomnia' class='filtre'><div class='form-label'>" . $label[2] . " " . $row[2] . "</div>" . $box[2] . "</div>"; // Punt Omnia
$output .= "<div id='filtre-tipologia' class='filtre'><div class='form-label'>" . $label[3] . " " . $row[3] . "</div>" . $box[3] . "</div>"; // tipologia
$output .= "<div id='filtre-tipus' class='filtre'><div class='form-label'>" . $label[4] . " " . $row[4] . "</div>" . $box[4] . "</td>"; // punt o entitat?
$output .= "<div id='filtre-lliure' class='filtre'><div class='form-label'>" . $label[5] . " " . $row[5] . "</div>" . $box[5] . "</td>"; // cerca lliure
$output .= "<div id='filtre-boto'>".$row[6] . $box[6] . "</div>"; // submit button

$output .= "</div>";
$body = $output;

$fieldset = array(
  '#title' => $title,
  '#collapsible' => TRUE,
  '#collapsed' => FALSE,
  '#value' => $body);
print theme('fieldset', $fieldset);

?>

</div>

<br class="clear" />
