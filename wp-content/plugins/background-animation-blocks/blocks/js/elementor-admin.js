jQuery( window ).on( 'elementor/frontend/init', () => {
    elementor.hooks.addAction("panel/open_editor/section", bab_section_change);
    elementorFrontend.hooks.addAction("frontend/element_ready/section", bab_elementor_change);

    function bab_section_change(vent, model) {
        window.bab_last_model_id = model.id;
		window.bab_last_model_attributes = model.attributes;
    }

    function bab_elementor_change(element) {
        var objElement = jQuery(element);
		var type = objElement.data("element_type");
		if(type != "section")
			return(true);
		var id = objElement.data("id");
        var objSettings = bab_elementor_settings(id);

        jQuery.ajax({
			url: bab_ajax.url,
			type: 'POST',
			data: {
                action: 'bab_get_elementor_block',
                settings: objSettings
            },
			success: function( data ) {
                if(data != '') {
                    var html = "<div class='bab-background-overlay'>";
                    html += data;
                    html += "</div>";
                    objElement.find('.bab-background-overlay').remove();
                    objElement.prepend(html);
					babInitBackgrounds( objElement.get(0).querySelectorAll( '.bab-trigger-el' ) );
                }
			}
		});
    }
    /**
	 * get settings from elementor
	 */
	function bab_elementor_settings(id){
		var data = elementor.config.data;
        var objSettings = bab_elementor_search_data(data, id);

        return(objSettings);
	}

    /**
	 * search elementor data
	 */
	function bab_elementor_search_data(data, id){
		//get from last opened object
		if(id == window.bab_last_model_id){
			var objSettings = bab_get_val(window.bab_last_model_attributes, "settings");
			var objSettingsAttributes = bab_get_val(objSettings, "attributes");
			
			return(objSettingsAttributes);
		}

		if(id){
			g_searchDataID = id;
			g_searchData = null;
		}
		
		if(!g_searchDataID)
			return(false);
		
		if(!data)
			return(false);
		
		var isArray = jQuery.isArray(data);
		
		if(isArray == false)
			return(false);
		
		jQuery.each(data, function(index, item){
						
			var elType = bab_get_val(item, "elType");
			var elID = bab_get_val(item, "id");
			var elements = bab_get_val(item, "elements");
			
			if(g_searchDataID == elID){
				
				g_searchData = bab_get_val(item, "settings");
				return(false);
			}
			
			if(elType != "widget" && jQuery.isArray(elements) && elements.length > 0){
				bab_elementor_search_data(elements);
				return(true);
			}
			
		});
		
		var settingsOutput = {};
		
		if(g_searchData && jQuery.isArray(g_searchData) == false)
			settingsOutput = jQuery.extend({}, g_searchData);
			
		return(settingsOutput);
	}

    /**
	 * get object property
	 */
	function bab_get_val(obj, name, defaultValue){
		
		if(!defaultValue)
			var defaultValue = "";
		
		var val = "";
		
		if(!obj || typeof obj != "object")
			val = defaultValue;
		else if(obj.hasOwnProperty(name) == false){
			val = defaultValue;
		}else{
			val = obj[name];			
		}
		
		
		return(val);
	}
});