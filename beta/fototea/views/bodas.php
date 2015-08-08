<!----------------Animacion de background que se mueve---------------------->
<script>
    $(function () {
        $.stellar({
            horizontalScrolling: false,
            verticalOffset: 80
        });
        $("#animate1").removeClass("hidden");
        $("#animate1").addClass("animated");
        $("#animate1").addClass("slideInRight")
        $("#animate1.slideInRight").delay(500).queue(function(){

                   $("#animate2").removeClass("hidden");
                  $("#animate2").addClass("animated");
        $("#animate2").addClass("slideInRight")    
        
                    $("#animate2.slideInRight").delay(500).queue(function(){

           $("#animate3").removeClass("hidden");
        $("#animate3").addClass("animated");
        $("#animate3").addClass("slideInRight")
        $(this).dequeue(); 
        });
               
        });
            
        $(".img-gallery").hover(function() {
           $(this).removeClass('pulse' + ' animated').addClass('pulse' + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass('pulse' + ' animated');
          });
          
        });
            


        
    });
</script>
<!----------------Fin de animacion---------------------->


<!----------------Banner principal---------------------->
<section class="banner-section row under-header" style="background-image: url(images/Bodas/Dollarphotoclub_55760502_banner.jpg); position: relative;">
    <div class="col-sm-12 banner" style="bottom: 5%; position: absolute; padding-right: 50px;">
        <div class="banner-contenido" style="text-align: right; height: 225px;">
            <h2 class="hidden" style="font-weight: bold; " id="animate1" >Sólo te casas una vez.</h2>
            <h2 class="hidden" id="animate2">Contrata el fotógrafo correcto.</h2>
            <a style="margin-top: 20px;" class="hidden btn btn-alternative btn-lg pull-right" role="button" id="animate3" href="<?php echo $app->getHelper('UrlHelper')->getUrl('agregarProyecto'); ?>">Publica aquí</a>
        </div>
<!--        <img alt="" src="images/Bodas/Dollarphotoclub_55760502_banner.jpg">-->

    </div>
</section>
<!----------------Fin banner ppal---------------------->


<!----------------Descripcion de la categoria---------------------->
<div class="content" style="margin-top: 40px">
    <section class="row categoria-descripcion">
        <div class="col-sm-12">
            <h3>Fotógrafos de Bodas, en Fototea</h3>
        </div>
    </section>

</div>
<!----------------Fin descripcion de la categoria---------------------->

<!----------------Banner fondo que se mueve---------------------->
<section class="banner-second row">
    <div class="photo banner-second-img img-responsive" data-stellar-background-ratio="0.5" style="background-image: url(images/Bodas/Dollarphotoclub_36875084_banner.jpg);">
        <span>Consigue al fotógrafo de boda ideal para el día más especial de tu vida.
            <br/>En Fototea te ayudaremos a descubrir al profesional perfecto para tu gran día.
            <span>
     </div>

</section>
 
 <!----------------Fin banner que se mueve---------------------->
 
 
 
<!----------------Galeria---------------------->

<div class="content" style="margin-top: 60px">
    <section class="row categoria-descripcion">
        <div class="col-sm-12" style="font-size: 18px">
            Elige entre nuestros fotógrafos que ya han capturado eventos inolvidables.
        </div>
    </section>

</div>


<section class="row mosaico" style="margin-top: 50px;">

    <div class="col-sm-3">
        <img class="img-responsive img-thumbnail img-gallery" alt="" src="images/Bodas/Dollarphotoclub_14846350-mini.jpg">
    </div>
    <div class="col-sm-3">


        <div class="row" style="margin-bottom:8px">
            <img class="img-responsive img-thumbnail img-gallery" alt="" src="images/Bodas/Dollarphotoclub_40283365-mini.jpg" height="368px">
        </div>
        <div class="row">
            <img class="img-responsive img-thumbnail img-gallery" alt="" src="images/Bodas/Dollarphotoclub_25006208-mini.jpg" height="368px">
        </div>

    </div>
    <div class="col-sm-3">
        <img class="img-responsive img-thumbnail img-gallery" alt="" src="images/Bodas/Dollarphotoclub_62895446-mini.jpg">
        

    </div>
    <div class="col-sm-3">

        <div class="row" style="margin-bottom:8px">
            <img class="img-responsive img-thumbnail img-gallery" alt="" src="images/Bodas/Dollarphotoclub_46549197-mini.jpg" height="368px">
        </div>
        <div class="row">
            <img class="img-responsive img-thumbnail img-gallery" alt="" src="images/Bodas/Dollarphotoclub_55760502-mini.jpg" height="368px">
        </div>

    </div>

    <div class="col-sm-12" style="text-align: center;">
        <a style="margin-top: 60px; " class="btn btn-alternative btn-lg" role="button" href="<?php echo $app->getHelper('UrlHelper')->getUrl('agregarProyecto'); ?>">Publica aquí</a>
    </div>

</section>




<!----------------Fin galeria---------------------->
 