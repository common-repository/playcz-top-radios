<?php
/*
Plugin Name: PLAY.CZ TopRadia [widget]
Plugin URI: http://www.play.cz
Description: Zobrazí TOP rádia z portálu PLAY.CZ.
Version: 2.1.2
Author: PLAY.CZ (Ladislav Soukup)
Author URI: http://www.play.cz/
License: GPL2
*/

/*  Copyright 2012 Ladislav Soukup (email: ladislav.soukup@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * PLAYCZ_TopRadia Class
 */
class PLAYCZ_TopRadia extends WP_Widget
{
	/** Constructor */
	function PLAYCZ_TopRadia()
	{
		parent::WP_Widget(
			'itnewswidget',
			__( 'PLAY.CZ Top Rádia', 'playcztopradia' ),
			array(	'classname' => 'playcztopradia', 'description' => __( 'Zobrazí TOP rádia z portálu PLAY.CZ', 'playcztopradia' ) )
		);
	}

	/** @see WP_Widget::form */
	function form( $instance )
	{
		$cntID = esc_attr( $instance[ 'cntID' ] );
		if( empty( $cntID ) )
			$cntID = '';
		
		$title = esc_attr( $instance[ 'title' ] );
		if( empty( $title ) )
			$title = __( 'PLAY.CZ - TOP Rádia', 'playcztopradia' );
        			
		
		$maxDisplayedItemsInTotal = $instance[ 'maxDisplayedItemsInTotal' ];
		if( !isset( $maxDisplayedItemsInTotal ) || $maxDisplayedItemsInTotal <= 0 || $maxDisplayedItemsInTotal > 25 )
			$maxDisplayedItemsInTotal = 10;
			
		$showListeners = $instance[ 'showListeners' ];
		if( !isset( $showListeners ) || $showListeners < 0 || $showListeners > 1 )
			$showListeners = 1;
			
		$openInNewWindow = $instance[ 'openInNewWindow' ];
		if( !isset( $openInNewWindow ) || $openInNewWindow < 0 || $openInNewWindow > 1 )
			$openInNewWindow = 1;

		
		?>
		<p>
			<label for="<?php echo( $this->get_field_id( 'cntID' ) ); ?>">
				<?php _e( 'ID boxu:', 'playcztopradia' ); ?>
				<input class="widefat" id="<?php echo( $this->get_field_id( 'cntID' ) ); ?>" name="<?php echo( $this->get_field_name( 'cntID' ) ); ?>" type="text" value="<?php echo( $cntID ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo( $this->get_field_id( 'title' ) ); ?>">
				<?php _e( 'Titulek:', 'playcztopradia' ); ?>
				<input class="widefat" id="<?php echo( $this->get_field_id( 'title' ) ); ?>" name="<?php echo( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo( $title ); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo( $this->get_field_id( 'maxDisplayedItemsInTotal' ) ); ?>">
				<?php _e( 'Počet rádií k zobrazení (max. 25):', 'playcztopradia' ); ?>
				<input class="widefat" id="<?php echo( $this->get_field_id( 'maxDisplayedItemsInTotal' ) ); ?>" name="<?php echo( $this->get_field_name( 'maxDisplayedItemsInTotal' ) ); ?>" type="text" value="<?php echo( $maxDisplayedItemsInTotal ); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo( $this->get_field_id( 'showListeners' ) ); ?>">
				<?php _e( 'Zobrazit počet posluchačů:', 'playcztopradia' ); ?>
				<select class="widefat" id="<?php echo( $this->get_field_id( 'showListeners' ) ); ?>" name="<?php echo( $this->get_field_name( 'showListeners' ) ); ?>">
					<option value="0"<?php if ($showListeners == 0) echo ' SELECTED'; ?>><?php _e( 'Ne' ); ?></option>
					<option value="1"<?php if ($showListeners == 1) echo ' SELECTED'; ?>><?php _e( 'Ano' ); ?></option>
				</select>
			</label>
		</p>
		
		<p>
			<label for="<?php echo( $this->get_field_id( 'openInNewWindow' ) ); ?>">
				<?php _e( 'Otevírat do nového okna:', 'playcztopradia' ); ?>
				<select class="widefat" id="<?php echo( $this->get_field_id( 'openInNewWindow' ) ); ?>" name="<?php echo( $this->get_field_name( 'openInNewWindow' ) ); ?>">
					<option value="0"<?php if ($openInNewWindow == 0) echo ' SELECTED'; ?>><?php _e( 'Ne' ); ?></option>
					<option value="1"<?php if ($openInNewWindow == 1) echo ' SELECTED'; ?>><?php _e( 'Ano' ); ?></option>
				</select>
			</label>
		</p>

		<p>
			<div><b><u><?php _e( 'CSS class' ); ?></u></b></div>
			<div><b>.PLAYCZ-TopRadia-item</b><br/> - <?php _e( 'řádek s rádiem' ); ?></div>
			<div><b>.PLAYCZ-TopRadia-item-link</b><br/> - <?php _e( '&lt;a&gt; tag' ); ?></div>
			<div><b>.PLAYCZ-TopRadia-item-logo</b><br/> - <?php _e( '&lt;img&gt; tag s logem' ); ?></div>
			<div><b>.PLAYCZ-TopRadia-item-title</b><br/> - <?php _e( '&lt;div&gt; s názvem rádia' ); ?></div>
			<div><b>.PLAYCZ-TopRadia-item-listeners</b><br/> - <?php _e( '&lt;div&gt; s počtem posluchačů' ); ?></div>
			<div><b>.PLAYCZ-TopRadia-more a</b><br/> - <?php _e( '&lt;div&gt; tlačítko "Všechna rádia" ' ); ?></div>
			
			
		</p>

		<?php
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance )
	{
		// processes widget options to be saved
		$instance = $old_instance;
		
		$instance[ 'cntID' ] = strip_tags( $new_instance[ 'cntID' ] );
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
	
		$instance[ 'maxDisplayedItemsInTotal' ] = $new_instance[ 'maxDisplayedItemsInTotal' ];
		if(    !is_numeric( $instance[ 'maxDisplayedItemsInTotal' ] )
			|| $instance[ 'maxDisplayedItemsInTotal' ] <= 0
			|| $instance[ 'maxDisplayedItemsInTotal' ] > 25 )
		{
			$instance[ 'maxDisplayedItemsInTotal' ] = 10;
		}
		
		
		$instance[ 'showListeners' ] = $new_instance[ 'showListeners' ];
		if(    !is_numeric( $instance[ 'showListeners' ] )
			|| $instance[ 'showListeners' ] < 0
			|| $instance[ 'showListeners' ] > 1 )
		{
			$instance[ 'showListeners' ] = 1;
		}
		
		$instance[ 'openInNewWindow' ] = $new_instance[ 'openInNewWindow' ];
		if(    !is_numeric( $instance[ 'openInNewWindow' ] )
			|| $instance[ 'openInNewWindow' ] < 0
			|| $instance[ 'openInNewWindow' ] > 1 )
		{
			$instance[ 'openInNewWindow' ] = 1;
		}

		
		return $instance;

	}


	/** @see WP_Widget::widget */
	function widget( $args, $instance )
	{
		// outputs the content of the widget
		extract( $args );

		echo( $before_widget );

		// Get options
		$cntID = esc_attr( $instance[ 'cntID' ] );
		if( empty( $cntID ) ) $cntID = '';
		
		$title = apply_filters( 'widget_title', $instance[ 'title' ] );
		echo( $before_title . $title . $after_title );

		$maxDisplayedItemsInTotal = $instance[ 'maxDisplayedItemsInTotal' ];
		if( !isset( $maxDisplayedItemsInTotal ) || $maxDisplayedItemsInTotal <= 0 || $maxDisplayedItemsInTotal > 25 )
			$maxDisplayedItemsInTotal = 10;
			
		$showListeners = $instance[ 'showListeners' ];
		if( !isset( $showListeners ) || $showListeners < 0 || $showListeners > 1 )
			$showListeners = 1;
		
		$openInNewWindow = $instance[ 'openInNewWindow' ];
		if( !isset( $openInNewWindow ) || $openInNewWindow < 0 || $openInNewWindow > 1 )
			$openInNewWindow = 1;

		
		// Get and display RSS feeds
		$data = get_transient( 'PLAYCZ_topRadios_widget' ); // $data = false;
		if ( false === $data ) {
			$uri = "http://api.play.cz/json/getTopRadios/?callback=cb_" . time();
	        $data = wp_remote_get($uri, array( 'timeout' => 5 ));  // print_r($data);
	        if (is_array($data)) {
		        $data = json_decode($data['body']);  // echo '<pre>'; print_r($data); echo '</pre>';
		        
		        if (!is_object($data->data)) {
			    	$data = get_transient( 'PLAYCZ_topRadios_widget_bck' );
			    }   
			    set_transient( 'PLAYCZ_topRadios_widget', $data, (120 + rand(60, 300)) );
			    set_transient( 'PLAYCZ_topRadios_widget_bck', $data, 86400 );
			    
			} else {
				echo '<!-- error loading data -->';
				$data = get_transient( 'PLAYCZ_topRadios_widget_bck' );
				set_transient( 'PLAYCZ_topRadios_widget', $data, (120 + rand(60, 300)) );
			}
	    }
        

        // WIDGET
		echo( '<div class="PLAYCZ-TopRadia" id="'.$cntID.'">' );
		$displayedItemsCount = 1;
		if (is_object($data->data)) {
			foreach( $data->data as $item ) {
				echo( '<div class="PLAYCZ-TopRadia-item">' );
				echo( '<a class="PLAYCZ-TopRadia-item-link" title="' . $item->title . ' - ' . $item->description . '" href="'.$item->weburl.'"' );
				if ($openInNewWindow == 1 ) { echo( ' target=_blank"' ); }
				echo( '>' );
				echo( '<img class="PLAYCZ-TopRadia-item-logo" src="' . $item->logo . '" alt="'.$item->title.'" />' );
				echo( '<div class="PLAYCZ-TopRadia-item-title">'.$item->title.'</div>' );
				if ($showListeners == 1) {
					echo( '<div class="PLAYCZ-TopRadia-item-listeners">'.$item->listeners.'</div>' );
				}
				echo( '</a>' );
				echo( '</div>');
				
				$displayedItemsCount++;
				if( $displayedItemsCount > $maxDisplayedItemsInTotal )
				{
					break;
				}
			}
			
			echo( '<div class="PLAYCZ-TopRadia-spacer">&nbsp;</div>' );
			
			echo( '<div class="PLAYCZ-TopRadia-more"><a href="' . $data->url_katalog . '"' );
			if ($openInNewWindow == 1 ) { echo( ' target=_blank"' ); }
			echo( '>' );
			echo _e( 'Všechna rádia' );
			echo( '</a></div>' );
		}
		echo( '</div>' );
		// echo '<pre>';print_r($data);echo '</pre>';
		// END WIDGET


		echo( $after_widget );
		
		// add styles
		wp_register_style( 'PLAYCZ_TopRadia_stylesheet', plugins_url('style.css', __FILE__) );
	    wp_enqueue_style( 'PLAYCZ_TopRadia_stylesheet' );
		    
	}
	
} 


function PLAYCZ_TopRadia_Register()
{
	load_plugin_textdomain( 'playcztopradia', false, dirname( plugin_basename( __FILE__ ) ) );
	return register_widget( "PLAYCZ_TopRadia" );
}

// register widget
add_action( 'widgets_init', 'PLAYCZ_TopRadia_Register' );

