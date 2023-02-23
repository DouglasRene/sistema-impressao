<?php
    require_once 'dompdf/autoload.inc.php';

    use Dompdf\Dompdf;
    use Dompdf\Options;

    $options = new Options();
    $options->setChroot(__DIR__);
    $options->setIsRemoteEnabled(true);

    // // instantiate and use the dompdf class
    $dompdf =  new Dompdf($options);

    ob_start();
    require(__DIR__."/formulariopdf.php");
    $dompdf->loadHtml(ob_get_clean());

    $dompdf->setPaper("A4", "landscape");

    $dompdf->render();
    $dompdf->stream("file.pdf", ["Attachment" => false]);
