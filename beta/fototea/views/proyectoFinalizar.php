<?php

use Fototea\Models\User;
use Fototea\Util\DateHelper;

//TODO usar clases
//TODO eliminar cookie id
//TODO mover logica arriba
//TODO revisar javascript
//TODO pendiente con sql injection

  //validar que sea un usuario valido para ver esta pagina (claro claro claro)
  $calVal = validarCalificacion($_COOKIE['id'], $_GET['id']);
  if($calVal == true or !isset($_GET['id'])){  
  ?> <script>
   window.location="perfil";
   </script>
    
<?php }
$pro_id = intval($_GET['id']);
$pro = listAll("proyectos", "WHERE pro_id = '$pro_id'");
$rs_pro = mysql_fetch_object($pro);
$user_info = getUserInfo($_COOKIE['id']);
$current_user = getCurrentUser();
?>

<div class="content-container">
    <div class="content">
    <div class="sub-title first">
        <i class="glyphicon glyphicon-chevron-right"></i>Finalizar proyecto: <?php echo $rs_pro->pro_tit ?>
    </div>


        <form id="replay" name="replay" action="" method="post">
<!--            --><?php // if($user_info['user_type'] == User::USER_TYPE_CLIENT): ?>
<!--                <div class="replayMsj txtNaranja fontW400">¡Tu pago se ha verificado con éxito!</div>-->
<!--            --><?php //endif ?>

            <blockquote>
                <?php if($user_info['user_type'] == User::USER_TYPE_CLIENT): ?>
                    Para finalizar el proyecto debes calificar al usuario que te ha prestado servicio.
                <?php else: ?>
                    Para finalizar el proyecto debes calificar al usuario al que le has prestado servicio.
                <?php endif ?>
                Esta evaluación tendrá efecto sobre la calificación global de esta persona.
                <small>Seleccione los siguientes campos de acuerdo a la experiencia con el proyecto.</small>
            </blockquote>
            
            <div class="review-options-list" id="reviews_list">
                
                <label>El proyecto se realizó con éxito:</label>
                <div>
                    <input id="r_finish" name="r_finish" type="radio" value="S"  checked="checked"/> Sí<br/>
                    <input id="r_finish" name="r_finish" type="radio" value="N"/> No
                  </div> 
                <?php  if($user_info['user_type'] == User::USER_TYPE_CLIENT):
                    $of = listAll("ofertas","WHERE pro_id = '$pro_id' AND awarded = 'S'");
                    $rs_of = mysql_fetch_object($of);
                    $id_us_eval = $rs_of->user_id;
                ?>
                <br>
                <div class="clearfix">
                    <label>Calidad: </label>
                    <div id="raty_calidad" class="rating"></div>
                    <input id="r_calidad" name="r_calidad" type="hidden" value="" />
                </div>
                <br>
                <div class="clearfix">
                    <label>Trato:</label>
                    <div id="raty_trato" class="rating"></div>
                    <input id="r_trato" name="r_trato" type="hidden" value="" />
                </div>
                <div class="clearfix">
                    <br>
                    <label>Puntualidad:</label>
                    <div id="raty_puntualidad" class="rating"></div>
                    <input id="r_punt" name="r_punt" type="hidden" value="" />
                </div>
                <br>
                <div class="clearfix">
                    <label>Responsabilidad:</label>
                    <div id="raty_responsabilidad" class="rating"></div>
                    <input id="r_resp" name="r_resp" type="hidden" value="" />
                </div>
                <br>
                <div class="clearfix">
                    <label>Profesionalismo:</label>
                    <div id="raty_profesionalismo" class="rating"></div>
                    <input id="r_prof" name="r_prof" type="hidden" value="" />
                </div>
                <br>     
                <?php endif ?>
                <?php  if($user_info['user_type'] == User::USER_TYPE_PHOTOGRAPHER):
                    //Usuario que esta siendo calificado
                    $id_us_eval = $rs_pro->user_id;
                ?>
                <?php endif ?>
                <br/>
                <div class="clearfix">
                    <label>Calificación:</label>
                    <div id="raty_calificacion" class="rating"></div>
                    <input id="r_calif" name="r_calif" type="hidden" value="" />
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">Comentario:</label>
                            <br>
                            <textarea id="p_review" name="p_review" class="form-control" rows="3" placeholder="Comentario" title="Comentario"></textarea>    
                        </div>
                    </div>
                </div>
                <br>
                <a class="btn btn-primary pull-right" href="javascript:sendReview(<?php echo $rs_pro->pro_id ?>);">Finalizar proyecto</a>
                
            </div>
            
            <!--<ul class="review-options-list" id="reviews_list">
                <li>
                    <label>El proyecto se realizó con éxito:</label>
                    <input id="r_finish" name="r_finish" type="radio" value="S"  checked="checked"/> Sí<br/>
                    <input id="r_finish" name="r_finish" type="radio" value="N"/> No
                </li>

                    <li> 
                        <label>Calidad: </label>
                        
                        
                        <input id="r_calidad" name="r_calidad" type="radio" value="1" checked="checked"/>
                        <img alt="" src="images/rating_1.jpg">
                        <input id="r_calidad" name="r_calidad" type="radio" value="2" />
                        <img alt="" src="images/rating_2.jpg">
                        <input id="r_calidad" name="r_calidad" type="radio" value="3" />
                        <img alt="" src="images/rating_3.jpg">
                        <input id="r_calidad" name="r_calidad" type="radio" value="4" />
                        <img alt="" src="images/rating_4.jpg">
                        <input id="r_calidad" name="r_calidad" type="radio" value="5" />
                        <img alt="" src="images/rating_5.jpg">
                    </li>

                    <li>
                        <label>Trato:</label>
                        <input id="r_trato" name="r_trato" type="radio" value="1" checked="checked"/>
                        <img alt="" src="images/rating_1.jpg">
                        <input id="r_trato" name="r_trato" type="radio" value="2" />
                        <img alt="" src="images/rating_2.jpg">
                        <input id="r_trato" name="r_trato" type="radio" value="3" />
                        <img alt="" src="images/rating_3.jpg">
                        <input id="r_trato" name="r_trato" type="radio" value="4" />
                        <img alt="" src="images/rating_4.jpg">
                        <input id="r_trato" name="r_trato" type="radio" value="5" />
                        <img alt="" src="images/rating_5.jpg"></li>
                    <li>
                        <label>Puntualidad:</label>
                        <input id="r_punt" name="r_punt" type="radio" value="1" checked="checked"/>
                        <img alt="" src="images/rating_1.jpg">
                        <input id="r_punt" name="r_punt" type="radio" value="2" />
                        <img alt="" src="images/rating_2.jpg">
                        <input id="r_punt" name="r_punt" type="radio" value="3" />
                        <img alt="" src="images/rating_3.jpg">
                        <input id="r_punt" name="r_punt" type="radio" value="4" />
                        <img alt="" src="images/rating_4.jpg">
                        <input id="r_punt" name="r_punt" type="radio" value="5" />
                        <img alt="" src="images/rating_5.jpg">
                    </li>

                    <li>
                        <label>Responsabilidad:</label>
                        <input id="r_resp" name="r_resp" type="radio" value="1" checked="checked"/>
                        <img alt="" src="images/rating_1.jpg">
                        <input id="r_resp" name="r_resp" type="radio" value="2" />
                        <img alt="" src="images/rating_2.jpg">
                        <input id="r_resp" name="r_resp" type="radio" value="3" />
                        <img alt="" src="images/rating_3.jpg">
                        <input id="r_resp" name="r_resp" type="radio" value="4" />
                        <img alt="" src="images/rating_4.jpg">
                        <input id="r_resp" name="r_resp" type="radio" value="5" />
                        <img alt="" src="images/rating_5.jpg">
                    </li>

                    <li>
                        <label>Profesionalismo:</label>
                        <input id="r_prof" name="r_prof" type="radio" value="1" checked="checked"/>
                        <img alt="" src="images/rating_1.jpg">
                        <input id="r_prof" name="r_prof" type="radio" value="2" />
                        <img alt="" src="images/rating_2.jpg">
                        <input id="r_prof" name="r_prof" type="radio" value="3" />
                        <img alt="" src="images/rating_3.jpg">
                        <input id="r_prof" name="r_prof" type="radio" value="4" />
                        <img alt="" src="images/rating_4.jpg">
                        <input id="r_prof" name="r_prof" type="radio" value="5" />
                        <img alt="" src="images/rating_5.jpg">
                    </li>

                    <li>
                        <label>Calificación:</label>
                        <input id="r_calif" name="r_calif" type="radio" value="1" checked="checked"/>
                        <img alt="" src="images/rating_1.jpg">
                        <input id="r_calif" name="r_calif" type="radio" value="2" />
                        <img alt="" src="images/rating_2.jpg">
                        <input id="r_calif" name="r_calif" type="radio" value="3" />
                        <img alt="" src="images/rating_3.jpg">
                        <input id="r_calif" name="r_calif" type="radio" value="4" />
                        <img alt="" src="images/rating_4.jpg">
                        <input id="r_calif" name="r_calif" type="radio" value="5" />
                        <img alt="" src="images/rating_5.jpg">
                    </li>

                <li>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">Comentario:</label>
                                <textarea id="p_review" name="p_review" class="form-control" rows="3" placeholder="Comentario" title="Comentario"></textarea>    

                            </div>
                        </div>
                    </div>

                </li>

                <li>
                    <a class="btn btn-primary pull-right" href="javascript:sendReview(<?php echo $rs_pro->pro_id ?>);">Finalizar proyecto</a>
                </li>
            </ul>-->

            <input type="hidden" id="us" name="us" value="<?php  echo $id_us_eval;?>"/>
            <input type="hidden" id="type_us" name="type_us" value="<?php  echo $user_info['user_type'];?>"/>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $.fn.raty.defaults.path = 'images';
    $('#raty_calidad').raty( { click: function(score, evt) {
        $('#r_calidad').val(score)
      }
    });
    
        $('#raty_trato').raty( { click: function(score, evt) {
        $('#r_trato').val(score)
      }
    });
        $('#raty_puntualidad').raty( { click: function(score, evt) {
        $('#r_punt').val(score)
      }
    });
        $('#raty_responsabilidad').raty( { click: function(score, evt) {
        $('#r_resp').val(score)
      }
    });
        $('#raty_profesionalismo').raty( { click: function(score, evt) {
        $('#r_prof').val(score)
      }
    });
        
        $('#raty_calificacion').raty( { click: function(score, evt) {
        $('#r_calif').val(score)
      }
    });
    
    
    
    function sendReview(pro_id){
        if($("#p_review").val() != ""){
            $("#p_review").css("border","1px solid black");
            $("#p_review").css("background-color","#fff");

            if($("#type_us").val() == <?php echo User::USER_TYPE_PHOTOGRAPHER ?>){
                $.ajax({
                    type: 'get',
                    dataType: 'json',
                    url: 'actions/proyectosAction.php',
                    data: {us:$("#us").val(),us_type:$("#type_us").val(),pro:pro_id,comment:$("#p_review").val(),cal:$("#r_calif").val(),finish:$("input[name='r_finish']:checked").val(),act:"finalizar"},
                    success: function(json){
                        //funcion para llenar los datos del detalle
                        $("#replay").html("<p>Se ha realizado la calificación con éxito. Gracias por darnos tu opinión.<br><br> <a href='perfil' class='txtAzul'>Ir al home</a>");
                    }
                });
            }else if($("#type_us").val() == <?php echo User::USER_TYPE_CLIENT ?>){

                $.ajax({
                    type: 'get',
                    dataType: 'json',
                    url: 'actions/proyectosAction.php',
                    data: {us:$("#us").val(),us_type:$("#type_us").val(),pro:pro_id,comment:$("#p_review").val(),finish:$("input[name='r_finish']:checked").val(),calidad:$("#r_calidad").val(),trato:$("#r_trato").val(),puntual:$("#r_punt").val(),resp:$("#r_resp").val(),prof:$("#r_prof").val(),act:"finalizar"},
                    success: function(json){
                        //funcion para llenar los datos del detalle
                        $("#replay").html("<p>Se ha realizado la calificación con éxito. Gracias por darnos tu opinión.<br><br> <a href='perfil' class='txtAzul'>Ir al home</a>");

                    }
                });
            }

        }else{
            $("#p_review").focus();
            $("#p_review").css("border","1px solid red");
            $("#p_review").css("background-color","#ffcccc");
        }

    }
</script>