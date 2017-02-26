<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Homelist extends MY_Controller {

        
	    public function __construct(){
    		 parent::__construct();
              error_reporting(0);
              $this->load->model('homelist');
              $this->load->helper(array('form', 'url'));
              $this->load->library('form_validation');
    		
     
        }

        public function index()
        {
             
             $this->site_data['main_content']= 'pages/homelist';
             $this->site_data['title']= 'Testing';
             $this->load->view($this->site_data['layout'], $this->site_data);
            
                
        }
                public function create_meeting()
{
   
   

   

    //$this->form_validation->set_rules('title', 'Title', 'required');
   // $this->form_validation->set_rules('text', 'Text', 'required');

   /* if ($this->form_validation->run() === FALSE)
    {
        $this->load->view('templates/header', $data);
        $this->load->view('news/create');
        $this->load->view('templates/footer');

    }
    else*/
    //{
      $data = array(
                  'mdate'=>$this->input->post('mdate'),
                  'subject'=>$this->input->post('subject'),
                  'department'=>$this->input->post('department'),
                  'user'=>$this->input->post('user'),
                  'subject'=>$this->input->post('subject'),
                  'agenda'=>$this->input->post('agenda'),
                  'timeslotfrom'=>$this->input->post('timeslotfrom'),
                  'timeslotto'=>$this->input->post('timeslotto'),
        
    );
                  return $this->db->insert('meeting_transac', $data);
  
}
}