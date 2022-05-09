

<!-- <div id="carouselHome" class="carousel slide" data-ride="carousel"> -->
<?php $activeSlide; ?>
<div id="carouselHome" class="carousel slide" data-ride="carousel">
     <div class="container-fluid w-1800">
        <div class="row">
        <div class="col-1">
               <!-- left button -->
                <a class="carousel-control-prev" href="#carouselHome" role="button" data-slide="prev">
                    <span  aria-hidden="true" class="home-slider-span-arrow">
                        <img class="img-arrow-blue" src="<?php echo get_template_directory_uri() ?>/library/images/left_arrow.svg">
                    </span>
                    <span class="sr-only">Previous</span>
                </a>
         </div>

         <div class="col-10">
            <div class="carousel-inner">
        
                <?php $i = 0; foreach ( $slides as $s ) : ?>
                    <div class="carousel-item <?php if($i == 0) { ?>active<?php } ?>">
                        <div class="container-fluid">
                            <div class="row w-1350">
                                <div class="col-sm-12 col-md-12 col-lg-6 flex-col">
                                    <div class="slider-left-html-container">
                                        <?php if ( $s['title'] ) :  echo  $s['title']; endif; 
                                            if ( $s['texts'] ) :  echo  $s['texts'];  endif;  
                                            if ( $s['button'] ) :  $button = $s['button']; ?>
                                            <!-- <a class="dark-blue h-s-b"
                                                role = "button" 
                                                href="<?php echo esc_url( $button['button_link'] ); ?>"
                                                target="<?php echo $button['button_target'] ? '_blank' : '_self' ?>">
                                                <?php esc_html_e( $button['button_text'], 'tora' ); ?>
                                            </a>  -->
                                            <?php endif; ?>
                                            <!-- <div class="download-images-container-home"> 
                                                    <a href="https://play.google.com/store/apps/details?id=tora.wallet.android" target="_blank"> <img src="<?php echo get_template_directory_uri() ?>/library/images/Google-Play.png" alt="Tora Wallet Android">  </a>
                                                    <a href="https://apps.apple.com/us/app/tora/id1482376985" target="_blank"> <img src="<?php echo get_template_directory_uri() ?>/library/images/iOS.png" alt="Tora Wallet IOS">  </a>
                                            </div> -->
                                            <?php if ($i == 0): ?>
                                                <!-- <div class="download-images-container-home"> 
                                                    <a href="https://play.google.com/store/apps/details?id=tora.wallet.android" target="_blank"> <img src="<?php echo get_template_directory_uri() ?>/library/images/Google-Play.png" alt="Tora Wallet Android">  </a>
                                                    <a href="https://apps.apple.com/us/app/tora/id1482376985" target="_blank"> <img src="<?php echo get_template_directory_uri() ?>/library/images/iOS.png" alt="Tora Wallet IOS">  </a>
                                            </div> -->
                                            <?php endif; ?>       
                                    </div>
                                </div>
                                    
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <img class="img-fluid a-pos" src="<?php echo $s['image'] ?>" alt="">
                                </div>
                            </div>
                        
                        </div>   
                    </div>
                <?php $i++; endforeach ?>
             </div>
         </div>

         <div class="col-1">
                <!-- right button -->
            <a class="carousel-control-next" href="#carouselHome" role="button" data-slide="next">
                <span  aria-hidden="true" class="home-slider-span-arrow">
                    <img class="img-arrow-blue" src="<?php echo get_template_directory_uri() ?>/library/images/right_arrow.svg">
                </span>
                <span class="sr-only">Next</span>
            </a>
         </div>
        </div>
       
     </div>
   
      <!--  -->

  
    
    <!--  -->
    <div class="container-fluid">
        <div class="row w-b-1350">
                <div class="col-sm-12 slider-buttons">
                    <button id="startStop" class="but btn-customized paused"> 
                        <i class="fas fa-play"></i>   
                   </button>
                   <div class="carousel-indicators">
                        <?php $index = 1; foreach (  $slides  as $s ) :  ?>
                            <button data-target="#carouselHome" data-slide-to="<?php echo $index - 1 ?>" <?php if($index==1) { ?>class="active"<?php } ?>> <?php echo $index ?> </button>
                        <?php $index++; endforeach ?>
                   </div>
                  
                </div>
            </div>
    </div>
</div>