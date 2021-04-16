<?php
    $pdf_file_name = strtolower( str_replace( " ", "-", $attendee_name ) );
    $pdf           = new \Etn\Utils\FPDF();
    $pdf->AddPage();
    $pdf->SetFont( 'Arial', 'B', 16 );
    // html
    $pdf->Cell( 80, 15, esc_html__( "Event details:", "eventin" ), 0, 0, 'L', 0 );
    $pdf->ln();
    $pdf->SetFont( '', 'B', 10 );
    $pdf->Cell( 40, 5, esc_html__( "Event name:", "eventin" ), 0, 0, 'L', 0 );
    $pdf->Cell( 80, 5, $event_name, 0, 1, 'L', 0 );
    $pdf->ln();

    $pdf->Cell( 40, 5, esc_html__( "Start date :", "eventin" ), 0, 0, 'L', 0 );
    $pdf->Cell( 80, 5, $start_date, 0, 1, 'L', 0 );
    $pdf->Cell( 40, 5, esc_html__( "End date :", "eventin" ), 0, 0, 'L', 0 );
    $pdf->Cell( 80, 5, $end_date, 0, 1, 'L', 0 );
    $pdf->ln();

    $pdf->Cell( 40, 5, esc_html__( "Start time :", "eventin" ), 0, 0, 'L', 0 );
    $pdf->Cell( 80, 5, $start_time, 0, 1, 'L', 0 );
    $pdf->Cell( 40, 5, esc_html__( "End time :", "eventin" ), 0, 0, 'L', 0 );
    $pdf->Cell( 80, 5, $end_time, 0, 1, 'L', 0 );
    $pdf->ln();
    $pdf->Cell( 40, 5, esc_html__( "Location:", "eventin" ), 0, 0, 'L', 0 );
    $pdf->Cell( 80, 5, $event_location, 0, 1, 'L', 0 );
    $pdf->ln();
    $pdf->Cell( 40, 5, esc_html__( "Ticket price:", "eventin" ), 0, 0, 'L', 0 );
    $pdf->Cell( 80, 5, $ticket_price, 0, 1, 'L', 0 );

    $pdf->SetFont( '', 'B', 16 );
    $pdf->Cell( 80, 15, esc_html__( "Attendee details:", "eventin" ), 0, 0, 'L', 0 );

    $pdf->SetFont( '', 'B', 10 );
    $pdf->ln();
    $pdf->Cell( 40, 5, esc_html__( "Name:", "eventin" ), 0, 0, 'L', 0 );
    $pdf->Cell( 80, 5, $attendee_name, 0, 1, 'L', 0 );
    
    if( $include_email  ){
        $pdf->ln();
        $pdf->Cell( 40, 5, esc_html__( "Email:", "eventin" ), 0, 0, 'L', 0 );
        $pdf->Cell( 80, 5, $attendee_email, 0, 1, 'L', 0 );
    }
    if( $include_phone  ){
        $pdf->ln();
        $pdf->Cell( 40, 5, esc_html__( "Phone:", "eventin" ), 0, 0, 'L', 0 );
        $pdf->Cell( 80, 5, $attendee_phone, 0, 1, 'L', 0 );
    }


    $pdf->Output( "D", $pdf_file_name . ".pdf" );