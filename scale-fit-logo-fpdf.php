<?php
    /*
        [10 is the margin value, you can adjust acoordingly]
            Top-Left -> TL
            Top-Center -> TC
            Top-Right -> TR
            Center-Left -> CL
            Center-Center -> CC
            Center-Right -> CR
            Bottom-Left -> BL
            Bottom-Center -> BC
            Bottom-Right -> BR
    */
    require("fpdi.php");
    class PDF extends Fpdi\Fpdi{
        
        function scale_image($imageWidth, $imageHeight,$size){
            $DPI = 96;
            $MM_IN_INCH = 25.4;

            // You can adjust Max Width and Max Height as per your Image Size and quality
            $Max_Width = $size['width']/4;
            $Max_Height = $size['height']/4;
            
            $width_scale = ($Max_Width*$DPI/$MM_IN_INCH)/$imageWidth;
            $height_scale = ($Max_Height*$DPI/$MM_IN_INCH)/$imageHeight;

            $scale = min($width_scale,$height_scale);

            $imageWidth = round($scale*$imageWidth*$MM_IN_INCH/$DPI);
            $imageHeight = round($scale*$imageHeight*$MM_IN_INCH/$DPI);
            
            $scale = ['imageWidth' => $imageWidth, 'imageHeight' => $imageHeight];
            return $scale;
        }

        function fitImage($Image,$imageWidth,$imageHeight,$size,$alignment = 'CC'){
            
            if($alignment === 'CL'){
                $scaledImage = $this->scale_image($imageWidth,$imageHeight,$size);
                $X = 10;
                $Y = ($size['height'] - $scaledImage['imageHeight'])/2 - 10;
                
                $this->Image($Image,$X,$Y,$scaledImage['imageWidth'],$scaledImage['imageHeight']);
            }else if($alignment === 'CC'){
                $scaledImage = $this->scale_image($imageWidth,$imageHeight,$size);
                $X = ($size['width'] - $scaledImage['imageWidth'])/2;
                $Y = ($size['height'] - $scaledImage['imageHeight'])/2;
                $this->Image($Image,$X,$Y,$scaledImage['imageWidth'],$scaledImage['imageHeight']);
            }else if($alignment === 'CR'){
                $scaledImage = $this->scale_image($imageWidth,$imageHeight,$size);
                $X = ($size['width'] - $scaledImage['imageWidth']);
                $Y = ($size['height'] - $scaledImage['imageHeight'])/2;
                
                $this->Image($Image,$X,$Y,$scaledImage['imageWidth'],$scaledImage['imageHeight']);
            }else if($alignment === 'TL'){
                $scaledImage = $this->scale_image($imageWidth,$imageHeight,$size);
                $X = 10;
                $Y = 10;
                $this->Image($Image,$X,$Y,$scaledImage['imageWidth'],$scaledImage['imageHeight']);
            }else if($alignment === 'TC'){
                $scaledImage = $this->scale_image($imageWidth,$imageHeight,$size);
                $X = ($size['width'] - $scaledImage['imageWidth'])/2;
                $Y = 10;
                
                $this->Image($Image,$X,$Y,$scaledImage['imageWidth'],$scaledImage['imageHeight']);
            }else if($alignment === 'TR'){
                $scaledImage = $this->scale_image($imageWidth,$imageHeight,$size);
                $X = ($size['width'] - $scaledImage['imageWidth'])-10;
                $Y = 10;
                $this->Image($Image,$X,$Y,$scaledImage['imageWidth'],$scaledImage['imageHeight']);
            }else if($alignment === 'BL'){
                $scaledImage = $this->scale_image($imageWidth,$imageHeight,$size);
                $X = 10;
                $Y = ($size['height'] - $scaledImage['imageHeight'])-10;
                
                $this->Image($Image,$X,$Y,$scaledImage['imageWidth'],$scaledImage['imageHeight']);
            }else if($alignment === 'BC'){
                $scaledImage = $this->scale_image($imageWidth,$imageHeight,$size);
                $X = ($size['width'] - $scaledImage['imageWidth'])/2;
                $Y = ($size['height'] - $scaledImage['imageHeight'])-10;

                $this->Image($Image,$X,$Y,$scaledImage['imageWidth'],$scaledImage['imageHeight']);
            }else if($alignment === 'BR'){
                $scaledImage = $this->scale_image($imageWidth,$imageHeight,$size);
                $X = ($size['width'] - $scaledImage['imageWidth'])-10;
                $Y = ($size['height'] - $scaledImage['imageHeight'])-10;

                $this->Image($Image,$X,$Y,$scaledImage['imageWidth'],$scaledImage['imageHeight']);
            }
        }
        
    }

    // Get image Height and Width 
    $imageInfo = getimagesize('Your Image URL');
    $imageWidth = $imageInfo[0];
    $imageHeight = $imageInfo[1];

    // Creating new PDF Object.
    $pdf = new PDF();

    // First Page Of PDF.
    // Put your PDF URL in setSourceFile()
    $pdf->setSourceFile('YOUR PDFURL');  
    $pageId = $pdf->importPage(1, '/MediaBox');
    $size = $pdf->getTemplateSize($pageId);

    /*
    To get PDF Page's Width and Height use -> getTemplateSize() Method
    Size -> Size['width'] == PDF Document's Width
    Size -> Size['height'] == PDF Document's Height
    Size -> Size['orientation'] == PDF Document's Orientation like => Portrait 'P' or Landscape 'L'
    */

    $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));
    $pdf->useTemplate($pageId);

    /*
    Pass this Values in function fitImage
    (Image URL, Image Width, Image Height, PDF width, PDF Height, Alignment [By Default It's CC])
    */
    $pdf->fitImage('Image URL',$imageWidth,$imageHeight,$size,'TL');

    // Download PDF
    $pdf->Output('D', "XYZ.pdf");
    
     
     
