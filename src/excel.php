<?php
/**
 * Created by PhpStorm.
 * User: Aaji
 * Date: 11/09/2019
 * Time: 12:49
 */

error_reporting(~E_NOTICE);

/*$filename = "logbook " . date("YmdHi") . ".xls";
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=" . $filename);  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);*/


$column = require_once("_column_export_excel.php");
?>


<table border="1" style="border-collapse: collapse">
    <thead id="table-header">
    <tr>
        <td style="text-align: center"><strong>NO</strong></td>
        <?php
        foreach ($column as $item) {
            echo '<td style="text-align: center"><strong>' . $item["label"] . '</strong></td>';
        }
        ?>
    </tr>
    </thead>
    <tbody id="table-body">
    <?php
    $i = 1;
    foreach ($data as $row) {
        echo '<tr><td>' . $i++ . '</td>';
        foreach ($column as $item) {
            if ($item['visible'] == 'hide') {
            } else {
                echo '<td>' . $row[$item["attribute"]] . '</td>';
            }
        }
        echo '</tr>';
    }
    ?>
    </tbody>
</table>
