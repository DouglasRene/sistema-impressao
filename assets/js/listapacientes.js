$(function() {
    $("#tabela input").keyup(function(e) {
        if (e.key == 'Backspace') {
            $("#tabela tbody tr").show();
            $("#tabela tbody tr").each(function() {
                if ($(this).is(".filtrado3")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado4")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado6")) {
                    $(this).hide();
                }
            })
        }
        var index = $(this).parent().index();
        var nth = "#tabela td:nth-child(" + (index + 1).toString() + ")";
        var valor = $(this).val().toUpperCase();
        console.log(nth)
        $(nth).each(function() {
            if ($(this).text().toUpperCase().indexOf(valor) < 0) {
                $(this).parent().hide();
                $(this).parent().addClass("filtradotext")
            }
        });
    });
})

function adicionarOptions(tabela, coluna) {
    var valores = new Array();

    $("#" + tabela + " tbody tr").each(function() {
        var txt = $(this).children("td:nth-child(" + coluna + ")").text();
        if (valores.indexOf(txt) < 0) {
            valores.push(txt);
        }
    });

    for (elemento in valores) {
        $("#filtroColuna_" + coluna.toString()).append("<option>" + valores[elemento] + "</option>");
    }
}

function AdicionarFiltro(tabela, ) {

    adicionarOptions(tabela, 3)
    adicionarOptions(tabela, 4)
    adicionarOptions(tabela, 6) 

    $("#filtroColuna_3").change(function() {
        $("#" + tabela + " tbody tr").each(function() {
            if ($(this).is(".filtradotext")) {
                $(this).show();
                $(this).removeClass("filtradotext");
                $("#usuario").val("")
                $("#cns").val("")
            }
        });
        var filtro = $(this).val();
        if (filtro != "Todos") {
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado3")) {
                    $(this).show();
                    $(this).removeClass("filtrado3")
                }
            });
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado4")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado6")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado5")) {
                    $(this).hide();
                }
            })
            $("#" + tabela + " tbody tr").each(function() {
                var txt = $(this).children("td:nth-child(3)").text();
                if (txt != filtro) {
                    $(this).hide();
                    $(this).addClass("filtrado3")
                }
            });
        } else {
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado3")) {
                    $(this).show();
                    $(this).removeClass("filtrado3")
                }
            });
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado4")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado6")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado5")) {
                    $(this).hide();
                }
            })
        }
    });

    $("#filtroColuna_4").change(function() {
        $("#" + tabela + " tbody tr").each(function() {
            if ($(this).is(".filtradotext")) {
                $(this).show();
                $(this).removeClass("filtradotext");
                $("#usuario").val("")
                $("#cns").val("")
            }
        });
        var filtro = $(this).val();
        if (filtro != "Todos") {
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado4")) {
                    $(this).show();
                    $(this).removeClass("filtrado4")
                }
            });
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado3")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado6")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado5")) {
                    $(this).hide();
                }
            })
            $("#" + tabela + " tbody tr").each(function() {
                var txt = $(this).children("td:nth-child(4)").text();
                if (txt != filtro) {
                    $(this).hide();
                    $(this).addClass("filtrado4")
                }
            });
        } else {
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado4")) {
                    $(this).show();
                    $(this).removeClass("filtrado4")
                }
            });
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado3")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado6")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado5")) {
                    $(this).hide();
                }
            })
        }
    });

    $("#filtroColuna_6").change(function() {
        $("#" + tabela + " tbody tr").each(function() {
            if ($(this).is(".filtradotext")) {
                $(this).show();
                $(this).removeClass("filtradotext");
                $("#usuario").val("")
                $("#cns").val("")
            }
        });
        var filtro = $(this).val();
        if (filtro != "Todos") {
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado6")) {
                    $(this).show();
                    $(this).removeClass("filtrado6")
                }
            });
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado3")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado4")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado5")) {
                    $(this).hide();
                }
            })
            $("#" + tabela + " tbody tr").each(function() {
                var txt = $(this).children("td:nth-child(6)").text();
                if (txt != filtro) {
                    $(this).hide();
                    $(this).addClass("filtrado6")
                }
            });
        } else {
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado6")) {
                    $(this).show();
                    $(this).removeClass("filtrado6")
                }
            });
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado3")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado4")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado5")) {
                    $(this).hide();
                }
            })
        }
    });

    $("#filtroColuna_5").change(function() {
        $("#" + tabela + " tbody tr").each(function() {
            if ($(this).is(".filtradotext")) {
                $(this).show();
                $(this).removeClass("filtradotext");
                $("#usuario").val("")
                $("#cns").val("")
            }
        });
        var filtro = $(this).val();
        if (filtro != "Todos") {
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado5")) {
                    $(this).show();
                    $(this).removeClass("filtrado5")
                }
            });
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado3")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado4")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado6")) {
                    $(this).hide();
                }
            })
            $("#" + tabela + " tbody tr").each(function() {
                var txt = $(this).children("td:nth-child(5)").text();
                if (txt != filtro) {
                    $(this).hide();
                    $(this).addClass("filtrado5")
                }
            });
        } else {
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado5")) {
                    $(this).show();
                    $(this).removeClass("filtrado5")
                }
            });
            $("#" + tabela + " tbody tr").each(function() {
                if ($(this).is(".filtrado3")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado4")) {
                    $(this).hide();
                }
                if ($(this).is(".filtrado6")) {
                    $(this).hide();
                }
            })
        }
    });

};


AdicionarFiltro('tabela');

$("#filtro_prof").change(() => {
    dados = $("#caps_id").val()
    $.ajax({
        url: '/teste/assets/process/listapacientes_process.php',
        type: 'POST',
        data: {
            data: dados
        },
        success: function(result) {
            centros
            console.log(typeof(result))

        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Retorno caso algum erro ocorra
        }
    });
})