<?php
error_reporting(-1);
ini_set("display_errors", 1);
include_once('../../../../database/evolutiondb.inc');

$one2Many = new one2Many;
$failed_records = $one2Many->process_migration_issues();
//$res= EVODB::GetAllMigrations();
echo "<pre>";
print_r($failed_records);


class one2Many
{
    private $token = 'kbfjC3zbKjmQ2fXXmA2mdQILgqqgFyZ5gD5DH7ndU3BOvK77xHEUDRUKFQxqqy5f';
    /**
    * 
    * Fetches the details of a canvas migration issue
    *
    * @param string $course_id course ID that the migration issue relates to
    * @param string $migration_issue_id ID of the migration issue
    * @return array
    */
	private function get_course_content_migration_issue($course_id, $migration_issue_id) {
		try {
			$ch = curl_init();

            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            curl_setopt($ch, CURLOPT_URL, 'https://psu.test.instructure.com/api/v1/courses/'.$course_id.'/content_migrations/'.$migration_issue_id);
            $headers = array(
               "Content-Type: application/json",
               "Authorization: Bearer ".$this->token
           );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXY, 'tcp://ots-rhel5-proxy-01.outreach.psu.edu');
            curl_setopt($ch, CURLOPT_PROXYPORT, '8080');


            $json_migration_issue_info = curl_exec($ch);
            $arr_migration_issue_info = json_decode($json_migration_issue_info, TRUE);

            if (FALSE === $json_migration_issue_info)
                throw new Exception(curl_error($ch), curl_errno($ch));
            else {
                //echo "<pre>";
                return $arr_migration_issue_info;
                curl_close($ch);
            }


            // ...process $content now
        } catch(Exception $e) {

            trigger_error(sprintf(	
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }
	}
    
    private function get_course($course_id) {
		try {
			$ch = curl_init();

            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            curl_setopt($ch, CURLOPT_URL, 'https://psu.test.instructure.com/api/v1/courses/'.$course_id);
            $headers = array(
               "Content-Type: application/json",
               "Authorization: Bearer ".$this->token
           );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXY, 'tcp://ots-rhel5-proxy-01.outreach.psu.edu');
            curl_setopt($ch, CURLOPT_PROXYPORT, '8080');


            $json_course_info = curl_exec($ch);
            $arr_course_info = json_decode($json_course_info, TRUE);

            if (FALSE === $json_course_info)
                throw new Exception(curl_error($ch), curl_errno($ch));
            else {
                //echo "<pre>";
                return $arr_course_info;
                curl_close($ch);
            }


            // ...process $content now
        } catch(Exception $e) {

            trigger_error(sprintf(	
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }
    }
    
    private function get_course_group_categories($course_id) {
        try {
					
            $ch = curl_init();

            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            curl_setopt($ch, CURLOPT_URL, 'https://psu.test.instructure.com/api/v1/courses/'.$course_id.'/group_categories?per_page=100');
            $headers = array(
               "Content-Type: application/json",
               "Authorization: Bearer ".$this->token
           );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXY, 'tcp://ots-rhel5-proxy-01.outreach.psu.edu');
            curl_setopt($ch, CURLOPT_PROXYPORT, '8080');


            $json_group_categories = curl_exec($ch);
            $arr_group_categories = json_decode($json_group_categories, TRUE);

            if (FALSE === $json_group_categories)
                throw new Exception(curl_error($ch), curl_errno($ch));
            else {
                //echo "<pre>";
                return $arr_group_categories;
                curl_close($ch);
            }


            // ...process $content now
        } catch(Exception $e) {

            trigger_error(sprintf(	
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }
    }
    
    private function get_course_groups($course_id) {
        try {
					
            $ch = curl_init();

            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            curl_setopt($ch, CURLOPT_URL, 'https://psu.test.instructure.com/api/v1/courses/'.$course_id.'/groups?per_page=100');
            $headers = array(
               "Content-Type: application/json",
               "Authorization: Bearer ".$this->token
           );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXY, 'tcp://ots-rhel5-proxy-01.outreach.psu.edu');
            curl_setopt($ch, CURLOPT_PROXYPORT, '8080');


            $json_course_groups = curl_exec($ch);
            $arr_course_groups = json_decode($json_course_groups, TRUE);

            if (FALSE === $json_course_groups)
                throw new Exception(curl_error($ch), curl_errno($ch));
            else {
                //echo "<pre>";
                return $arr_course_groups;
                curl_close($ch);
            }


            // ...process $content now
        } catch(Exception $e) {

            trigger_error(sprintf(	
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }
    }
    
    
    private function create_course_group_category($course_id, $category_data) {
        try {

            $ch = curl_init();

            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            curl_setopt($ch, CURLOPT_URL, 'https://psu.test.instructure.com/api/v1/courses/'.$course_id.'/group_categories');
            $headers = array(
               //"Content-Type: application/json",
               "Authorization: Bearer ".$this->token
           );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $postFields = array('name' => $category_data['name'], 'group_limit' => $category_data['group_limit']);

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXY, 'tcp://ots-rhel5-proxy-01.outreach.psu.edu');
            curl_setopt($ch, CURLOPT_PROXYPORT, '8080');


            $json_group_category = curl_exec($ch);
            $arr_group_category = json_decode($json_group_category, TRUE);

            if (FALSE === $json_group_category)
                throw new Exception(curl_error($ch), curl_errno($ch));
            else {
                //echo "<pre>";
                return $arr_group_category;
                curl_close($ch);
            }


            // ...process $content now
        } catch(Exception $e) {

            trigger_error(sprintf(	
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }
    }
    
    private function create_group($group_category_id, $group_data) {
        try {

            $ch = curl_init();

            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            curl_setopt($ch, CURLOPT_URL, 'https://psu.test.instructure.com/api/v1/group_categories/'.$group_category_id.'/groups');
            $headers = array(
               //"Content-Type: application/json",
               "Authorization: Bearer ".$this->token
           );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $postFields = array('name' => $group_data['name'], 'description' => $group_data['description']);

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXY, 'tcp://ots-rhel5-proxy-01.outreach.psu.edu');
            curl_setopt($ch, CURLOPT_PROXYPORT, '8080');


            $json_target_group = curl_exec($ch);
            $arr_target_group = json_decode($json_target_group, TRUE);

            if (FALSE === $json_target_group)
                throw new Exception(curl_error($ch), curl_errno($ch));
            else {
                return $arr_target_group;
                curl_close($ch);
            }


            // ...process $content now
        } catch(Exception $e) {

            trigger_error(sprintf(	
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }
    }
	
	private function update_course($course_id, $data) {
		try {
					
			$ch = curl_init();
		
			if (FALSE === $ch)
				throw new Exception('failed to initialize');
		
			curl_setopt($ch, CURLOPT_URL, 'https://psu.test.instructure.com/api/v1/courses/'.$course_id);
			$headers = array(
			   //"Content-Type: application/json",
			   "Authorization: Bearer ".$this->token
		   );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$postFields = array('id' => $course_id);
			/*
			if(isset($data['start_at'])) {
				$postFields['course[start_at]'] = $data['start_at'];
			}
			if(isset($data['end_at'])) {
				$postFields['course[end_at]'] = $data['end_at'];
			}
			*/
			if(isset($data['license'])) {
				$postFields['course[license]'] = $data['license'];
			}
			/*
			if(isset($data['is_public'])) {
				$postFields['course[is_public]'] = $data['is_public'];
			}
			if(isset($data['public_syllabus'])) {
				$postFields['course[public_syllabus]'] = $data['public_syllabus'];
			}
			if(isset($data['public_description'])) {
				$postFields['course[public_description]'] = $data['public_description'];
			}
			*/
			// not exists allow_student_wiki_edits, offer
			if(isset($data['allow_student_wiki_edits'])) {
				$postFields['course[allow_student_wiki_edits]'] = $data['allow_student_wiki_edits'];
			}
			if(isset($data['allow_wiki_comments'])) {
				$postFields['course[allow_wiki_comments]'] = $data['allow_wiki_comments'];
			}
			if(isset($data['allow_student_forum_attachments'])) {
				$postFields['course[allow_student_forum_attachments]'] = $data['allow_student_forum_attachments'];
			}
			/*
			if(isset($data['open_enrollment'])) {
				$postFields['course[open_enrollment]'] = $data['open_enrollment'];
			}
			if(isset($data['self_enrollment'])) {
				$postFields['course[self_enrollment]'] = $data['self_enrollment'];
			}
			if(isset($data['restrict_enrollments_to_course_dates'])) {
				$postFields['course[restrict_enrollments_to_course_dates]'] = $data['restrict_enrollments_to_course_dates'];
			}
			// not sure if term_id, sis_course_id, integration_id need to be overridden
			if(isset($data['hide_final_grades'])) {
				$postFields['course[hide_final_grades]'] = $data['hide_final_grades'];
			}
			*/
			if(isset($data['apply_assignment_group_weights'])) {
				$postFields['course[apply_assignment_group_weights]'] = $data['apply_assignment_group_weights'];
			}
			if(isset($data['syllabus_body'])) {
				$postFields['course[syllabus_body]'] = $data['syllabus_body'];
			}
			if(isset($data['grading_standard_id'])) {
				$postFields['course[grading_standard_id]'] = $data['grading_standard_id'];
			}
			/*
			if(isset($data['course_format'])) {
				$postFields['course[course_format]'] = $data['course_format'];
			}
			*/
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXY, 'tcp://ots-rhel5-proxy-01.outreach.psu.edu');
            curl_setopt($ch, CURLOPT_PROXYPORT, '8080');
			
		
			$json_course_info = curl_exec($ch);
			$arr_course_info = json_decode($json_course_info, TRUE);

            if (FALSE === $json_course_info)
                throw new Exception(curl_error($ch), curl_errno($ch));
            else {
                return $arr_course_info;
                curl_close($ch);
            }
		
			// ...process $content now
		} catch(Exception $e) {
		
			trigger_error(sprintf(	
				'Curl failed with error #%d: %s',
				$e->getCode(), $e->getMessage()),
				E_USER_ERROR);
		
		}
	}
	
	private function get_course_settings($course_id) {
		try {
					
			$ch = curl_init();
		
			if (FALSE === $ch)
				throw new Exception('failed to initialize');
		
			curl_setopt($ch, CURLOPT_URL, 'https://psu.test.instructure.com/api/v1/courses/'.$course_id.'/settings?per_page=100');
			$headers = array(
			   "Content-Type: application/json",
			   "Authorization: Bearer ".$this->token
		   );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXY, 'tcp://ots-rhel5-proxy-01.outreach.psu.edu');
            curl_setopt($ch, CURLOPT_PROXYPORT, '8080');
			
		
			$json_course_setttings = curl_exec($ch);
			$arr_course_settings = json_decode($json_course_setttings, TRUE);
		
			if (FALSE === $json_course_setttings)
				throw new Exception(curl_error($ch), curl_errno($ch));
			else {
				//echo "<pre>";
				return $arr_course_settings;
				curl_close($ch);
			}
			
		
			// ...process $content now
		} catch(Exception $e) {
		
			trigger_error(sprintf(	
				'Curl failed with error #%d: %s',
				$e->getCode(), $e->getMessage()),
				E_USER_ERROR);
		
		}
	}
	
	private function update_course_settings($course_id, $data) {
		try {
					
			$ch = curl_init();
		
			if (FALSE === $ch)
				throw new Exception('failed to initialize');
		
			curl_setopt($ch, CURLOPT_URL, 'https://psu.test.instructure.com/api/v1/courses/'.$course_id.'/settings');
			$headers = array(
			   //"Content-Type: application/json",
			   "Authorization: Bearer ".$this->token
		   );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$postFields = array('id' => $course_id);
			
			if(isset($data['allow_student_discussion_topics'])) {
				$postFields['allow_student_discussion_topics'] = $data['allow_student_discussion_topics'];
			}
			if(isset($data['allow_student_forum_attachments'])) {
				$postFields['allow_student_forum_attachments'] = $data['allow_student_forum_attachments'];
			}
			if(isset($data['allow_student_discussion_editing'])) {
				$postFields['allow_student_discussion_editing'] = $data['allow_student_discussion_editing'];
			}
			if(isset($data['allow_student_organized_groups'])) {
				$postFields['allow_student_organized_groups'] = $data['allow_student_organized_groups'];
			}
			if(isset($data['hide_final_grades'])) {
				$postFields['hide_final_grades'] = $data['hide_final_grades'];
			}
			if(isset($data['hide_distribution_graphs'])) {
				$postFields['hide_distribution_graphs'] = $data['hide_distribution_graphs'];
			}
			if(isset($data['lock_all_announcements'])) {
				$postFields['lock_all_announcements'] = $data['lock_all_announcements'];
			}
			if(isset($data['restrict_student_past_view'])) {
				$postFields['restrict_student_past_view'] = $data['restrict_student_past_view'];
			}
			if(isset($data['restrict_student_future_view'])) {
				$postFields['restrict_student_future_view'] = $data['restrict_student_future_view'];
			}

			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXY, 'tcp://ots-rhel5-proxy-01.outreach.psu.edu');
            curl_setopt($ch, CURLOPT_PROXYPORT, '8080');
			
		
			$json_course_setttings = curl_exec($ch);
			$arr_course_settings = json_decode($json_course_setttings, TRUE);
		
			if (FALSE === $json_course_setttings)
				throw new Exception(curl_error($ch), curl_errno($ch));
			else {
				//echo "<pre>";
				return $arr_course_settings;
				curl_close($ch);
			}
		
			// ...process $content now
		} catch(Exception $e) {
		
			trigger_error(sprintf(	
				'Curl failed with error #%d: %s',
				$e->getCode(), $e->getMessage()),
				E_USER_ERROR);
		
		}
	}
	
	private function get_course_features($course_id) {
		try {
					
			$ch = curl_init();
		
			if (FALSE === $ch)
				throw new Exception('failed to initialize');
		
			curl_setopt($ch, CURLOPT_URL, 'https://psu.test.instructure.com/api/v1/courses/'.$course_id.'/features?per_page=100');
			$headers = array(
			   "Content-Type: application/json",
			   "Authorization: Bearer ".$this->token
		   );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXY, 'tcp://ots-rhel5-proxy-01.outreach.psu.edu');
            curl_setopt($ch, CURLOPT_PROXYPORT, '8080');
			
		
			$json_course_features = curl_exec($ch);
			$arr_course_features = json_decode($json_course_features, TRUE);
		
			if (FALSE === $json_course_features)
				throw new Exception(curl_error($ch), curl_errno($ch));
			else {
				//echo "<pre>";
				return $arr_course_features;
				curl_close($ch);
			}
			
		
			// ...process $content now
		} catch(Exception $e) {
		
			trigger_error(sprintf(	
				'Curl failed with error #%d: %s',
				$e->getCode(), $e->getMessage()),
				E_USER_ERROR);
		
		}
	}
	
	private function update_course_feature($course_id, $feature_flag, $feature_state) {
		try {
			$ch = curl_init();
		
			if (FALSE === $ch)
				throw new Exception('failed to initialize');
		
			curl_setopt($ch, CURLOPT_URL, 'https://psu.test.instructure.com/api/v1/courses/'.$course_id.'/features/flags/'.$feature_flag);
			$headers = array(
			   //"Content-Type: application/json",
			   "Authorization: Bearer ".$this->token
		   );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$postFields = array('course_id' => $course_id, 'feature' => $feature_flag, 'state' => $feature_state);
			
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXY, 'tcp://ots-rhel5-proxy-01.outreach.psu.edu');
            curl_setopt($ch, CURLOPT_PROXYPORT, '8080');
			
		
			$json_feature_info = curl_exec($ch);
		
			$arr_feature_info = json_decode($json_feature_info, TRUE);
		
			if (FALSE === $json_feature_info)
				throw new Exception(curl_error($ch), curl_errno($ch));
			else {
				//echo "<pre>";
				return $arr_feature_info;
				curl_close($ch);
			}
			
		
			// ...process $content now
		} catch(Exception $e) {
		
			trigger_error(sprintf(	
				'Curl failed with error #%d: %s',
				$e->getCode(), $e->getMessage()),
				E_USER_ERROR);
		
		}
	}
	
	public function process_migration_issues() {
		$processed_code = 'N';
		$failed_records = array();
		$db_first_migration_item = EVODB::GetOldestMigration($processed_code);
		$first_migration_group = isset($db_first_migration_item[0]->sequenceId) ? $db_first_migration_item[0]->sequenceId : NULL;
		if(!empty($first_migration_group)) {
			$db_migration_items = EVODB::GetMigrationBySequenceId($first_migration_group, $processed_code);
			foreach($db_migration_items as $db_migration_item) {
				$migration_issue_id = !empty($db_migration_item->migrationId) ? $db_migration_item->migrationId : NULL;
				$source_course_id = !empty($db_migration_item->canvasSourceCourseId) ? urlencode(utf8_encode($db_migration_item->canvasSourceCourseId)) : NULL;
				$target_course_id = !empty($db_migration_item->canvasTargetCourseId) ? urlencode(utf8_encode($db_migration_item->canvasTargetCourseId)) : NULL;
				if (empty($migration_issue_id) OR empty($source_course_id) OR empty($target_course_id)) {
					$failed_records[$migration_issue_id][] = "Encountered an empty migration issue or source course ID or target course ID";
				}
				else {
					$arr_migration_issue = $this->get_course_content_migration_issue($target_course_id, $migration_issue_id);
					if (isset($arr_migration_issue['errors'][0]['message'])) {
						$err_msg = !empty($arr_migration_issue['errors'][0]['message']) ? $arr_migration_issue['errors'][0]['message'] : NULL;
						//$failed_records[$migration_issue_id][] = "Could not read the details of the migration issue ".$migration_issue_id." : ".$err_msg;
						$failed_records[$migration_issue_id][] = "Looks like few parts of the course ".$source_course_id." already been copied to the course ".$target_course_id.", give a try again by resetting its content.";
						EVODB::UpdateMigrationQueue('P', $migration_issue_id);
					}
					else if (isset($arr_migration_issue['workflow_state'])) {
						if ($arr_migration_issue['workflow_state'] == 'completed') {
							$result = $this->copy_course_objects($source_course_id, $target_course_id);
							if (count($result['failed_records']) > 0) {
								$failed_records[$migration_issue_id] = array_merge($result['failed_records'], $failed_records[$migration_issue_id]);
							}
							EVODB::UpdateMigrationQueue('Y', $migration_issue_id);
						}
						else {
							EVODB::UpdateMigrationQueue('E', $migration_issue_id);
						}
					}
				}
			}
		}
        $failed_records = array_reduce($failed_records, 'array_merge', array());
		return $failed_records;
	}
	
	private function copy_course_objects($source_course_id, $target_course_id) {
		$result = array('failed_records' => array());
		$arr_source_course_info = $this->get_course($source_course_id);
		if (isset($arr_source_course_info['errors'][0]['message'])) {
			$err_msg = !empty($arr_source_course_info['errors'][0]['message']) ? $arr_source_course_info['errors'][0]['message'] : NULL;
			$result['failed_records'][] = "Could not read the details of the course ".$source_course_id." : ".$err_msg;
		}
		else if (!empty($arr_source_course_info['id'])) {
			$arr_target_course_info = $this->update_course($target_course_id, $arr_source_course_info);
			if (isset($arr_target_course_info['errors'][0]['message'])) {
				$err_msg = !empty($arr_target_course_info['errors'][0]['message']) ? $arr_target_course_info['errors'][0]['message'] : NULL;
				$result['failed_records'][] = "Could not update the course ".$target_course_id." : ".$err_msg;
			}
			$copied_course_groups = $this->copy_course_groups($source_course_id, $target_course_id);
			if (count($copied_course_groups['failed_records']) > 0) {
				$result['failed_records'] = array_merge($copied_course_groups['failed_records'], $result['failed_records']);
			}
			
			$copied_course_settings = $this->copy_course_settings($source_course_id, $target_course_id);
			if (count($copied_course_settings['failed_records']) > 0) {
				$result['failed_records'] = array_merge($copied_course_settings['failed_records'], $result['failed_records']);
			}
			$coiped_course_features = $this->copy_course_features($source_course_id, $target_course_id);
			if (count($coiped_course_features['failed_records']) > 0) {
				$result['failed_records'] = array_merge($coiped_course_features['failed_records'], $result['failed_records']);
			}
			
		}
		return $result;
	}
	
	private function copy_course_group_categories($source_course_id, $target_course_id) {
		$result = array(
						'source_group_categories' => array(
														   'existing' => array()
														   ),
						'target_group_categories' => array(
														   'existing' => array(),
														   'new' => array()
														   ),
						'mappings' => array(),
						'failed_records' => array()
						);
		$arr_source_group_categories = $this->get_course_group_categories($source_course_id);
		if (isset($arr_source_group_categories['errors'][0]['message'])) {
			$err_msg = !empty($arr_source_group_categories['errors'][0]['message']) ? $arr_source_group_categories['errors'][0]['message'] : NULL;
			$result['failed_records'][] = "Could not read the group categories of the course ".$source_course_id." : ".$err_msg;
		}
		else if (count($arr_source_group_categories) > 0) {
			$result['source_group_categories']['existing'] = $arr_source_group_categories;
			$arr_target_group_category_names = array();
			$arr_target_group_categories = $this->get_course_group_categories($target_course_id);
			if (isset($arr_target_group_categories['errors'][0]['message'])) {
				$err_msg = !empty($arr_target_group_categories['errors'][0]['message']) ? $arr_target_group_categories['errors'][0]['message'] : NULL;
				$result['failed_records'][] = "Could not read the group categories of the course ".$target_course_id." : ".$err_msg;
			}
			else if (count($arr_target_group_categories) > 0) {
				$result['target_group_categories']['existing'] = $arr_target_group_categories;
				foreach($arr_target_group_categories as $arr_target_group_category) {
					if (isset($arr_target_group_category['name']))
					$arr_target_group_category_names[$arr_target_group_category['id']] = $arr_target_group_category['name'];
				}
			}
			foreach($arr_source_group_categories as $arr_source_group_category) {
				if (isset($arr_source_group_category['name'])) {
					$target_group_category_names_key = array_search($arr_source_group_category['name'], $arr_target_group_category_names);
					if (FALSE !== $target_group_category_names_key) {
						$result['mappings'][$arr_source_group_category['id']] = $target_group_category_names_key;
					}
					else {
						$arr_target_group_category = $this->create_course_group_category($target_course_id, $arr_source_group_category);
						if (isset($arr_target_group_category['errors'][0]['message'])) {
							$err_msg = !empty($arr_target_group_category['errors'][0]['message']) ? $arr_target_group_category['errors'][0]['message'] : NULL;
							$result['failed_records'][] = "Could not create the group category ".$arr_source_group_category['name']." under the course ".$target_course_id." : ".$err_msg;
						}
						else if (isset($arr_target_group_category['id'])) {
							$result['target_group_categories']['new'][] = $arr_target_group_category;
							$result['mappings'][$arr_source_group_category['id']] = $arr_target_group_category['id'];
						}
					}
				}
			}
			
		}
		return $result;
	}
	
	private function copy_course_groups($source_course_id, $target_course_id) {
		$result = array(
						'source_groups' => array(
														   'existing' => array()
														   ),
						'target_groups' => array(
														   'existing' => array(),
														   'new' => array()
														   ),
						'mappings' => array(),
						'failed_records' => array()
						);
		$copied_course_group_categories = $this->copy_course_group_categories($source_course_id, $target_course_id);
		if(count($copied_course_group_categories['source_group_categories']['existing']) > 0) {
			$group_category_mappings = $copied_course_group_categories['mappings'];
            if (count($group_category_mappings) > 0) {
                $arr_source_groups = $this->get_course_groups($source_course_id);
                if (isset($arr_source_groups['errors'][0]['message'])) {
                    $err_msg = !empty($arr_source_groups['errors'][0]['message']) ? $arr_source_groups['errors'][0]['message'] : NULL;
                    $result['failed_records'][] = "Could not read the groups of the course ".$source_course_id." : ".$err_msg;
                }
                else if(count($arr_source_groups) > 0) {
                    $result['source_groups']['existing'] = $arr_source_groups;
                    $arr_target_group_names = array();
                    $arr_target_groups = $this->get_course_groups($target_course_id);
                    if (isset($arr_target_groups['errors'][0]['message'])) {
                        $err_msg = !empty($arr_target_groups['errors'][0]['message']) ? $arr_target_groups['errors'][0]['message'] : NULL;
                        $result['failed_records'][] = "Could not read the groups of the course ".$target_course_id." : ".$err_msg;
                    }
                    else if (count($arr_target_groups) > 0) {
                        $result['target_groups']['existing'] = $arr_target_groups;
                        foreach($arr_target_groups as $arr_target_group) {
                            if (isset($arr_target_group['name']))
                            $arr_target_group_names[$arr_target_group['group_category_id']][] = $arr_target_group['name'];
                        }
                    }

                    foreach($arr_source_groups as $arr_source_group) {
                        if (isset($arr_source_group['name'])) {
                            if (!isset($group_category_mappings[$arr_source_group['group_category_id']]) OR (isset($arr_target_group_names[$group_category_mappings[$arr_source_group['group_category_id']]]) && in_array($arr_source_group['name'], $arr_target_group_names[$group_category_mappings[$arr_source_group['group_category_id']]])))
                            continue;
                            $arr_target_group = $this->create_group($group_category_mappings[$arr_source_group['group_category_id']], $arr_source_group);
                            if (isset($arr_target_group['errors'][0]['message'])) {
                                $err_msg = !empty($arr_target_group['errors'][0]['message']) ? $arr_target_group['errors'][0]['message'] : NULL;
                                $result['failed_records'][] = "Could not create the group ".$arr_source_group['name']." under the course ".$target_course_id." : ".$err_msg;
                            }
                            else if (isset($arr_target_group['id'])) {
                                $result['target_groups']['new'][] = $arr_target_group;
                                $result['mappings'][$arr_source_group['id']] = $arr_target_group['id'];
                            }
                        }
                    }
                }
            }
		}
		if (count($copied_course_group_categories['failed_records']) > 0) {
			$result['failed_records'] = array_merge($copied_course_group_categories['failed_records'], $result['failed_records']);
		}
		return $result;
	}
	
	private function copy_course_settings($source_course_id, $target_course_id) {
		$result = array('failed_records' => array());
		$arr_source_course_settings = $this->get_course_settings($source_course_id);
		if (isset($arr_source_course_settings['errors'][0]['message'])) {
			$err_msg = !empty($arr_source_course_settings['errors'][0]['message']) ? $arr_source_course_settings['errors'][0]['message'] : NULL;
			$result['failed_records'][] = "Could not read the settings of the course ".$source_course_id." : ".$err_msg;
		}
		else if (count($arr_source_course_settings) > 0) {
			$arr_target_course_settings = $this->update_course_settings($target_course_id, $arr_source_course_settings);
			if (isset($arr_target_course_settings['errors'][0]['message'])) {
				$err_msg = !empty($arr_target_course_settings['errors'][0]['message']) ? $arr_target_course_settings['errors'][0]['message'] : NULL;
				$result['failed_records'][] = "Could not update the settings of the course ".$target_course_id." : ".$err_msg;
			}
		}
		return $result;
	}
	
	private function copy_course_features($source_course_id, $target_course_id) {
		$result = array('failed_records' => array());
		$arr_source_course_features = $this->get_course_features($source_course_id);
		if (isset($arr_source_course_features['errors'][0]['message'])) {
			$err_msg = !empty($arr_source_course_features['errors'][0]['message']) ? $arr_source_course_features['errors'][0]['message'] : NULL;
			$result['failed_records'][] = "Could not read the feature flags of the course ".$source_course_id." : ".$err_msg;
		}
		else if (count($arr_source_course_features) > 0) {
			$arr_target_course_feature_states = array();
			$arr_target_course_features = $this->get_course_features($target_course_id);
			if (isset($arr_target_course_features['errors'][0]['message'])) {
				$err_msg = !empty($arr_target_course_features['errors'][0]['message']) ? $arr_target_course_features['errors'][0]['message'] : NULL;
				$result['failed_records'][] = "Could not read the feature flags of the course ".$target_course_id." : ".$err_msg;
			}
			else if (count($arr_target_course_features) > 0) {
				foreach($arr_target_course_features as $course_feature) {
					if (!isset($course_feature['feature_flag']['feature']))
					continue;
					$arr_target_course_feature_states[$course_feature['feature_flag']['feature']] = $course_feature['feature_flag']['state'];
				}
			}
			foreach($arr_source_course_features as $course_feature) {
				if (!isset($course_feature['feature_flag']['feature']))
				continue;
				if (array_key_exists($course_feature['feature_flag']['feature'], $arr_target_course_feature_states) && $course_feature['feature_flag']['state'] !== $arr_target_course_feature_states[$course_feature['feature_flag']['feature']]) {
					$arr_target_course_feature = $this->update_course_feature($target_course_id, $course_feature['feature_flag']['feature'], $course_feature['feature_flag']['state']);
					if (isset($arr_target_course_feature['errors'][0]['message'])) {
						$err_msg = !empty($arr_target_course_feature['errors'][0]['message']) ? $arr_target_course_feature['errors'][0]['message'] : NULL;
						$result['failed_records'][] = "Could not update the feature flag ".$course_feature['feature_flag']['feature']." of the course ".$target_course_id." : ".$err_msg;
					}
				}
			}
		}
		return $result;
	}
}