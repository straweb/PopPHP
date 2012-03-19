Pop PHP Framework
=================

Documentation : Pdf
-------------------

Το PDF προσφέρει συστατικό χαρακτηριστικό-πλούσια λειτουργικότητα για την δημιουργία PDF και χειραγώγησης. Μαζί με τη δημιουργία νέων αρχείων PDF, μπορείτε επίσης να εισάγετε υπάρχουσες και να προσθέσετε περιεχόμενο σε αυτούς από εκεί. Μερικά από τα χαρακτηριστικά που είναι διαθέσιμα είναι τα εξής:

* σχήματα σχεδίασης
* προσθέτοντας διαδρομές αποκοπής
* προσθήκη κειμένου
* ενσωμάτωση εικόνων
* ενσωμάτωση γραμματοσειρών
* URL που συνδέει
* εσωτερική διασύνδεση

<pre>
use Pop\Color\Rgb,
    Pop\Pdf\Pdf;

$pdf = new Pdf('../tmp/doc.pdf');
$pdf->addPage('Letter');

$pdf->setVersion('1.4')
    ->setTitle('Test Title')
    ->setAuthor('Test Author')
    ->setSubject('Test Subject')
    ->setCreateDate(date('D, M j, Y h:i A'));

$pdf->setCompression(true);

$pdf->setTextParams(6, 6, 100, 100, 30, 0)
    ->setFillColor(new Rgb(12, 101, 215))
    ->setStrokeColor(new Rgb(215, 101, 12));
$pdf->addFont('Arial');
$pdf->addText(50, 620, 18, 'Hello World! & You!', 'Arial');

$pdf->setTextParams();
$pdf->addFont('Courier-Bold');
$pdf->addText(150, 350, 48, 'Hello World!', 'Courier-Bold');
$sz = $pdf->getStringSize('Hello World!', 'Courier-Bold', 48);
$pdf->addUrl(150, (350 - $sz['baseline']), $sz['width'], $sz['height'], 'http://www.google.com/');

$pdf->addPage('Letter');

$pdf->setFillColor(new Rgb(12, 101, 215))
    ->setStrokeColor(new Rgb(215, 101, 12))
    ->setStrokeWidth(4, 10, 5);
$pdf->addCircle(150, 700, 60, false);

$pdf->setPage(1)->setFillColor(new Rgb(0, 0, 255));
$pdf->addRectangle(100, 550, 175, 50);
$pdf->addLink(100, 550, 175, 50, 150, 550, 1, 2);

$pdf->setPage(2)
    ->setFillColor(new Rgb(12, 101, 215))
    ->setStrokeColor(new Rgb(215, 101, 12))
    ->setStrokeWidth(4, 10, 5);
$pdf->addCircle(250, 650, 25);
$pdf->addImage('../assets/images/logo_rgb.jpg', 150, 400);

$pdf->setPage(1)
    ->setFillColor(new Rgb(255, 10, 25))
    ->setStrokeColor(new Rgb(12, 101, 215))
    ->setStrokeWidth(2);
$pdf->addEllipse(300, 150, 200, 100, false);

$pdf->addPage('Legal');
$pdf->addFont('Courier-Bold');
$pdf->addText(50, 650, 36, 'Hello World Again!', 'Courier-Bold');
$pdf->addUrl(50, 650, 380, 36, 'http://www.popphp.org/');

$pdf->orderPages(array(3, 1, 2));

$pdf->output();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.