function printBarcode(barcode, itemName) {
    // Get the barcode SVG content
    const barcodeContainer = document.querySelector("[data-barcode='" + barcode + "'] .barcode-container");
    
    if (!barcodeContainer) {
        console.error("Could not find barcode container for:", barcode);
        return;
    }
    
    const barcodeSvg = barcodeContainer.innerHTML;
    
    // Create print content
    const printContent = `
    <!DOCTYPE html>
    <html>
    <head>
        <title>Barcode: ${barcode}</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
                padding: 20px;
            }
            .barcode-print-wrapper {
                display: inline-block;
                padding: 10px;
                border: 1px solid #ddd;
                margin-bottom: 15px;
            }
            .item-name {
                font-size: 14px;
                font-weight: bold;
                margin-bottom: 5px;
            }
            .barcode-number {
                font-size: 12px;
                margin-top: 5px;
            }
            .barcode-container svg {
                max-width: 200px;
                height: auto;
            }
        </style>
    </head>
    <body>
        <div id="barcode-print-section">
            <div class="barcode-print-wrapper">
                <div class="item-name">${itemName}</div>
                <div class="barcode-container">
                    ${barcodeSvg}
                </div>
                <div class="barcode-number">${barcode}</div>
            </div>
        </div>
        <script>
            // Print automatically when page loads
            window.onload = function() {
                window.print();
                // Close the window after printing (or when print dialog is closed)
                setTimeout(function() {
                    window.close();
                }, 500);
            };
        </script>
    </body>
    </html>
    `;
    
    // Open a new window with the print content
    const printWindow = window.open('', '_blank', 'width=600,height=600');
    printWindow.document.write(printContent);
    printWindow.document.close();
}

window.printBarcode = printBarcode; 