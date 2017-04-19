$(document).ready(function () {
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#buscar_producto").focus();
    //comprobamos si se pulsa una tecla
    $("#buscar_producto").keyup(function (e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#buscar_producto").val();
        //hace la búsqueda                                                                                  
        $.ajax({
            type: "POST",
            url: "view/facturas/buscar.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function () {
                //imagen de carga
                $("#resultadoBusqueda").html("<p align='center'><img src='ajax-loader.gif' /></p>");
            },
            error: function () {
                alert("error petición ajax");
            },
            success: function (data) {
                $("#resultadoBusqueda").empty();
                $("#resultadoBusqueda").append(data);
            }
        });
    });
});

$(document).ready(function () {
    $("#buttonAjax").click(function () {
        var name = encodeURI($("#name").val());

        $.ajax({
            type: "POST",
            url: "pdo.php",
            data: "name=" + name,
            success: function (data) {
                var json = $.parseJSON(data);
                $("#output").html(json.summe);
                talk(json.say);
            }
        });

    });

    function talk(say) {
        jQuery.noticeAdd({text: say, stay: false});
    }

});