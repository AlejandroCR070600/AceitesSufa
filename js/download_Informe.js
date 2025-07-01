let btnDownload=document.getElementById("btnDownload");

btnDownload.addEventListener('click', function(event){
    event.preventDefault();
    let folio =document.getElementById("download_Folio").value;

    let datos={
        "folio":folio
    };

    fetch("pdf/generador_PDF.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({ folio })
})
.then(res => {
    if (!res.ok) {
        return res.json().then(err => { throw err; });
    }
    return res.blob();
})
.then(blob => {
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "Reporte_Motos.pdf";
    a.click();
})
.catch(err => {
    alert(err.error || "Ocurrió un error al generar el PDF.");
});


});