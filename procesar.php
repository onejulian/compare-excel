<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['file1']) && isset($_FILES['file2'])) {
    $file1 = $_FILES['file1']['tmp_name'];
    $file2 = $_FILES['file2']['tmp_name'];

    $spreadsheet1 = IOFactory::load($file1);
    $spreadsheet2 = IOFactory::load($file2);

    $sheet1Data = $spreadsheet1->getActiveSheet()->toArray();
    $sheet2Data = $spreadsheet2->getActiveSheet()->toArray();

    echo '<div id="navbar" style="position:fixed; top:0; left:0; background-color: white; padding: 10px; z-index: 1000;">
    <button id="btn1" style="background-color: green; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;"
     onclick="showTable(\'table1\', \'btn2\', \'btn1\')">Mostrar Excel 1</button>
    <button id="btn2" style="background-color: green; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; display: none;"
    onclick="showTable(\'table2\', \'btn1\', \'btn2\')">Mostrar Excel 2</button>
  </div>';

  echo '<div id="navbar2" style="position:fixed; top:0; right:0; background-color: white; padding: 10px; z-index: 1000;">
    <button style="background-color: green; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;"
     id="btn3" onclick="restart()">Reiniciar</button>
    </div>';

    echo "<div id='table1' style='display:none; margin-top: 70px;
    '><table border='1' style='border-collapse: collapse;'>";

    echo "<p id='loading' style='display:block;'>Cargando...</p>";
    foreach ($sheet1Data as $rowIndex => $row) {
        echo "<tr>";
        foreach ($row as $colIndex => $cell) {
            if (!isset($sheet2Data[$rowIndex][$colIndex])) {
                echo "<td style='background-color: red;'>$cell</td>";
                continue;
            }
            $cell2 = $sheet2Data[$rowIndex][$colIndex];
            if ($cell === $cell2) {
                echo "<td>$cell</td>";
            } else {
                echo "<td style='background-color: yellow;'>$cell</td>";
            }
        }
        echo "</tr>";
    }

    echo "</table></div>";


    echo "<div id='table2' style='display:none; margin-top: 70px;
    '><table border='1' style='border-collapse: collapse;'>";

    foreach ($sheet2Data as $rowIndex => $row) {
        echo "<tr>";
        foreach ($row as $colIndex => $cell) {
            if (!isset($sheet1Data[$rowIndex][$colIndex])) {
                echo "<td style='background-color: red;'>$cell</td>";
                continue;
            }
            $cell1 = $sheet1Data[$rowIndex][$colIndex];
            if ($cell === $cell1) {
                echo "<td>$cell</td>";
            } else {
                echo "<td style='background-color: orange;'>$cell</td>";
            }
        }
        echo "</tr>";
    }

    echo "</table></div>";
} else {
    echo "No se han subido los dos archivos";
}

?>

<script>
    function showTable(tableId, btnIdShow, btnIdHide) {
        document.getElementById('table1').style.display = 'none';
        document.getElementById('table2').style.display = 'none';

        document.getElementById(tableId).style.display = 'block';
        document.getElementById('loading').style.display = 'none';
        document.getElementById(btnIdShow).style.display = 'block';
        document.getElementById(btnIdHide).style.display = 'none';
    }
    showTable('table1', 'btn2', 'btn1');
    function restart(){
        const url = window.location.href;
        const newUrl = url.substring(0, url.lastIndexOf('/'));
        window.location.href = newUrl;        
    }
</script>