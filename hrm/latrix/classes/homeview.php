<?php

require_once("classes/dbobject.php");
require_once("Image/Graph.php");

class HomeView extends DBObject{

	var $dbc;
	var $error;
	var $page;
 	
	public function __construct(&$page,&$db_conn,&$errorbox) {
		$this->dbc = $db_conn;
		$this->error = $errorbox;
		$this->page = $page;
		$this->isFaulty = false;
		$this->userid = $this->page->config['user_id'];
		$sql = 'SELECT e.emp_id, e.payroll, e.fname, e.sname, e.max_leave, e.email, e.leave_left,
				  l.name as location, d.name as deptname, e.user_level_id
				  FROM employees e INNER JOIN locations l USING (location_id) INNER JOIN teams t USING (team_id)
				  INNER JOIN departments d USING (dept_id) WHERE e.emp_id='.$this->userid;
		$this->user = $this->dbc->query($sql);
		$this->help_url = 'http://www.latrix.org.uk/node/23';			//TODO: create this page !!!
	}

	private function getTitle() {
		// return a string containing, complete name, department and location 
		return $this->user[0]['fname'].' '.$this->user[0]['sname'].", ".$this->user[0]['deptname'].", ".$this->user[0]['location'];
	}

	public function show() {
	
		if($this->isFaulty == true) {
			$this->error->add("Cannot show details, the item is not defined properly. Call support!");
			return "";
		}
		$out = "\t<table style=\"padding: 5px; width=100%;\" class=\"data-table\" cellpadding=\"0px\" cellspacing=\"0px\" >\n";
		$out .= "\t<thead>\n";
		$out .= "\t\t<tr><td colspan=3 class=\"td-left\" style=\"width: 50%;\"><h1>".$this->getTitle()."</h1></td></tr>\n";
		$out .= "\t</thead>\n";
		$out .= "\t<tbody>\n";
		$out .= "\t\t<tr><td valign=\"top\">\n";			// This is the left hand side column.
		$out .= $this->showleaveapps(); 
		$out .= $this->showexceptionapps();
		$out .= "\t\t</td><td style=\"width: 10px;\" valign=\"top\">\n";		// This is the separator column.
		$out .= "\t\t</td><td rowspan=\"2\" valign=\"top\">\n";		// This is the right hand side column.
		$out .= $this->showstats();
		$out .= $this->shownotes();
		$out .= "\t\t<h2>Your personal presence graph (last 14 days)</h2>\n";
		$this->image = "images/presence".$this->user[0]['user_level_id'].".png";
		if ($this->showgraph() == -1) {
			$out .= "\t\tThere is no presence data, graph cannot be generated.\n"; 
		} else {
			$out .= "<span style=\"font-size: 8pt;\">(Click on the graph for a bigger image)</span>\n";
			$out .= "\t\t<a href=\"".$this->image."\"><img src=\"".$this->image."\" width=\"70%\" height=\"70%\"></a>\n"; 
		}
		$out .= "\t\t</td></tr>\n";
		$out .= "\t\t<tr><td>\n";
		if ($this->user[0]['user_level_id'] >= lu_manager) {
			$out .= $this->showactionitems();
		} else {
			$out .= "&nbsp;";
		}
		if ($this->user[0]['user_level_id'] >= lu_gm) {
			$out .= $this->showescalations();
		}
		$out .= "\t\t</td></tr>\n";
		$out .= "\t</tbody>\n";
		$out .= "\t</table>\n";
		return $out;
	}

	private function showleaveapps() {
		$sql = "SELECT el.emp_leave_id, el.start_date, el.end_date, lt.name as name, el.note, el.approved, el.approval_date,	
				  el.submit_date, concat(e.sname, ', ',e.fname) as approved_by, el.emp_id, el.is_half_day, el.is_am
				  FROM emp_leave el inner join leave_types lt on el.type_id = lt.leave_type_id
				  left join employees e on el.approval_emp_id = e.emp_id
				  WHERE start_date > curdate() AND el.emp_id = ".$this->userid." ORDER BY start_date ASC";
		$leave = $this->dbc->query($sql);
		$sql = 'SELECT * FROM data_columns WHERE subject_id = 10 AND visible = 1';
		$columns = $this->dbc->query($sql);
		$this->subject = 'Leave';
		return $this->showtable($leave, $columns,'Your future leave applications'); 
	}
	
	private function showexceptionapps() {
		$sql = "SELECT ee.exception_id, ee.start_time, ee.end_time, ee.exception_date as name, ee.reason, ee.submit_date, ee.approved,
				  ee.approval_date, concat(e.sname,', ', e.fname) as approved_by, ee.emp_id
				  FROM exceptions ee LEFT JOIN employees e on ee.approval_emp_id = e.emp_id
				  WHERE ee.exception_date >= curdate() AND ee.emp_id = ".$this->userid." ORDER BY exception_date ASC";
		$leave = $this->dbc->query($sql);
		$sql = 'SELECT * FROM data_columns WHERE subject_id = 12 AND visible = 1';
		$columns = $this->dbc->query($sql);
		return $this->showtable($leave, $columns,'Your future exception applications'); 
		$this->subject = 'Exceptions';
	}
	
	private function showstats() {
		// show remaining leave, end date of defined shift patterns, days late (compared to shifts)
		$sql = 'SELECT b.year_name, a.leave_left FROM annual_leave a INNER JOIN business_years b on 
				  a.year_id = b.business_year_id WHERE b.year_start <= curdate() AND b.year_end >= curdate()
				  AND a.emp_id='.$this->userid;
		$remleave = $this->dbc->query($sql);
		if (count($remleave) > 0) {
			$leave_left = $remleave[0]['leave_left'];
		} else {
			$leave_left = 0;
		}
		$sql = 'SELECT max(shift_date) as maxdate FROM emp_shifts WHERE shift_date > curdate() AND emp_id = '.$this->userid;
		$maxshift = $this->dbc->query($sql);
		if ($maxshift[0]['maxdate'] == '') {
			$maxdate = 'undefined';
		} else {
			$maxdate = $maxshift[0]['maxdate'];
		}
		$sql = 'select att_date, min(p.start_time) as start_time, if(s1.shift_id is null, s2.start_time, s1.start_time) as proper_start,
				  if(s1.shift_id is null, if(min(p.start_time) > s2.start_time,1,0),if(min(p.start_time) > s1.start_time,1,0)) as late
				  FROM presence p LEFT JOIN emp_shifts es ON p.att_date = es.shift_date AND p.emp_id = es.emp_id
				  LEFT JOIN shifts s1 on es.shift_id = s1.shift_id
				  INNER JOIN employees e on p.emp_id = e.emp_id INNER JOIN companies c on e.company_id = c.company_id
				  INNER JOIN shifts s2 on c.default_shift = s2.shift_id 
				  WHERE p.emp_id = '.$this->userid.' and p.att_date >= date_sub(curdate(), interval 30 day)
				  GROUP BY att_date;';		
		$lates = $this->dbc->query($sql);
		
		$out = '<table style="width: 100%; text-align: center;" cellpadding="0px" cellspacing="0px" class="data-table">'."\n";
		$out .= "\t<thead>\n";
		$out .= "\t<tr>\n";
		$out .= "\t\t<td class=\"td-left\" colspan=\"3\"><h1>Your Stats</h1></td>\n";
		$out .= "\t</tr>\n";
		$out .= "\t</thead><tbody>\n";
		$out .= "\t<tr>\n";
		$out .= "\t<td class=\"td-left\" colspan=2>Leave left in this year</td>\n";
		$out .= "\t<td class=\"td-right\">".$leave_left." days</td></tr>\n";
		$out .= "\t<tr>\n";
		$out .= "\t<td class=\"td-left\" colspan=2>Last defined shift is on</td>\n";
		$out .= "\t<td class=\"td-right\">".$maxdate."</td></tr>\n";
		$out .= "\t<tr class=\"data-head\"><td colspan=3>Lateness in the last 14 days</td></tr>\n";
		$latecount = 0;
		if (count($lates) >0) {
			foreach($lates as $late) {
				if ($late['late'] == 1) { $latecount++; }
			}
		}
		if ($latecount == 0) {
			$out .= "\t<tr><td colspan=3>Perfect record, no lates!</td></tr>\n";
		} else {
			$out .= "\t<tr><td>Date</td><td>Exp. Start</td><td>Real Start</td></tr>\n";
			foreach($lates as $late) {
				if ($late['late'] == 1) {		
					$out .= "\t<tr><td class=\"td-left\">".$late['att_date']."</td><td class=\"td_right\">".$late['proper_start'];
					$out .= "</td><td class=\"td_right\">".$late['start_time']."</td></tr>\n";
				}
			}
		}
		$out .= "\t</tbody>\n";
		$out .= "\t</table>\n";
		return $out;
	}
	
	private function shownotes() {
		// all notes from other employees, requires implementation of the note feature
	}
		
	private function showactionitems() {
		// only applicable to managers, which is handled by the calling function
		// shows late team members, folks that are off, folks back from sick leave and unapproved applications for leave
		// and unapproved exceptions
		$sql = "SELECT concat(e.fname,' ',e.sname) AS empname, t.name AS team_name, min(a.start_time) AS start_time, 
				  IF(s.start_time is null, ds.start_time, s.start_time) AS required_start
				  FROM presence a INNER JOIN employees e ON a.emp_id = e.emp_id INNER JOIN teams t ON e.team_id = t.team_id
				  INNER JOIN departments d ON t.dept_id = d.dept_id 
				  LEFT JOIN emp_shifts es ON e.emp_id = es.emp_id AND es.shift_date = curdate() LEFT JOIN shifts s ON es.shift_id = s.shift_id
				  INNER JOIN companies c ON e.company_id = c.company_id INNER JOIN shifts ds ON c.default_shift = ds.shift_id
				  WHERE d.manager_id = ".$this->userid." AND a.att_date = curdate() GROUP BY e.emp_id
				  HAVING start_time > required_start";
		$lates = $this->dbc->query($sql);
		$sql = "SELECT concat(e.fname, ' ', e.sname) AS emp_name, t.name AS team_name, lt.name AS leave_name, el.start_date, el.end_date
				  FROM employees e INNER JOIN teams t ON e.team_id = t.team_id
				  INNER JOIN departments d ON t.dept_id = d.dept_id INNER JOIN emp_leave el ON e.emp_id = el.emp_id 
				  AND el.start_date <= curdate() and el.end_date >= curdate() INNER JOIN leave_types lt ON el.type_id = lt.leave_type_id
				  WHERE d.manager_id = ".$this->userid.";";
		$leaves = $this->dbc->query($sql);
		$sql = "SELECT concat(e.fname,' ',e.sname) as emp_name, t.name AS team_name, el.note
				  FROM emp_leave el INNER JOIN employees e on el.emp_id = e.emp_id INNER JOIN teams t on e.team_id = t.team_id
				  INNER JOIN departments d on t.dept_id = d.dept_id 
				  WHERE el.end_date = date_sub(curdate(), interval 1 day) AND d.manager_id =".$this->userid.";";
		$returns = $this->dbc->query($sql);
		$sql = "SELECT concat(e.fname,' ',e.sname) as emp_name, t.name AS team_name, el.start_date, el.end_date, lt.name AS leave_name
				  FROM emp_leave el INNER JOIN employees e on el.emp_id = e.emp_id INNER JOIN teams t on e.team_id = t.team_id
				  INNER JOIN departments d on t.dept_id = d.dept_id INNER JOIN leave_types lt on el.type_id = lt.leave_type_id
				  WHERE el.approved = 0 AND el.start_date > curdate() AND d.manager_id =".$this->userid.";";
		$approvals = $this->dbc->query($sql);
		$sql = "SELECT concat(e.fname,' ',e.sname) as emp_name, t.name AS team_name, min(p.start_time) as pres_start, min(a.start_time) as att_start
				  FROM presence p INNER JOIN employees e on p.emp_id = e.emp_id INNER JOIN teams t on e.team_id = t.team_id
				  INNER JOIN departments d on t.dept_id = d.dept_id LEFT JOIN attendance a on p.emp_id = a.emp_id and p.att_date = a.att_date 
				  WHERE p.att_date = curdate() AND e.monitored =1 AND d.manager_id =".$this->userid." GROUP BY e.emp_id;";
		$monitored = $this->dbc->query($sql);
		// This outputs a table of its own. Seeing that we have 4 datasets, we will have a table with 2 rows
		// and 2 columns. The only 2 sets that have action items are the sick leave returners and the 
		// unapproved leave apps, so they go on the right hand side, with action icons. 
		$out = '<table style="width: 100%; text-align: center;" cellpadding="0px" cellspacing="0px" class="data-table">'."\n";
		$out .= "\t<thead><tr><td colspan=\"2\"><h1>Your action items & monitors</h1></td></tr></thead>";
		$out .= "\t<tr>\n";
		$out .= "\t\t<td>\n"; 
		//First up are the lates
		$out .= "\t\t\t<table style=\"width: 95%;\" class=\"data-table\">\n"; 
		$out .= "\t\t\t\t<thead><tr><td colspan=\"3\"><h1>Today's latecomers:</h1></td></tr>\n";
		$out .= "\t\t\t\t<tr class=\"data-head\"><td>Name</td><td>Should start</td><td>Did start</td></tr></thead>\n"; 
		if (count($lates) > 0) {
			foreach($lates as $late) {
				$out .= "\t\t\t\t<tr><td class=\"td-left\">".$late['empname']."</td>";
				$out .= "<td class=\"td-right\">".$late['required_start']."</td>";
				$out .= "<td class=\"td-right\">".$late['start_time']."</td></tr>\n"; 
			}
		} else {
			$out .= '<tr><td colspan="3">Your team members all started on time!</td></tr>';
		}
		$out .= "\t\t\t</table>\n";
		$out .= "\t\t</td>\n";
		$out .= "\t\t<td>\n";
		//Second the sick leave returns 
		$out .= "\t\t\t<table style=\"width: 95%;\" class=\"data-table\">\n"; 
		$out .= "\t\t\t\t<thead><tr><td colspan=\"3\"><h1>Today's leave returners:</h1></td></tr>\n";
		$out .= "\t\t\t\t<tr class=\"data-head\"><td>Name</td><td>Team</td><td>Sick leave note</td></tr></thead>\n"; 
		if (count($returns) > 0) {
			foreach($returns as $returner) {
				$out .= "\t\t\t\t<tr><td class=\"td-left\">".$returner['emp_name']."</td>";
				$out .= "<td class=\"td-right\">".$returner['team_name']."</td>";
				$out .= "<td class=\"td-right\">".$returner['note']."</td></tr>\n"; 
			}
		} else {
			$out .= '<tr><td colspan="3">Your team members are all healthy!</td></tr>';
		}
		$out .= "\t\t\t</table>\n";
		$out .= "\t\t</td>\n";
		$out .= "\t</tr>\n";
		$out .= "\t<tr>\n";
		$out .= "\t\t<td>\n";
		//Thirds the folks on leave
		$out .= "\t\t\t<table style=\"width: 95%;\" class=\"data-table\">\n"; 
		$out .= "\t\t\t\t<thead><tr><td colspan=\"3\"><h1>Today's absentees:</h1></td></tr>\n";
		$out .= "\t\t\t\t<tr class=\"data-head\"><td>Name</td><td>Team</td><td>Leave type</td></tr></thead>\n"; 
		if (count($leaves) > 0) {
			foreach($leaves as $leave) {
				$out .= "\t\t\t\t<tr><td class=\"td-left\">".$leave['emp_name']."</td>";
				$out .= "<td class=\"td-right\">".$leave['team_name']."</td>";
				$out .= "<td class=\"td-right\">".$leave['leave_name']."</td></tr>\n"; 
			}
		} else {
			$out .= '<tr><td colspan="3">Your team members are all at work!</td></tr>';
		}
		$out .= "\t\t\t</table>\n";
		$out .= "\t\t</td>\n";
		$out .= "\t\t<td>\n";
		//Fourth the attendance monitors
		$out .= "\t\t\t<table style=\"width: 95%;\" class=\"data-table\">\n"; 
		$out .= "\t\t\t\t<thead><tr><td colspan=\"4\"><h1>Attendance Monitors:</h1></td></tr>\n";
		$out .= "\t\t\t\t<tr class=\"data-head\"><td>Name</td><td>Team</td><td>Check In</td><td>Start Work</td></tr></thead>\n"; 
		if (count($monitored) > 0) {
			foreach($monitored as $monitor) {
				if ($monitor['att_start'] == '') {
					$out .= "\t\t\t\t<tr><td class=\"td-left\"><span class=\"monitored\">".$monitor['emp_name']."</span></td>";
					$out .= "<td class=\"td-right\"><span class=\"monitored\">".$monitor['team_name']."</span></td>";
					$out .= "<td class=\"td-right\"><span class=\"monitored\">".$monitor['pres_start']."</span></td>\n";
					$out .= "<td class=\"td-right\"><span class=\"monitored\">--:--:--</span></td></tr>\n";
				} else {
					$out .= "\t\t\t\t<tr><td class=\"td-left\">".$monitor['emp_name']."</td>";
					$out .= "<td class=\"td-right\">".$monitor['team_name']."</td>";
					$out .= "<td class=\"td-right\">".$monitor['pres_start']."</td>\n";
					$out .= "<td class=\"td-right\">".$monitor['att_start']."</td></tr>\n";
				}
			}
		} else {
			$out .= '<tr><td colspan="3">Your team members are all hard at work!</td></tr>';
		}
		$out .= "\t\t\t</table>\n";
		$out .= "\t\t</td>\n";
		$out .= "\t</tr>\n";
		$out .= "\t<tr>\n";
		//Finally the unapproved apps
		$out .= "\t\t<td colspan=\"2\">";
		$out .= "\t\t\t<table style=\"width: 95%;\" class=\"data-table\">\n"; 
		$out .= "\t\t\t\t<thead><tr><td colspan=\"5\"><h1>Unapproved applications:</h1></td></tr>\n";
		$out .= "\t\t\t\t<tr class=\"data-head\"><td>Name</td><td>Start</td><td>End</td><td>Type</td><td>Action</td></tr></thead>\n"; 
		if (count($approvals) > 0) {
			foreach($approvals as $app) {
				$out .= "\t\t\t\t<tr><td class=\"td-left\">".$app['emp_name']."</td>";
				$out .= "<td class=\"td-right\">".$app['start_date']."</td>";
				$out .= "<td class=\"td-right\">".$app['end_date']."</td>";
				$out .= "<td class=\"td-right\">".$app['leave_name']."</td>";
				$out .= "<td class=\"td-right\">Approve/Decline</td>\n"; 
			}
		} else {
			$out .= '<tr><td colspan="5">Your team members don\'t want any leave!</td></tr>';
		}
		$out .= "\t\t\t</table>\n";
		$out .= "\t\t</td>"; 
		$out .= "\t</tr>\n";
		$out .= "</table>\n";
		return $out;
	}
	
	private function showescalations() {
		// only applicable to the GM, which is handled by the calling function
		// shows all unapproved excalated leave applications, with links for approval
		// These links open a pop-up page, where the GM can enter a note prior to approval. 
		// when actioned, these links send emails. This should be done using AJAX, so the page doesn't need a reload.
	}
	
	private function showgraph() {
		// shows a graph comparing expected presence (start/end) against real presence (start/end)
		// expected presence as a blue band, real presence as a green band on top (with opacity set to 50%)
		// data shown is for the last 14 days
		$sql ="SELECT a.att_date, time_to_sec(min(a.start_time)) AS start_time, time_to_sec(max(a.end_time)) AS end_time,
				 time_to_sec(if(s.start_time is null, ds.start_time, s.start_time)) AS required_start,
				 time_to_sec(if(s.end_time is null, ds.end_time, s.end_time)) AS required_end
				 FROM presence a INNER JOIN employees e ON a.emp_id = e.emp_id 
				 LEFT JOIN emp_shifts es ON e.emp_id = es.emp_id AND es.shift_date = a.att_date LEFT JOIN shifts s ON es.shift_id = s.shift_id
				 inner join companies c ON e.company_id = c.company_id INNER JOIN shifts ds ON c.default_shift = ds.shift_id
				 WHERE e.emp_id = ".$this->userid." AND a.att_date BETWEEN date_sub(curdate(), interval 15 day) AND curdate()
				 GROUP BY att_date;";
		$data = $this->dbc->query($sql);
		$Graph =& Image_Graph::factory('graph', array(1000, 700));
		$Graph->add(
		    Image_Graph::vertical(
		        Image_Graph::factory('title', array('Presence vs. Shift', 36)),
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
		$GridY2->setFillStyle(Image_Graph::factory('gradient', 
    								 array('IMAGE_GRAPH_VERTICAL', 'white', 'white')));    
		// create a line plot using a random dataset
		$Expected_start =& Image_Graph::factory('dataset');
		$Expected_end =& Image_Graph::factory('dataset');
		$Real_start =& Image_Graph::factory('dataset');
		$Real_end =& Image_Graph::factory('dataset');
		if ($data == NULL) return -1;
		foreach ($data as $row) {
			$Expected_start->addPoint(substr($row['att_date'],5), $row['required_start']/3600);
			$Expected_end->addPoint(substr($row['att_date'],5), ($row['required_end']-$row['required_start'])/3600);
			$Real_start->addPoint(substr($row['att_date'],5), $row['start_time']/3600);
			$Real_end->addPoint(substr($row['att_date'],5), ($row['end_time']-$row['start_time'])/3600);
		}
		$Expected = array('ES' => $Expected_start, 'EE' => $Expected_end);
		$Real = array('RS' => $Real_start, 'RE' => $Real_end);
	
		$fillE =& Image_Graph::factory('Image_Graph_Fill_Array'); 
		$fillE->addColor('white', 'ES'); 
		$fillE->addColor('blue@0.2', 'EE'); 
		$fillR =& Image_Graph::factory('Image_Graph_Fill_Array'); 
		$fillR->addColor('white@0.0', 'RS'); 
		$fillR->addColor('green@0.2', 'RE'); 

		$lineE =& Image_Graph::factory('Image_Graph_Line_Array'); 
		$lineE->addColor('white@0.0', 'ES'); 
		$lineE->addColor('blue@0.6', 'EE'); 
		$lineR =& Image_Graph::factory('Image_Graph_Line_Array'); 
		$lineR->addColor('white@0.0', 'RS'); 
		$lineR->addColor('green@0.6', 'RE'); 

		$Plot1 =& Image_Graph::factory('bar',array($Expected,'Stacked','Expected'));
		$Plot1->setFillStyle($fillE);
		$Plot1->setLineStyle($lineE);
		$Plotarea->add($Plot1);
		$Plot2 =& Image_Graph::factory('bar',array($Real,'Stacked','Real'));
		$Plot2->setFillStyle($fillR);
		$Plot2->setLineStyle($lineR);
		$Plotarea->add($Plot2);
		 
		$Plot1->setTitle('Required');
		$Plot2->setTitle('Real');

		$AxisX =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_X);
		$AxisX->setTitle('Workdays');
		$AxisX->setFontSize('24');
		$AxisY =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
		$AxisY->setTitle('Presence', 'vertical'); 
		$AxisY->setFontSize('24');
		$AxisX->setAxisIntersection(0,'ysec'); 
		// output the Graph
		$Graph->done(array('filename' => $this->image));
	}
	
	private function showtable(&$data,&$cols,$title) {
		if ($this->isFaulty) { return;}

		$out = '<table style="width: 100%; text-align: center;" cellpadding="0px" cellspacing="0px" class="data-table">'."\n";
		$out .= "\t<thead>\n";
		$out .= "\t<tr>\n";
		$out .= "\t\t<td class=\"td-left\" colspan=".count($cols)."><h1>".$title."</h1></td>\n";
		$out .= "\t</tr>\n";
		$out .= "\t<tr>\n";

		// First we build the header row
		foreach ($cols as $col) {
			$out .= "\t\t<td class=\"data-head\"";
			if ($col['width'] > 25 ) {
				$width = 25;
			} else {
				$width = $col['width'];
			}
			$out .= " style=\"width:".$width."%; text-align:";
			switch ($col['align']) {
				case 'R':
					$out .= " right;";
					break;
				case 'L':
					$out .= " left;";
					break;
				case 'C':
					$out .= " center;";
					break;
				}
			$out .= "\">";
			$out .= $col['title']."</td>\n";
		}
		//the final column is always the action column, with links for edit, delete, e-mail (only for employees).
		$out .= "\t\t<td class=\"data-head\" style=\"text-align:right;\">Action</td>\n";
		$out .= "\t</tr>\n";
		$out .= "\t</thead>\n";
		
		if ($data == NULL) {
			$out .= "\t\t<tr><td colspan=\"".(count($cols)+1)."\">There are no records to display.</td></tr>\n";
			$out .= "</table>\n";
			return $out;
		}

		$out .= "\t<tbody>\n";
		//Now we loop through the data
		$cnt = 1;
		foreach ($data as $row) {
			// the first column is always a link to view the details;
			if ($cnt++ % 2 == 0) {
				if ($this->isOpenApplication($row)) {
					$out .= "\t\t<tr class=\"odd-row-open\">\n";
				} else {
					$out .= "\t\t<tr class=\"odd-row\">\n";
				}
			} else {
				if ($this->isOpenApplication($row)) {
					$out .= "\t\t<tr class=\"even-row-open\">\n";
				} else {
					$out .= "\t\t<tr class=\"even-row\">\n";
				}
			}
			$out .= "\t\t<td style=\"text-align:";
			switch ($this->cols[0]['align']) {
				case 'R':
					$out .= " right;";
					break;
				case 'L':
					$out .= " left;";
					break;
				case 'C':
					$out .= " center;";
					break;
				}
			$out .= "\"><a href=\"#\" title=\"Show Details\" onclick=\"SetAction('".$row[0]."','".$displayID."','view');\">".$row[$this->cols[0]['db_name']]."</a></td>\n";
			for ($i = 1; $i < count($this->cols); $i++) {
				$out .= "\t\t<td class=\"data-table\"";
				$out .= " style=\"text-align:";
				switch ($this->cols[$i]['align']) {
					case 'R':
						$out .= " right;";
						break;
					case 'L':
						$out .= " left;";
						break;
					case 'C':
						$out .= " center;";
						break;
					}
				$out .= "\">";
				if($this->cols[$i]['type'] == 'B') {
					if ($row[$this->cols[$i]['db_name']] == 0) {
						$out .= "No</td>\n";
					} else {
						$out .= "Yes</td>\n";
					}
				} elseif($this->cols[$i]['type'] == 'D') {
					if ($row[$this->cols[$i]['db_name']] == '0000-00-00') {
						$out .= "---</td>\n";
					} else {
						$out .= $row[$this->cols[$i]['db_name']]."</td>\n";
					}
				} elseif($this->cols[$i]['format'] != '') {
					$out .= sprintf($this->cols[$i]['format'], $row[$this->cols[$i]['db_name']])."</td>\n";
				} else {
					$out .= $row[$this->cols[$i]['db_name']]."</td>\n";
				}
			}
			//
			$out .= "\t\t<td class=\"data-table\" style=\"text-align:right;\">&nbsp;\n"; 
			$out .= "\t\t</td></tr>\n";
			$displayID++;
		}
		$out .= "\t</tbody>\n";
		$out .= "\t</table>\n";
		return $out;
	}
	
	private function isOpenApplication($row) {
		if ($this->subject == 'Exceptions' || $this->subject == 'Leave' || $this->subject == 'Half days off') {
			if ($row['approval_date'] == '0000-00-00') {
				return true;
			} else {
				return false;
			}
		}
	}

}
