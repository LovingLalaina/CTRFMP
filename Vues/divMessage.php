
<?php if( isset( $_SESSION["message"] ) ) : ?>
    <div class="alert alert-<?=$_SESSION['typeMessage']?>" style="font-size:16px;<?php if( $_SERVER["SCRIPT_NAME"] == "/CTRFMP/dossierRemboursement/dossierRemboursement.php" ) echo "margin-top:65px;z-index:3"; ?>">
    <?php
        echo $_SESSION["message"];
        unset( $_SESSION["message"] );//POUR ENLEVER LE MESSAGE A LA REACTUALISATION
    ?>
    </div>
<?php endif; ?>