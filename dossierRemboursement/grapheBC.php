<?php

    require_once( "../Ressources/jpgraph-4.3.4/src/jpgraph.php" );
    require_once( "../Ressources/jpgraph-4.3.4/src/jpgraph_bar.php" );

    $grapheBC = new Graph( 1100 , 500 , "auto" );
    $grapheBC->SetScale( "textlin" );
    $grapheBC->SetTheme( new UniversalTheme );
    $grapheBC->title->Set( "Bon Caisse en ".$_GET["annee"] );
    $grapheBC->yaxis->SetTickPositions( array( 0 , 1 , 20 , 40 , 60 , 80 , 100 , 120 ) , array( 10 , 30 , 50 , 70 , 90 , 110 ) );
    $grapheBC->SetBox( false );

    $grapheBC->ygrid->SetFill( false );
    $grapheBC->xaxis->SetTickLabels( array( "Janvier" , "Février" , "Mars" , "Avril" , "Mai" , "Juin" , "Juillet" , "Aout" , "Septembre" , "Octobre" , "Novembre" , "Decembre" ) );
    $grapheBC->yaxis->HideTicks( false , false );

    require_once( "../Modeles/connexion.php" );
    require_once( "../Fonctions/tableauBCParAnnee.php" );

    $tableauBCArrivee = tableauBCParAnnee( $connexionMySQLi , "arrivee" );
    $tableauBCDelivre = tableauBCParAnnee( $connexionMySQLi , "delivre" );

    //INSERTION DE DONNEES ALEATOIRES POUR TEST ET VISUALISATION
    $tableauBCArrivee = array( 0 , 0 , 79 , 86 , 56 , 14 , 0 , 0 , 0 , 0 , 0 , 0 );
    $tableauBCDelivre = array( 60 , 52 , 72 , 45 , 26 , 103 , 0 , 0 , 0 , 0 , 0 , 0 );
    //FIN INSERTION ALEATOIRES
    
    $barPlotArrivee = new BarPlot( $tableauBCArrivee );
    $barPlotDelivre = new BarPlot( $tableauBCDelivre );
    
    $grapheBC->Add( new GroupBarPlot( array( $barPlotArrivee , $barPlotDelivre ) ) );

    $barPlotArrivee->SetColor( "white" );
    $barPlotArrivee->SetFillColor( "green" );
    $barPlotArrivee->value->SetFormat( "%d" );
    $barPlotArrivee->value->show();
    $barPlotArrivee->SetLegend( "BC provenant du trésor" );

    $barPlotDelivre->SetColor( "white" );
    $barPlotDelivre->SetFillColor( "blue" );
    $barPlotDelivre->value->SetFormat( "%d" );
    $barPlotDelivre->value->show();
    $barPlotDelivre->SetLegend( "BC délivré" );

    $grapheBC->legend->Pos( 0.02 , 0.05 );
    $grapheBC->Stroke();
?>