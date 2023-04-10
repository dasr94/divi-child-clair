<?php
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_script( 'lottie_js', get_stylesheet_directory_uri() . '/lottie.js', array(), filemtime( get_stylesheet_directory_uri() . '/lottie.js' ) , false );
    wp_enqueue_script( 'qrcode_js', get_stylesheet_directory_uri() . '/qrcode.min.js', array('jquery'), filemtime( get_stylesheet_directory_uri() . '/qrcode.min.js' ) , false );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


function WooCommerce_cart_count() {
    global $woocommerce;
    //echo '<span class="cuenta-carrito">' . wc()->cart->get_cart_contents_count() . '</span>';
    //echo '#';
}
add_action( 'woocommerce_before_cart', 'woocommerce_cart_count' );

function prueba_shc(){
    return 'hola';
}






/* function lottie_enqueque_script() {
} */

function image_post( int $post_id, string $size = 'full' ){
    $img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size, true );
    return $img[0];
}

function shc_zona($atts){
    $categories = shortcode_atts( array (
        'categories' => 0,
        'departamento' => 'san salvador',
        'zona' => 'occidental'
    ), $atts );

    $pos = strpos($categories['departamento'], ",");
    if($pos > 0){

        $deps = explode( "," , $categories['departamento']);
        $meta_query = array('relation' => 'OR');
        foreach($deps as $dep => $val){
            $meta_query[] = array(
                'key' => 'departamentos',
                'value' => serialize("'" . $val . "'"),
                'compare' => 'LIKE'
            );
        }
        $args = array(
            'post_per_page' => -1,
            'post_type' => 'project',
            'post_status' => 'publish',
            'meta_query' => $meta_query
        );
    } else {
        $args = array(
            'post_per_page' => -1,
            'post_type' => 'project',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'departamento',
                    'value' => serialize( $categories['departamento'] ) ,
                    'compare' => 'LIKE'
                )
            )
        );

    }

	


	$i = 0;	
    $query = new WP_Query($args);
    if( $query->have_posts() ){
        while( $query->have_posts() ){
			$i++;
			$query->the_post();
			$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $size, true );
            $tel = '';
            if( substr(get_field('telefono'),0,1) == '2' ){
                $tel = '<a class="et_pb_button dipi-carousel-button" style="font-family: FontAwesome!important;color: #081830!important; border-color: #fff; font-size: 14px; background-color: #fff; /*transform: scale(.6) translateY(60px)*/" href="tel:+503' . get_field('telefono') . '"></a>';
            } else {
                $tel = '<a class="et_pb_button dipi-carousel-button" style="font-family: FontAwesome!important;color: #081830!important; border-color: #fff; font-size: 14px; background-color: #fff; /*transform: scale(.6) translateY(60px)*/" href="https://api.whatsapp.com/send?phone=503' . get_field('telefono') . '&text=Hola,%20te%20encontre%20en%20tumedicosv.com"></a>';
            }
            $dep = get_field('departamento');
			//var_dump( get_the_category(get_the_ID()) );
			$return2 .= '<div class="et_pb_column et_pb_column_1_3 et_pb_column_2  et_pb_css_mix_blend_mode_passthrough"> <div class="dipi-carousel-wrapper" style="">';
            $return2 .= '
            <div class="et_pb_module dipi_carousel_child dipi_carousel_child_0 swiper-slide-duplicate" data-swiper-slide-index="2" style="width: 100%; margin-right: 30px; display: flex; font-size: 14px; padding-top: 200px; justify-content: flex-start; flex-shrink: 0; flex-direction: column; float: none !important; overflow: hidden; height: auto; clear: none !important;  background-image: linear-gradient(180deg,rgba(38,61,123,0) 38%,rgba(8,24,48,0.62) 100%),url(\'' . $img[0] . '\');  position: relative; filter: opacity(100%); height: 389px;">
            ';
			$return2 .= '
                <div class="et_pb_module_inner">
                    <div class="dipi-carousel-child-wrapper">
                        <div class="dipi-image-wrap">
                            <span class="dipi-carousel-image " href="">
                                <img src="" alt="">
                            </span>
                        </div>
                        <div class="dipi-carousel-item-content">
                            <h2 class="dipi-carousel-item-title" style="color: white;">'. get_the_title() .'</h2>
                            <div class="dipi-carousel-item-desc">
                                <p style="color: white;">'. get_field('especialidad') .'</p>
                            </div>
                            <div class="dipi-carousel-button-wrapper">
                                <a class="et_pb_button dipi-carousel-button" style="color: #081830!important; border-color: #fff; font-size: 14px; background-color: #fff; /*transform: scale(.6) translateY(60px)*/" href=" ' . get_the_permalink() . ' ">Ver Perfil</a>
                                '.$tel.'
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			</div></div>
            ';
        }
    }
	$return2 .= '';
	return $return2;
}

function makeQRCode(){

    $link = get_permalink();
    $texto2 = '
    <div style="margin: 0 auto; width: 256px;" id="qrcode"></div>
    <script type="text/javascript">
        new QRCode(document.getElementById("qrcode"), "'.$link.'");
    </script>
    ';
	$texto = "hola";
	return $texto2;

}

function zona_especialidad(){
    
	$zona_occidental = ['sonsonate', 'santa ana', 'ahuchapan'];
    $zona_central = ['la libertad', 'san salvador', 'chalatenango', 'cuscaltan', 'san vicente', 'cabanas', 'la paz'];
    $zona_oriental = ['la union', 'morazan', 'san miguel', 'usulutan'];
	$zona = $_REQUEST['zona'];
    $especialidad = $_REQUEST['especialidad'];
    $return2 = '';

    $args_occidente = array(
        
        'post_type' => 'project',
        'post_status' => 'publish',
		'post_per_page' => -1,
		'nopaging' => true,
		'meta_query' => array(
			'relation' => 'OR',
            array(
                'key' => 'departamento',
                'value' => serialize( 'sonsonate' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'santa ana' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'ahuchapan' ),
                'compare' => 'LIKE'
            ),
        )
    );
    $args_central = array(
        
        'post_type' => 'project',
        'post_status' => 'publish',
		'post_per_page' => -1,
		'nopaging' => true,
		'meta_query' => array(
			'relation' => 'OR',
            array(
                'key' => 'departamento',
                'value' => serialize( 'san salvador' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'la libertad' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'chalatenango' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'la paz' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'cuscaltan' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'cabanas' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'san vicente' ),
                'compare' => 'LIKE'
            ),
        )
    );
    $args_oriental = array(
        
        'post_type' => 'project',
        'post_status' => 'publish',
		'post_per_page' => -1,
		'nopaging' => true,
		'meta_query' => array(
			'relation' => 'OR',
            array(
                'key' => 'departamento',
                'value' => serialize( 'la union' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'morazan' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'san miguel' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'usulutan' ),
                'compare' => 'LIKE'
            ),
        )
    );

    switch ($zona) {
        case 'occidental':
            $args = $args_occidente;
            break;
        case 'central':
            $args = $args_central;
            break;
        case 'oriental':
            $args = $args_oriental;
            break;
        
        default:
            $args = $args_central;
            break;
    }

	$i = 0;
    $return2 .= '<h3>Los mejores especialistas de la zona '. $zona .'</h3>';
	$query = new WP_Query($args);
    if( $query->have_posts() ){
        while( $query->have_posts() ){
            $query->the_post();
			$i++;
			//var_dump(get_field('departamento'));
			//var_dump(get_field('espe'));
			//echo get_the_title();
            if( in_array($especialidad, get_field('espe')) ){
				
                
                $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $size, true );
                $tel = '';
                if( substr(get_field('telefono'),0,1) == '2' ){
                    $tel = '<a class="et_pb_button dipi-carousel-button" style="font-family: FontAwesome!important;color: #081830!important; border-color: #fff; font-size: 14px; background-color: #fff; /*transform: scale(.6) translateY(60px)*/" href="tel:+503' . get_field('telefono') . '"></a>';
                } else {
                    $tel = '<a class="et_pb_button dipi-carousel-button" style="font-family: FontAwesome!important;color: #081830!important; border-color: #fff; font-size: 14px; background-color: #fff; /*transform: scale(.6) translateY(60px)*/" href="https://api.whatsapp.com/send?phone=503' . get_field('telefono') . '&text=Hola,%20te%20encontre%20en%20tumedicosv.com"></a>';
                }
                //var_dump( get_the_category(get_the_ID()) );
                $return2 .= '<div class="et_pb_column et_pb_column_1_3 et_pb_column_2  et_pb_css_mix_blend_mode_passthrough custom-grid"> <div class="dipi-carousel-wrapper" style="">';
                $return2 .= '
                <div class="et_pb_module dipi_carousel_child dipi_carousel_child_0 swiper-slide-duplicate" data-swiper-slide-index="2" style="width: 100%; margin-right: 30px; display: flex; font-size: 14px; padding-top: 200px; justify-content: flex-start; flex-shrink: 0; flex-direction: column; float: none !important; overflow: hidden; height: auto; clear: none !important;  background-image: linear-gradient(180deg,rgba(38,61,123,0) 38%,rgba(8,24,48,0.62) 100%),url(\'' . $img[0] . '\');  position: relative; filter: opacity(100%); height: 389px; ">
                ';
                $return2 .= '
                    <div class="et_pb_module_inner">
                        <div class="dipi-carousel-child-wrapper">
                            <div class="dipi-image-wrap">
                                <span class="dipi-carousel-image " href="">
                                    <img src="" alt="">
                                </span>
                            </div>
                            <div class="dipi-carousel-item-content">
                                <h2 class="dipi-carousel-item-title" style="color: white; font-size: 24px; line-height: 1em;">'. get_the_title() .'</h2>
                                <div class="dipi-carousel-item-desc">
                                    <p style="color: white;">'. get_field('especialidad') .'</p>
                                </div>
                                <div class="dipi-carousel-button-wrapper">
                                    <a class="et_pb_button dipi-carousel-button" style="color: #081830!important; border-color: #fff; font-size: 14px; background-color: #fff; /*transform: scale(.6) translateY(60px)*/" href=" ' . get_the_permalink() . ' ">Ver Perfil</a>
                                    '.$tel.'
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div></div>
                ';
            }
        }
    }
	$return2 .= '';
	if( $i == 0 ){
		$return2 = '
		<div class="et_pb_module et_pb_cta_0 et_pb_promo  et_pb_text_align_center et_pb_bg_layout_dark">
            <div class="et_pb_promo_description">
                <h2 class="et_pb_module_header" style="color: #09A2D6 !important">¡Lo lamentamos!</h2>
                <div>
                    <p style="color: #09A2D6">Aun no tenemos doctores con esta especialidad en esta zona, trabajamos para poder brindarte la informacion que buscas.</p>
                </div>
            </div>
            <div class="et_pb_button_wrapper"><a class="et_pb_button et_pb_promo_button" href="tumedicosv.com">Regresar al inicio</a></div>
        </div>
		';
	}
	return $return2;
}
function todas_especialidad(){
    $especialidad = $_REQUEST['especialidad'];

  $args = array(
      
      'post_type' => 'project',
      'post_status' => 'publish',
      'post_per_page' => -1,
      'nopaging' => true,
      'meta_query' => array(
          array(
              'key' => 'espe',
              'value' => $especialidad ,
              'compare' => 'LIKE'
          )
      )
  );

  $i = 1;
  $query = new WP_Query($args);
  if( $query->have_posts() ){
    while( $query->have_posts() ){ 
      $query->the_post();
      //echo $i;
      $i++;
      //echo get_the_title();
      //echo "============";
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $size, true );
                $tel = '';
                if( substr(get_field('telefono'),0,1) == '2' ){
                    $tel = '<a class="et_pb_button dipi-carousel-button" style="font-family: FontAwesome!important;color: #081830!important; border-color: #fff; font-size: 14px; background-color: #fff; /*transform: scale(.6) translateY(60px)*/" href="tel:+503' . get_field('telefono') . '"></a>';
                } else {
                    $tel = '<a class="et_pb_button dipi-carousel-button" style="font-family: FontAwesome!important;color: #081830!important; border-color: #fff; font-size: 14px; background-color: #fff; /*transform: scale(.6) translateY(60px)*/" href="https://api.whatsapp.com/send?phone=503' . get_field('telefono') . '&text=Hola,%20te%20encontre%20en%20tumedicosv.com"></a>';
                }
                //var_dump( get_the_category(get_the_ID()) );
                $return2 .= '<div class="et_pb_column et_pb_column_1_3 et_pb_column_2  et_pb_css_mix_blend_mode_passthrough custom-grid"> <div class="dipi-carousel-wrapper" style="">';
                $return2 .= '
                <div class="et_pb_module dipi_carousel_child dipi_carousel_child_0 swiper-slide-duplicate" data-swiper-slide-index="2" style="width: 100%; margin-right: 30px; display: flex; font-size: 14px; padding-top: 200px; justify-content: flex-start; flex-shrink: 0; flex-direction: column; float: none !important; overflow: hidden; height: auto; clear: none !important;  background-image: linear-gradient(180deg,rgba(38,61,123,0) 38%,rgba(8,24,48,0.62) 100%),url(\'' . $img[0] . '\');  position: relative; filter: opacity(100%); height: 389px; ">
                ';
                $return2 .= '
                    <div class="et_pb_module_inner">
                        <div class="dipi-carousel-child-wrapper">
                            <div class="dipi-image-wrap">
                                <span class="dipi-carousel-image " href="">
                                    <img src="" alt="">
                                </span>
                            </div>
                            <div class="dipi-carousel-item-content">
                                <h2 class="dipi-carousel-item-title" style="color: white;">'. get_the_title() .'</h2>
                                <div class="dipi-carousel-item-desc">
                                    <p style="color: white;">'. get_field('especialidad') .'</p>
                                </div>
                                <div class="dipi-carousel-button-wrapper">
                                    <a class="et_pb_button dipi-carousel-button" style="color: #081830!important; border-color: #fff; font-size: 14px; background-color: #fff; /*transform: scale(.6) translateY(60px)*/" href=" ' . get_the_permalink() . ' ">Ver Perfil</a>
                                    '.$tel.'
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div></div>
                ';
    }
  }
	$return2 .= '';
	return $return2;
}
function especialidad_departamento(){
    $especialidad = $_REQUEST['especialidad'];
    $depa = $_REQUEST['depa'];

  $args = array(
      
      'post_type' => 'project',
      'post_status' => 'publish',
      'post_per_page' => -1,
      'nopaging' => true,
      'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'departamento',
                'value' => $depa,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'espe',
                'value' => $especialidad ,
                'compare' => 'LIKE'
            )
      )
  );

  $i = 1;
  $query = new WP_Query($args);
  if( $query->have_posts() ){
    while( $query->have_posts() ){ 
      $query->the_post();
      //echo $i;
      $i++;
      //echo get_the_title();
      //echo "============";
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $size, true );
                $tel = '';
                if( substr(get_field('telefono'),0,1) == '2' ){
                    $tel = '<a class="et_pb_button dipi-carousel-button" style="font-family: FontAwesome!important;color: #081830!important; border-color: #fff; font-size: 14px; background-color: #fff; /*transform: scale(.6) translateY(60px)*/" href="tel:+503' . get_field('telefono') . '"></a>';
                } else {
                    $tel = '<a class="et_pb_button dipi-carousel-button" style="font-family: FontAwesome!important;color: #081830!important; border-color: #fff; font-size: 14px; background-color: #fff; /*transform: scale(.6) translateY(60px)*/" href="https://api.whatsapp.com/send?phone=503' . get_field('telefono') . '&text=Hola,%20te%20encontre%20en%20tumedicosv.com"></a>';
                }
                //var_dump( get_the_category(get_the_ID()) );
                $return2 .= '<div class="et_pb_column et_pb_column_1_3 et_pb_column_2  et_pb_css_mix_blend_mode_passthrough custom-grid"> <div class="dipi-carousel-wrapper" style="">';
                $return2 .= '
                <div class="et_pb_module dipi_carousel_child dipi_carousel_child_0 swiper-slide-duplicate" data-swiper-slide-index="2" style="width: 100%; margin-right: 30px; display: flex; font-size: 14px; padding-top: 200px; justify-content: flex-start; flex-shrink: 0; flex-direction: column; float: none !important; overflow: hidden; height: auto; clear: none !important;  background-image: linear-gradient(180deg,rgba(38,61,123,0) 38%,rgba(8,24,48,0.62) 100%),url(\'' . $img[0] . '\');  position: relative; filter: opacity(100%); height: 389px; ">
                ';
                $return2 .= '
                    <div class="et_pb_module_inner">
                        <div class="dipi-carousel-child-wrapper">
                            <div class="dipi-image-wrap">
                                <span class="dipi-carousel-image " href="">
                                    <img src="" alt="">
                                </span>
                            </div>
                            <div class="dipi-carousel-item-content">
                                <h2 class="dipi-carousel-item-title" style="color: white;">'. get_the_title() .'</h2>
                                <div class="dipi-carousel-item-desc">
                                    <p style="color: white;">'. get_field('especialidad') .'</p>
                                </div>
                                <div class="dipi-carousel-button-wrapper">
                                    <a class="et_pb_button dipi-carousel-button" style="color: #081830!important; border-color: #fff; font-size: 14px; background-color: #fff; /*transform: scale(.6) translateY(60px)*/" href=" ' . get_the_permalink() . ' ">Ver Perfil</a>
                                    '.$tel.'
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div></div>
                ';
    }
  }
	$return2 .= '';
	return $return2;
}
function especialidadesZonaCentro(){

    $args = array(
        
        'post_type' => 'project',
        'post_status' => 'publish',
		'post_per_page' => -1,
		'nopaging' => true,
		'meta_query' => array(
			'relation' => 'OR',
            array(
                'key' => 'departamento',
                'value' => serialize( 'san salvador' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'la libertad' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'chalatenango' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'la paz' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'cuscaltan' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'cabanas' ),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'departamento',
                'value' => serialize( 'san vicente' ),
                'compare' => 'LIKE'
            ),
        )
    );

    $output = '
    
    <div id="frmBuscador" style="display: none;">
        <form method="GET" action="https://tumedicosv.com/busqueda/">
            <input type="hidden" name="zona" value="central">
            <select name="especialidad">
                <option value="ginecologia">ginecologia</option>
            </select>
            <button type="submit" style="padding: 20px; border-radius: 30px; background: rgba(0,0,0,0.3); color: white; font-family: "Raleway",Helvetica; font-weight: 300;"> <svg style="width: 15px;" xmlns="http://www.w3.org/2000/svg" id="Layer_1" x="0" y="0" version="1.1" viewBox="0 0 29 29" xml:space="preserve"><circle cx="11.854" cy="11.854" r="9" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="2"/><path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" d="M18.451 18.451l7.695 7.695"/></svg> </button>
        </form>
    </div>
    <button onclick="mostrarInput();" style="padding: 20px; border-radius: 30px; background: rgba(0,0,0,0.3); color: white; font-family: "Raleway",Helvetica; font-weight: 300;"> <svg style="width: 15px;" xmlns="http://www.w3.org/2000/svg" id="Layer_1" x="0" y="0" version="1.1" viewBox="0 0 29 29" xml:space="preserve"><circle cx="11.854" cy="11.854" r="9" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="2"/><path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" d="M18.451 18.451l7.695 7.695"/></svg> </button>
    <script>
        console.log("buscador cargado");
        function mostrarInput(){
            console.log("mostrando");
            document.getElementById("frmBuscador").style.display = "block";
        }
    </script>
    ';

        $output2 = '<div class="et_pb_with_border et_pb_module et_pb_search et_pb_search_0 rm-buscador  et_pb_text_align_left et_pb_bg_layout_light">
				
				
        <form role="search" method="get" class="et_pb_searchform" action="https://tumedicosv.com/busqueda/">
            <input type="hidden" name="zona" value="central">
            <div>
                <label class="screen-reader-text" for="s">Buscar:</label>
                <input type="text" name="s" placeholder="Escribe para buscar" class="et_pb_s" style="padding-right: 50px;">
                <input type="hidden" name="et_pb_searchform_submit" value="et_search_proccess">
                
                <input type="hidden" name="et_pb_include_posts" value="yes">
                <input type="hidden" name="et_pb_include_pages" value="yes">
                <input type="submit" value="Búsqueda" class="et_pb_searchsubmit" style="">
            </div>
        </form><div class="caja-cerrar"><div class="rm-cancelar"><i class="fas fa-times"></i></div></div><div class="caja-cerrar"><div class="rm-cancelar"><i class="fas fa-times"></i></div></div>
    </div>';

    $query = new WP_Query($args);
    if( $query->have_posts() ){
        while( $query->have_posts() ){
            $query->the_post();
        }
    }

    return $output2;

}

function add_action_init_zona(){
	add_shortcode( 'zona', 'shc_zona' );
	/**
	 * Todas las paginas de los doctores, tienen un codigo QR que es su misma URL, se genera gracias al siguiente shortcode
	 */
	add_shortcode( 'codigo_qr', 'makeQRCode' );
	/**
	 * @descripcion: ubicado en /busqueda y espera dos parametros por REQUEST:
	 * @param zona => central, occidental, oriental
	 * @param especialidad => cualquier especalidad
	 * @example /busqueda/?zona=occidental&especialidad=ginecologia
	 */
	add_shortcode( 'zona_espe', 'zona_especialidad' );
	/**
	 * @descripcion: muestra todas las conicidencias de esa especialidad sin hacer distinción de zona
	 * @param especialidad => cualquier especialidad
	 * @example https://tumedicosv.com/todas-especialidades/?especialidad=ginecologia
	 */
    add_shortcode( 'todas_espe', 'todas_especialidad' );
	add_shortcode( 'espe_depa', 'especialidad_departamento' );
    /**
     * @descripcion: buscador de especialidades, realmente muestra todas las especialidades disponibles para esa zona
     * @param noparam => se hara un buscador por zona
     */
    add_shortcode( 'buscador_centro', 'especialidadesZonaCentro' );

    
    add_shortcode( 'amanda', 'prueba_shc' );
}
add_action('init', 'add_action_init_zona');



/**
 * BK DE FUNCTION DE ZONA DE ESPECIALIDADES
 * 
 * zona_especialidad
 * 
 * $array_meta_query = [];
    $meta_query = array('relation' => 'OR');
    foreach($deps as $dep => $val){
        $meta_query = array(
            'key' => 'departamento',
            'value' => serialize($val),
            'compare' => 'LIKE'
        );
        array_push($array_meta_query, $meta_query);
    }
	return json_encode($meta_query);
 * 
 */


/* 
/busqueda/?zona=occidental&especialidad=ginecologia
/busqueda/?zona=occidental&especialidad=odontologia
/busqueda/?zona=occidental&especialidad=oftalmologia

/busqueda/?zona=occidental&especialidad=ortopedia
/busqueda/?zona=occidental&especialidad=nutricion
/busqueda/?zona=occidental&especialidad=nefrologia

/busqueda/?zona=occidental&especialidad=salud_mental
/busqueda/?zona=occidental&especialidad=cirugia_general
/busqueda/?zona=occidental&especialidad=medicina_interna

/busqueda/?zona=occidental&especialidad=geriatria
/busqueda/?zona=occidental&especialidad=oncologia 

===========================================

/todas-especialidades/?especialidad=ginecologia
/todas-especialidades/?especialidad=odontologia
/todas-especialidades/?especialidad=oftalmologia

/todas-especialidades/?especialidad=ortopedia
/todas-especialidades/?especialidad=nutricion
/todas-especialidades/?especialidad=nefrologia

/todas-especialidades/?especialidad=salud_mental
/todas-especialidades/?especialidad=cirugia_general
/todas-especialidades/?especialidad=medicina_interna

/todas-especialidades/?especialidad=geriatria
/todas-especialidades/?especialidad=oncologia


*/

