
import JsPDF from 'jspdf'
import JsBarcode from 'jsbarcode'

// convert orderNo to base64Barcode
// convert base64Barcode to PNGImage
// Use PNGImage in pdf downloaded file

const generateAndDownloadBarcodeInPDF = (orderNo) => {
  const makeBase64Image = convertTextToBase64Barcode(orderNo)

  convertBase64ToPNGImage(makeBase64Image).then((realImage) => {
    const doc = new JsPDF('p', 'mm', 'a4')
    var width = 40
    var height = 25
    // Following we add 5 barcode images
    doc.addImage(realImage, 'PNG', 10, 5, width, height)
    doc.addImage(realImage, 'PNG', 10, 45, width, height)
    doc.addImage(realImage, 'PNG', 10, 85, width, height)
    doc.addImage(realImage, 'PNG', 10, 125, width, height)
    doc.addImage(realImage, 'PNG', 10, 165, width, height)
    doc.addImage(realImage, 'PNG', 10, 205, width, height)
    doc.addImage(realImage, 'PNG', 10, 245, width, height)

    doc.addImage(realImage, 'PNG', 78, 5, width, height)
    doc.addImage(realImage, 'PNG', 78, 45, width, height)
    doc.addImage(realImage, 'PNG', 78, 85, width, height)
    doc.addImage(realImage, 'PNG', 78, 125, width, height)
    doc.addImage(realImage, 'PNG', 78, 165, width, height)
    doc.addImage(realImage, 'PNG', 78, 205, width, height)
    doc.addImage(realImage, 'PNG', 78, 245, width, height)

    doc.addImage(realImage, 'PNG', 140, 5, width, height)
    doc.addImage(realImage, 'PNG', 140, 45, width, height)
    doc.addImage(realImage, 'PNG', 140, 85, width, height)
    doc.addImage(realImage, 'PNG', 140, 125, width, height)
    doc.addImage(realImage, 'PNG', 140, 165, width, height)
    doc.addImage(realImage, 'PNG', 140, 205, width, height)
    doc.addImage(realImage, 'PNG', 140, 245, width, height)

    doc.save('barcode.pdf')
  })
}

const convertBase64ToPNGImage = (url) => {
  return new Promise((resolve) => {
    const img = new Image()
    img.onload = () => resolve(img)
    img.src = url
  })
}

const convertTextToBase64Barcode = (text) => {
  const canvas = document.createElement('canvas')
  JsBarcode(canvas, text, { format: 'CODE128' })
  return canvas.toDataURL('image/png')
}

export { generateAndDownloadBarcodeInPDF }
