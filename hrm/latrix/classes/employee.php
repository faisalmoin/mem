<?php

require_once("classes/dbobject.php");
require_once("Mail.php");
require_once("Image/Graph.php");

class Employee extends DBObject{

	var $mailer;

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Employee";
		$this->idcol = "emp_id";
		$this->tablename = "employees ";
		$this->sql_fields = 'SELECT e.emp_id, e.payroll, e.fname, e.sname, e.max_leave, e.location_id,'; 
		$this->sql_fields .= 'e.visitor, e.monitored, e.team_id, e.title_id, e.username, e.email,';
		$this->sql_fields .= "AES_DECRYPT(e.password,'".la_aes_key."') as password, e.leave_left, ";
		$this->sql_fields .= 'e.keycode, e.home_phone, e.work_phone, e.mobile_phone, l.name as location, d.name as deptname, e.enabled, e.user_level_id';
		$this->sql_from = ' FROM employees e INNER JOIN locations l USING (location_id) INNER JOIN teams t USING (team_id)';
		$this->sql_from .= ' INNER JOIN departments d USING (dept_id)';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT e.emp_id ';
		$this->subject_id = 3;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 3 AND editable = 1 ORDER BY sequence");
	}
	
	private function getSQLCondition() {
	
		// the number of records available for navigation depends on the user level. The employee himself can only see one record (his own).
		// the manager can see everyone in the department
		// the admin and everybody else can see everyone in the company.
		switch ($this->page->config['user_level']) {
			case lu_employee:
				$sql = ' WHERE e.emp_id = '.$this->page->ctrl['record'];
				break;
			case lu_manager:
				$sql = ' WHERE d.manager_id = '.$this->page->ctrl['record'];
				break;
			case lu_admin:
			case lu_gm:
			case lu_owner:
				$sql = ' WHERE e.company_id = '.$this->page->company['company_id'];
		}
		return $sql;
	}

	private function checkkeycode($value, $emp_id) {
		$sql = "SELECT count( DISTINCT emp_id) as cnt FROM employees where keycode='".$value."' AND company_id=".$this->page->company['company_id'];
		if ($this->data[0]['emp_id'] > 0) {
			$sql .= " AND emp_id <> ".$this->data[0]['emp_id'];
		}
		$count = $this->dbc->query($sql);
		if ($count[0]['cnt'] > 0) { return false; }
		return true;	
	}
	
	public function checkData() {
	
		// need to parse all the POST data through various checkers using the data_columns. String length is not a problem, though.
		// e.g. numbers must only have digits, e-mail addresses must have a "@" and a ".".
		$test = $this->control->checkPOST($this);
		if (!$this->control->checkemail($this->data[0]['email'],$this->page->ctrl['record'])){
			$this->control->errflags['email'] = true;
			$this->error->add('The email address is not valid.');
			$test = false;
		}
		if ($this->data[0]['max_leave'] < 0) { 
			$this->control->errflags['max_leave'] = true;
			$this->error->add('The leave allowance cannot be negative.');
			$test = false;
			}
		// plus special checks for fields with limitations, e.g. the keycode must be unique within the company.
		if (!$this->checkkeycode($this->data[0]['keycode'],$this->page->ctrl['record'])) {
			$this->control->errflags['keycode'] = true;
			$this->error->add('The key code must be unique. Please choose another.');
			$test = false;
		}
		return $test;
	}

	public function resetPassword() {
		$pattern = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$password = $pattern{rand(0,25)};
	   $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
   	for($i=0;$i<8;$i++) {
			$password .= $pattern{rand(0,35)};
   	}
		$sql = "UPDATE employees SET password = md5('".$password."') WHERE emp_id=".$this->data[0]['emp_id'];
		$this->dbc->exec($sql);
		// now e-mail this to the employee.
		if ($this->data[0]['email'] != '') {
			$this->mailer =& MAIL::factory("smtp");
			$headers['From'] = 'admin@latrax.co.uk';
			$headers['To'] = $this->data[0]['email'];
	//		$headers['To'] = 'wolfgangs@manticoreit.com';
			$headers['Subject'] = 'New Password for your LATRIX login';
			$recipients = $this->data[0]['email'];
	//		$recipients = 'wolfgangs@manticoreit.com';
			$body = file_get_contents('include/templates/newpassword.email',true);
			$body = str_replace('%firstname%', $this->data[0]['fname'], $body);
			$body = str_replace('%username%', $this->data[0]['username'], $body);
			$body = str_replace('%password%', $password,$body);
			if($err = $this->mailer->send($recipients, $headers, $body) != true) {
				$this->error->add($err->toString());
			}
		}
	}
	
	public function add() {
		parent::add();
		$this->data[0]['emp_id'] = $this->page->ctrl['record'];
		$this->sendMessages('added');
	}
	
	public function save() {
		$sql = "SELECT enabled FROM employees WHERE emp_id = ".$this->data[0]['emp_id'];
		$saved = $this->dbc->query($sql);
		if ($saved[0]['enabled'] != $this->data[0]['enabled'] && $this->data[0]['enabled'] == 0) {
			parent::save();
			$this->sendMessages('disabled');
		} else {
			parent::save();
		}
	}
	
	private function sendMessages($msg_type) {
		// if messaging is disabled then exit
		if ($this->page->company['send_email'] == false) {
			return;
		}
		// retrieve the email address, full name and manager name and manger email address 
		// of the employee from $this->data[0]['emp_id']
		$sql = "SELECT e.email, concat(e.fname, ' ', e.sname) AS fullname, mgr.email AS mgr_email, ";
		$sql .= "concat(mgr.fname, ' ', mgr.sname) AS mgr_fullname  FROM employees e ";
		$sql .= "INNER JOIN teams t ON e.team_id = t.team_id ";
		$sql .= "INNER JOIN departments d ON t.dept_id = d.dept_id ";
		$sql .= "INNER JOIN employees mgr ON d.manager_id = mgr.emp_id WHERE e.emp_id=".$this->data[0]['emp_id'];
		$maildata = $this->dbc->query($sql);
		$this->getMailParams();
		$params = array($maildata[0]['fullname'], "", "", "", "", $this->data[0]['username'], $this->data[0]['password'], date('d/m/Y'), 
							 $maildata[0]['fullname'], "","", "");
		switch ($msg_type) {
			case 'added':
				$this->sendTemplateMail($maildata[0]['email'], TPL_NEW_EMP_EMP, $params);
				$params[PAR_RECEIVER] = $maildata[0]['mgr_fullname'];
				$this->sendTemplateMail($maildata[0]['mgr_email'], TPL_NEW_EMP_MGR, $params);
				if ($this->page->company['hr_email_adr'] != '') {
					$params[PAR_RECEIVER] = 'HR Admin staff';
					$this->sendTemplateMail($this->page->company['hr_email_adr'], TPL_NEW_EMP_MGR, $params);
				}
				break;
			case 'disabled':
				$this->sendTemplateMail($maildata[0]['email'], TPL_DIS_EMP_EMP, $params);
				$params[PAR_RECEIVER] = $maildata[0]['mgr_fullname'];
				$this->sendTemplateMail($maildata[0]['mgr_email'], TPL_DIS_EMP_MGR, $params);
				if ($this->page->company['hr_email_adr'] != '') {
					$params[PAR_RECEIVER] = 'HR Admin staff';
					$this->sendTemplateMail($this->page->company['hr_email_adr'], TPL_DIS_EMP_MGR, $params);
				}
		}
	}

	public function getTitle() {
		if ($this->page->ctrl['action'] == 'add') {
			return "New Employee";
		}
		return $this->data[0]['fname'].' '.$this->data[0]['sname'].", ".$this->data[0]['deptname'].", ".$this->data[0]['location'];
	}

	private function getShortTitle() {
		return $this->data[0]['fname'].' '.$this->data[0]['sname'];
	}

	public function graph_top() {

		$this->graphEmpty = false;
		$this->createGraph('attendance');
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Attendance (last 30 days)</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>\n";
		if ($this->graphEmpty == true) {
			$out .= "<h3>There is no data for a graph yet.</h3>\n";
		} else {
			$out .= "          <a href=\"images/attendance".$this->data[0]['emp_id'].".png\">";
			$out .= "<img width=\"70%\" height=\"70%\" src=\"images/attendance".$this->data[0]['emp_id'].".png\"></a>\n";
		}
		$out .= "		  </td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;
	
	}
	public function graph_bottom() {

		$this->graphEmpty = false;
		$this->createGraph('lateness');
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Lateness (last 30 days)</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>\n";
		if ($this->graphEmpty == true) {
			$out .= "<h3>There is no data for a graph yet.</h3>\n";
		} else {
			$out .= "          <a href=\"images/lateness".$this->data[0]['emp_id'].".png\">";
			$out .= "<img width=\"70%\" height=\"70%\" src=\"images/lateness".$this->data[0]['emp_id'].".png\"></a>\n";
		}
		$out .= "		  </td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	

	}
	public function activities() {
	
		$title = $this->getShortTitle();
		$rec = $this->page->ctrl['record'];
		$dis = $this->page->ctrl['display'];
	
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td colspan=2 width=\"100%\" class=\"td-left\"><h2>Activities</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','edit');\">Edit</a></td>\n";
		$out .= "            <td class=\"td-right\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','edit');\">Change the password</a></td></tr>\n";
		if (($this->page->config['user_level'] > lu_manager && $this->page->config['user_id'] != $this->data[0]['emp_id']) 
			  || $this->page->config['user_level'] > lu_admin) {
			$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','delete');\">Delete</a></td>\n";
			$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"SelectSubSubject('Annual Leave','show','".$title."')\">Leave Allowances</a></td></tr>\n";
		}
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SelectSubSubject('Leave','show','".$title."')\">Leave Bookings</a></td>\n"; 
		$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"SelectSubSubject('Leave','add','".$title."');\">Apply for leave</a></td></tr>\n";
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SelectSubSubject('Exceptions','show','".$title."')\">Exceptions</a></td>\n"; 
		$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"SelectSubSubject('Exceptions','add','".$title."');\">Apply for an exception</a></td></tr>\n";
//		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SelectSubSubject('Attendance','show','".$title."')\">Attendance</a></td>\n";
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SelectSubSubject('Shift Schedule','show','".$title."');\">Shifts</a></td>\n";
		$out .= "            <td class=\"td-right\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','resetpw');\">Reset password</a></td></tr>\n";  
//		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SelectSubSubject('Half days off','show','".$title."')\">Half Days Off</a></td>\n"; 
//		$out .= "            <td class=\"td-right\"><a href=\"#\" onclick=\"SetAction('Half days off','add','".$title."');\">Apply for half a day off</a></td></tr>\n"; 
//		$out .= "				<td></td>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}
	
	protected function time2secs($value) {
		// value must be in hh:mm:ss format
		return substr($value,0,2)*3600 + substr($value,3,2)*60 + substr($value,6,2);
	}
	
	private function createGraph($type) {
	
		$filename = "images/".$type.$this->data[0]['emp_id'].".png";
		$sql = '';
		$emp_id = $this->data[0]['emp_id'];
		$comp_id = $this->page->company['company_id'];
		// Unless you really, really, really know your SQL, you better leave these two queries alone.
		// Took me 3 days to figure out how to do them properly (and I am quite good at SQL !!!)
		switch($type) {
			case 'attendance':
				$sql = "SELECT d.short_date, if(a.end_time is null or a.end_time='00:00:00',0,sum(time_to_sec(a.end_time)-time_to_sec(a.start_time))) as att_real,
						  round(if(date_format(d.short_date,'%a') in ('Sat','Sun') or h.hdate is not null or el.is_half_day = 0,0,
						  if(el.is_half_day = 1, time_to_sec(c.default_hours)/2,
						  if(s.end_time is null, time_to_sec(c.default_hours), time_to_sec(s.end_time)-time_to_sec(s.start_time)))),0) as att_exp
						  FROM dates d INNER JOIN companies c on c.company_id = ".$comp_id." INNER JOIN shifts ds on c.default_shift = ds.shift_id 
		 				  LEFT JOIN attendance a ON d.short_date = a.att_date and a.emp_id = ".$emp_id;
				break; 
			case 'lateness';
				$sql = "SELECT d.short_date, min(if(a.start_time is null,0,time_to_sec(a.start_time))) as att_real,
						  round(if(date_format(d.short_date,'%a') in ('Sat','Sun') or h.hdate is not null or el.is_half_day = 0,0,
						  if(el.is_half_day = 1, if(el.is_am = 1, if(s.start_time is null, time_to_sec(ds.start_time), time_to_sec(s.start_time)), 
						  if(s.start_time is null,time_to_sec(ds.start_time) + time_to_sec(c.default_hours)/2, time_to_sec(s.start_time) + time_to_sec(c.default_hours)/2)),
						  if(s.start_time is null, time_to_sec(ds.start_time), time_to_sec(s.start_time)))),0) as att_exp 
						  FROM dates d INNER JOIN companies c on c.company_id = ".$comp_id." INNER JOIN shifts ds on c.default_shift = ds.shift_id 
		 				  LEFT JOIN presence a ON d.short_date = a.att_date and a.emp_id = ".$emp_id; 
				break;
		}
		$sql .= " LEFT JOIN emp_leave el on el.emp_id = ".$emp_id." and el.start_date <= d.short_date and el.end_date >= d.short_date and el.approved = 1
					LEFT JOIN emp_shifts es on d.short_date = es.shift_date and es.emp_id = ".$emp_id." LEFT JOIN shifts s on es.shift_id = s.shift_id
					LEFT JOIN holidays h on d.short_date = h.hdate and h.company_id = ".$comp_id."
					WHERE d.short_date >= date_sub(curdate(), interval 31 day) and d.short_date < curdate()
					GROUP BY d.short_date;";
		$data = $this->dbc->query($sql);
		
		if ($data == NULL) {
			$this->graphEmpty = true;
			return;
			}

		$Graph =& Image_Graph::factory('graph', array(800, 400));
		$Graph->add(
		    Image_Graph::vertical(
		        Image_Graph::factory('title', array($type, 36)),
		        Image_Graph::vertical(
		            $Plotarea = Image_Graph::factory('plotarea'),
		            $Legend = Image_Graph::factory('legend'),
		            90
		        ),
		        5
		    )
		);         
		 
		// make the legend use the plotarea (or implicitly it's plots)
		$Legend->setPlotarea($Plotarea);   
		 
		// create a grid and assign it to the secondary Y axis
		$GridY2 =& $Plotarea->addNew('bar_grid', IMAGE_GRAPH_AXIS_Y_SECONDARY);  
//		$GridY2->setFillStyle(Image_Graph::factory('Image_Graph_Fill','white'));    
		$Expected =& Image_Graph::factory('dataset');
		$Real =& Image_Graph::factory('dataset');
		
		foreach ($data as $row) {
			$Expected->addPoint(substr($row['short_date'],5), $row['att_exp']/3600);
			$Real->addPoint(substr($row['short_date'],5), $row['att_real']/3600);
		}
	
		$fill =& Image_Graph::factory('Image_Graph_Fill_Array'); 
		$fill->addColor('blue@0.8'); 
		$fill->addColor('green@0.8'); 

		$line =& Image_Graph::factory('Image_Graph_Line_Array'); 
		$line->addColor('blue'); 
		$line->addColor('green'); 

		$Plot1 =& Image_Graph::factory('bar',array(array($Expected,$Real),'Normal','Expected'));
		$Plot1->setFillStyle($fill);
		$Plot1->setLineStyle($line);
		$Plotarea->add($Plot1);
		 
		$Expected->setName('Expected');
		$Real->setName('Real');
		$Plot1->setTitle('Expected vs. Real');
		
		$AxisX =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_X);
//		$AxisX->setTitle('Workdays');
		$AxisX->setFontSize('24');
		$AxisX->setFontAngle(90);
		$AxisY =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
		if ($type=='attendance') {
			$AxisY->setTitle('Attendance', 'vertical');
		} else {
			$AxisY->setTitle('Presence', 'vertical');
		} 
		$AxisY->setFontSize('24');
		$AxisX->setAxisIntersection(0,'ysec'); 
		// output the Graph
		$Graph->done(array('filename' => $filename));
		
	}

}
?>