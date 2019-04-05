<?

require_once("dompdf/dompdf_config.inc.php");
require_once("db_connect.php");


$query = "SELECT * FROM list";
echo $query;
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) ;
//var_dump($data);

$html =
'<html><meta http-equiv="content-type" content="text/html; charset=utf-8" /><body>'.
'<img src=.'.  $data['0']['title'] .'>'.
/*'<p>' . $data['0']['title'] .'</p>'.*/
'<p>herny !</p>'.
'</body></html>';

echo $html;


$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('mypdf.pdf'); // Выводим результат (скачивание)

