<?php  /* Template: Pudo Page */ ?>

<main id="main" role="main" itemprop="mainContentOfPage">


    <header class="service-header">
        <div class="featured-image intro-text flex-col flex p-1"
            style="background: url('<?php echo esc_url( get_the_post_thumbnail_url() ); ?>') no-repeat center; background-size: cover; min-height: 500px; position: relative;">
            <h1 class="page-title" itemprop="headline" style="position: absolute; top: 10%; left: 5%;">
                <?php get_field( 'header_title' ) ? the_field( 'header_title' ) : the_title(); ?></h1>
            <p class="service-intro normal pudo h3"><?php the_field( 'subtitle' ); ?></p>
        </div>
    </header>




    <div style="width:100%; height: 20px"></div>

    <div class="pudo-page">
        <div class="container w-1000">
            <?php the_field('pudo_first_section') ?>
        </div>

        <!-- Top Tabs Sections -->
        <div class="container w-1000">
            <div class="row justify-content-center d-none d-md-flex">
                <?php $tabsTop = get_field('pudo_second_section'); foreach ($tabsTop as $t) : ?>
                <div class="col-12 col-md-4 center-items">
                    <div class="row">
                        <div class="col-sm-12">
                            <img src="<?php echo $t['image']['url'] ?>" alt="<?php echo  $t['image']['alt'] ?>">
                        </div>
                        <div class="col-12">
                            <div class="tab-title">
                                <a href="#<?php echo $t['pudo_button_id'] ?>" style="font-size: 18px; color:#0266A2; line-height: 1.2; padding: 2% 1%;font-weight: 500;"> <?php echo $t['title'] ?></a>
                            </div>
                        </div>
                        <div class="col-12">
                            <a class="dark-blue h-s-b" href="#<?php echo $t['pudo_button_id'] ?>-how-to" role="button"> <i
                                    class="fas fa-arrow-down"></i> <?php echo $t['button_text'] ?></a>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>


            </div>
            <!-- mobile -->
            <div class="row d-flex d-md-none mob-row">
                <?php $tabsTop = get_field('pudo_second_section'); foreach ($tabsTop as $t) : ?>
                <div class="row mob-inner-row">
                    <div class="col-4">
                        <img class="row-mb-image" src="<?php echo $t['image']['url'] ?>" alt="<?php echo $t['image']['alt'] ?>">
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-12">
                                <div class="tab-title">
                                    <h5 style="color:#0266A2"> <?php echo $t['title'] ?></h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <a class="dark-blue h-s-b" href="#<?php echo $t['pudo_button_id'] ?>" role="button"> <i
                                        class="fas fa-arrow-down"></i> <?php echo $t['button_text'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>

        <br>
        <br>

        <!-- Παραλαβή Online Αγορών -->
        <div  id="paralavi-online-agoron" class="container top-section-part pl-0">
            <?php the_field('third_section_top_part') ?>
        </div>

        <div id="paralavi-online-agoron-how-to"  class="container grey-container">
            <h4> <?php the_field('third_section_mid_part_title') ?> </h4>
            <div class="row justify-content-center d-none d-lg-flex">

                <?php $index=1; $thirdSectiontabs = get_field('third_section_mid_part_tabs'); foreach ($thirdSectiontabs as $thirdSecionTab) : ?>
                <div class="col-4 center-items">
                    <div class="row">
                        <div class="col-sm-12">
                            <img src="<?php echo $thirdSecionTab['image']['url'] ?>" alt="<?php echo $thirdSecionTab['image']['alt'] ?>">
                            <span class="tab-number"> <?php echo $index; ?> </span>
                        </div>
                        <div class="col-12">
                            <div class="tab-title">
                                <p> <?php echo $thirdSecionTab['text'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $index++; endforeach ?>
            </div>
            <!-- tablet -->
            <div class="row d-none d-sm-flex d-md-flex d-lg-none">
                <?php $index=1; $thirdSectiontabs = get_field('third_section_mid_part_tabs'); foreach ($thirdSectiontabs as $thirdSecionTab) : ?>
                <div class="row tablet-row">
                    <div class="col-4">
                        <img src="<?php echo $thirdSecionTab['image']['url'] ?>" alt="<?php echo $thirdSecionTab['image']['alt'] ?>">
                        <span class="tab-number"> <?php echo $index; ?> </span>
                    </div>
                    <div class="col-8">
                        <div class="tab-title">
                            <p class="p-md"> <?php echo $thirdSecionTab['text'] ?></p>
                        </div>
                    </div>
                </div>
                <?php $index++; endforeach ?>
            </div>
            <!-- mobile -->
            <div class="row d-sm-none row-mobile">
                <?php $index=1; $thirdSectiontabs = get_field('third_section_mid_part_tabs'); foreach ($thirdSectiontabs as $thirdSecionTab) : ?>
                <div class="row tab-row-mob">
                    <div class="col-sm-12">
                        <img src="<?php echo $thirdSecionTab['image']['url'] ?>" alt="<?php echo $thirdSecionTab['image']['alt'] ?>">
                        <span class="tab-number"> <?php echo $index; ?> </span>
                    </div>
                    <div class="col-12">
                        <div class="tab-title">
                            <p> <?php echo $thirdSecionTab['text'] ?></p>
                        </div>
                        <?php $display = 'block'; if (sizeof($thirdSectiontabs) == $index) { $display = 'none'; } ?>
                        <div class="line-dotted" style="display: <?php echo $display ?>"> </div>
                    </div>
                </div>
                <?php $index++; endforeach ?>
            </div>

            <!-- Inside Button -->
            <div class="container d-lg-none">
                <div class="row">
                    <div class="col-12 pl-0">
                        <a class="dark-blue-reverse" href="<?php echo the_field('pudo_third_section_button_url')  ?>"
                            role="button"> <?php the_field('pudo_third_section_button_text') ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div style="width:100%; height: 20px"></div>

        <div class="container d-none d-lg-flex">
            <div class="row">
                <div class="col-12 pl-0">
                    <a class="dark-blue-reverse" href="<?php echo the_field('pudo_third_section_button_url')  ?>"
                        role="button"> <?php the_field('pudo_third_section_button_text') ?></a>
                </div>
            </div>
        </div>

        <div style="width:100%; height: 80px"></div>


        <!-- Πως λειτουργούν οι αποστολές δεμάτων και φακέλων  -->
        <div  id="apostoli-dematon-fakelon"  class="container top-section-part pl-0">
            <?php the_field('forth_section_top_part') ?>
        </div>


        <div id="apostoli-dematon-fakelon-how-to" class="container grey-container">
            <h4> <?php the_field('forth_section_mid_part_title') ?> </h4>
            <div class="row justify-content-center d-none d-lg-flex">

                <?php $index=1; $forthSectiontabs = get_field('forth_section_mid_part_tabs'); foreach ($forthSectiontabs as $forthSecionTab) : ?>
                <div class="col-3 center-items">
                    <div class="row">
                        <div class="col-sm-12">
                            <img src="<?php echo $forthSecionTab['image']['url'] ?>" alt="<?php echo $forthSecionTab['image']['alt'] ?>">
                            <span class="tab-number"> <?php echo $index; ?> </span>
                        </div>
                        <div class="col-12">
                            <div class="tab-title">
                                <p> <?php echo $forthSecionTab['text'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $index++; endforeach ?>
            </div>
            <!-- Tablet -->
            <div class="row d-none d-sm-flex d-md-flex d-lg-none">
                <?php $index=1; $forthSectiontabs = get_field('forth_section_mid_part_tabs'); foreach ($forthSectiontabs as $forthSecionTab) : ?>
                <div class="row tablet-row">
                    <div class="col-sm-4">
                        <img src="<?php echo $forthSecionTab['image']['url'] ?>" alt="<?php echo $forthSecionTab['image']['alt'] ?>">
                        <span class="tab-number extra-bottom"> <?php echo $index; ?> </span>
                    </div>
                    <div class="col-sm-8">
                        <div class="tab-title">
                            <p class="p-md"> <?php echo $forthSecionTab['text'] ?></p>
                        </div>
                    </div>
                </div>
                <?php $index++; endforeach ?>
            </div>
            <!-- mobile -->
            <div class="row d-sm-none row-mobile">
                <?php $index=1; $forthSectiontabs = get_field('forth_section_mid_part_tabs'); foreach ($forthSectiontabs as $forthSecionTab) : ?>
                <div class="row tab-row-mob">
                    <div class="col-sm-12">
                        <img src="<?php echo $forthSecionTab['image']['url'] ?>" alt="<?php echo $forthSecionTab['image']['alt'] ?>">
                        <span class="tab-number"> <?php echo $index; ?> </span>
                    </div>
                    <div class="col-12">
                        <div class="tab-title">
                            <p> <?php echo $forthSecionTab['text'] ?></p>
                        </div>
                        <?php $display = 'block'; if (sizeof($forthSectiontabs) == $index) { $display = 'none'; } ?>
                        <div class="line-dotted" style="display: <?php echo $display ?>"> </div>
                    </div>
                </div>
                <?php $index++; endforeach ?>
            </div>
            <!-- Inside Button -->
            <div class="container d-lg-none">
                <div class="row">
                    <div class="col-12 pl-0">
                        <a class="dark-blue-reverse" href="<?php echo the_field('pudo_forth_section_button_url')  ?>"
                            role="button"> <?php the_field('pudo_forth_section_button_text') ?></a>
                    </div>
                </div>
            </div>

        </div>
        <div style="width:100%; height: 20px"></div>

        <div class="container d-none d-lg-flex">
            <div class="row">
                <div class="col-12 pl-0">
                    <a class="dark-blue-reverse" href="<?php echo the_field('pudo_forth_section_button_url')  ?>"
                        role="button"> <?php the_field('pudo_forth_section_button_text') ?></a>
                </div>
            </div>
        </div>

        <div style="width:100%; height: 80px"></div>


        <!-- Πως λειτουργούν οι επιστροφές σε e-Shops  -->
        <div id="epistrofes-eshops" class="container top-section-part pl-0">
            <?php the_field('fifth_section_top_part') ?>
        </div>

        <div id="epistrofes-eshops-how-to" class="container grey-container">
            <h4> <?php the_field('fifth_section_mid_part_title') ?> </h4>
            <div class="row justify-content-center d-none d-lg-flex">

                <?php $index=1; $fifthSectiontabs = get_field('fifth_section_mid_part_tabs'); foreach ($fifthSectiontabs as $fifthSecionTab) : ?>
                <div class="col-3 center-items">
                    <div class="row">
                        <div class="col-sm-12">
                            <img src="<?php echo $fifthSecionTab['image']['url'] ?>" alt="<?php echo $fifthSecionTab['image']['alt'] ?>">
                            <span class="tab-number"> <?php echo $index; ?> </span>
                        </div>
                        <div class="col-12">
                            <div class="tab-title">
                                <p> <?php echo $fifthSecionTab['text'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $index++; endforeach ?>
            </div>
            <!-- Tablet -->
            <div class="row d-none d-sm-flex d-md-flex d-lg-none">
                <?php $index=1; $fifthSectiontabs = get_field('fifth_section_mid_part_tabs'); foreach ($fifthSectiontabs as $fifthSecionTab) : ?>
                <div class="row tablet-row">
                    <div class="col-sm-4">
                        <img src="<?php echo $fifthSecionTab['image']['url'] ?>" alt="<?php echo $fifthSecionTab['image']['alt'] ?>">
                        <span class="tab-number extra-bottom"> <?php echo $index; ?> </span>
                    </div>
                    <div class="col-sm-8">
                        <div class="tab-title">
                            <p class="p-md"> <?php echo $fifthSecionTab['text'] ?></p>
                        </div>
                    </div>
                </div>
                <?php $index++; endforeach ?>
            </div>
            <!-- mobile -->
            <div class="row d-sm-none row-mobile">
                <?php $index=1; $fifthSectiontabs = get_field('forth_section_mid_part_tabs'); foreach ($fifthSectiontabs as $fifthSecionTab) : ?>
                <div class="row tab-row-mob">
                    <div class="col-sm-12">
                        <img src="<?php echo $fifthSecionTab['image']['url'] ?>" alt="<?php echo $fifthSecionTab['image']['alt'] ?>">
                        <span class="tab-number"> <?php echo $index; ?> </span>
                    </div>
                    <div class="col-12">
                        <div class="tab-title">
                            <p> <?php echo $fifthSecionTab['text'] ?></p>
                        </div>
                        <?php $display = 'block'; if (sizeof($fifthSectiontabs) == $index) { $display = 'none'; } ?>
                        <div class="line-dotted" style="display: <?php echo $display ?>"> </div>
                    </div>
                </div>
                <?php $index++; endforeach ?>
            </div>
            <!-- Inside Button -->
            <div class="container d-lg-none">
                <div class="row">
                    <div class="col-12 pl-0">
                        <a class="dark-blue-reverse"
                            href="<?php echo the_field('pudo_fifth_section_button_url_copy')  ?>" role="button">
                            <?php the_field('pudo_fifth_section_button_text') ?></a>
                    </div>
                </div>
            </div>

        </div>
        <div style="width:100%; height: 20px"></div>

        <div class="container d-none d-lg-flex">
            <div class="row">
                <div class="col-12 pl-0">
                    <a class="dark-blue-reverse" href="<?php echo the_field('pudo_fifth_section_button_url')  ?>"
                        role="button"> <?php the_field('pudo_fifth_section_button_text') ?></a>
                </div>
            </div>
        </div>

        <div style="width:100%; height: 80px"></div>


    </div>

    <!-- Map -->
    <?php
if ( have_rows( 'element' ) ) :  while ( have_rows( 'element' ) ) : the_row();

$rl =   get_row_layout();

$column 	  = get_sub_field( 'column_content' );
$column_bg 	  = $column['background']['background_image'];
$column_class = $column['background']['add_overlay'] ? 'overlay' : ''; ?>

    <div class="page-section one-column-section has-bg-color"
        style="background-color: <?php esc_attr_e( get_sub_field( 'row_background_color' ) ); ?>">
        <div class="wrap grid-row">
            <div class="column col-12 <?php esc_attr_e( $column_class ); ?>"
                <?php echo $column_bg ? 'style="background-image: url(' . esc_url( $column_bg ) . '); min-height: ' . esc_attr( get_sub_field( 'column_min_height' ) ) . 'px;"' : ''; ?>>

                <?php
            $btn_class = 'white' === $column['button']['style'] ? 'button button-white' : 'button';

            echo $column['title'] ? '<h2 style="max-width: 60%; color: #fff">' . esc_html( $column['title'] ) . '</h2>' : '';

	    $pudo_term = get_term_by('name', 'Παραλαβή και επιστροφή δεμάτων', 'location-category');

	    ?>  <p class="counter h1"><span data-count="<?php echo $pudo_term->count; ?>">0</span></p>
            <?php if ( $column['counter'] ) :
                $total = wp_count_posts( 'location' )->publish; ?>
                <!-- <?php esc_attr_e( $total ); ?> -->
                <!-- <p class="counter h1"><span data-count="50">0</span></p> -->
                <?php
            endif;

            echo $column['text'] ? '<p>' . esc_html( $column['text'] ) . '</p>' : '';
            echo $column['button']['link'] ? '<a class="' . esc_attr( $btn_class ) . '" href="' . esc_url( $column['button']['link'] ) . '">' . esc_html( $column['button']['text'] ) . '</a>' : ''; ?>
            </div>
        </div>
    </div>

    <?php endwhile; endif;?>
</main>
