name = esc_html__('Website Grid', 'dwgp');
        $this->icon = 'apps'; // Divi-Icon
        $this->main_css_element = '%%order_class%%.dwgp_website_grid';
        
        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'websites' => esc_html__('Websites', 'dwgp'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'grid_settings' => esc_html__('Grid Einstellungen', 'dwgp'),
                    'item_settings' => esc_html__('Item Einstellungen', 'dwgp'),
                ),
            ),
        );
    }
    
    public function get_fields() {
        $fields = array();
        
        for ($i = 1; $i <= 30; $i++) {
            $fields["website_title_$i"] = array(
                'label' => sprintf(esc_html__('Website %d Titel', 'dwgp'), $i),
                'type' => 'text',
                'option_category' => 'basic_option',
                'toggle_slug' => 'websites',
                'tab_slug' => 'general',
                'description' => esc_html__('Gib den Titel der Website ein.', 'dwgp'),
            );
            
            $fields["website_url_$i"] = array(
                'label' => sprintf(esc_html__('Website %d URL', 'dwgp'), $i),
                'type' => 'text',
                'option_category' => 'basic_option',
                'toggle_slug' => 'websites',
                'tab_slug' => 'general',
                'description' => esc_html__('Gib die vollständige URL der Website ein.', 'dwgp'),
            );
            
            $fields["website_image_$i"] = array(
                'label' => sprintf(esc_html__('Website %d Bild', 'dwgp'), $i),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Bild hochladen', 'dwgp'),
                'choose_text' => esc_attr__('Bild auswählen', 'dwgp'),
                'update_text' => esc_attr__('Bild setzen', 'dwgp'),
                'toggle_slug' => 'websites',
                'tab_slug' => 'general',
                'description' => esc_html__('Lade das Thumbnail für diese Website hoch.', 'dwgp'),
            );
        }
        
        // Grid Einstellungen
        $fields['columns_desktop'] = array(
            'label' => esc_html__('Spalten (Desktop)', 'dwgp'),
            'type' => 'range',
            'option_category' => 'layout',
            'toggle_slug' => 'grid_settings',
            'tab_slug' => 'advanced',
            'range_settings' => array(
                'min' => 1,
                'max' => 6,
                'step' => 1,
            ),
            'default' => '3',
            'description' => esc_html__('Wähle die Anzahl der Spalten für Desktop-Geräte.', 'dwgp'),
        );
        
        $fields['columns_tablet'] = array(
            'label' => esc_html__('Spalten (Tablet)', 'dwgp'),
            'type' => 'range',
            'option_category' => 'layout',
            'toggle_slug' => 'grid_settings',
            'tab_slug' => 'advanced',
            'range_settings' => array(
                'min' => 1,
                'max' => 4,
                'step' => 1,
            ),
            'default' => '2',
            'description' => esc_html__('Wähle die Anzahl der Spalten für Tablet-Geräte.', 'dwgp'),
        );
        
        $fields['columns_mobile'] = array(
            'label' => esc_html__('Spalten (Mobil)', 'dwgp'),
            'type' => 'range',
            'option_category' => 'layout',
            'toggle_slug' => 'grid_settings',
            'tab_slug' => 'advanced',
            'range_settings' => array(
                'min' => 1,
                'max' => 2,
                'step' => 1,
            ),
            'default' => '1',
            'description' => esc_html__('Wähle die Anzahl der Spalten für mobile Geräte.', 'dwgp'),
        );
        
        $fields['grid_gap'] = array(
            'label' => esc_html__('Grid Abstand', 'dwgp'),
            'type' => 'range',
            'option_category' => 'layout',
            'toggle_slug' => 'grid_settings',
            'tab_slug' => 'advanced',
            'range_settings' => array(
                'min' => 0,
                'max' => 100,
                'step' => 1,
            ),
            'default' => '20',
            'description' => esc_html__('Wähle den Abstand zwischen den Grid-Elementen.', 'dwgp'),
            'validate_unit' => true,
            'fixed_unit' => 'px',
        );
        
        // Item Einstellungen
        $fields['item_border_radius'] = array(
            'label' => esc_html__('Rahmen-Radius', 'dwgp'),
            'type' => 'range',
            'option_category' => 'layout',
            'toggle_slug' => 'item_settings',
            'tab_slug' => 'advanced',
            'range_settings' => array(
                'min' => 0,
                'max' => 100,
                'step' => 1,
            ),
            'default' => '8',
            'description' => esc_html__('Lege den Rahmen-Radius fest.', 'dwgp'),
            'validate_unit' => true,
            'fixed_unit' => 'px',
        );
        
        $fields['item_overflow'] = array(
            'label' => esc_html__('Overflow', 'dwgp'),
            'type' => 'select',
            'option_category' => 'layout',
            'toggle_slug' => 'item_settings',
            'tab_slug' => 'advanced',
            'options' => array(
                'visible' => esc_html__('Sichtbar', 'dwgp'),
                'hidden' => esc_html__('Versteckt', 'dwgp'),
            ),
            'default' => 'hidden',
            'description' => esc_html__('Lege fest, ob Inhalte außerhalb des Containers sichtbar sein sollen.', 'dwgp'),
        );
        
        $fields['item_shadow'] = array(
            'label' => esc_html__('Box-Schatten verwenden', 'dwgp'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => array(
                'on' => esc_html__('Ja', 'dwgp'),
                'off' => esc_html__('Nein', 'dwgp'),
            ),
            'default' => 'on',
            'toggle_slug' => 'item_settings',
            'tab_slug' => 'advanced',
            'description' => esc_html__('Aktiviere oder deaktiviere den Box-Schatten.', 'dwgp'),
        );
        
        $fields['item_hover_effect'] = array(
            'label' => esc_html__('Hover-Effekt', 'dwgp'),
            'type' => 'select',
            'option_category' => 'configuration',
            'options' => array(
                'none' => esc_html__('Keiner', 'dwgp'),
                'scale' => esc_html__('Vergrößern', 'dwgp'),
                'shadow' => esc_html__('Schatten vergrößern', 'dwgp'),
                'both' => esc_html__('Beides', 'dwgp'),
            ),
            'default' => 'both',
            'toggle_slug' => 'item_settings',
            'tab_slug' => 'advanced',
            'description' => esc_html__('Wähle einen Hover-Effekt für die Grid-Elemente.', 'dwgp'),
        );
        
        return $fields;
    }
    
    public function get_advanced_fields_config() {
        return array(
            'fonts' => array(
                'title' => array(
                    'label' => esc_html__('Titel', 'dwgp'),
                    'css' => array(
                        'main' => "{$this->main_css_element} .dwgp-item-title",
                    ),
                    'font_size' => array(
                        'default' => '18px',
                    ),
                    'line_height' => array(
                        'default' => '1.3em',
                    ),
                    'toggle_slug' => 'item_settings',
                ),
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => "{$this->main_css_element} .dwgp-item",
                    ),
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => "{$this->main_css_element} .dwgp-item",
                    ),
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'margin' => "{$this->main_css_element}",
                    'padding' => "{$this->main_css_element}",
                ),
            ),
            'background' => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css' => array(
                    'main' => "{$this->main_css_element} .dwgp-item",
                ),
            ),
        );
    }
    
    public function render($attrs, $content = null, $render_slug) {
        // CSS generieren
        $columns_desktop = $this->props['columns_desktop'];
        $columns_tablet = $this->props['columns_tablet'];
        $columns_mobile = $this->props['columns_mobile'];
        $grid_gap = $this->props['grid_gap'];
        $item_border_radius = $this->props['item_border_radius'];
        $item_overflow = $this->props['item_overflow'];
        $item_shadow = $this->props['item_shadow'];
        $item_hover_effect = $this->props['item_hover_effect'];
        
        // Grid Styles
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dwgp-grid',
            'declaration' => sprintf(
                'display: grid; grid-template-columns: repeat(%s, 1fr); gap: %spx;',
                $columns_desktop,
                $grid_gap
            ),
        ));
        
        // Responsive Grid Styles (Tablet)
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dwgp-grid',
            'declaration' => sprintf(
                'grid-template-columns: repeat(%s, 1fr);',
                $columns_tablet
            ),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        
        // Responsive Grid Styles (Mobile)
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dwgp-grid',
            'declaration' => sprintf(
                'grid-template-columns: repeat(%s, 1fr);',
                $columns_mobile
            ),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
        
        // Item Styles
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dwgp-item',
            'declaration' => sprintf(
                'border-radius: %spx; overflow: %s; transition: all 0.3s ease;',
                $item_border_radius,
                $item_overflow
            ),
        ));
        
        // Shadow Style
        if ($item_shadow === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dwgp-item',
                'declaration' => 'box-shadow: 0 4px 10px rgba(0,0,0,0.1);',
            ));
        }
        
        // Hover Effekte
        if ($item_hover_effect === 'scale' || $item_hover_effect === 'both') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dwgp-item:hover',
                'declaration' => 'transform: scale(1.05);',
            ));
        }
        
        if ($item_hover_effect === 'shadow' || $item_hover_effect === 'both') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dwgp-item:hover',
                'declaration' => 'box-shadow: 0 10px 30px rgba(0,0,0,0.15);',
            ));
        }
        
        // Sammle alle Websites
        $websites = array();
        for ($i = 1; $i <= 30; $i++) {
            $title = isset($this->props["website_title_$i"]) ? $this->props["website_title_$i"] : '';
            $url = isset($this->props["website_url_$i"]) ? $this->props["website_url_$i"] : '';
            $image = isset($this->props["website_image_$i"]) ? $this->props["website_image_$i"] : '';
            
            if (!empty($title) && !empty($url)) {
                $websites[] = array(
                    'title' => $title,
                    'url' => $url,
                    'image' => $image,
                );
            }
        }
        
        // HTML Ausgabe
        $output = '';
        
        foreach ($websites as $website) {
            $image_output = '';
            if (!empty($website['image'])) {
                $image_output = sprintf(
                    '',
                    esc_url($website['image']),
                    esc_attr($website['title'])
                );
            }
            
            $output .= sprintf(
                '
                    %s
                    %s
                ',
                esc_url($website['url']),
                $image_output,
                esc_html($website['title'])
            );
        }
        
        $output .= '';
        
        return $output;
    }
}

new DWGP_WebsiteGrid;