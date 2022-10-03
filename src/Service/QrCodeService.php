<?php

namespace App\Service;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class QrCodeService
{


    /**
     * @var BuilderInterface
     */
    protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }



        public function qrcode($query)
        {
            $url = 'https://tn.wego.com/destinations/'; //lien specifique

            $objDateTime = new \DateTime('NOW');
            $dateString = $objDateTime->format('d-m-Y H:i:s');

           $path = dirname(__DIR__, 2).'/public/assets/';

            // set qrcode
            $result = $this->builder
                ->data($url.$query)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->size(100)
                ->margin(5)
                ->labelText($dateString)
                ->labelAlignment(new LabelAlignmentCenter())
                ->labelMargin(new Margin(15, 5, 5, 5))
                ->backgroundColor(new Color(221, 158, 3))
                ->build()
            ;

            //generate name
            $namePng = uniqid('', '') . '.png';

            //Save img png
              $result->saveToFile($path.'qr-code/'.$namePng);
          /*  try {
                $result->move(
                    $this->getParameter('qr-code_directory'),
                    $namePng
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }*/

            return $result->getDataUri();
        }

    public function qrcode2($query)
    {
        $url = 'https://www.google.com/search?q='; //lien specifique

        $objDateTime = new \DateTime('NOW');
        $dateString = $objDateTime->format('d-m-Y H:i:s');

        $path = dirname(__DIR__, 2).'/public/assets/';

        // set qrcode
        $result = $this->builder
            ->data($url.$query)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(120)
            ->margin(5)
            ->backgroundColor(new Color(221, 158, 3))
            ->build()
        ;

        //generate name
        $namePng = uniqid('', '') . '.png';

        //Save img png
        $result->saveToFile($path.'qr-code/'.$namePng);
        /*  try {
              $result->move(
                  $this->getParameter('qr-code_directory'),
                  $namePng
              );
          } catch (FileException $e) {
              // ... handle exception if something happens during file upload
          }*/

        return $result->getDataUri();
    }

    public function qrcodeH($query)
    {
        $url = 'https://www.booking.com/searchresults.en-gb.html?&ss='; //lien specifique

        $objDateTime = new \DateTime('NOW');
        $dateString = $objDateTime->format('d-m-Y H:i:s');

        $path = dirname(__DIR__, 2).'/public/assets/';

        // set qrcode
        $result = $this->builder
            ->data($url.$query)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(100)
            ->margin(5)
            ->backgroundColor(new Color(230, 128, 0))
            ->build()
        ;

        //generate name
        $namePng = uniqid('', '') . '.png';

        //Save img png
        $result->saveToFile($path.'qr-code/'.$namePng);
        /*  try {
              $result->move(
                  $this->getParameter('qr-code_directory'),
                  $namePng
              );
          } catch (FileException $e) {
              // ... handle exception if something happens during file upload
          }*/

        return $result->getDataUri();
    }







}