<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class YT_Grid_RSS_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'youtube_grid_rss';
    }

    public function get_title() {
        return __( 'YouTube Grid (RSS)', 'yt-grid-rss' );
    }

    public function get_icon() {
        return 'eicon-youtube';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_style_depends() {
        return [ 'yt-grid-rss-style' ];
    }

    public function get_script_depends() {
        return [ 'yt-grid-rss-script' ];
    }

    protected function register_controls() {
        // --- CONTENT TAB: SOURCE OPTIONS ---
        $this->start_controls_section(
            'source_section',
            [
                'label' => __( 'YouTube Source Settings', 'yt-grid-rss' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'source_type',
            [
                'label' => __( 'Feed Source', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'channel'  => __( 'YouTube Channel', 'yt-grid-rss' ),
                    'playlist' => __( 'YouTube Playlist', 'yt-grid-rss' ),
                ],
                'default' => 'channel',
            ]
        );

        $this->add_control(
            'channel_id',
            [
                'label' => __( 'Channel ID', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => 'UC_x5XG1OV2P6wRIM_tf3BAQ',
                'description' => __('Enter the unique YouTube Channel ID. You can follow <a href="https://abdullahwp.com/extract-youtube-channel-id/" target="_blank" rel="noopener">this tutorial</a> to extract yours.', 'yt-grid-rss'),
                'condition' => [
                    'source_type' => 'channel',
                ],
            ]
        );

        $this->add_control(
            'playlist_id',
            [
                'label' => __( 'Playlist ID', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => 'PLwnBEhITAFhi54FlcUCvwuQIBmV8qTGN8',
                'description' => __('Enter the YouTube Playlist ID.', 'yt-grid-rss'),
                'condition' => [
                    'source_type' => 'playlist',
                ],
            ]
        );

        $this->add_control(
            'max_videos',
            [
                'label' => __( 'Number of Videos', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 50,
            ]
        );

        $this->add_control(
            'click_action',
            [
                'label' => __( 'Click Action', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'lightbox' => __( 'Open in Lightbox Modal', 'yt-grid-rss' ),
                    'youtube'  => __( 'Open on YouTube (New Tab)', 'yt-grid-rss' ),
                    'same_tab' => __( 'Open on YouTube (Same Tab)', 'yt-grid-rss' ),
                ],
                'default' => 'lightbox',
            ]
        );

        $this->add_control(
            'cache_lifetime',
            [
                'label' => __( 'Cache Expiration', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1'  => __( '1 Hour', 'yt-grid-rss' ),
                    '3'  => __( '3 Hours', 'yt-grid-rss' ),
                    '6'  => __( '6 Hours', 'yt-grid-rss' ),
                    '12' => __( '12 Hours', 'yt-grid-rss' ),
                    '24' => __( '24 Hours', 'yt-grid-rss' ),
                    '0'  => __( 'Disable Cache (Always Live)', 'yt-grid-rss' ),
                ],
                'default' => '12',
                'description' => __('Controls how long RSS entries are locally saved in WordPress transients.', 'yt-grid-rss'),
            ]
        );

        $this->end_controls_section();

        // --- CONTENT TAB: VISUAL DISPLAY SWITCHES ---
        $this->start_controls_section(
            'display_section',
            [
                'label' => __( 'Metadata Display Options', 'yt-grid-rss' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __( 'Show Title', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'yt-grid-rss' ),
                'label_off' => __( 'Hide', 'yt-grid-rss' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label' => __( 'Show Publish Date', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'yt-grid-rss' ),
                'label_off' => __( 'Hide', 'yt-grid-rss' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'date_format_choice',
            [
                'label' => __( 'Date Format', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'default' => __( 'WordPress Default Format', 'yt-grid-rss' ),
                    'relative' => __( 'Relative (e.g., 2 hours ago)', 'yt-grid-rss' ),
                ],
                'default' => 'default',
                'condition' => [
                    'show_date' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_desc',
            [
                'label' => __( 'Show Description Excerpt', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'yt-grid-rss' ),
                'label_off' => __( 'Hide', 'yt-grid-rss' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'desc_limit',
            [
                'label' => __( 'Description Word Limit', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 15,
                'min' => 1,
                'max' => 100,
                'condition' => [
                    'show_desc' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // --- CONTENT TAB: LAZY LOADING ---
        $this->start_controls_section(
            'lazy_section',
            [
                'label' => __( 'Lazy Load Configurations', 'yt-grid-rss' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'lazy_load',
            [
                'label' => __( 'Lazy Load Images', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Enable', 'yt-grid-rss' ),
                'label_off' => __( 'Disable', 'yt-grid-rss' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'loader_icon',
            [
                'label' => __( 'Loader Icon Selection', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-spinner',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'lazy_load' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE TAB: GRID LAYOUT ---
        $this->start_controls_section(
            'grid_layout_style',
            [
                'label' => __( 'Grid Layout Options', 'yt-grid-rss' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => __( 'Grid Columns', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 6,
                'default' => 3,
                'tablet_default'  => 2,
                'mobile_default'  => 1,
            ]
        );

        $this->add_responsive_control(
            'column_gap',
            [
                'label' => __( 'Columns Gap', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 20 ],
                'selectors' => [
                    '{{WRAPPER}} .yt-grid' => 'column-gap: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label' => __( 'Rows Gap', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 20 ],
                'selectors' => [
                    '{{WRAPPER}} .yt-grid' => 'row-gap: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => __( 'Card Padding', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .yt-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'card_bg_color',
            [
                'label' => __( 'Card Background Color', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .yt-item' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .yt-item',
            ]
        );

        $this->add_responsive_control(
            'card_border_radius',
            [
                'label' => __( 'Card Border Radius', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .yt-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_shadow',
                'selector' => '{{WRAPPER}} .yt-item',
            ]
        );

        $this->end_controls_section();

        // --- STYLE TAB: VIDEO THUMBNAILS ---
        $this->start_controls_section(
            'thumb_style_section',
            [
                'label' => __( 'Video Thumbnail Options', 'yt-grid-rss' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'aspect_ratio',
            [
                'label' => __( 'Video Aspect Ratio', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '16-9' => '16:9 (Cinema standard)',
                    '4-3'  => '4:3 (Traditional SD)',
                    '1-1'  => '1:1 (Square aspect)',
                ],
                'default' => '16-9',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => __( 'Thumbnail Border Radius', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .yt-thumb-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; overflow: hidden;',
                    '{{WRAPPER}} .yt-lazy-placeholder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; overflow: hidden;',
                    '{{WRAPPER}} .yt-standard-ratio-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; overflow: hidden;',
                ],
            ]
        );

        $this->add_control(
            'hover_zoom_scale',
            [
                'label' => __( 'Hover Zoom Power', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 1, 'max' => 1.2, 'step' => 0.01 ],
                ],
                'default' => [ 'size' => 1.05 ],
                'selectors' => [
                    '{{WRAPPER}} .yt-item:hover img' => 'transform: scale({{SIZE}}) !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'image_css_filters',
                'selector' => '{{WRAPPER}} .yt-item img',
            ]
        );

        $this->add_control(
            'show_play_overlay',
            [
                'label' => __( 'Hover Play Overlay Indicator', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'yt-grid-rss' ),
                'label_off' => __( 'Hide', 'yt-grid-rss' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label' => __( 'Overlay Background Color', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.4)',
                'selectors' => [
                    '{{WRAPPER}} .yt-play-overlay' => 'background-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'show_play_overlay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'play_icon_type',
            [
                'label' => __( 'Play Icon Selection', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'default' => __( 'Modern Inline SVG', 'yt-grid-rss' ),
                    'custom'  => __( 'Custom Library Icon', 'yt-grid-rss' ),
                ],
                'default' => 'default',
                'condition' => [
                    'show_play_overlay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'play_icon_custom',
            [
                'label' => __( 'Icon Library Choice', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-play',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_play_overlay' => 'yes',
                    'play_icon_type'    => 'custom',
                ],
            ]
        );

        $this->add_control(
            'play_icon_color',
            [
                'label' => __( 'Play Icon Color', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .yt-play-icon' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .yt-play-icon svg' => 'fill: {{VALUE}} !important;',
                ],
                'condition' => [
                    'show_play_overlay' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'play_icon_size',
            [
                'label' => __( 'Play Icon Size', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 10, 'max' => 120 ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 40 ],
                'selectors' => [
                    '{{WRAPPER}} .yt-play-icon' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
                'condition' => [
                    'show_play_overlay' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE TAB: TYPOGRAPHY (TITLES) ---
        $this->start_controls_section(
            'title_style_section',
            [
                'label' => __( 'Video Title Styling', 'yt-grid-rss' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Text Color', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .yt-item .yt-title' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __( 'Typography', 'yt-grid-rss' ),
                'selector' => '{{WRAPPER}} .yt-item .yt-title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => __( 'Top Margined Spacing', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 10 ],
                'selectors' => [
                    '{{WRAPPER}} .yt-item .yt-title' => 'margin-top: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'title_alignment',
            [
                'label' => __( 'Text Alignment', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'yt-grid-rss' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'yt-grid-rss' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'yt-grid-rss' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .yt-item .yt-title' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'title_line_limit',
            [
                'label' => __( 'Line Limit (Truncation)', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'none' => __( 'No Limit', 'yt-grid-rss' ),
                    '1' => __( '1 Line', 'yt-grid-rss' ),
                    '2' => __( '2 Lines', 'yt-grid-rss' ),
                    '3' => __( '3 Lines', 'yt-grid-rss' ),
                ],
                'default' => '2',
            ]
        );

        $this->end_controls_section();

        // --- STYLE TAB: METADATA (PUBLISHED & DESCRIPTION) ---
        $this->start_controls_section(
            'meta_style_section',
            [
                'label' => __( 'Metadata Style Configurations', 'yt-grid-rss' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'meta_alignment',
            [
                'label' => __( 'Global Alignment', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'yt-grid-rss' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'yt-grid-rss' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'yt-grid-rss' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .yt-meta-pub, {{WRAPPER}} .yt-meta-desc' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'heading_pub_meta',
            [
                'label' => __( 'Publish Date Label', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_date' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' => __( 'Text Color', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#888888',
                'selectors' => [
                    '{{WRAPPER}} .yt-meta-pub' => 'color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'show_date' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'date_typography',
                'label' => __( 'Typography', 'yt-grid-rss' ),
                'selector' => '{{WRAPPER}} .yt-meta-pub',
                'condition' => [
                    'show_date' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'date_spacing',
            [
                'label' => __( 'Date Margined Spacing', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 6 ],
                'selectors' => [
                    '{{WRAPPER}} .yt-meta-pub' => 'margin-top: {{SIZE}}{{UNIT}} !important; margin-bottom: {{SIZE}}{{UNIT}} !important;',
                ],
                'condition' => [
                    'show_date' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'heading_desc_meta',
            [
                'label' => __( 'Description Excerpt Label', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_desc' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label' => __( 'Text Color', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .yt-meta-desc' => 'color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'show_desc' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'label' => __( 'Typography', 'yt-grid-rss' ),
                'selector' => '{{WRAPPER}} .yt-meta-desc',
                'condition' => [
                    'show_desc' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'desc_spacing',
            [
                'label' => __( 'Excerpt Margined Spacing', 'yt-grid-rss' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 8 ],
                'selectors' => [
                    '{{WRAPPER}} .yt-meta-desc' => 'margin-top: {{SIZE}}{{UNIT}} !important;',
                ],
                'condition' => [
                    'show_desc' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $source_type = $settings['source_type'];
        $channel_id  = preg_replace( '/[^A-Za-z0-9_-]/', '', sanitize_text_field( $settings['channel_id'] ) );
        $playlist_id = preg_replace( '/[^A-Za-z0-9_-]/', '', sanitize_text_field( $settings['playlist_id'] ) );
        $max_videos  = intval( $settings['max_videos'] );
        $show_title  = $settings['show_title'];
        $show_date   = $settings['show_date'];
        $show_desc   = $settings['show_desc'];
        $click_action = $settings['click_action'];
        $lazy_load   = $settings['lazy_load'] === 'yes';

        // Retrieve responsive grid variables safely
        $desktop_cols = !empty($settings['columns']) ? $settings['columns'] : 3;
        $tablet_cols  = !empty($settings['columns_tablet']) ? $settings['columns_tablet'] : $desktop_cols;
        $mobile_cols  = !empty($settings['columns_mobile']) ? $settings['columns_mobile'] : $tablet_cols;

        // Resolve Target Resource ID Check
        $target_id = ($source_type === 'channel') ? $channel_id : $playlist_id;

        if ( empty($target_id) ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                $this->render_mock_data($settings);
            } else {
                echo '<p class="yt-grid-error" style="color:red; text-align:center;">' . esc_html__( 'Please configure the YouTube ID in widget options.', 'yt-grid-rss' ) . '</p>';
            }
            return;
        }

        // Generate precise standard YouTube RSS targets
        if ( $source_type === 'channel' ) {
            $feed_url = add_query_arg( 'channel_id', rawurlencode( $target_id ), 'https://www.youtube.com/feeds/videos.xml' );
        } else {
            $feed_url = add_query_arg( 'playlist_id', rawurlencode( $target_id ), 'https://www.youtube.com/feeds/videos.xml' );
        }

        // Fetch Cached Stream
        $cache_hours = intval( $settings['cache_lifetime'] );
        $cache_key   = 'yt_rss_' . md5($feed_url); // Safely fits inside the 45-character db limit
        $cached_body = ( $cache_hours > 0 ) ? get_transient($cache_key) : false;
        $xml_object  = null;

        if ( false === $cached_body ) {
            // Secure fetch via safe core protocols to protect against SSRF issues
            $response = wp_safe_remote_get( $feed_url, array( 'timeout' => 12 ) );

            if ( is_wp_error( $response ) ) {
                echo '<p class="yt-grid-error" style="color:red; text-align:center;">' . esc_html__( 'Feed fetching failed. Confirm your ID is accurate.', 'yt-grid-rss' ) . '</p>';
                return;
            }

            $body = wp_remote_retrieve_body( $response );

            if ( 200 !== wp_remote_retrieve_response_code( $response ) || empty($body) || strlen( $body ) > 2 * MB_IN_BYTES ) {
                echo '<p class="yt-grid-error" style="color:red; text-align:center;">' . esc_html__( 'Received empty content from RSS servers.', 'yt-grid-rss' ) . '</p>';
                return;
            }

            // Simple XML Parser initiation
            $xml_object = simplexml_load_string( $body, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NONET );

            if ( $xml_object && $cache_hours > 0 ) {
                set_transient( $cache_key, $body, $cache_hours * HOUR_IN_SECONDS );
            }
        } else {
            $xml_object = simplexml_load_string( $cached_body, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NONET );
        }

        if ( ! $xml_object ) {
            echo '<p class="yt-grid-error" style="color:red; text-align:center;">' . esc_html__( 'Failed parsing YouTube RSS structure.', 'yt-grid-rss' ) . '</p>';
            if ( $cache_hours > 0 ) {
                delete_transient($cache_key);
            }
            return;
        }

        // Construct Grid custom layout variables
        $widget_id = 'yt-grid-' . $this->get_id();
        $aspect_ratio_class = 'yt-ratio-' . esc_attr($settings['aspect_ratio']);

        $styles_str = sprintf(
            '--desktop-cols: %s; --tablet-cols: %s; --mobile-cols: %s;',
            esc_attr($desktop_cols),
            esc_attr($tablet_cols),
            esc_attr($mobile_cols)
        );

        echo "<div id='" . esc_attr($widget_id) . "' class='yt-grid' style='" . esc_attr($styles_str) . "'>";

        $count = 0;
        if ( ! empty( $xml_object->entry ) ) {
            foreach ( $xml_object->entry as $entry ) {
                if ( $count >= $max_videos ) {
                    break;
                }

                // Query Namespaces natively
                $yt_ns    = $entry->children( 'http://www.youtube.com/xml/schemas/2015' );
                $media_ns = $entry->children( 'http://search.yahoo.com/mrss/' );

                $video_id = (string) $yt_ns->videoId;
                $title    = esc_html( (string) $entry->title );
                
                // Fetch dynamic elements safely
                $url = '';
                if ( isset( $entry->link ) ) {
                    $attributes = $entry->link->attributes();
                    if ( isset( $attributes['href'] ) ) {
                        $url = esc_url( (string) $attributes['href'] );
                    }
                }

                // Processing fallback strategies
                if ( empty($video_id) ) {
                    $video_id = str_replace('yt:video:', '', (string) $entry->id);
                }
                if ( empty($video_id) && preg_match('/v=([a-zA-Z0-9_-]+)/', $url, $matches) ) {
                    $video_id = $matches[1];
                }
                $video_id = preg_replace( '/[^A-Za-z0-9_-]/', '', $video_id );
                if ( empty($video_id) ) {
                    continue;
                }

                if ( empty($url) ) {
                    $url = "https://www.youtube.com/watch?v={$video_id}";
                }

                // Capture image fallback values
                $thumb = '';
                if ( isset( $media_ns->group->thumbnail ) ) {
                    $thumb = esc_url( (string) $media_ns->group->thumbnail->attributes()->url );
                }
                if ( empty($thumb) ) {
                    $thumb = "https://i.ytimg.com/vi/{$video_id}/hqdefault.jpg";
                }

                // Render image configurations
                $image_html = '';
                if ($lazy_load) {
                    $loader_icon_html = '';
                    if ( ! empty( $settings['loader_icon']['value'] ) ) {
                        ob_start();
                        \Elementor\Icons_Manager::render_icon( $settings['loader_icon'], [ 
                            'aria-hidden' => 'true', 
                            'class' => 'yt-grid-spinner' 
                        ] );
                        $loader_icon_html = ob_get_clean();
                    }

                    $image_html = "
                        <div class='yt-lazy-placeholder {$aspect_ratio_class}'>
                            <div class='yt-lazy-loader-wrapper'>{$loader_icon_html}</div>
                            <img class='yt-lazy-hidden' src='data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=' data-src='{$thumb}' alt='{$title}' />
                        </div>
                    ";
                } else {
                    $image_html = "
                        <div class='yt-standard-ratio-wrapper {$aspect_ratio_class}'>
                            <img src='{$thumb}' alt='{$title}' />
                        </div>
                    ";
                }

                // Generate Play Overlay Visuals
                $play_overlay_html = '';
                if ( $settings['show_play_overlay'] === 'yes' ) {
                    $icon_inner_html = '';
                    if ( $settings['play_icon_type'] === 'custom' && ! empty( $settings['play_icon_custom']['value'] ) ) {
                        ob_start();
                        \Elementor\Icons_Manager::render_icon( $settings['play_icon_custom'], [ 'aria-hidden' => 'true' ] );
                        $icon_inner_html = ob_get_clean();
                    } else {
                        // High-performance direct play button inline SVG asset
                        $icon_inner_html = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width:1.2em; height:1.2em; fill:currentColor;"><path d="M8 5v14l11-7z"/></svg>';
                    }

                    $play_overlay_html = "
                        <div class='yt-play-overlay'>
                            <span class='yt-play-icon'>{$icon_inner_html}</span>
                        </div>
                    ";
                }

                // Target click redirects & element lightbox binds
                $target_attr   = 'target="_blank" rel="noopener noreferrer"';
                $lightbox_attr = 'data-elementor-open-lightbox="no"';

                if ( $click_action === 'lightbox' ) {
                    $url = "https://www.youtube.com/embed/{$video_id}?autoplay=1";
                    $target_attr   = '';
                    $lightbox_attr = 'data-elementor-open-lightbox="yes" class="elementor-open-lightbox"';
                } elseif ( $click_action === 'same_tab' ) {
                    $target_attr   = 'target="_self"';
                }

                // Render dynamic published date
                $date_html = '';
                if ( $show_date === 'yes' && ! empty( $entry->published ) ) {
                    $timestamp = strtotime( (string) $entry->published );
                    if ( $timestamp ) {
                        if ( $settings['date_format_choice'] === 'relative' ) {
                            $formatted_date = sprintf( esc_html__( '%s ago', 'yt-grid-rss' ), human_time_diff( $timestamp, current_time( 'timestamp' ) ) );
                        } else {
                            $formatted_date = date_i18n( get_option( 'date_format' ), $timestamp );
                        }
                        $date_html = "<p class='yt-meta-pub'>" . esc_html( $formatted_date ) . "</p>";
                    }
                }

                // Render description details
                $desc_html = '';
                if ( $show_desc === 'yes' ) {
                    $raw_desc = '';
                    if ( isset( $media_ns->group->description ) ) {
                        $raw_desc = (string) $media_ns->group->description;
                    } elseif ( isset( $entry->summary ) ) {
                        $raw_desc = (string) $entry->summary;
                    }
                    if ( ! empty($raw_desc) ) {
                        $clean_desc = wp_strip_all_tags( $raw_desc );
                        $truncated_desc = wp_trim_words( $clean_desc, intval($settings['desc_limit']), '...' );
                        $desc_html = "<p class='yt-meta-desc'>" . esc_html( $truncated_desc ) . "</p>";
                    }
                }

                // Custom Truncation lines wrapper configurations
                $title_clamp_class = ($settings['title_line_limit'] !== 'none') ? 'yt-truncate line-clamp-' . esc_attr($settings['title_line_limit']) : '';

                echo "
                    <div class='yt-item'>
                        <a href='{$url}' {$target_attr} {$lightbox_attr} data-elementor-lightbox-title='{$title}' aria-label='{$title}'>
                            <div class='yt-thumb-wrapper'>
                                {$image_html}
                                {$play_overlay_html}
                            </div>
                            " . ( $show_title === 'yes' ? "<p class='yt-title {$title_clamp_class}'>{$title}</p>" : "" ) . "
                            {$date_html}
                            {$desc_html}
                        </a>
                    </div>
                ";

                $count++;
            }
        } else {
             echo '<p class="yt-grid-error" style="color:red; text-align:center;">' . esc_html__( 'No videos found in the feed configuration.', 'yt-grid-rss' ) . '</p>';
        }

        echo "</div>";
    }

    // Displays dynamic markup layout placeholders inside Elementor editor screens if fields are empty
    protected function render_mock_data( $settings ) {
        $widget_id = 'yt-grid-' . $this->get_id();
        $max_videos  = intval( $settings['max_videos'] );
        $show_title  = $settings['show_title'];
        $show_date   = $settings['show_date'];
        $show_desc   = $settings['show_desc'];
        $lazy_load   = $settings['lazy_load'] === 'yes';
        $aspect_ratio_class = 'yt-ratio-' . esc_attr($settings['aspect_ratio']);

        $desktop_cols = !empty($settings['columns']) ? $settings['columns'] : 3;
        $tablet_cols  = !empty($settings['columns_tablet']) ? $settings['columns_tablet'] : $desktop_cols;
        $mobile_cols  = !empty($settings['columns_mobile']) ? $settings['columns_mobile'] : $tablet_cols;

        $styles_str = sprintf(
            '--desktop-cols: %s; --tablet-cols: %s; --mobile-cols: %s;',
            esc_attr($desktop_cols),
            esc_attr($tablet_cols),
            esc_attr($mobile_cols)
        );

        echo '<div class="elementor-alert elementor-alert-info">' . esc_html__( 'Please enter your YouTube Channel ID or Playlist ID. Showing preview sample layout below:', 'yt-grid-rss' ) . '</div>';
        echo "<div id='" . esc_attr( $widget_id ) . "' class='yt-grid' style='" . esc_attr( $styles_str ) . "'>";

        for ( $i = 1; $i <= $max_videos; $i++ ) {
            $title = "Sample YouTube Video Title Excerpt #{$i}";
            $thumb = "https://i.ytimg.com/vi/dQw4w9WgXcQ/hqdefault.jpg"; 

            $image_html = '';
            if ($lazy_load) {
                $image_html = "
                    <div class='yt-lazy-placeholder {$aspect_ratio_class}'>
                        <div class='yt-lazy-loader-wrapper'><div class='yt-grid-spinner'>...</div></div>
                        <img class='yt-lazy-hidden' src='data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=' data-src='{$thumb}' alt='{$title}' />
                    </div>
                ";
            } else {
                $image_html = "
                    <div class='yt-standard-ratio-wrapper {$aspect_ratio_class}'>
                        <img src='{$thumb}' alt='{$title}' />
                    </div>
                ";
            }

            $play_overlay_html = '';
            if ( $settings['show_play_overlay'] === 'yes' ) {
                $play_overlay_html = "
                    <div class='yt-play-overlay'>
                        <span class='yt-play-icon'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' style='width:1.2em; height:1.2em; fill:currentColor;'><path d='M8 5v14l11-7z'/></svg></span>
                    </div>
                ";
            }

            $date_html = ($show_date === 'yes') ? "<p class='yt-meta-pub'>" . esc_html__( '2 hours ago', 'yt-grid-rss' ) . "</p>" : "";
            $desc_html = ($show_desc === 'yes') ? "<p class='yt-meta-desc'>" . esc_html__( 'This is a sample description snippet outputting detailed descriptions inside your grid template style configurations.', 'yt-grid-rss' ) . "</p>" : "";
            $title_clamp_class = ($settings['title_line_limit'] !== 'none') ? 'yt-truncate line-clamp-' . esc_attr($settings['title_line_limit']) : '';

            $url = '#';
            $target_attr = '';
            $lightbox_attr = '';

            if ( $settings['click_action'] === 'lightbox' ) {
                $url = "https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1";
                $lightbox_attr = 'data-elementor-open-lightbox="yes" class="elementor-open-lightbox"';
            }

            echo "
                <div class='yt-item'>
                    <a href='{$url}' {$target_attr} {$lightbox_attr}>
                        <div class='yt-thumb-wrapper'>
                            {$image_html}
                            {$play_overlay_html}
                        </div>
                        " . ($show_title === 'yes' ? "<p class='yt-title {$title_clamp_class}'>{$title}</p>" : "") . "
                        {$date_html}
                        {$desc_html}
                    </a>
                </div>
            ";
        }
        echo "</div>";
    }
}
