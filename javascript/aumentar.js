var $btnAumentar = $("#btnAumentar");
var $btnDiminuir = $("#btnDiminuir");
var $elementos = $("body p, body h1, body h2, body h3, body h4").not("footer h2");
var $listasParaAumentar = $("body ul, body ol").not("header ul, header ol, footer ul, footer ol");
var tamanhoFonteOriginal;
var contadorCliquesAumentar = 0;

function obterTamanhoFonte($elemento) {
  return parseFloat($elemento.css('font-size'));
}

$(document).ready(function() {
  tamanhoFonteOriginal = obterTamanhoFonte($elementos.first());
});

$btnAumentar.on('click', function() {
  if (contadorCliquesAumentar < 4) {
    $elementos.each(function() {
      var tamanhoAtual = obterTamanhoFonte($(this));
      $(this).css('font-size', tamanhoAtual + 1);
    });
    $listasParaAumentar.css('font-size', obterTamanhoFonte($listasParaAumentar) + 1);
    contadorCliquesAumentar++;
  }
});

$btnDiminuir.on('click', function() {
  var tamanhoAtual = obterTamanhoFonte($elementos.first());

  // verifica se o tamanho atual é maior que o tamanho original antes de diminuir
  if (tamanhoAtual > tamanhoFonteOriginal) {
    $elementos.each(function() {
      var tamanhoAtualElemento = obterTamanhoFonte($(this));
      $(this).css('font-size', tamanhoAtualElemento - 1);
    });
    $listasParaAumentar.css('font-size', obterTamanhoFonte($listasParaAumentar) - 1);
    // restaura o contador de cliques
    contadorCliquesAumentar = 0;
  }
});
