
    function to_change_taxonomy(element)
        {
            //select the default category (0)
            jQuery('#to_form #cat').val(jQuery("#to_form #cat option:first").val());
            jQuery('#to_form').submit();
        }
        
        
        
    function serialize(mixed_value) 
        {
            // http://kevin.vanzonneveld.net
            // +   original by: Arpad Ray (mailto:arpad@php.net)
            // +   improved by: Dino
            // +   bugfixed by: Andrej Pavlovic
            // +   bugfixed by: Garagoth
            // +      input by: DtTvB (http://dt.in.th/2008-09-16.string-length-in-bytes.html)
            // +   bugfixed by: Russell Walker (http://www.nbill.co.uk/)
            // +   bugfixed by: Jamie Beck (http://www.terabit.ca/)
            // +      input by: Martin (http://www.erlenwiese.de/)
            // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net/)
            // +   improved by: Le Torbi (http://www.letorbi.de/)
            // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net/)
            // +   bugfixed by: Ben (http://benblume.co.uk/)
            // -    depends on: utf8_encode
            // %          note: We feel the main purpose of this function should be to ease the transport of data between php & js
            // %          note: Aiming for PHP-compatibility, we have to translate objects to arrays
            // *    