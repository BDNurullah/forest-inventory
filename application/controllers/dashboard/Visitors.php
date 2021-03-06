<?php

    /**
     
     * @package Admin Panel
     * @author     Reazul Islam <reazul@atilimited.net>
     * @copyright  2017 ATI Limited Development Group
     
    */

    if (!defined('BASEPATH')) {
        exit('No direct script access allowed');


     /**
     * Website Class
     *
     * Parses URIs and determines routing
     *
     * @package     Admin Panel
     * @subpackage  Admin Panel
     * @category    Admin Panel
     * @author      Reazul Islam <reazul@atilimited.net>
     *
     */

 }

 class Visitors extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->user_session = $this->session->userdata('user_logged_in');
        if (!$this->user_session) {
            redirect('dashboard/auth/index');
        }
        $this->load->library("form_validation");
        $this->load->model('utilities');
        $this->load->model('Forestdata_model');
        $this->load->model('Menu_model');
        $this->load->library('upload');
        $this->load->library('Csvimport');
        $this->load->helper(array('html', 

            'form'));
        $this->load->model('setup_model');
    }

    /**
      * Show all pages in datatable
      
      
     */


    public function visitorList() {

        $data["breadcrumbs"] = array(
            "Page" => "dashboard/Visitors/visitorList",
            );
        $data['pageTitle'] = "All Visitor List ";
        $sql = "SELECT v.*, e.EDUCATION_DEGREE_NAME,i.INSTITUTE_NAME,i.INSTITUTE_ADDRESS,i.PHONE,i.FAX  FROM visitor_info v
        left JOIN education e ON v.EDUCATION_ID = e.EDUCATION_ID
        left JOIN institution i ON v.USER_ID = i.USER_ID  ORDER BY  v.USER_ID DESC
        ;";
        $data['all_visitors'] = $this->db->query($sql)->result();
            //echo"<pre>";print_r( $data['all_visitors']);exit;
        $data['content_view_page'] = 'setup/visitorList/all_visitor';
        $this->template->display($data);
    }

      public function purposeList()
    {
        $data['purpose']           = $this->db->query("SELECT * FROM purpose")->result();
        $data['content_view_page'] = 'setup/purposeList/all_purpose';
        $this->template->display($data);
    }


     public function commentList()
    {
        $data['comment']           = $this->db->query("SELECT a.id,a.title,(SELECT COUNT(*) FROM community_comment c where c.community_id=a.id ) TOTAL_COMMENT FROM community a
            order by a.id DESC")->result();
        $data['content_view_page'] = 'setup/commentList/all_comment';
        $this->template->display($data);
    }


       public function commentDetails($id)
    {
        $data['comment']           = $this->db->query("SELECT c.*,cm.title,cm.post_date,cm.description,v.FIRST_NAME,v.LAST_NAME,v.USER_ID FROM community_comment c 
            left join visitor_info v on v.USER_ID=c.user_id 
            left join community cm on cm.id=c.community_id
            where c.community_id=$id order by c.id DESC")->row();
         $data['coummunity_id'] = $id;
        $data['comment_details'] = $this->Forestdata_model->get_comment_details($id);
        $data['content_view_page'] = 'setup/commentList/all_comment_details';
        $this->template->display($data);
    }


      public function addReplyByAdmin()
  {


    if (isset($_POST['comment'])) {
      $comment    = $this->input->post('comment');
          //$id = $this->input->post('user_id');
      $session = $this->user_session = $this->session->userdata('user_logged_in');
      $userid =  $session["USER_ID"];
      $data = array(
        'comment' => $comment,
        'community_id' => $this->input->post('COMMINITY_ID'),
        'date' => date('Y-m-d H:i:s', time()),
        'user_id' =>$userid


      );

          //$data['IMAGE_PATH'] = 'asdasdsad';

      $this->utilities->insertData($data, 'community_comment');
      $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Comment Posted successfully.<button data-dismiss="alert" class="close" type="button">×</button></div>');
      redirect('dashboard/visitors/commentDetails/'.$this->input->post('COMMINITY_ID'));
    }

    else {
      $data['content_view_page'] = 'setup/commentList/all_comment_details';
      $this->template->display_portal($data);
    }
  }

        public function deleteComment($id)
    {
        
        $attr = array(
            "id" => $id
        );
        //return $this->utilities->deleteRowByAttribute("family", $attr);
        if ($this->utilities->deleteRowByAttribute("community", $attr)) {
            $this->session->set_flashdata('Error', ' Comment Deleted Successfully.');
        } else {
            $this->session->set_flashdata('Error', 'Comment Not Deleted Successfully.');
        }
        
    }



         public function deleteCommentDetails($id)
    {
        
        $attr = array(
            "id" => $id
        );
        //return $this->utilities->deleteRowByAttribute("family", $attr);
        if ($this->utilities->deleteRowByAttribute("community_comment", $attr)) {
            $this->session->set_flashdata('Error', ' Comment Deleted Successfully.');
        } else {
            $this->session->set_flashdata('Error', 'Comment Not Deleted Successfully.');
        }

        
    }
    
    


        public function addPurpose()
    {
        if (isset($_POST['PURPOSE_NAME'])) {
            
            //$titles = count($this->input->post('title'));
            $PURPOSE_NAME    = $this->input->post('PURPOSE_NAME');
           
            $data = array(
                'PURPOSE_NAME' => $PURPOSE_NAME
               
            );
            
            //$data['IMAGE_PATH'] = 'asdasdsad';
            
            $this->utilities->insertData($data, 'purpose');
            $this->session->set_flashdata('Success', 'New Purpose Added Successfully.');
            redirect('dashboard/Visitors/purposeList');
        }
        
        else {
            $data['content_view_page'] = 'setup/purposeList/addPurpose';
            $this->template->display($data);
        }
    }

      public function deletePurpose($id)
    {
        
        $attr = array(
            "PURPOSE_ID" => $id
        );
        //return $this->utilities->deleteRowByAttribute("family", $attr);
        if ($this->utilities->deleteRowByAttribute("purpose", $attr)) {
            $this->session->set_flashdata('Error', ' Purpose Deleted Successfully.');
        } else {
            $this->session->set_flashdata('Error', 'Purpose Not Deleted Successfully.');
        }
        
    }
    


    function visitor_detail($USER_ID) {
        $data['visitor_info'] = $this->db->query("SELECT v.*, e.EDUCATION_DEGREE_NAME,i.INSTITUTE_NAME,i.INSTITUTE_ADDRESS,i.PHONE,i.FAX,z.zones  FROM visitor_info v
         left JOIN education e ON v.EDUCATION_ID = e.EDUCATION_ID
         left JOIN institution i ON v.USER_ID = i.USER_ID
        left JOIN zones z ON v.ID_Zones = z.ID_Zones 
         WHERE v.USER_ID= $USER_ID ORDER BY i.USER_ID")->row();
        //echo "<pre>";print_r($data['visitor_info']);exit;
        $this->load->view('setup/visitorList/visitor_details', $data);

    }


    /**
     * Edit ACTIVE_FLAG 
     */

    public function update_visitor() {
        $USER_ID = $this->input->post('USER_ID');
        $FIRST_NAME = $this->input->post('FIRST_NAME');
        $LAST_NAME = $this->input->post('LAST_NAME');
        $USER_MAIL = $this->input->post('USER_MAIL');
        $message = "Dear<br>$FIRST_NAME $LAST_NAME,<br>Congratulation! You have been Successfully registered.  <br> To activate the account please click the following link<br>" . base_url("index.php/Accounts/userActivition/$USER_ID") . " <br>Your login details.<br />Email:<b> " . $USER_MAIL . '</b><br>Thanks <br> FAO';

        $subject = "FAO Applicant Login Info";

             //echo $message;exit;
        require 'gmail_app/class.phpmailer.php';
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = "mail.harnest.com";
        $mail->Port = "465";
        $mail->SMTPAuth = true;
        $mail->Username = "dev@atilimited.net";
        $mail->Password = "@ti321$#";
        $mail->SMTPSecure = 'ssl';
        $mail->From = "support@harnest.com";
        $mail->FromName = "FAO";
        $mail->AddAddress($USER_MAIL);
             //$mail->AddReplyTo($emp_info->EMPLOYEE);
        $mail->IsHTML(TRUE);
        $mail->Subject = $subject;
        $mail->Body = $message;
        if ($mail->Send()){
            echo "Success";
        }
        else {
            echo "Faild";
        }
        $activeStatus = array(
            'ACTIVE_FLAG' => isset($_POST['ACTIVE_FLAG']) ? 2 : 0,
            );
        if ($this->utilities->updateData('visitor_info', $activeStatus, array('USER_ID' => $USER_ID))) {
            $this->session->set_flashdata('Success', 'Mail send successfully.');
            redirect('dashboard/Visitors/visitorList');
        }
        else{
                $this->session->set_flashdata('Error', 'Mail send failed!.');
            }
    }
   public function generatePassword() {

        $random_code = $this->uri->segment(3, '');
        if ($random_code == '') {
            $this->session->set_flashdata('Error', 'Sorry ! You are Trying Invalid Way to Reset Password.');
            redirect('auth/index', 'refresh');
        }
        $data['requestinfo'] = $this->utilities->findByAttribute('sa_forget_pass_request', array('REQUESTED_CODE' => $random_code));
        if (empty($data['requestinfo'])) {
            $this->session->set_flashdata('Error', 'Sorry ! You are Trying Invalid Way to Reset Password.');
            redirect('auth/index', 'refresh');
        } else {
            if ($data['requestinfo']->IS_USED != 0) {

                $data['content_view_page'] = 'auth/errorMessage';
                $this->template_auth->display($data);
            } else {

                $data['content_view_page'] = 'auth/generateNewPasswordPage';
                $this->template_auth->display($data);
            }
        }
    }



    public function deleteVisitor($id)
    {

        $attr = array(
            "USER_ID" => $id
            );
        return $this->utilities->deleteRowByAttribute("visitor_info", $attr);


    }
    
}
