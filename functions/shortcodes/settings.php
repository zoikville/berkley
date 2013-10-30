<?php

require( '../../../../../wp-load.php' );

$shortcode = array(

	'link' => array(
		'params' => array(
			'text' => array(
				'std' => '',
				'type' => 'text',
				'label' => 'link text',
				'desc' => ''
			),
			'url' => array(
				'std' => '',
				'type' => 'text',
				'label' => 'link url',
				'desc' => ''
			),
			'bold' => array(
				'type' => 'select',
				'label' => 'Use bold?',
				'desc' => '',
				'options' => array(
					'no' => 'no',
					'yes' => 'yes',
				)
			)
		),
		'shortcode' => '[link url="{{url}}" bold="{{bold}}"] {{text}} [/link]',
	),
	
	'subheading' => array(
		'params' => array(
			'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => 'Subheading',
				'desc' => ''
			)
		),
		'shortcode' => '[subheading] {{title}} [/subheading]',
	),
	
	'line' => array(
		'params' => array(
			'noshow' => array(
				'std' => '',
				'type' => 'text',
				'label' => 'hr',
				'desc' => 'hr'
			)
		),
		'shortcode' => '[hr class="{{post-hr}}"][/hr]',
	),
	
	'featured' => array(
		'params' => array(
			'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => 'Featured title',
				'desc' => ''
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => 'Featured content',
				'desc' => '',
			)
		),
		'shortcode' => '[featured title="{{title}}"] {{content}} [/featured]',
	),
	'columns' => array(
		'params' => array(
			'lefttitle' => array(
				'std' => '',
				'type' => 'text',
				'label' => 'Left Column Title',
				'desc' => '',
			),
			'leftcontent' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => 'Left Column Content',
				'desc' => '',
			),
			'righttitle' => array(
				'std' => '',
				'type' => 'text',
				'label' => 'Right Column Title',
				'desc' => '',
			),
			'rightcontent' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => 'Right Column Content',
				'desc' => '',
			)
		),

		'shortcode' => '[columns lefttitle="{{lefttitle}}" righttitle="{{righttitle}}" leftcontent="{{leftcontent}}" rightcontent="{{rightcontent}}"][/columns]',
	)

);
 
function create_shortcode($popup)
	{
        global $shortcode;

		if( isset( $shortcode ) && is_array( $shortcode ) )
		{
			$shortcode_param = $shortcode[$popup]['params'];
			$shortcode_code = $shortcode[$popup]['shortcode'];

			$shortcode_output = print_shortcode( "\n" . '<div id="old-shortcode" class="hidden">' . $shortcode_code . '</div>' );
			$shortcode_output = print_shortcode( "\n" . '<div id="shortcode-popup" class="hidden">' . $popup . '</div>' );


			foreach( $shortcode_param as $key => $param )
			{
				$key = 'shortcode_' . $key;
				
				$style = '';
				if( $key == 'shortcode_noshow') {
					$style = 'style="display:none"';
				}
				//echo $key;
				$row_start  = '<tbody '. $style .'>' . "\n";
				$row_start .= '<tr style="height:40px;">' . "\n";
				$row_start .= '<th class="label" style="vertical-align:top;width: 100px;padding:5px 0"><span class="alignleft">' . $param['label'] . '</span></th>' . "\n";
				$row_start .= '<td class="field" style="vertical-align:top;width: 300px;">' . "\n";

				$row_end	= '<span>' . $param['desc'] . '</span>' . "\n";
				$row_end   .= '</td>' . "\n";
				$row_end   .= '</tr>' . "\n";
				$row_end   .= '</tbody>' . "\n";
				
				switch( $param['type'] )
				{
					case 'text' :

						$output  = $row_start;
						$output .= '<input type="text" class="popup-input" name="' . $key . '" id="' . $key . '" value="' . $param['std'] . '" />' . "\n";
						$output .= $row_end;

						print_shortcode( $output );

						break;

					case 'textarea' :

						$output  = $row_start;
						$output .= '<textarea rows="10" style="width:100%" name="' . $key . '" id="' . $key . '" class="popup-input">' . $param['std'] . '</textarea>' . "\n";
						$output .= $row_end;

						print_shortcode( $output );

						break;

					case 'select' :

						$output  = $row_start;
						$output .= '<select name="' . $key . '" id="' . $key . '" class="popup-input">' . "\n";

						foreach( $param['options'] as $value => $option )
						{
							$output .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
						}

						$output .= '</select>' . "\n";
						$output .= $row_end;

						print_shortcode( $output );

						break;

				}
			}

		}
	}

	function print_shortcode( $output )
	{
            global $shortcode_output;
		$shortcode_output = $shortcode_output. "\n" . $output;
	}
?>
