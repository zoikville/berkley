var formfield;
jQuery(document).ready(function($) {

	// duplicating fields
	if ( $('.add-multiple').length ) {
		$('.add-multiple').live('click', function(e) {
			e.preventDefault();
			var parent = $(this).parent().prev('.sortable').children('.cloneable:last').attr('id');
			var $last = $('#'+parent);
			var $clone = $last.clone();
			if($clone.find('input').hasClass('hasDatepicker')){
				$clone.find('input').removeClass('hasDatepicker');
				$clone.find('input').attr('id', '');
			}
			var idName = $clone.attr('id');
			var instanceNum = parseInt(idName.split('-')[1])+1;
			idName = idName.split('-')[0]+'-'+instanceNum;
			$clone.attr('id',idName);
			$clone.insertAfter($last).hide().fadeIn().find(':input[type=text]').attr('value', '').val('');

		});
	}

	// sortable
	$('.sortable').sortable();

	// deleting fields
	if ( $('.del-multiple').length )	 {
		$('.del-multiple').live('click', function(e) {
			e.preventDefault();
			$(this).parent().fadeOut('normal', function(){
				$(this).remove();
			});
		});
	}

	// init the upload fields
	if ( $('.upload_button').length ) {
		$('.upload_button').live('click', function(e) {
			formfield = $(this).parent().attr('id');
			window.send_to_editor=window.send_to_editor_clone;
			tb_show('','media-upload.php?post_id='+numb+'&TB_iframe=true');
			return false;
		});
		window.original_send_to_editor = window.send_to_editor;
		window.send_to_editor_clone = function(html){
			if (formfield) {
				file_url = jQuery('img','<div>'+html+'</div>').attr('src');
				if (!file_url) { file_url = jQuery('a','<div>'+html+'</div>').attr('href'); }
				tb_remove();
				if(jQuery('#'+formfield+' .upload_field.current').length > 0)
					jQuery('#'+formfield+' .upload_field.current').val(file_url);
				else
					jQuery('#'+formfield+' .upload_field').val(file_url);
				formfield = "";
			} else {
				window.original_send_to_editor(html);
			}
		}
 	}

 	// init the datepicker fields
	// if ( $('.datepicker').length ) {
	// 	$( '.datepicker input' ).datepicker({changeMonth: true, changeYear: true});
	// }
	// 
	$('.datepicker input').live('click', function() {
	    $(this).datepicker({showOn:'focus', dateFormat: 'yy-mm-dd'}).focus();
	});


});