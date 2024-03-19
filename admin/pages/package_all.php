<?php
	global $wpdb;
	$currencies = array();
	$currencies['AUD'] ='$';$currencies['CAD'] ='$';
	$currencies['EUR'] ='€';$currencies['GBP'] ='£';
	$currencies['JPY'] ='¥';$currencies['USD'] ='$';
	$currencies['NZD'] ='$';$currencies['CHF'] ='Fr';
	$currencies['HKD'] ='$';$currencies['SGD'] ='$';
	$currencies['SEK'] ='kr';$currencies['DKK'] ='kr';
	$currencies['PLN'] ='zł';$currencies['NOK'] ='kr';
	$currencies['HUF'] ='Ft';$currencies['CZK'] ='Kč';
	$currencies['ILS'] ='₪';$currencies['MXN'] ='$';
	$currencies['BRL'] ='R$';$currencies['PHP'] ='₱';
	$currencies['MYR'] ='RM';$currencies['AUD'] ='$';
	$currencies['TWD'] ='NT$';$currencies['THB'] ='฿';	
	$currencies['TRY'] ='TRY';	$currencies['CNY'] ='¥';	
	if(isset($_REQUEST['delete_id']))  {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Are you cheating:user Permission?' );
		}
		$post_id=sanitize_text_field($_REQUEST['delete_id']);	
		$recurring= get_post_meta($post_id, 'jobboard_package_recurring', true);
		if($recurring=='on'){
			$iv_gateway = get_option('jobboard_payment_gateway');
			if($iv_gateway=='stripe'){
				require_once(wp_jobboard_DIR . '/admin/init.php');
				$post_name2='jobboard_stripe_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s",$post_name2 ));
				if(isset($row->ID )){
					$stripe_id= $row->ID;
				}	
				$post_package = get_post($post_id); 
				$p_name = $post_package->post_name;
				$stripe_mode=get_post_meta( $stripe_id,'jobboard_stripe_mode',true);	
				if($stripe_mode=='test'){
					$stripe_api =get_post_meta($stripe_id, 'jobboard_stripe_secret_test',true);	
					}else{
					$stripe_api =get_post_meta($stripe_id, 'jobboard_stripe_live_secret_key',true);	
				}
				$plan='';	
				\Stripe\Stripe::setApiKey($stripe_api);
				
				try {
					$p = \Stripe\Plan::retrieve($p_name);
					} catch (Exception $e) {
					$error==1;
				}
				if( $error==0){
					$p->delete();	
				}
					
			}
		}							
		wp_delete_post($post_id);
		delete_post_meta($post_id,true);
		$message=esc_html__( 'Deleted Successfully', 'jobboard' ) ;
	}
	if(isset($_REQUEST['form_submit']))  {
		$message= esc_html__( 'Update Successfully', 'jobboard' ) ;
	}
	$api_currency= get_option('epjbjobboard_api_currency' );
?>
<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">
		<div class="row ">					
			<div class="col-md-12" id="submit-button-holder">					
				<div class="pull-right ">								
					<a class="btn btn-info "  href="<?php echo wp_jobboard_ADMINPATH; ?>admin.php?page=wp-jobboard-package-create"><?php esc_html_e( 'Create A New Package', 'jobboard' );?></a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 table-responsive">
				<h3  class=""><?php esc_html_e( 'All Package / Membership Level ', 'jobboard' );?> <small></small>
					<small >
						<?php
							if (isset($_REQUEST['form_submit']) AND $_REQUEST['form_submit'] <> "") {
							}
							if (isset($message) AND $message <> "") {
								echo  '<span> [ '.$message.' ]</span>';
							}
						?>
					</small>
				</h3>
				<div class="panel panel-info">
					<div class="panel-body">
						<table class="table table-striped col-md-12">
							<thead >
								<tr>
									<th ><?php esc_html_e( 'Package Name', 'jobboard' );?></th>
									<th ><?php esc_html_e( 'Amount', 'jobboard' );?></th>
									<th><?php esc_html_e( 'Link', 'jobboard' );?></th>
									<th><?php esc_html_e( 'Type', 'jobboard' );?></th>
									<th><?php esc_html_e( 'User Role', 'jobboard' );?></th>
									<th><?php esc_html_e( 'Status', 'jobboard' );?></th>
									<th ><?php esc_html_e( 'Action', 'jobboard' );?></th>
								</tr>
							</thead>
							<tbody>
								<?php
									$currency=$api_currency ;
									$currency_symbol=(isset($currencies[$currency]) ? $currencies[$currency] :$currency );
									global $wpdb, $post;
									$jobboard_pack='jobboard_pack';
									$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'",$jobboard_pack );
									$membership_pack = $wpdb->get_results($sql);
									$total_package=count($membership_pack);
									if(sizeof($membership_pack)>0){
										$i=0;
										foreach ( $membership_pack as $row )
										{	
											echo'<tr>';
											echo '<td>'. $row->post_title.'</td>';
											$amount='';
											if(get_post_meta($row->ID, 'jobboard_package_cost', true)!="" AND get_post_meta($row->ID, 'jobboard_package_cost', true)!="0"){
												$amount= get_post_meta($row->ID, 'jobboard_package_cost', true).' '.$currency;
												}else{
												$amount= '0 '.$currency;
											}
											$recurring= get_post_meta($row->ID, 'jobboard_package_recurring', true);	
											if($recurring == 'on'){
												$count_arb=get_post_meta($row->ID, 'jobboard_package_recurring_cycle_count', true); 	
												if($count_arb=="" or $count_arb=="1"){
													$recurring_text=" per ".' '.get_post_meta($row->ID, 'jobboard_package_recurring_cycle_type', true);
													}else{
													$recurring_text=' per '.$count_arb.' '.get_post_meta($row->ID, 'jobboard_package_recurring_cycle_type', true).'s';
												}
												}else{
												$recurring_text=' &nbsp; ';
											}
											$recurring= get_post_meta($row->ID, 'jobboard_package_recurring', true);	
											if($recurring == 'on'){
												$amount= get_post_meta($row->ID, 'jobboard_package_recurring_cost_initial', true).' '.$currency;
												$amount=$amount. ' / '.$recurring_text;
											}
											echo '<td>'. $amount.'</td>';	
											$page_name_reg=get_option('epjbjobboard_registration' ); 		
											echo '<td><a target="blank" href="'.get_page_link($page_name_reg).'?&package_id=	'.esc_attr($row->ID).'">'.get_page_link($page_name_reg).'?&package_id=	'.esc_attr($row->ID).' </a>			
											</td>';
										?>
										<td><?php 
											echo (get_post_meta($row->ID,'jobboard_package_vip_badge',true)=='yes'?'VIP Badge':'' );
											echo' | ';
											echo (get_post_meta($row->ID,'jobboard_package_feature',true)=='yes'?'Feature Listing':'' ); 
										?> </td>
										<?php
											echo '<td>'. esc_html($row->post_title).'</td>';
										?>
										<td>
											<div id="status_<?php echo esc_html($row->ID); ?>">
												<?php
													if($row->post_status=="draft"){										
														$pac_msg='Active';
														}else{										
														$pac_msg='Inactive';
													}
												?>
												<button class="btn btn-info btn-xs" onclick="return iv_package_status_change('<?php echo esc_attr($row->ID); ?>','<?php echo esc_attr($row->post_status); ?>');"><?php echo esc_html($pac_msg); ?></button>
											</div>	
											<?php
												echo" </td> ";
												echo '<td>  <a class="btn btn-primary btn-xs" href="?page=wp-jobboard-package-update&id='.esc_attr($row->ID).'"> '.esc_html__( ' Edit', 'jobboard' ).'</a> <a href="?page=wp-jobboard-package-all&delete_id='.esc_attr($row->ID).'" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure to delete this package?\')">'.esc_html__( 'Delete', 'jobboard' ).'</a></td>';
												echo'</tr>';
												$i++;
											}
										}else{ ?>
										<br/>
										<br/>
										<tr><td> <h4><?php esc_html_e( 'Package List is Empty', 'jobboard' );?> </h4></td></tr>
										<?php	
										}
									?>
								</tbody>
							</table>
						</div>					
					</div>
				</div>
			</div>
			<div class="row">					
				<div class="col-md-12">					
					<div class="">								
						<a class="btn btn-info "  href="<?php echo wp_jobboard_ADMINPATH; ?>admin.php?page=wp-jobboard-package-create"><?php esc_html_e( 'Create A New Package', 'jobboard' );?></a>
					</div>
				</div>
			</div>
			<br/>
				<?php
			include('footer.php');
			?>
			<div class="panel panel-info">
				<div class="panel-body">
					<div class=" col-md-12  bs-callout bs-callout-info">		
						<?php esc_html_e( 'User role "Basic" is created on the plugin activation. Paid exprired or unsuccessful payment user will set on the "Basic" user role.', 'jobboard' );?>	
					</div>
					<div class="clearfix"></div>
					<ul class=" list-group col-md-6">
						<li class="list-group-item"><?php esc_html_e('Short Code :','jobboard');  ?> <code>[jobboard_price_table]  </code></li>
						<li class="list-group-item"><?php esc_html_e('PHP Code :','jobboard');  ?><code>
							&lt;?php
							echo do_shortcode('[jobboard_price_table ]');
						?&gt;</code>  
						</li>
						<li class="list-group-item">
							<?php esc_html_e( 'Package Page ', 'jobboard' );?>: 
							<?php 
								$jobboard_price_table=get_option('epjbjobboard_price_table');
							?>
							<a class="btn btn-info btn-xs " href="<?php echo get_permalink( $jobboard_price_table ); ?>" target="blank"><?php esc_html_e( 'View Page', 'jobboard' );?></a>
						</li>		
					</ul>	
					<div class="clearfix"></div>
					<div class="  bs-callout bs-callout-info">	
						<?php esc_html_e( 'Note: You can use other available pricing table. The package link URL will go on "Sign UP " button. ', 'jobboard' );?>	
					</div>
				</div>
			</div>	
		</div>
	</div>		