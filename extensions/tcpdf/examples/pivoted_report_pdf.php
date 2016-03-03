<?php
/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Removing Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Dandy Collera');
$pdf->SetTitle('TCPDF Example 002');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
  require_once(dirname(__FILE__).'/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

// set some text to print
$txt = <<<EOD
TCPDF <b>Example 002</b>

Default page header and footer are disabled using setPrintHeader() and setPrintFooter() methods.
EOD;


$my_html='<table border="1" width="1500">
        <tr>
          <th>Were there clear instructions on completing the online registration and examination?</th>
          <th width="70">BGC</th>
          <th width="70">Cavite</th>
          <th width="70">Anonas</th>
          <th width="70">Untag</th>
          <th width="70">Grand Total</th>
        </tr><tr>
              <td>10</td>
              <td>127</td>
              <td>563</td>
              <td>542</td>
              <td>0</td>
              <td>1236</td>
              
            </tr><tr>
              <td>9</td>
              <td>39</td>
              <td>279</td>
              <td>126</td>
              <td>0</td>
              <td>446</td>
              
            </tr><tr>
              <td>8</td>
              <td>30</td>
              <td>200</td>
              <td>66</td>
              <td>0</td>
              <td>296</td>
              
            </tr><tr>
              <td>7</td>
              <td>7</td>
              <td>99</td>
              <td>21</td>
              <td>0</td>
              <td>129</td>
              
            </tr><tr>
              <td>6</td>
              <td>4</td>
              <td>40</td>
              <td>8</td>
              <td>0</td>
              <td>52</td>
              
            </tr><tr>
              <td>5</td>
              <td>7</td>
              <td>106</td>
              <td>15</td>
              <td>0</td>
              <td>131</td>
              
            </tr><tr>
              <td>4</td>
              <td>0</td>
              <td>5</td>
              <td>0</td>
              <td>0</td>
              <td>5</td>
              
            </tr><tr>
              <td>3</td>
              <td>0</td>
              <td>6</td>
              <td>0</td>
              <td>0</td>
              <td>6</td>
              
            </tr><tr>
              <td>2</td>
              <td>0</td>
              <td>3</td>
              <td>1</td>
              <td>0</td>
              <td>4</td>
              
            </tr><tr>
              <td>1</td>
              <td>1</td>
              <td>6</td>
              <td>3</td>
              <td>1</td>
              <td>11</td>
              
            </tr><tr>
              <td>0</td>
              <td>0</td>
              <td>6</td>
              <td>0</td>
              <td>0</td>
              <td>6</td>
              
            </tr>
        </table>
        <br>
        <br>

        <table border="1">
            <tr>
              <th colspan="2">Anonas</th>
              <th colspan="2">BGC</th>
              <th colspan="2">Cavite</th>
              <th colspan="2">Un-tag</th>
              <th colspan="2">Across all site</th>
            </tr>

            <tr>
              <th>Promoter</th>
              <td>668</td>
              <th>Promoter</th>
              <td>166</td>
              <th>Promoter</th>
              <td>842</td>
              <th>Promoter</th>
              <td>0</td>
              <th>Promoter</th>
              <td>1682</td> 
            </tr>

            <tr>
              <th>Detractor</th>
              <td>27</td>
              <th>Detractor</th>
              <td>12</td>
              <th>Detractor</th>
              <td>172</td>
              <th>Detractor</th>
              <td>1</td>
              <th>Detractor</th>
              <td>215</td>  
            </tr>

            <tr>
              <th>Total</th>
              <td>82%</td>
              <th>Total</th>
              <td>72%</td>
              <th>Total</th>
              <td>51%</td>
              <th>Total</th>
              <td>-100%</td>
              <th>Total</th>
              <td>63%</td>  
            </tr>


        </table>';

// print a block of text using Write()
//$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

$pdf->writeHTML($my_html, true, false, false, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_002.pdf', 'I');



//============================================================+
// END OF FILE
//============================================================+
