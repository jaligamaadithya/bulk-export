<?php
error_reporting(-1);
ini_set("display_errors", 1);

include_once('../../soapwrapper.php');
include_once('../../lib/blti.php');
include_once('../../../../database/evolutiondb.inc');

$client = getClient();
$client->setCredentials("test","test");

$one2Many = new one2Many;

$action = isset($_POST['action']) ? $_POST['action'] : null;
switch ($action){
	case 'copy':
		$output = array('err' => array(), 'success' => array());
		$source_course_sis_id = isset($_POST['source_course_sis_id']) ? $_POST['source_course_sis_id'] : NULL;
		$user_sis_id = isset($_POST['user_sis_id']) ? $_POST['user_sis_id'] : NULL;
		$p_target_courses = isset($_POST['target_courses']) ? $_POST['target_courses'] : array();
		if (empty($source_course_sis_id)) {
			$output['err'][] = "Encountered an empty source course ID";
		}
		else if (empty($user_sis_id)) {
			$output['err'][] = "Encountered an empty user ID";
		}
		else if (count($p_target_courses) <= 0) {
			$output['err'][] = "Please select a target course";
		}
		else {
			parse_str(rawurldecode($p_target_courses)); 
			$source_course_id = 'sis_course_id:'.urlencode(utf8_encode($source_course_sis_id));
			
			//$file_content = "";
			$db_queue_group = EVODB::GetNextMigrationSequence();
			if (isset($db_queue_group[0]->SequenceId)) {
				foreach($target_courses as $target_course_sis_id => $value) {
					$target_course_id = 'sis_course_id:'.urlencode(utf8_encode($target_course_sis_id));
					if ($_POST['reset_course']) {
						$arr_target_course_info = $one2Many->reset_course_content($target_course_id);
						if (isset($arr_target_course_info['errors'][0]['message'])) {
							$err_msg = !empty($arr_target_course_info['errors'][0]['message']) ? $arr_target_course_info['errors'][0]['message'] : NULL;
							$output['err'][] = "Could not reset the course ".$target_course_id." : ".$err_msg;
							continue;
						}
						else if (isset($arr_target_course_info['sis_course_id'])){
							$target_course_id = 'sis_course_id:'.urlencode(utf8_encode($arr_target_course_info['sis_course_id']));
						}
					}
					$arr_migration_issue_info = $one2Many->create_course_content_migration_issue($source_course_id, $target_course_id);
					if (isset($arr_migration_issue_info['errors'][0]['message'])) {
						$err_msg = !empty($arr_migration_issue_info['errors'][0]['message']) ? $arr_migration_issue_info['errors'][0]['message'] : NULL;
						$output['err'][] = "Could not initiate a migration issue for the course ".$target_course_id." : ".$err_msg;
					}
					else if (isset($arr_migration_issue_info['id'])) {
						//$file_content .= $arr_migration_issue_info['id'].'###'.$source_course_id.'###'.$target_course_id."\n";
						//$output['success'][] = $file_content;
						EVODB::AddToMigrationQueue($arr_migration_issue_info['id'], $db_queue_group[0]->SequenceId, $source_course_id, $target_course_id, FALSE, $user_sis_id);
						
					}
				}
			}
			/*
			if (!empty($file_content)) {
				$handle = fopen("raj.txt", "a");
				if(!$handle) {
					echo 'cant open';
				}
				fwrite($handle, $file_content);
				fclose($handle);
			}
			*/
		}
		print json_encode($output);
		break;
	default:	
		
		$context= new BLTI("secret", true, false);
		
		//LTI info
		$source_course_sis_id=$context->info['lis_course_offering_sourcedid'];
		$user_sis_id = $context->info['custom_canvas_user_login_id'];
		$user_id = urlencode(utf8_encode('sis_user_id:'.$user_sis_id));
		$source_course_id = 'sis_course_id:'.urlencode(utf8_encode($source_course_sis_id));
		
		/*
		$source_course_sis_id='MS-85746-20160404151151';
		$user_sis_id = 'rus353@psu.edu';
		$user_id = urlencode(utf8_encode('sis_user_id:'.$user_sis_id));
		$source_course_id = 'sis_course_id:'.urlencode(utf8_encode($source_course_sis_id));
		*/
		$courses_list = $one2Many->build_courses_table($user_id, array($source_course_sis_id));
		
		//Variables for Javascript
$add_headers =<<<HEADERS
<script>
		var source_course_sis_id = "{$source_course_sis_id}";
		var user_sis_id = "{$user_sis_id}";
</script>
HEADERS;
		print render_template('one2many.tpl', array('<!-- $add_headers -->' => $add_headers, '<!-- $canvas_courses -->' => $courses_list));
		
}

class one2Many
{
    private $token = 'kbfjC3zbKjmQ2fXXmA2mdQILgqqgFyZ5gD5DH7ndU3BOvK77xHEUDRUKFQxqqy5f';
    
    /**
    * 
    * Creates a content migration issue in Canvas
    *
    * @param string $source_course_id Source course ID in Canvas that should be copied
    * @param string $target_course_id Target course ID in Canvas that the source course to be copied into
    * @return array
    */
	public function create_course_content_migration_issue($source_course_id, $target_course_id) {
		global $client;
		$json_migration_issue_info = $client->call('createContentMigration', array('mastercourseid'=> $source_course_id, 'targetcourse' => $target_course_id));
		$arr_migration_issue_info = json_decode($json_migration_issue_info, true);
		return $arr_migration_issue_info;
		
	}
    
    private function get_active_user_courses($user_id){
        try {
			//echo $user_login_id;		
            $ch = curl_init();

            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            curl_setopt($ch, CURLOPT_URL, 'https://psu.test.instructure.com/api/v1/users/'.$user_id.'/courses?include[]=term&per_page=100');
            $headers = array(
               "Content-Type: application/json",
               "Authorization: Bearer ".$this->token
           );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXY, 'tcp://ots-rhel5-proxy-01.outreach.psu.edu');
            curl_setopt($ch, CURLOPT_PROXYPORT, '8080');


            $json_user_enrollments = curl_exec($ch);
		
            $arr_user_enrollments = json_decode($json_user_enrollments, TRUE);

            if (FALSE === $json_user_enrollments)
                throw new Exception(curl_error($ch), curl_errno($ch));
            else {
                //echo "<pre>";
                return $arr_user_enrollments;
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
    
    //  Builds HTML table for target courses
    public function build_courses_table($user_id, $courses_to_exclude = array()){
        $output = NULL;
        $user_courses = $this->get_active_user_courses($user_id);
        if (isset($user_courses['errors'][0]['message']) OR count($user_courses) <= 0) {
			//$err_msg = !empty($user_courses['errors'][0]['message']) ? $user_courses['errors'][0]['message'] : NULL;
			$output .= "No courses available";
		}
		else {
            $output .= '<form method="POST" id="form_one2many">';
			$output .= '<table id="coursetable" class="table table-hover">';
            $output .= '<thead><tr><th></th><th>Course Name</th><th>Course Code</th><th>Term</th></tr></thead>';
			$output .= '<tbody>';
            foreach( $user_courses as $user_course ) {
                if (!isset($user_course['enrollments']) OR !isset($user_course['sis_course_id']) OR in_array($user_course['sis_course_id'], $courses_to_exclude))
                continue;
                foreach($user_course['enrollments'] as $user_enrollment) {
                    //echo "<pre>";
                    //print_r($user_enrollment);
                    if ($user_enrollment['type'] == 'teacher') {
                        $output .= "<tr>";
						$output .= "<td><input type='checkbox' name='target_courses[".$user_course['sis_course_id']."]'  class='target_courses' value='1'/></td>";
						$output .= "<td>".$user_course['name']."</td><td>".$user_course['course_code']."</td>";
						$output .= "<td>".$user_course['term']['name']."</td>";
						$output .= "</tr>\n";
                        break;
                    }
                }
                
            }
            $output .= '</tbody>';
            $output .= '</table>';
            $output .= '<p><input type="checkbox" name="reset_course" id="reset_course" value="1" />Reset course(s) before copying</p><input type="submit" name="submit" value="Submit">';
			$output .= '</form>';
        }
     
       return $output;
    }
	
	public function reset_course_content($course_id) {
		try {
			$ch = curl_init();
		
			if (FALSE === $ch)
				throw new Exception('failed to initialize');
		
			curl_setopt($ch, CURLOPT_URL, 'https://psu.test.instructure.com/api/v1/courses/'.$course_id.'/reset_content');
			$headers = array(
			   //"Content-Type: application/json",
			   "Authorization: Bearer ".$this->token
		   );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$postFields = array('course_id' => $course_id);
			
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
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
	
}

function render_template($file_name, $replacements = array()) {
	$template_content = file_get_contents($file_name);
	$template_content = str_replace(array_keys($replacements), $replacements, $template_content);
	return $template_content;
}
