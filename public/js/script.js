function link(link_pg) {
    if (link_pg != null && link_pg !== undefined) {
        $("#conteudo").html("Carregando..");
        $("#conteudo").load(link_pg);
    } else {
        $("#conteudo").load('index/principal');
    }
}
window.onload = link();

function SomenteNumero(e) {
    var tecla = (window.event) ? event.keyCode : e.which;
    if ((tecla > 47 && tecla < 58))
        return true;
    else {
        if (tecla == 8 || tecla == 0)
            return true;
        else
            return false;
    }
}

function enviarAjax(link) {
    $("#sub").html("<img src='images/ajax-loader.gif' id='loader' align='center' />");
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: link,
        data: $('#form').serialize(),
        success: function (data) {
            $("#origem_r").text(data.origem);
            $("#destino_r").text(data.destino);
            $("#tempo_r").text(data.tempo);
            $("#plano_r").text(data.plano);
            $("#falaMais_r").text(data.taxa);
            $("#SfalaMais_r").text(data.ftaxa);
            $("#sub").hide();
        },
        error: function (data) {
            alert('erro');
        }
    });
}

$('a').bind('click', function (event) {
    var $anchor = $(this);

    $('html, body').stop().animate({scrollTop: $($anchor.attr('href')).offset().top}, 1000, 'easeInOutExpo');

    // Outras Animações
    // linear, swing, jswing, easeInQuad, easeInCubic, easeInQuart, easeInQuint, easeInSine, easeInExpo, easeInCirc, easeInElastic, easeInBack, easeInBounce, easeOutQuad, easeOutCubic, easeOutQuart, easeOutQuint, easeOutSine, easeOutExpo, easeOutCirc, easeOutElastic, easeOutBack, easeOutBounce, easeInOutQuad, easeInOutCubic, easeInOutQuart, easeInOutQuint, easeInOutSine, easeInOutExpo, easeInOutCirc, easeInOutElastic, easeInOutBack, easeInOutBounce


});