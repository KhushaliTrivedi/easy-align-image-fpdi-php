# fpdi-image-align

A utility function for scaling and aligning images using **FPDF/FPDI in PHP**. This script allows you to scale an image proportionally to fit within a PDF page and place it at any common alignment point (top-left, center, bottom-right, etc.).

## 🚀 Features

- Automatically scales images based on PDF dimensions
- Maintains aspect ratio for accurate rendering
- Supports 9 alignment positions
- Easily customizable margin (default: `10`)
- Simple integration with FPDI workflows

## 📐 Alignment Options

You can align the image using any of the following codes:

| Code | Position        |
|------|-----------------|
| TL   | Top Left        |
| TC   | Top Center      |
| TR   | Top Right       |
| CL   | Center Left     |
| CC   | Center Center   |
| CR   | Center Right    |
| BL   | Bottom Left     |
| BC   | Bottom Center   |
| BR   | Bottom Right    |

> **Note:** Margin is set to `10` units by default. You can change this inside the code logic if needed.

## 🧩 Example Usage

```php
require("fpdi.php");

class PDF extends Fpdi\Fpdi {
    // Includes scale_image() and fitImage() functions
}

// Get image dimensions
$imageInfo = getimagesize('Your Image URL');
$imageWidth = $imageInfo[0];
$imageHeight = $imageInfo[1];

// Load PDF and get its size
$pdf = new PDF();
$pdf->setSourceFile('YOUR_PDF_URL.pdf');
$pageId = $pdf->importPage(1, '/MediaBox');
$size = $pdf->getTemplateSize($pageId);

$pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
$pdf->useTemplate($pageId);

// Fit and place the image with alignment
$pdf->fitImage('Your Image URL', $imageWidth, $imageHeight, $size, 'CC');

// Output the final PDF
$pdf->Output('D', 'output.pdf');
