<?php
	
namespace Elementor;
use Elementor\Includes\Widgets\Traits\Button_Trait;


/**
 * Listing image widget.
 *
 * Elementor widget that displays an embedded image.
 *
 * @since 1.0.0
 */


		
	class Widget_job_apply_button extends \Elementor\Widget_Base {
		use Button_Trait;
		
		public function __construct( $data=[], $args=null ){
            parent::__construct( $data, $args );      
			//wp_register_style('iv-bootstrap-4', wp_jobboard_template . 'admin/files/css/iv-bootstrap-4.css');
			
           
        }
	/**
	 * Get widget name.
	 *
	 * Retrieve image widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	 
	public function get_name() {
		return 'Widget_job_apply_button';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Job Apply Button', 'jobboard' );
	}
	public function get_keywords()
    {
        return [
            'button',           
            'call to action',            
           
        ];
    }
	/**
	 * Get widget icon.
	 *
	 * Retrieve Image widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-button';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Image widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['jobboard'];
	}

	
	/**
	 * Register Image widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'elementor' ),
			]
		);

		$this->register_button_content_controls();
		
		$this->add_control(
			'ekit_btn_text',
			[
				'label' =>esc_html__( 'Label', 'elementskit-lite' ),
				//'type' => Controls_Manager::TEXT,
				'default' =>esc_html__( 'Learn more ', 'elementskit-lite' ),
				'placeholder' =>esc_html__( 'Learn more ', 'elementskit-lite' ),
				'dynamic' => [
                    'active' => true,
                ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Button', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_button_style_controls();
		
		
		$this->end_controls_section();
	}
	
	/**
	 * Render Image widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {	
		?>
		<div class="bootstrap-wrapper popup0margin "id="popup-contact" >		
	<div class="container" >
		<div class="row" >
		
			<div class="col-md-12">
				<div class="modal-header">
					<h4 class="modal-title"><?php esc_html_e('Apply Now','jobboard'); ?></h4>							
						<button type="button" onclick="contact_close();" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
				</div>
				<div class="modal-body">
					<div class="row vertical-divider">
						<div class="col-md-6 col-sm-12">
							<?php
							include( wp_jobboard_template. 'listing/apply-form.php');						
							?>
						</div>
						
						<div class="col-md-6 col-sm-12">
								<h4 class="modal-title"><?php esc_html_e('Apply From Your Account ','jobboard'); ?></h4>
								<hr/>
								<?php
								 if(is_user_logged_in()){
								
									$job_apply='no';
									$userID = get_current_user_id();
									$job_apply_all = get_user_meta($userID,'job_apply_all',true);
									$job_apply_all = explode(",", $job_apply_all);
									if (in_array($id, $job_apply_all)) {
										$job_apply='yes';
									}										
									if($job_apply=='yes'){ ?>
										<div class="col-md-12 alert alert-info alert-dismissable"><h4><?php  esc_html_e( 'Applyed Already', 'jobboard' ); ?></h4></div>
										
									<?php	
									}	
									?>
								<form action="#" id="apply-pop2" name="apply-pop2"   method="POST" >
									<div class="form-group ">
										<label for="message" ><?php  esc_html_e( 'Cover Letter', 'jobboard' ); ?></label>
										 <input type="hidden" name="dir_id" id="dir_id" value="<?php echo esc_attr($id);?>">
										<textarea  class="form-control" name="cover-content2" id="cover-content2"  cols="20" rows="3"></textarea>
									 </div>
									 <div class="form-group ">									
									  <button type="button" class="btn btn-secondary ml-2"  onclick="job_apply_user();" ><?php  esc_html_e( 'Submit', 'jobboard' ); ?></button>									 
									  </div>
								</form>
								 <div  id="message_popupjob_apply_user"></div> 
								<?php
								}else{
								$login_page=get_option('epjbjobboard_login_page'); 
								?>
								<h5 ><a href="<?php echo get_permalink( $login_page);?>"><?php esc_html_e('Please Login & Apply','jobboard'); ?></a></h5>
							<?php
							
							}
							?>
						</div>
					</div>				
				</div>	
												
			</div>				
		</div>	
	</div>	
</div>	
	<?php	
		
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_job_apply_button);