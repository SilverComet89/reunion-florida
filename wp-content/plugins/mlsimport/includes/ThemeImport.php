<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Description of ThemeImport
 *
 * @author cretu
 */
class ThemeImport {

	// put your code here

	public $theme;
	public $plugin_name;
	public $enviroment;
	public $encoded_values;
	/**
	 * class construct
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */


	/*
	 *
	 *
	 * Api Request to MLSimport APi
	 *
	 *
	 *
	 * */

	 public function global_api_request_CURL_saas( $method, $values_array, $type = 'GET' ) {
		global $mlsimport;
		$url = MLSIMPORT_API_URL . $method;	
		$headers = array( 'Content-Type' => 'text/plain' );
	
		if ( 'token' !== $method ) {
			$token = $mlsimport->admin->mlsimport_saas_get_mls_api_token_from_transient();
			$headers = array();
			$headers['Content-Type'] = 'application/json';
			$headers['authorizationToken'] = $token;

		}

	
		$args = array(
			'method' 	  => 'GET',
			'headers'     => $headers,
			'body'        => wp_json_encode($values_array),
			'timeout'     => 120,
			'redirection' => 10,
			'httpversion' => '1.1',
			'blocking'    => true,
			'user-agent'  => $_SERVER['HTTP_USER_AGENT']		
		);
	

		if(empty($values_array)){
			unset($args['body']);	
		}



		// Choose the appropriate WordPress HTTP API function based on the request type
		if ( 'GET' === $type ) {
			$response = wp_remote_get( $url, $args );
		} else {
			$args['method'] = $type; 
			$response = wp_remote_post( $url, $args );
		}
	


		// Handle response
		if ( is_wp_error( $response ) ) {
			return $response->get_error_message();
		} else {
			$body 		= wp_remote_retrieve_body( $response );
			$to_return 	= json_decode( $body, true );
			
			return $to_return;
		}
	}

	



	/*
	 *
	 *
	 * Api Request to MLSimport APi
	 *
	 *
	 *
	 * */


	public static function global_api_request_saas( $method, $values_array, $type = 'GET' ) {
			global $mlsimport;
			$url = MLSIMPORT_API_URL . $method;

			$headers = array();
			if (  'token' !== $method  && 'mls' !==  $method  ) {
				$token   = $mlsimport->admin->mlsimport_saas_get_mls_api_token_from_transient();
				$headers = array(
					'authorizationToken' => $token,
					'Content-Type'       => 'application/json',
				);
			}


			$arguments = array(
				'method'      => $type,
				'timeout'     => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => $headers,
				'cookies'     => array(),
			);

			if ( is_array( $values_array ) && ! empty( $values_array ) ) {
				$arguments['body'] = wp_json_encode( $values_array );
			}

			$response = wp_remote_post( $url, $arguments );


			if ( is_wp_error( $response ) ) {
				// It is a WordPress error.
				$error_code = $response->get_error_code();
				$error_message = esc_html( $response->get_error_message( $error_code ) );
				$warning_message = sprintf(
					esc_html__( 'You have a WordPress Error. Error code: %s. Error Description: %s', 'mlsimport' ),
					esc_html( $error_code ),
					$error_message
				);
				print esc_html( '<div class="mlsimport_warning">' . $warning_message . '</div>' );
			
				$received_data['succes'] = false;
				return $received_data;
			}

			if ( isset( $response['response']['code'] ) && 200 ===  $response['response']['code']  ) {
				$received_data = json_decode( wp_remote_retrieve_body( $response ), true );
		
				return $received_data;
			} else {
				$received_data['succes'] = false;
				return $received_data;
			}
			exit();
	}








	/**
	 *
	 *
	 *
	 * Parse Result Array
	 */
	public function mlsimport_saas_parse_search_array_per_item( $ready_to_parse_array, $item_id_array, $batch_key, $mlsimport_item_option_data ) {
		$logs = '';

		wp_cache_flush();
		gc_collect_cycles();
		$counter_prop = 0;
		foreach ( $ready_to_parse_array['data'] as $key => $property ) {
			++$counter_prop;

			$logs = $this->mlsimport_mem_usage() . '=== In parse search array, listing no ' . $key . ' from batch ' . $batch_key . ' with Listingkey: ' . $property['ListingKey'] . PHP_EOL;
			mlsimport_saas_single_write_import_custom_logs( $logs, 'import' );

	
			wp_cache_delete( 'mlsimport_force_stop_' . $item_id_array['item_id'], 'options' );

			$status = get_option( 'mlsimport_force_stop_' . $item_id_array['item_id'] );
			$logs   = $this->mlsimport_mem_usage() . ' / on Batch ' . $item_id_array['batch_counter'] . ', Item ID: ' . $item_id_array['item_id'] . '/' . $counter_prop . ' check ListingKey ' . $property['ListingKey'] . ' - stop command issued ? ' . $status . PHP_EOL;
			mlsimport_saas_single_write_import_custom_logs( $logs, 'import' );

			if ( 'no' === $status ) {
				$logs = 'Will proceed to import - Memory Used ' . $this->mlsimport_mem_usage() . PHP_EOL;
				mlsimport_saas_single_write_import_custom_logs( $logs, 'import' );
				$this->mlsimport_saas_prepare_to_import_per_item( $property, $item_id_array, 'normal', $mlsimport_item_option_data );
			} else {
				update_post_meta( $item_id_array['item_id'], 'mlsimport_spawn_status', 'completed' );
			}
			unset( $logs );
		}

		unset( $ready_to_parse_array );
		unset( $logs );
	}


	/**
	 *
	 *
	 * Parse Result Array in CROn
	 */
	public function mlsimport_saas_cron_parse_search_array_per_item( $ready_to_parse_array, $item_id_array, $batch_key ) {

		$mlsimport_item_option_data                                   = array();
		$mlsimport_item_option_data['mlsimport_item_standardstatus']  = get_post_meta( $item_id_array['item_id'], 'mlsimport_item_standardstatus', true );
		$mlsimport_item_option_data['mlsimport_item_property_user']   = get_post_meta( $item_id_array['item_id'], 'mlsimport_item_property_user', true );
		$mlsimport_item_option_data['mlsimport_item_agent']           = get_post_meta( $item_id_array['item_id'], 'mlsimport_item_agent', true );
		$mlsimport_item_option_data['mlsimport_item_property_status'] = get_post_meta( $item_id_array['item_id'], 'mlsimport_item_property_status', true );

		foreach ( $ready_to_parse_array['data'] as $key => $property ) {
			$logs = 'In CRON parse search array, listing no ' . $key . ' from batch ' . $batch_key . ' with Listingkey: ' . $property['ListingKey'] . PHP_EOL;
			mlsimport_saas_single_write_import_custom_logs( $logs, 'cron' );
			$this->mlsimport_saas_prepare_to_import_per_item( $property, $item_id_array, 'cron', $mlsimport_item_option_data );
		}
	}







	/**
	 *
	 *
	 *  check if property already imported
	 */
	public function mlsimport_saas_retrive_property_by_id( $key, $post_type = 'estate_property' ) {

		$args = array(
			'post_type'   => $post_type,
			'post_status' => 'any',

			'meta_query'  => array(
				array(
					'key'     => 'ListingKey',
					'value'   => $key,
					'compare' => '=',
				),
			),
			'fields'      => 'ids',
		);

		$prop_selection = new WP_Query( $args );
		if ( $prop_selection->have_posts() ) {
			while ( $prop_selection->have_posts() ) {
				$prop_selection->the_post();
				$the_id = get_the_ID();
				wp_reset_postdata();
				return $the_id;
			}
		} else {
			wp_reset_postdata();
			return 0;
		}
	}





	/**
	 * clear taxonomy
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	public function mlsimport_saas_clear_property_for_taxonomy( $property_id, $taxonomies ) {

		if ( is_array( $taxonomies ) ) :
			foreach ( $taxonomies as $taxonomy => $term ) :
				if (is_wp_error($taxonomy)) {
                    error_log('Error with taxonomy: ' . $taxonomy->get_error_message());
                    continue; // Skip this iteration
                }
              
                if ( taxonomy_exists($taxonomy) ) {
                    wp_delete_object_term_relationships($property_id, $taxonomy);
                } else {
                    error_log("Taxonomy does not exist: {$taxonomy}");
                }
			endforeach;
		endif;
	}








	/**
	 * return non encoded encoded values
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	public function mlsimport_saas_return_non_encoded_value( $item, $encoded_values ) {

		if ( is_array( $item ) ) {
			if ( ! empty( $encoded_values ) ) {
				foreach ( $item as $key => $value ) {
					if ( isset( $encoded_values [ $value ] ) ) {
						$item[ $key ] = $encoded_values [ $value ];
					}
				}
			}
			return $item;
		} elseif ( ! empty( $encoded_values ) && isset( $encoded_values [ $item ] ) ) {
				return $encoded_values [ $item ];
		} else {
			return $item;
		}
	}

	/**
	 * set taxonomy
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	public function mlsimport_saas_update_taxonomy_for_property( $taxonomy, $property_id, $field_values ) {
	
		if ( ! is_array( $field_values ) ) {
			if ( strpos( $field_values, ',' ) !== false ) {
				$field_values = explode( ',', $field_values );
			} else {
				$field_values = array( $field_values );
			}
		}

		// Remove empty values and decode values in one pass
		$processed_field_values = array();
		foreach ( $field_values as $value ) {
			if ( ! empty( $value ) ) {
				$processed_field_values[] = $value;
			}
		}

		// Bulk update terms if array is not empty
		if ( ! empty( $processed_field_values ) ) {
			wp_set_object_terms( $property_id, $processed_field_values, $taxonomy, true );
			clean_term_cache( $property_id, $taxonomy );
		}
	}




	/**
	 * Set Property Title
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	public function mlsimport_saas_update_property_title( $property_id, $mls_import_post_id, $property ) {

		global $mlsimport;

		$title_format = esc_html( get_post_meta( $mls_import_post_id, 'mlsimport_item_title_format', true ) );

		if ( '' === $title_format ) {
			$options      = get_option( 'mlsimport_admin_mls_sync' );
			$title_format = $options['title_format'];
		}

		$start       = '{';
		$end         = '}';
		$title_array = $this->str_between_all( $title_format, $start, $end );

		$property_extra_meta_array_lowecase = array_change_key_case( $property['extra_meta'], CASE_LOWER );

		foreach ( $title_array as $key => $value ) {
			$replace = '';
			if ( 'Address' === $value   ) {
				if ( isset( $property['adr_title'] ) ) {
					$replace = $property['adr_title'];
				}
				$title_format = str_replace( '{Address}', $replace, $title_format );
			} elseif ( 'City' === $value   ) {
				if ( isset( $property['adr_city'] ) ) {
					$replace = $property['adr_city'];
				}
				$title_format = str_replace( '{City}', $replace, $title_format );
			} elseif ( 'CountyOrParish' ===  $value  ) {
				if ( isset( $property['adr_county'] ) ) {
					$replace = $property['adr_county'];
				}
				$title_format = str_replace( '{CountyOrParish}', $replace, $title_format );
			} elseif ( 'PropertyType' === $value  ) {
				if ( isset( $property['adr_type'] ) ) {
					$replace = $property['adr_type'];
				}
				$title_format = str_replace( '{PropertyType}', $replace, $title_format );
			} elseif ( 'Bedrooms' === $value   ) {
				if ( isset( $property['adr_bedrooms'] ) ) {
					$replace = $property['adr_bedrooms'];
				}
				$title_format = str_replace( '{Bedrooms}', $replace, $title_format );
			} elseif ( 'Bathrooms' === $value  ) {
				if ( isset( $property['adr_bathrooms'] ) ) {
					$replace = $property['adr_bathrooms'];
				}
				$title_format = str_replace( '{Bathrooms}', $replace, $title_format );
			} elseif ( 'ListingKey' === $value   ) {
				$replace = $property['ListingKey'];
				if ( '' !==   $replace ) {
					$title_format = str_replace( '{ListingKey}', $replace, $title_format );
				}
			} elseif ( 'ListingId' === $value   ) {
				if ( isset( $property['adr_listingid'] ) ) {
					$replace = $property['adr_listingid'];
				}
				if ( '' !==  $replace  ) {
					$title_format = str_replace( '{ListingId}', $replace, $title_format );
				}
			} elseif ( 'StateOrProvince' ===  $value  ) {
				if ( isset( $property['extra_meta']['StateOrProvince'] ) ) {
					$replace = $property['extra_meta']['StateOrProvince'];
				}
				$title_format = str_replace( '{StateOrProvince}', $replace, $title_format );
			} elseif ( 'PostalCode' ===  $value  ) {
				if ( isset( $property['meta']['property_zip'] ) ) {
					if ( is_array( $property['meta']['property_zip'] ) ) {
						$replace = strval( $property['meta']['property_zip'][0] );
					} else {
						$replace = strval( $property['meta']['property_zip'] );
					}
				} elseif ( isset( $property['meta']['fave_property_zip'] ) ) {
					if ( is_array( $property['meta']['fave_property_zip'] ) ) {
						$replace = strval( $property['meta']['fave_property_zip'][0] );
					} else {
						$replace = strval( $property['meta']['fave_property_zip'] );
					}
				}

				$title_format = str_replace( '{PostalCode}', $replace, $title_format );
			} elseif ( 'StreetNumberNumeric' ===  $value  ) {
				if ( isset( $property_extra_meta_array_lowecase['streetnumbernumeric'] ) ) {
					$replace = $property_extra_meta_array_lowecase['streetnumbernumeric'];
				}
				$title_format = str_replace( '{StreetNumberNumeric}', $replace, $title_format );
			} elseif ( 'StreetName' ===  $value  ) {
				if ( isset( $property_extra_meta_array_lowecase['streetname'] ) ) {
					$replace = $property_extra_meta_array_lowecase['streetname'];
				}
				$title_format = str_replace( '{StreetName}', $replace, $title_format );
			}
		}

		$post = array(
			'ID'         => $property_id,
			'post_title' => $title_format,
			'post_name'  => $title_format,
		);

		wp_update_post( $post );

		unset( $property_extra_meta_array_lowecase );
		return $title_format;
	}








	/**
	 *
	 *
	 *
	 *
	 * import property -prepare
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	public function mlsimport_saas_prepare_to_import_per_item( $property, $item_id_array, $tip_import, $mlsimport_item_option_data ) {
		// check if MLS id is set
		global $mlsimport;


		$mls_import_item_status = $mlsimport_item_option_data['mlsimport_item_standardstatus'];
		$new_author             = $mlsimport_item_option_data['mlsimport_item_property_user'];
		$new_agent              = $mlsimport_item_option_data['mlsimport_item_agent'];
		$property_status        = $mlsimport_item_option_data['mlsimport_item_property_status'];

		if ( is_array( $mls_import_item_status ) ) {
			$mls_import_item_status = array_map( 'strtolower', $mls_import_item_status );
		}

		
		if ( ! isset( $property['ListingKey'] ) ) {
			$log = 'ERROR : No Listing Key ' . PHP_EOL;
			mlsimport_saas_single_write_import_custom_logs( $log, $tip_import );
			return;
		}

		ob_start();

		$ListingKey        = $property['ListingKey'];
		$listing_post_type = $mlsimport->admin->env_data->get_property_post_type();
		$property_id       = intval( $this->mlsimport_saas_retrive_property_by_id( $ListingKey, $listing_post_type ) );
		$status            = 'Not Found';
		$property_history  = array();
		if ( isset( $property['StandardStatus'] ) ) {
			$status = strtolower( $property['StandardStatus'] );
		} else {
			$status = strtolower( $property['extra_meta']['MlsStatus'] );
		}

		if ( 0 === intval( $property_id)  ) {
			$is_insert = 'no';
			if (
				'active' === $status || 'active under contract' === $status ||
				'active with contract' === $status || 'activewithcontract' === $status ||
				'status' === $status || 'activeundercontract' === $status ||
				'comingsoon' === $status || 'coming soon' === $status ||
				'pending' === $status
			) {
				$is_insert = 'yes';
				if ( 'cron' === $tip_import  ) {
					if ( ! in_array( $status, $mls_import_item_status ) ) {
						// REJECTED because not selected';
						$is_insert = 'no';
					}
				}
			}
		} else {
			$is_insert = 'no';
		}

		$log = $this->mlsimport_mem_usage() . '==========' . wp_json_encode( $mls_import_item_status ) . '/' . $new_author . '/' . $new_agent . '/' . $property_status . '/ We have property with $ListingKey=' . $ListingKey . ' id=' . $property_id . ' with status ' . $status . ' is insert? ' . $is_insert . PHP_EOL;

		mlsimport_saas_single_write_import_custom_logs( $log, $tip_import );

		// content set and check
		$content      = '';
		$submit_title = $ListingKey;
		if ( isset( $property['content'] ) ) {
			$content = $property['content'];
		}

		// $new_author         =   get_post_meta($item_id_array['item_id'],'mlsimport_item_property_user',true );
		// $new_agent          =   esc_html(get_post_meta($item_id_array['item_id'], 'mlsimport_item_agent', true));
		// $property_status    =   esc_html(get_post_meta($item_id_array['item_id'], 'mlsimport_item_property_status', true));

		$mlsimport_item_option_data = null;

		if ( 'yes' ===  $is_insert  ) {
			$post = array(
				'post_title'   => $submit_title,
				'post_content' => $content,
				'post_status'  => $property_status,
				'post_type'    => $listing_post_type,
				'post_author'  => $new_author,
			);

			$property_id = wp_insert_post( $post );

			if ( is_wp_error( $property_id ) ) {
				$log = 'ERROR : on inserting ' . PHP_EOL;
				mlsimport_saas_single_write_import_custom_logs( $log, $tip_import );
			} else {
				update_post_meta( $property_id, 'ListingKey', $ListingKey );
				$property_history[] = date( 'F j, Y, g:i a' ) . ': We Inserted the property with Default title :  ' . $submit_title . ' and received id:' . $property_id;
			}

			clean_post_cache( $property_id );
		} elseif ( 0 !==  $property_id  ) {
				$property_history   = array();
				$property_history[] = get_post_meta( $property_id, 'mlsimport_property_history', true );

				$delete_statuses = array(
					'incomplete' => 'incomplete',
					'hold'       => 'hold',
					'canceled'   => 'canceled',
					'closed'     => 'closed',
					'delete'     => 'delete',
					'expired'    => 'expired',
					'withdrawn'  => 'withdrawn',
				);

				if ( ! in_array( 'pending', $mls_import_item_status ) ) {
					$delete_statuses['pending'] = 'pending';
				}

				if ( in_array( $status, $delete_statuses ) ) {
						$log = 'Property with ID ' . $property_id . ' and with name ' . get_the_title( $property_id ) . ' has a status of <strong>' . $status . '</strong> and will be deleted' . PHP_EOL;
						$log = '--1---> ' . $log . wp_json_encode( $mls_import_item_status ) . PHP_EOL;
					if ( in_array( $status, $mls_import_item_status ) ) {
						$log .= '-2--> canceling the delete ' . PHP_EOL;
					} else {
						$log .= '--3--> proceed with the delete ' . PHP_EOL;
						$this->delete_property( $property_id, $ListingKey );
					}

						mlsimport_saas_single_write_import_custom_logs( $log, $tip_import );
						unset( $log );

						return;
				} else {

					$post = array(
						'ID'           => $property_id,	
						'post_content' => $content,
						'post_type'    => $listing_post_type,
						'post_author'  => $new_author,
					);

					$log = ' Property with ID ' . $property_id . ' and with name ' . get_the_title( $property_id ) . ' has a status of <strong>' . $status . '</strong> and will be Edited</br>';
					mlsimport_saas_single_write_import_custom_logs( $log, $tip_import );

					$property_id = wp_update_post( $post );

					if ( is_wp_error( $property_id ) ) {
						$log = 'ERROR : on edit ' . PHP_EOL;
						mlsimport_saas_single_write_import_custom_logs( $log, $tip_import );
					} else {
						$submit_title       = get_the_title( $property_id );
						$property_history[] = gmdate( 'F j, Y, g:i a' ) . ': Property with title: ' . $submit_title . ', id:' . $property_id . ', ListingKey:' . $ListingKey . ', Status:' . $status . ' will be edited';
					}

					clean_post_cache( $property_id );
				}
		}

		//
		// Insert or edit POST ends her - START ADDING DETAILS
		//

		$encoded_values = array();// may be obsolote

		if ( intval( $property_id ) === 0 ) {
			mlsimport_saas_single_write_import_custom_logs( 'ERROR property id is 0' . PHP_EOL, $tip_import );
			return; // no point in going forward if no id
		}

		// Start working on Taxonomies
		//
		$tax_log   = array();
		$tax_log[] = 'Property with ID ' . $property_id . ' NO taxonomies found ! ';

		if ( isset( $property['taxonomies'] ) && is_array( $property['taxonomies'] ) ) {
			$taxonomies = $property['taxonomies'];
			$tax_log    = array();

			$this->mlsimport_saas_clear_property_for_taxonomy( $property_id, $property['taxonomies'] );

			foreach ( $taxonomies as $taxonomy => $term ) :
				$this->mlsimport_saas_update_taxonomy_for_property( $taxonomy, $property_id, $term );
				$property_history[] = 'Updated Taxonomy ' . $taxonomy . ' with terms ' . wp_json_encode( $term );
				$tax_log []         = 'Memory:' . $this->mlsimport_mem_usage() . ' Property with ID ' . $property_id . '  Updated Taxonomy ' . $taxonomy . ' with terms ' . wp_json_encode( $term );
			endforeach;
			$taxonomies = null;
		}

		$tax_log = implode( PHP_EOL, $tax_log );
		mlsimport_saas_single_write_import_custom_logs( $tax_log, $tip_import );
		$tax_log = null;

		// Pre Meta jobs
		//
		$property = $this->mlsimport_saas_prepare_meta_for_property( $property );

		// Start working on Meta
		//

		$meta_log    = array();
		$meta_log [] = 'Property with ID ' . $property_id . ' NO meta found ! ' . PHP_EOL;

		if ( isset( $property['meta'] ) && is_array( $property['meta'] ) ) {
			$meta_properties = $property['meta'];
			foreach ( $meta_properties as $meta_name => $meta_value ) :
				if ( is_array( $meta_value ) ) {
					$meta_value = implode( ',', $meta_value );
				}
				update_post_meta( $property_id, $meta_name, $meta_value );

				$property_history[] = 'Updated Meta ' . $meta_name . ' with meta_value ' . $meta_value;
				$meta_log []        = 'Memory:' . $this->mlsimport_mem_usage() . 'Property with ID ' . $property_id . '  Updated Meta ' . $meta_name . ' with value ' . $meta_value;
			endforeach;
		}
		$meta_properties = null;
		$meta_log        = implode( PHP_EOL, $meta_log );
		mlsimport_saas_single_write_import_custom_logs( $meta_log, $tip_import );
		$meta_log = null;

		// Start working on EXTRA Meta
		//

		$extra_meta_log    = 'Property with ID ' . $property_id . ' Start Extra meta ! ' . PHP_EOL;
		$extra_meta_result = $mlsimport->admin->env_data->mlsimport_saas_set_extra_meta( $property_id, $property );

		if ( isset( $extra_meta_result['property_history'] ) ) {
			$property_history = array_merge( $property_history, (array) $extra_meta_result['property_history'] );
		}
		if ( isset( $extra_meta_result['extra_meta_log'] ) ) {
			$extra_meta_log .= $extra_meta_result['extra_meta_log'];
		}

		mlsimport_saas_single_write_import_custom_logs( $extra_meta_log, $tip_import );

		$extra_meta_log    = null;
		$extra_meta_result = null;

		// Start working on Property Media
		//

		$media            = $property['Media'];
		$media_history    = $this->mlsimport_sass_attach_media_to_post( $property_id, $media, $is_insert );
		$property_history = array_merge( $property_history, (array) $media_history );
		$media            = null;
		$media_history    = null;

		// Updateing property title and ending
		//

		$new_title          = $this->mlsimport_saas_update_property_title( $property_id, $item_id_array['item_id'], $property );
		$property_history[] = 'Updated title to  ' . $new_title . '</br>';

		// extra fields to be checked
		$global_extra_fields = array();
		$mlsimport->admin->env_data->correlation_update_after( $is_insert, $property_id, $global_extra_fields, $new_agent );

		// saving history
		if ( ! empty( $property_history ) ) {
			$disable_history = intval( get_option( 'mlsimport-disable-history', 1 ) );
			if ( 1 ===  intval( $disable_history ) ) {
				$property_history[] = '---------------------------------------------------------------</br>';
				$property_history   = implode( '</br>', $property_history );
				update_post_meta( $property_id, 'mlsimport_property_history', $property_history );
			}
		}

		$logs = PHP_EOL . 'Ending on Property ' . $property_id . ', ListingKey: ' . $ListingKey . ' , is insert? ' . $is_insert . ' with new title: ' . $new_title . '  ' . PHP_EOL;
		mlsimport_saas_single_write_import_custom_logs( $logs, $tip_import );

		$capture = ob_get_contents();
		ob_end_clean();
		mlsimport_saas_single_write_import_custom_logs( $capture, $tip_import );

		$post             = null;
		$capture          = null;
		$property_status  = null;
		$new_agent        = null;
		$new_author       = null;
		$property_history = null;
		$tax_log          = null;
		$meta_log         = null;
		$extra_meta_log   = null;
		$media_history    = null;
		$logs             = null;
		$capture          = null;
		clean_post_cache( $property_id );
		wp_cache_flush();
		gc_collect_cycles();
	}







	public function mlsimport_mem_usage() {
		$mem_usage      = memory_get_usage( true );
		$mem_usage_show = round( $mem_usage / 1048576, 2 );
		return $mem_usage_show . 'mb ';
	}


	/**
	 * prepare meta data
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	public function mlsimport_saas_prepare_meta_for_property( $property ) {

		if ( isset( $property['extra_meta']['BathroomsTotalDecimal'] ) && floatval( $property['extra_meta']['BathroomsTotalDecimal'] ) > 0 ) {
			$property['meta']['property_bathrooms']            = floatval( $property['extra_meta']['BathroomsTotalDecimal'] );
			$property['meta']['fave_property_bathrooms']       = floatval( $property['extra_meta']['BathroomsTotalDecimal'] );
			$property['meta']['REAL_HOMES_property_bathrooms'] = floatval( $property['extra_meta']['BathroomsTotalDecimal'] );
		}
		return $property;
	}





	/**
	 * attach media to post
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	public function mlsimport_sass_attach_media_to_post( $property_id, $media, $is_insert ) {


		$media_history = array();
		if ( 'no' ===  $is_insert  ) {
			$media_history[] = ' Media - We have edit - images are not replaced';
			return $media_history;
		}

		global $mlsimport;
		include_once ABSPATH . 'wp-admin/includes/image.php';
		$has_featured = false;
		$all_images   = array();

		delete_post_meta( $property_id, 'fave_property_images' );
		delete_post_meta( $property_id, 'REAL_HOMES_property_images' );

		add_filter( 'intermediate_image_sizes_advanced', array( $this, 'wpc_unset_imagesizes' ) );

		// sorting media
		if ( isset( $media[0]['Order'] ) ) {
			$order = array_column( $media, 'Order' );
			array_multisort( $order, SORT_ASC, $media );
		}

		if ( is_array( $media ) ) {
			foreach ( $media as $key => $image ) :
				if ( isset( $image['MediaCategory'] ) && 'Photo' !== $image['MediaCategory'] ) {
					continue;
				}

				$file = $image['MediaURL'];

				$media_url = '';
				if ( isset( $image['MediaURL'] ) ) {
					$attachment = array(
						'guid'         => $image['MediaURL'],
						'post_status'  => 'inherit',
						'post_content' => '',
						'post_parent'  => $property_id,
					);

					if ( isset( $image['MimeType'] ) ) {
						$attachment['post_mime_type'] = $image['MimeType'];
					} else {
						$attachment['post_mime_type'] = 'image/jpg';
					}

					if ( isset( $image['MediaKey'] ) ) {
						$attachment['post_title'] = $image['MediaKey'];
					} else {
						$attachment['post_title'] = '';
					}

					$attach_id = wp_insert_attachment( $attachment, $file );

					$media_history[] = ' Media - Added ' . $image['MediaURL'] . ' as attachement ' . $attach_id;
					// wp_generate_attachment_metadata($attach_id,$image['MediaURL']);
					$mlsimport->admin->env_data->enviroment_image_save( $property_id, $attach_id );

					update_post_meta( $attach_id, 'is_mlsimport', 1 );
					if ( ! $has_featured ) {
						set_post_thumbnail( $property_id, $attach_id );
						$has_featured = true;
					}
				}
			endforeach;
		} else {
			$media_history[] = ' Media data is blank - there are no images';
		}
		remove_filter( 'intermediate_image_sizes_advanced', array( $this, 'wpc_unset_imagesizes' ) );

		$media_history = implode( '</br>', $media_history );
		return $media_history;
	}



	function wpc_unset_imagesizes( $sizes ) {
		$sizes = array();
	}










	/**
	 * return user option
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	public function mlsimport_saas_theme_import_select_user( $selected ) {
		$blog_list = '';
		$blogusers = get_users( 'blog_id=1&orderby=nicename' );
		foreach ( $blogusers as $user ) {
			$the_id     = $user->ID;
			$blog_list .= '<option value="' . $the_id . '"  ';
			if ( $the_id === intval($selected) ) {
				$blog_list .= ' selected="selected" ';
			}
			$blog_list .= '>' . $user->user_login . '</option>';
		}
		return $blog_list;
	}








	/**
	 * return agent option
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	public function mlsimport_saas_theme_import_select_agent( $selected ) {
		global $mlsimport;
		$args2 = array(
			'post_type'      => $mlsimport->admin->env_data->get_agent_post_type(),
			'post_status'    => 'publish',
			'posts_per_page' => 150,
		);

		if ( method_exists( $mlsimport, 'get_agent_post_type' ) ) {
			$args2['post_type'] = $mlsimport->admin->env_data->get_agent_post_type();
		}

		$agent_selection2 = new WP_Query( $args2 );
		$agent_list_sec   = '<option value=""><option>';

		while ( $agent_selection2->have_posts() ) {
			$agent_selection2->the_post();
			$the_id = get_the_ID();

			$agent_list_sec .= '<option value="' . $the_id . '"  ';
			if ( intval($selected) === $the_id ) {
				$agent_list_sec .= ' selected="selected" ';
			}
			$agent_list_sec .= '>' . get_the_title() . '</option>';
		}
		wp_reset_postdata();

		return $agent_list_sec;
	}


	/**
	 * delete property
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	public function delete_property( $delete_id, $ListingKey ) {
		if ( intval( $delete_id ) > 0 ) {
			$arguments        = array(
				'numberposts' => -1,
				'post_type'   => 'attachment',
				'post_parent' => $delete_id,
				'post_status' => null,
				'orderby'     => 'menu_order',
				'order'       => 'ASC',
			);
			$post_attachments = get_posts( $arguments );

			foreach ( $post_attachments as $attachment ) {
				wp_delete_post( $attachment->ID );
			}

			wp_delete_post( $delete_id );
			$log_entry = ' Property with id ' . $delete_id . ' and ' . $ListingKey . ' was deleted on ' . current_time( 'Y-m-d\TH:i' ) . PHP_EOL;
			mlsimport_saas_single_write_import_custom_logs( $log_entry, 'delete' );
		}
	}











	/**
	 * return_array with title items
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	public function str_between_all( string $string, string $start, string $end, bool $includeDelimiters = false, int &$offset = 0 ) {
		$strings = array();
		$length  = strlen( $string );

		while ( $offset < $length ) {
			$found = $this->str_between( $string, $start, $end, $includeDelimiters, $offset );
			if ( null ===  $found  ) {
				break;
			}

			$strings[] = $found;
			$offset   += strlen( $includeDelimiters ? $found : $start . $found . $end ); // move offset to the end of the newfound string
		}

		return $strings;
	}









	/**
	 * str_between
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	public function str_between( string $string, string $start, string $end, bool $includeDelimiters = false, int &$offset = 0 ) {
		if ('' === $string || '' === $start || '' === $end ) {
			return null;
		}

		$startLength = strlen( $start );
		$endLength   = strlen( $end );

		$startPos = strpos( $string, $start, $offset );
		if ( false === $startPos  ) {
			return null;
		}

		$endPos = strpos( $string, $end, $startPos + $startLength );
		if ( false ===   $endPos) {
			return null;
		}

		$length = $endPos - $startPos + ( $includeDelimiters ? $endLength : -$startLength );
		if ( ! $length ) {
			return '';
		}

		$offset = $startPos + ( $includeDelimiters ? 0 : $startLength );

		$result = substr( $string, $offset, $length );

		return ( false !== $result  ? $result : null );
	}








	/**
	 * delete property via sql
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	public function mlsimport_saas_delete_property_via_mysql( $delete_id, $ListingKey ) {

		$post_type = get_post_type( $delete_id );

		if ( 'estate_property' ===  $post_type  ||  'property' === $post_type ) {
			$term_obj_list    = get_the_terms( $delete_id, 'property_status' );
			$delete_id_status = join( ', ', wp_list_pluck( $term_obj_list, 'name' ) );

			$ListingKey = get_post_meta( $delete_id, 'ListingKey', true );
			if ( '' ===  $ListingKey  ) { // manual added listing
				$log_entry = 'User added listing  with id ' . $delete_id . ' (' . $post_type . ') (status ' . $delete_id_status . ') and ' . $ListingKey . '  NOT DELETED' . PHP_EOL;
				mlsimport_saas_single_write_import_custom_logs( $log_entry, 'delete' );
				return;
			}

			global $wpdb;
			$wpdb->query(
				$wpdb->prepare(
					"
            DELETE FROM $wpdb->postmeta 
            WHERE `post_id` = %d",
					$delete_id
				)
			);

			$wpdb->query(
				$wpdb->prepare(
					"
            DELETE FROM $wpdb->posts 
            WHERE `post_parent` = %d",
					$delete_id
				)
			);

			$wpdb->query(
				$wpdb->prepare(
					"
            DELETE FROM $wpdb->posts 
            WHERE ID = %d",
					$delete_id
				)
			);

			$log_entry = 'MYSQL DELETE -> Property with id ' . $delete_id . ' (' . $post_type . ') (status ' . $delete_id_status . ') and ' . $ListingKey . ' was deleted on ' . current_time( 'Y-m-d\TH:i' ) . PHP_EOL;
			mlsimport_saas_single_write_import_custom_logs( $log_entry, 'delete' );
		}
	}
}
