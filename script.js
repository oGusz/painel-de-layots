function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Código copiado!');
    }, function(err) {
        alert('Erro ao copiar: ' + err);
    });
}
