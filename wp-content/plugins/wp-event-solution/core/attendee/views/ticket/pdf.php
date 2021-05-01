<?php

require_once ETN_DIR . '/utils/tfpdf.php';
$pdf_file_name  = strtolower( str_replace( " ", "-", $attendee_name ) );
$pdf            = new \Etn\Utils\tFPDF();
$pdf->AddPage();
$pdf->AddFont('DejaVu','', 'DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',18);

// html
$pdf->Cell( 80, 15, esc_html__( "Event details:", "eventin" ), 0, 0, 'L', 0 );
$pdf->ln();
$pdf->SetFont('DejaVu','',14);
$pdf->Cell( 40, 8, esc_html__( "Event name:", "eventin" ), 0, 0, 'L', 0 );
$pdf->Cell( 80, 8, $event_name, 0, 1, 'L', 0 );
$pdf->Cell( 40, 8, esc_html__( "Start date :", "eventin" ), 0, 0, 'L', 0 );
$pdf->Cell( 80, 8, $start_date, 0, 1, 'L', 0 );
$pdf->Cell( 40, 8, esc_html__( "End date :", "eventin" ), 0, 0, 'L', 0 );
$pdf->Cell( 80, 8, $end_date, 0, 1, 'L', 0 );
$pdf->Cell( 40, 8, esc_html__( "Start time :", "eventin" ), 0, 0, 'L', 0 );
$pdf->Cell( 80, 8, $start_time, 0, 1, 'L', 0 );
$pdf->Cell( 40, 8, esc_html__( "End time :", "eventin" ), 0, 0, 'L', 0 );
$pdf->Cell( 80, 8, $end_time, 0, 1, 'L', 0 );
$pdf->Cell( 40, 8, esc_html__( "Location:", "eventin" ), 0, 0, 'L', 0 );
$pdf->Cell( 80, 8, $event_location, 0, 1, 'L', 0 );
$pdf->Cell( 40, 8, esc_html__( "Ticket price:", "eventin" ), 0, 0, 'L', 0 );
$pdf->Cell( 80, 8, $ticket_price, 0, 1, 'L', 0 );


$pdf->ln();
$pdf->ln();
$pdf->Cell( 40, 8, '-----------------------------------------------------------------------------------------------------------------', 0, 0, 'L', 0 );
$pdf->Cell( 80, 8, '', 0, 1, 'L', 0 );
$pdf->ln();
$pdf->ln();

$pdf->SetFont('DejaVu','',18);
$pdf->Cell( 80, 15, esc_html__( "Attendee details:", "eventin" ), 0, 0, 'L', 0 );

$pdf->SetFont('DejaVu','',14);
$pdf->ln();
$pdf->Cell( 40, 8, esc_html__( "Name:", "eventin" ), 0, 0, 'L', 0 );
$pdf->Cell( 80, 8, $attendee_name, 0, 1, 'L', 0 );

if( $include_email  ){
    $pdf->Cell( 40, 8, esc_html__( "Email:", "eventin" ), 0, 0, 'L', 0 );
    $pdf->Cell( 80, 8, $attendee_email, 0, 1, 'L', 0 );
}
if( $include_phone  ){
    $pdf->Cell( 40, 8, esc_html__( "Phone:", "eventin" ), 0, 0, 'L', 0 );
    $pdf->Cell( 80, 8, $attendee_phone, 0, 1, 'L', 0 );
}


$pdf->Output( "D", $pdf_file_name . ".pdf" );