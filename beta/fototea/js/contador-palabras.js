
    function contador(maximo, minimo, obj ){
      
        $(obj).keyup(function () {
              var max = maximo;
              var min = minimo;
              var len = $(this).val().length;
              var char = 0;
               
            if (len > max) {
                char = max - len;
                $('#charNum').addClass("exceeded")
                $('#charNum').text('Te has sobrepasado en '+ (-1)*char +' caracteres :(');
            }else if (len <= min) {
                char = min - len;
                $('#charNum').addClass("exceeded")
                $('#charNum').text('Faltan al menos '+ char +' caracteres');
            } else {
                char = max - len;
                $('#charNum').removeClass("exceeded");
                $('#charNum').text('Quedan como máximo '+ char +' caracteres :)');
                if (char<=10){$('#charNum').addClass("exceeded");}
            }
        });
    }
