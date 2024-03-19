<?php
	namespace Elementor;	
	use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
	use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

	class ListingProSingleMeta extends \Elementor\Widget_Base {
		public function __construct( $data=[], $args=null ){
            parent::__construct( $data, $args );            
			wp_register_style('iv-bootstrap-4', wp_jobboard_template . 'admin/files/css/iv-bootstrap-4.css');
            /*
			wp_register_script( 'demo-elementor-widget-js',  plugin_dir_url( __FILE__ ) . '/assets/js/demo-elementor-widget.js', ['elementor-frontend'],'1.0.0', true );
            */
        }
		
		public function get_name()
		{
			return "jobboard_single_meta";
		}
		public function get_title()
		{
			return "Job Listing Fields";
		}
		public function get_icon()
		{
			return 'eicon-text';
		}
		public function get_categories()
		{
			return ['jobboard'];
		}
		

		public function get_style_depends() {
				return [ 'iv-bootstrap-4' ];
		}
		/******************** CONTENT PROCESSING ***********************/
		protected function register_controls() {
			//Top Section Right Side Image
			$this->start_controls_section(
			'jobboard_meta_data',
			[
			'label' => __( 'Listing Fields', 'jobboard' ),
			'tab' => Controls_Manager::TAB_CONTENT,
			]
			);
			
			$default_fields = array();
			$field_set=get_option('jobboard_fields' );			
			if($field_set!=""){
				$default_fields=get_option('jobboard_fields' );
				}else{
				$default_fields['other_link']='Other Link';			
			}
			
			$default_fields['title']= esc_html__( 'Title', 'jobboard' );
			$default_fields['listing_content']=  esc_html__( 'Job Description', 'jobboard' );
			$default_fields['published']=esc_html__( 'Published', 'jobboard' );
			$default_fields['vacancy']=esc_html__( 'vacancy', 'jobboard' );
			$default_fields['job_type']=esc_html__( 'Employment Status', 'jobboard' );
			$default_fields['experience_range']=esc_html__( 'Experience', 'jobboard' );
			$default_fields['gender']=esc_html__( 'gender', 'jobboard' );
			$default_fields['job_level']=esc_html__( 'Career Level', 'jobboard' );
			$default_fields['educational_requirements']=esc_html__( 'Qualification', 'jobboard' );
			$default_fields['deadline']=esc_html__( 'Deadline', 'jobboard' );
			$default_fields['job_education']=esc_html__( 'Education & Experience', 'jobboard' );
			$default_fields['job_must_have']=esc_html__( 'Must Have', 'jobboard' );
			$default_fields['workplace']=esc_html__( 'Job Location', 'jobboard' );
			$default_fields['other_benefits']=esc_html__( 'Other Benefits', 'jobboard' );	
			$default_fields['address']= esc_html__( 'Address', 'jobboard' );
			$default_fields['city']=  esc_html__( 'City', 'jobboard' );
			$default_fields['state']= esc_html__( 'State', 'jobboard' );
			$default_fields['country']= esc_html__( 'Country', 'jobboard' );
			$default_fields['postcode']= esc_html__( 'Post Code', 'jobboard' );
			$default_fields['zipcode']= esc_html__( 'Zip Code', 'jobboard' );
			$default_fields['phone']=  esc_html__( 'Conatct Phone #', 'jobboard' );
			$default_fields['contact_name']= esc_html__('Contact Name', 'jobboard');
			$default_fields['contact-email']= esc_html__( 'Contact Email', 'jobboard' );
			$default_fields['contact_web']= esc_html__( 'Contact Web Address', 'jobboard' );
			$default_fields['vimeo']= esc_html__('Vimeo video', 'jobboard');
			$default_fields['youtube']= esc_html__('Youtube video', 'jobboard');	
					
			
			$this->add_control(
			'jobboard_meta',
				[
				'label' => esc_html__( 'Select Field', 'jobboard' ),
				'type' => Controls_Manager::SELECT,
				'block' => true,
				'default' => 'title',
				'options' => $default_fields,
			]
			);
			
			
			$this->add_control(
			'size',
				[
				'label' => __( 'Size', 'jobboard' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
				'default' => __( 'Default', 'jobboard' ),
				'small' => __( 'Small', 'jobboard' ),
				'medium' => __( 'Medium', 'jobboard' ),
				'large' => __( 'Large', 'jobboard' ),
				'xl' => __( 'XL', 'jobboard' ),
				'xxl' => __( 'XXL', 'jobboard' ),
				],
				]
			);
			$this->add_control(
			'header_size',
				[
				'label' => __( 'HTML Tag', 'jobboard' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
				'h1' => __( 'H1', 'jobboard' ),
				'h2' => __( 'H2', 'jobboard' ),
				'h3' => __( 'H3', 'jobboard' ),
				'h4' => __( 'H4', 'jobboard' ),
				'h5' => __( 'H5', 'jobboard' ),
				'h6' => __( 'H6', 'jobboard' ),
				'div' => __( 'div', 'jobboard' ),
				'span' => __( 'span', 'jobboard' ),
				'p' => __( 'p', 'jobboard' ),
				],
				'default' => 'h2',
				]
			);
			$this->add_responsive_control(
				'align',
				[
					'label' => esc_html__( 'Alignment', 'elementor' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'elementor' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'elementor' ),
							'icon' => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => esc_html__( 'Justified', 'elementor' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'default' => '',
					'selectors' => [
						'{{WRAPPER}}' => 'text-align: {{VALUE}};',
					],
					]
				);
			$this->add_control(
			'view',
			[
			'label' => __( 'View', 'elementor' ),
			'type' => Controls_Manager::HIDDEN,
			'default' => 'traditional',
			]
			);
			$this->end_controls_section();
			$this->start_controls_section(
			'section_title_style',
			[
			'label' => __( 'Title', 'elementor' ),
			'tab' => Controls_Manager::TAB_STYLE,
			]
			);
			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Text Color', 'elementor' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-heading-title' => 'color: {{VALUE}};',
					],
				]
			);

						
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography',
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .elementor-heading-title',
				]
				);

				$this->add_group_control(
					Group_Control_Text_Stroke::get_type(),
					[
						'name' => 'text_stroke',
						'selector' => '{{WRAPPER}} .elementor-heading-title',
					]
				);

				$this->add_group_control(
					Group_Control_Text_Shadow::get_type(),
					[
						'name' => 'text_shadow',
						'selector' => '{{WRAPPER}} .elementor-heading-title',
					]
				);
				$this->add_control(
					'blend_mode',
					[
						'label' => esc_html__( 'Blend Mode', 'elementor' ),
						'type' => Controls_Manager::SELECT,
						'options' => [
							'' => esc_html__( 'Normal', 'elementor' ),
							'multiply' => 'Multiply',
							'screen' => 'Screen',
							'overlay' => 'Overlay',
							'darken' => 'Darken',
							'lighten' => 'Lighten',
							'color-dodge' => 'Color Dodge',
							'saturation' => 'Saturation',
							'color' => 'Color',
							'difference' => 'Difference',
							'exclusion' => 'Exclusion',
							'hue' => 'Hue',
							'luminosity' => 'Luminosity',
						],
						'selectors' => [
							'{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
						],
						'separator' => 'none',
					]
				);
			$this->end_controls_section();
		}
		/**
			* Render heading widget output on the frontend.
			*
			* Written in PHP and used to generate the final HTML.
			*
			* @since 1.0.0
			* @access protected
		*/
		protected function render() {
			$settings = $this->get_settings_for_display();
			global $post;
			if ( empty( $settings['jobboard_meta'] ) ) {
				return;
			}
		

			if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'title', 'class', 'elementor-size-' . $settings['size'] );
			}

			$this->add_inline_editing_attributes( 'title' );
			$title = $settings['jobboard_meta'];
						
			$this->add_render_attribute( 'jobboard_meta', 'class', 'elementor-heading-title' );
			if ( ! empty( $settings['size'] ) ) {
				$this->add_render_attribute( 'jobboard_meta', 'class', 'elementor-size-' . $settings['size'] );
			}
			$this->add_inline_editing_attributes( 'jobboard_meta' );
			$title = get_post_meta($post->ID,$settings['jobboard_meta'],true) ;
							
			if( $settings['jobboard_meta']=='_opening_time'){	
				?>
					<div class="row col">
						<?php					
						foreach($title as $key => $item){
							$day_time = explode("|", $item);
							echo sprintf( '<div class="col-md-6"><p> <%1$s %2$s>%3$s %4$s %5$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'jobboard_meta' ), $key," : ",$day_time[0].' - '.$day_time[1].'</p></div>');
						}
						?>
					</div>
				<?php	
			}elseif( $settings['jobboard_meta']=='vimeo'){	
				$video_vimeo_id= get_post_meta($post->ID,'vimeo',true);
				if($video_vimeo_id!=""){ $v=$v+1; ?>
					<iframe src="https://player.vimeo.com/video/<?php echo esc_html($video_vimeo_id); ?>" width="100%" height="100%" class="w-100 m-0 p-0" frameborder="0"></iframe>					
					<?php
					}
			}elseif( $settings['jobboard_meta']=='youtube'){					
					$video_youtube_id=get_post_meta($post->ID,'youtube',true);
					if($video_youtube_id!=""){						
					?>
					<iframe width="100%" height="415px" src="https://www.youtube.com/embed/<?php echo esc_html($video_youtube_id); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-100"></iframe>
					<?php
					}
						
			}elseif( $settings['jobboard_meta']=='listing_content'){			
				
				$content_post = get_post($post->ID);
				$listing_data = $content_post->post_content;				

				echo sprintf( '<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag( $settings['header_size'] ), $this->get_render_attribute_string( 'title' ), $listing_data );
				
				
			}elseif( $settings['jobboard_meta']=='title'){	
					$title=get_the_title($post->ID);					
					echo  sprintf( '<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag( $settings['header_size'] ), $this->get_render_attribute_string( 'title' ), $title );
					
					
			}else{
			
				echo  sprintf( '<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag( $settings['header_size'] ), $this->get_render_attribute_string( 'title' ), $title );
				
			}
			
			
		}
		/**
			* Render heading widget output in the editor.
			*
			* Written as a Backbone JavaScript template and used to generate the live preview.
			*
			* @since 1.0.0
			* @access protected
		*/
		protected function content_template() {
		?>
		
		<#
		var title_template = settings.jobboard_meta;
		view.addRenderAttribute( 'jobboard_meta', 'class', [ 'elementor-heading-title', 'elementor-size-' + settings.size ] );
		var headerSizeTag = elementor.helpers.validateHTMLTag( settings.header_size ),
			title_html = '<' + headerSizeTag  + ' ' + view.getRenderAttributeString( 'jobboard_meta' ) + '>' + title_template + '</' + headerSizeTag + '>';
		
			print( title_html );
		#>
		
        <?php
		}
	}
	Plugin::instance()->widgets_manager->register_widget_type( new ListingProSingleMeta );
