<?php
/**
 * @file views-tablesorter-view-tablesorter.tpl.php
 * Template to display a view as a table sortable using the
 * tablesorter jQuery plugin.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $class: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * - $pager: The pager if it is required.
 * - $col_count: The number of columns in the table.
 * - $message: The message to display when sorting.  May be empty.
 * @ingroup views_templates
 */
?>
<?php if (!empty($message)): ?>
  <div id="views-tablesorter-sort-msg">
    <?php print $message; ?>
  </div>
<?php endif; ?>
<table class="<?php print $class; ?>">
  <?php if (!empty($title)): ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>
  <thead>
    <tr>
      <?php foreach ($header as $field => $label): ?>
        <th class="views-field views-field-<?php print $fields[$field]; ?>">
          <?php print $label; ?>
        </th>
      <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $count => $row): ?>
      <tr class="<?php print implode(' ', $row_classes[$count]); ?>">
        <?php foreach ($row as $field => $content): ?>
          <td class="views-field views-field-<?php print $fields[$field]; ?>">
            <?php print $content; ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>

  <?php if ($pager): ?>
    <tfoot>
      <tr class="pager">
        <td colspan=<?php print $col_count; ?>>
          <?php print $pager; ?>
        </td>
      </tr>
    </tfoot>
  <?php endif; ?>
</table>
