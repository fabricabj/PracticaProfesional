<?php 
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php'; 
require 'conexion.php';
include 'pdf/plantilla.php';
if (isset($_SESSION['venta']) && !empty($_SESSION['venta'])) {
	$idVenta=$_SESSION['venta'];
	$fechaP=date('d/m/Y');
	$pdf= new PDF();	
	$pdf->AddPage();
	$pdf->AliasNbPages();
//declaracion de numero de Factura	
	$querynFact="SELECT v.idventa,u.nombre_usuario,v.fecha_venta
	FROM `ventas` AS v
	JOIN usuarios AS u ON u.idusuario=v.idusuario
	WHERE idventa = (
	SELECT MAX(idventa) 
	FROM `ventas` )";
	$rsnFact=mysqli_query($conexion,$querynFact);
	
	while ($rn=mysqli_fetch_array($rsnFact)) {
		$nombre_usuario=$rn['nombre_usuario'];
		$idventa=$rn['idventa'];
		$fecha_compra=$rn['fecha_venta'];
		$filename='FacturaVenta_n°_'.$idventa;
	}
	$fecha=date('d/m/Y',strtotime($fecha_compra));
	
	$pdf->SetFillColor(255,255,255);
	
    $cliente=$_SESSION['login'];
	$nombreC=mysqli_query($conexion,"SELECT mail from usuarios WHERE idusuario=$cliente");
    while ($r=mysqli_fetch_array($nombreC)) {
	$email=$r['mail'];
};
	

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(75,5,'Cliente: '.$nombre_usuario,0,0,'i',1);
	$pdf->Cell(20,5,'',0,0,'C',1);
	$pdf->Cell(10,5,'',0,0,'C',1);
	$pdf->Cell(70,5,'Nro Factura: '.$idventa,0,1,'i',1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(75,5,'',0,0,'i',1);
	$pdf->Cell(20,5,'',0,0,'C',1);
	$pdf->Cell(10,5,'',0,0,'C',1);
	$pdf->Cell(70,5,'',0,1,'i',1);
	

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(75,5,'',0,0,'C',1);
	$pdf->Cell(20,5,'',0,0,'C',1);
	$pdf->Cell(10,5,'',0,0,'C',1);
	$pdf->Cell(70,5,'Fecha de emision: '.$fecha,0,1,'i',0);
	

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(75,5,'',0,0,'C',1);
	$pdf->Cell(20,5,'',0,0,'C',1);
	$pdf->Cell(10,5,'',0,0,'C',1);
	$pdf->Cell(70,5,'C.U.I.T: 30367483238',0,1,'i',0);
	

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(75,5,'',0,0,'C',1);
	$pdf->Cell(20,5,'',0,0,'C',1);
	$pdf->Cell(10,5,'',0,0,'C',1);
	$pdf->Cell(70,5,'',0,1,'i',0);
	$pdf->SetFillColor(0,0,0);
  

	


//$pdf->Cell(33,6,"Tipo Factura : ".$tFact,0,0,'C',0);
//Datos Cliente

/*$y= $pdf->GetY();
$pdf->setXY(15,50);
$pdf->SetFillColor(232,232,232);
$pdf->Cell(45,6,"Cliente : ".$ncliente,0,0,'C',0);
//Dirreccion de entrega
$calle=$_SESSION['calle'];
$altura=$_SESSION['altura'];

$y=$pdf->GetY();
$pdf->Ln(6);
$pdf->SetFillColor(232,232,232);
$pdf->Cell(78,6,"Domicilio de Entrega : ".$calle." ".$altura,0,0,'C',0);*/

$pdf->Ln(10);
$pdf->SetFillColor(134, 175, 0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(75,10,'Pelicula',0,0,'C',1);
$pdf->Cell(20,10,'',0,0,'C',1);
$pdf->Cell(40,10,'Importe',0,0,'C',1);
$pdf->Cell(40,10,'',0,0,'C',1);



$pdf->Ln(12);
$totalC=0;
$queryFD="SELECT p.titulo,p.precio  from peliculas AS p JOIN venta_detalles as vd on vd.idpelicula=p.idpelicula where vd.idventa=$idventa";
$rsFD=mysqli_query($conexion,$queryFD);

while($rf=mysqli_fetch_array($rsFD)){ 
	
    $Total=number_format((float)$rf['precio'], 2, '.', '');
	$pdf->Ln(4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',8);
    $pdf->Cell(75,10,utf8_decode($rf['titulo']),0,0,'C',1);
	$pdf->Cell(20,10,'',0,0,'C',1);
    $pdf->Cell(40,10,'$'.$rf['precio'],0,0,'C',1);
$pdf->Cell(40,10,'',0,0,'C',1);


$totalC+=$Total;
$pdf->Ln(4);
}
$pdf->Ln(5);


$pdf->Cell(75,10,'',0,0,'C',1);
$pdf->Cell(20,10,'',0,0,'C',1);
//$pdf->Cell(40,10,"subtotal",0,0,'C',1);
//$pdf->Cell(40,10,'$'.number_format((float)$totalC, 2, '.', ''),0,0,'C',1);
$pdf->Ln(7);
//$IVA=number_format((float)($totalC*21)/100, 2, '.', '');
$pdf->Cell(75,10,'',0,0,'C',1);
$pdf->Cell(20,10,'',0,0,'C',1);
//$pdf->Cell(40,10,"IVA 21.0%",0,0,'C',1);
$pdf->Cell(40,10,'',0,0,'C',1);
$pdf->Ln(9);
//$total=number_format((float)$totalC+$IVA, 2, '.', '');
$pdf->Cell(75,10,'',0,0,'C',1);
$pdf->Cell(20,10,'',0,0,'C',1);
$pdf->Cell(40,10,'Total: $'.$totalC,0,0,'C',1);
$pdf->Cell(40,10,'',0,0,'C',1);
$pdf->Ln(16);
$pdf->Cell(175,0,'',1,0,'C',1);


$doc=$pdf->Output('','S');
$mail = new PHPMailer(true);
$mensaje="Factura de compra";
try {
	//Server settings
	$mail->SMTPDebug = 0;                      // Enable verbose debug output
	$mail->isSMTP();                                            // Send using SMTP
	$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
	$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	$mail->Username   = 'aflcinema1@gmail.com';                     // SMTP username
	$mail->Password   = 'ohiczseicwwbodvh';                             // SMTP password
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);                              
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	//Recipients
	$mail->setFrom('aflcinema1@gmail.com', 'noReply');
	$mail->addAddress($email);     // Add a recipient
	//$mail->addAddress('ellen@example.com');               // Name is optional
	

	// Attachments
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	// Content
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->Subject = 'Factura por su compra';
	$mensajeHtml = nl2br($mensaje);
	$mail->Body  = "<html> 
	<head>
	<meta charset='utf-8'>
	</head>
	<body> 
	<h1 style='background:#ffe0b2;color:white;' align='center'>Afl Cinema</h1>

	<p>Se adjunta pdf de la compra realizada</p>
    <p>Link de peliculas: https://graciasporsucompra.com.ar

	</body> 
	</html>
	<br />";
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	$mail->AddStringAttachment($doc, $filename.'.pdf', 'base64', 'application/pdf');

	$mail->send();
	$pdf->Output('i',$filename.'.pdf');
} catch (Exception $e) {
	// echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	header("location:index.php?recuperar=2");
	exit();
}
	header("location:index.php");
}
?>