SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `actions` (
  `action_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `subject_id` int(10) unsigned NOT NULL,
  `targetURL` varchar(45) NOT NULL default 'badlocation.php',
  `action` varchar(10) NOT NULL default 'none',
  `user_level` smallint(5) unsigned NOT NULL default '1',
  PRIMARY KEY  (`action_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `annual_leave` (
  `annual_leave_id` int(10) unsigned NOT NULL auto_increment,
  `emp_id` int(10) unsigned NOT NULL,
  `allowance` int(10) unsigned NOT NULL,
  `leave_left` decimal(4,1) NOT NULL,
  `year_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`annual_leave_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `att_types` (
  `type_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY  (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `attendance` (
  `attendance_id` int(11) unsigned NOT NULL auto_increment,
  `emp_id` int(11) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL default '1',
  `company_id` int(10) unsigned NOT NULL default '1',
  `start_time` time NOT NULL default '00:00:00',
  `end_time` time NOT NULL default '00:00:00',
  `att_date` date NOT NULL default '0000-00-00',
  `start_type` int(10) unsigned NOT NULL default '9' COMMENT 'N(ormal), B(reak), T(ransfer), M(anual)',
  `end_type` int(10) unsigned NOT NULL default '9' COMMENT 'as above, plus A(utomatic)',
  PRIMARY KEY  (`attendance_id`),
  KEY `idx_date` (`att_date`),
  KEY `fk_attendance_comp` (`company_id`),
  KEY `fk_attendance_loc` (`location_id`),
  KEY `fk_attendance_emp` (`emp_id`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `blocks` (
  `block_id` int(10) unsigned NOT NULL auto_increment,
  `company_id` int(10) unsigned NOT NULL,
  `block_start` date NOT NULL,
  `block_end` date NOT NULL,
  `reason` varchar(80) NOT NULL,
  PRIMARY KEY  (`block_id`),
  KEY `idx_company` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `business_years` (
  `business_year_id` int(10) unsigned NOT NULL auto_increment,
  `year_name` varchar(10) NOT NULL,
  `year_start` date NOT NULL,
  `year_end` date NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`business_year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `companies` (
  `company_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(60) default NULL,
  `contact_phone` varchar(20) NOT NULL,
  `manager_id` int(10) unsigned default NULL,
  `double_login` tinyint(1) NOT NULL,
  `lone_worker_warning` tinyint(1) NOT NULL,
  `show_self_cert` tinyint(1) NOT NULL,
  `leave_login` tinyint(1) NOT NULL,
  `max_leave_block` int(10) unsigned NOT NULL,
  `default_end_time` time NOT NULL,
  `holiday_login` tinyint(1) NOT NULL,
  `default_start_time` time NOT NULL default '09:00:00',
  `default_hours` time NOT NULL default '08:00:00',
  `year_start` date NOT NULL default '2007-01-01',
  `send_email` tinyint(1) unsigned NOT NULL default '1',
  `strict_password` tinyint(1) unsigned NOT NULL default '1',
  `page_size` int(10) unsigned NOT NULL default '5',
  `default_shift` int(10) unsigned NOT NULL,
  `default_shift_wend` int(10) unsigned NOT NULL,
  `inandout_code` varchar(10) NOT NULL default 'nocode',
  `hr_email_adr` varchar(100) NOT NULL default '',
  `show_disabled_items` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `countries` (
  `country_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY  (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `data_columns` (
  `column_id` int(10) unsigned NOT NULL auto_increment,
  `db_name` varchar(20) NOT NULL COMMENT 'the column name in the resultset',
  `title` varchar(50) NOT NULL COMMENT 'the visible column title',
  `sequence` smallint(5) unsigned NOT NULL,
  `type` char(1) NOT NULL COMMENT 'I(nteger), F(loat), T(ext), C(heckbox), S(election)',
  `align` char(1) NOT NULL COMMENT 'L,R,C,D (decimal)',
  `format` varchar(10) NOT NULL COMMENT 'a formatting string for sprintf',
  `width` mediumint(8) unsigned NOT NULL COMMENT 'the width of the column in the table view',
  `query` text NOT NULL,
  `size` smallint(5) unsigned NOT NULL COMMENT 'the physical size in the database, input fields will be limited to this',
  `editable` tinyint(1) NOT NULL COMMENT 'flag, true = can be edited in detail view',
  `required` tinyint(3) unsigned NOT NULL,
  `visible` tinyint(1) NOT NULL COMMENT 'flag, true = show in table view',
  `subject_id` int(10) unsigned NOT NULL,
  `comment` varchar(100) NOT NULL,
  PRIMARY KEY  (`column_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `dates` (
  `date_id` int(11) NOT NULL auto_increment,
  `short_date` date NOT NULL,
  `week` smallint(6) NOT NULL,
  `month` smallint(6) NOT NULL,
  `year` int(11) NOT NULL,
  `day` smallint(6) NOT NULL,
  `yearday` mediumint(9) NOT NULL,
  `weekday` varchar(10) NOT NULL,
  `month_name` varchar(10) NOT NULL,
  PRIMARY KEY  (`date_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Used for reporting purposes';
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `departments` (
  `dept_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default 'noname',
  `manager_id` int(10) unsigned NOT NULL default '1',
  `company_id` int(10) unsigned NOT NULL default '1',
  `visitor` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`dept_id`),
  KEY `idx_manager` (`manager_id`),
  KEY `idx_name` (`name`),
  KEY `idx_company` (`company_id`),
  CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `dependencies` (
  `dependency_id` int(10) unsigned NOT NULL auto_increment,
  `subject_id` int(10) unsigned NOT NULL,
  `table_name` varchar(20) NOT NULL,
  `key_name` varchar(20) NOT NULL,
  `subject_name` varchar(30) NOT NULL,
  PRIMARY KEY  (`dependency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `dept_blocks` (
  `dept_block_id` int(10) unsigned NOT NULL auto_increment,
  `dept_id` int(10) unsigned NOT NULL,
  `block_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`dept_block_id`),
  KEY `idx_dept` (`dept_id`),
  KEY `idx_block` (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `emp_half_days` (
  `half_day_id` int(10) unsigned NOT NULL auto_increment,
  `half_date` date NOT NULL,
  `start_time` time NOT NULL,
  `submit_date` date NOT NULL,
  `approved` tinyint(1) unsigned NOT NULL,
  `approved_by` int(10) unsigned NOT NULL,
  `approval_date` date NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `emp_id` int(10) unsigned NOT NULL,
  `note` varchar(100) NOT NULL,
  PRIMARY KEY  (`half_day_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `emp_leave` (
  `emp_leave_id` int(10) unsigned NOT NULL auto_increment,
  `emp_id` int(11) unsigned NOT NULL,
  `start_date` date NOT NULL default '0000-00-00',
  `end_date` date NOT NULL default '0000-00-00',
  `workdays` decimal(4,1) unsigned NOT NULL default '0.0',
  `type_id` int(11) unsigned NOT NULL,
  `is_half_day` tinyint(1) NOT NULL default '0',
  `is_am` tinyint(1) NOT NULL default '0',
  `note` text NOT NULL,
  `submit_date` date NOT NULL,
  `approved` tinyint(1) default '0',
  `approval_date` date NOT NULL,
  `approval_emp_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`emp_leave_id`),
  KEY `idx_type` (`type_id`),
  KEY `idx_start` (`start_date`),
  KEY `fk_emp_leave_emp` (`emp_id`),
  CONSTRAINT `emp_leave_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `leave_types` (`leave_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `emp_leave_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `emp_shifts` (
  `emp_shift_id` int(10) unsigned NOT NULL auto_increment,
  `emp_id` int(10) unsigned NOT NULL,
  `shift_id` int(10) unsigned NOT NULL,
  `shift_date` date NOT NULL,
  PRIMARY KEY  (`emp_shift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `employees` (
  `emp_id` int(11) unsigned NOT NULL auto_increment,
  `fname` varchar(30) NOT NULL default 'unknown',
  `sname` varchar(30) NOT NULL,
  `title_id` int(11) unsigned NOT NULL,
  `team_id` int(11) unsigned NOT NULL,
  `location_id` int(11) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL default '1',
  `payroll` varchar(20) NOT NULL default 'TBD',
  `keycode` varchar(10) NOT NULL default '9999',
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL default 'password',
  `email` varchar(60) NOT NULL,
  `max_leave` int(11) NOT NULL,
  `home_phone` varchar(15) NOT NULL,
  `mobile_phone` varchar(15) NOT NULL,
  `work_phone` varchar(15) NOT NULL,
  `leave_left` int(10) unsigned NOT NULL default '0',
  `enabled` tinyint(1) unsigned NOT NULL default '1',
  `monitored` tinyint(1) unsigned NOT NULL default '0',
  `user_level_id` int(10) unsigned NOT NULL default '1',
  `visitor` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`emp_id`),
  KEY `idx_title` (`title_id`),
  KEY `idx_team` (`team_id`),
  KEY `idx_location` (`location_id`),
  KEY `idx_name` (`sname`,`fname`),
  KEY `idx_company` (`company_id`),
  KEY `idx_email` (`email`),
  KEY `idx_payroll` (`payroll`),
  CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `employees_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `employees_ibfk_4` FOREIGN KEY (`title_id`) REFERENCES `titles` (`title_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `exceptions` (
  `exception_id` int(10) unsigned NOT NULL auto_increment,
  `emp_id` int(11) unsigned NOT NULL,
  `start_time` time NOT NULL default '00:00:00',
  `end_time` time NOT NULL,
  `exception_date` date NOT NULL default '0000-00-00',
  `submit_date` date NOT NULL,
  `approved` bit(1) NOT NULL,
  `approval_date` date NOT NULL,
  `approval_emp_id` int(10) unsigned NOT NULL,
  `reason` varchar(100) NOT NULL,
  PRIMARY KEY  (`exception_id`),
  KEY `fk_exception_emp` (`emp_id`),
  CONSTRAINT `exceptions_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `holidays` (
  `holiday_id` int(11) unsigned NOT NULL auto_increment,
  `hdate` date NOT NULL default '2000-01-01',
  `name` varchar(30) NOT NULL,
  `company_id` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`holiday_id`),
  KEY `idx_company` (`company_id`),
  CONSTRAINT `holidays_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `leave_types` (
  `leave_type_id` int(11) unsigned NOT NULL auto_increment,
  `company_id` int(10) unsigned NOT NULL default '1',
  `user_level` int(10) unsigned NOT NULL default '1',
  `approver_level` int(10) unsigned NOT NULL default '1',
  `name` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `isPaid` tinyint(1) unsigned NOT NULL default '0',
  `isAWOL` tinyint(1) unsigned NOT NULL default '0',
  `isAnnual` tinyint(1) unsigned NOT NULL default '0',
  `needsNote` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`leave_type_id`),
  KEY `fk_leave_type_comp` (`company_id`),
  CONSTRAINT `leave_types_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `locations` (
  `location_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `company_id` int(10) unsigned NOT NULL default '1',
  `addr1` varchar(40) NOT NULL,
  `addr2` varchar(40) NOT NULL,
  `town` varchar(40) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country_id` int(10) unsigned NOT NULL,
  `ipaddress` varchar(15) NOT NULL default '0.0.0.0',
  PRIMARY KEY  (`location_id`),
  UNIQUE KEY `idx_ip` (`ipaddress`),
  KEY `idx_company` (`company_id`),
  CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mail_templates` (
  `id` int(11) NOT NULL auto_increment,
  `template_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `body` mediumtext NOT NULL,
  `html_body` mediumtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_company_template` (`template_id`,`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `presence` (
  `presence_id` int(10) unsigned NOT NULL auto_increment,
  `emp_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `start_time` time NOT NULL default '00:00:00',
  `end_time` time NOT NULL default '00:00:00',
  `att_date` date NOT NULL default '0000-00-00',
  `start_type` int(10) unsigned NOT NULL default '9',
  `end_type` int(10) unsigned NOT NULL default '9',
  PRIMARY KEY  (`presence_id`),
  KEY `FK_pres_emp` (`emp_id`),
  KEY `FK_pres_loc` (`location_id`),
  CONSTRAINT `FK_pres_emp` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`),
  CONSTRAINT `FK_pres_loc` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `report_schedule` (
  `sched_id` int(10) unsigned NOT NULL auto_increment,
  `report_name` varchar(15) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `rb_type` varchar(15) NOT NULL,
  `rb_group` varchar(15) NOT NULL,
  `groups` varchar(100) NOT NULL,
  `rb_range` varchar(15) NOT NULL,
  `ranges` varchar(100) NOT NULL,
  `details` tinyint(3) unsigned NOT NULL,
  `subtotals` tinyint(3) unsigned NOT NULL,
  `totals` tinyint(3) unsigned NOT NULL,
  `mailto` varchar(100) NOT NULL,
  `sched_type` smallint(5) unsigned NOT NULL,
  `sched_day` smallint(5) unsigned NOT NULL,
  `format` varchar(10) NOT NULL,
  PRIMARY KEY  (`sched_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sessions` (
  `session_id` int(10) unsigned NOT NULL auto_increment,
  `user_name` varchar(45) NOT NULL default 'None',
  `session_time` timestamp NOT NULL default '0000-00-00 00:00:00',
  `user_level` smallint(5) unsigned NOT NULL default '0',
  `session_key` varchar(32) NOT NULL,
  `user_id` int(10) unsigned NOT NULL default '0',
  `company_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`session_id`),
  UNIQUE KEY `idx_session` (`session_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `shifts` (
  `shift_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `company_id` int(10) unsigned NOT NULL default '1',
  `description` varchar(100) NOT NULL,
  `start_time` time NOT NULL default '09:00:00',
  `end_time` time NOT NULL default '17:30:00',
  PRIMARY KEY  (`shift_id`),
  KEY `shifts_idx_company` (`company_id`),
  CONSTRAINT `shifts_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `subjects` (
  `subject_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `sequence` int(10) unsigned NOT NULL,
  `level` int(10) unsigned NOT NULL,
  `query` text NOT NULL,
  `help_url` varchar(80) NOT NULL,
  `parent` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `teams` (
  `team_id` int(10) unsigned NOT NULL auto_increment,
  `dept_id` int(11) unsigned NOT NULL,
  `name` varchar(30) NOT NULL default 'noname',
  `company_id` int(10) unsigned NOT NULL default '1',
  `visitor` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`team_id`),
  KEY `idx_name` (`name`),
  KEY `idx_company` (`company_id`),
  KEY `fk_team_dept` (`dept_id`),
  CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `teams_ibfk_2` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `template_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default 'none',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `time_zones` (
  `time_zone_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `time_diff` time NOT NULL,
  PRIMARY KEY  (`time_zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `titles` (
  `title_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY  (`title_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_levels` (
  `user_level_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(12) NOT NULL,
  PRIMARY KEY  (`user_level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `version` (
  `version` varchar(20) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
INSERT INTO `actions` VALUES (1,'Add Department',1,'','add',3),(2,'Add Team',2,'','add',3),(3,'Add Employee',3,'','add',3),(4,'Add Location',4,'','add',3),(5,'Add Shift',5,'','add',3),(6,'Add Holiday',6,'','add',3),(7,'Import',1,'import.php','import',3),(8,'Import',2,'import.php','import',3),(9,'Import',3,'import.php','import',3),(10,'Import',4,'import.php','import',3),(11,'Import',5,'import.php','import',3),(12,'Import',6,'import.php','import',3),(13,'Export',1,'export.php','export',3),(14,'Export',2,'export.php','export',3),(15,'Export',3,'export.php','export',3),(16,'Export',4,'export.php','export',3),(17,'Export',5,'export.php','export',3),(18,'Export',6,'export.php','export',3),(19,'Add Leave',10,'badlocation.php','add',1),(20,'Add an Exception',12,'badlocation.php','add',1),(21,'Add  Shift Allocation',9,'badlocation.php','add',2),(22,'Add an Attendance Record',11,'badlocation.php','add',3),(23,'Add Company',8,'badlocation.php','add',5),(24,'Add Department Block',18,'badlocation.php','add',2),(25,'Add Title',17,'badlocation.php','add',5),(26,'Add Country',16,'badlocation.php','add',5),(27,'Add Block',15,'badlocation.php','add',4),(28,'Add Leave Type',14,'badlocation.php','add',3),(29,'Add Business Year',19,'badlocation.php','add',4),(30,'Add Leave Allowance',20,'badlocation.php','add',3),(31,'Add Half-a-day Off',21,'badlocation.php','add',1);
INSERT INTO `att_types` VALUES (1,'Start Work'),(2,'Back from Break'),(3,'Transfer In'),(4,'Finish Work'),(5,'Out for Break'),(6,'Transfer Out'),(7,'Arrived'),(8,'Departed'),(9,'System/Adj.');
INSERT INTO `countries` VALUES (1,'United Kingdom'),(2,'Germany'),(3,'United States of America'),(4,'France'),(5,'Austria'),(6,'Spain'),(7,'Italy'),(8,'Portugal'),(9,'Ireland');
INSERT INTO `data_columns` VALUES (1,'name','Name',1,'C','L','',20,'',30,1,1,1,1,''),(2,'members','Staff',3,'N','R','',10,'',0,0,0,1,1,''),(3,'manager','Manager',2,'C','L','',20,'',0,0,0,1,1,''),(4,'dept_id','ID',0,'N','R','',5,'',0,0,0,0,1,''),(5,'team_id','ID',0,'N','R','',5,'',0,0,0,0,2,''),(6,'name','Name',1,'C','L','',20,'',30,1,1,1,2,''),(7,'deptname','Department',2,'C','L','',20,'',0,0,0,1,2,''),(8,'members','Staff',3,'N','R','',10,'',0,0,0,1,2,''),(9,'emp_id','ID',0,'N','R','',5,'',0,0,0,0,3,''),(10,'fname','First Name',2,'C','L','',11,'',30,1,1,1,3,''),(11,'sname','Surname',3,'C','L','',11,'',30,1,1,0,3,''),(12,'teamname','Team',4,'C','L','',11,'',0,0,0,1,3,''),(13,'deptname','Department',5,'C','L','',11,'',0,0,0,1,3,''),(14,'location','Location',6,'C','L','',11,'',0,0,0,1,3,''),(16,'taken','Taken',8,'N','R','',5,'',0,0,0,1,3,''),(17,'leave_left','Left',9,'N','R','',5,'',0,0,0,1,3,''),(18,'team_id','Team',9,'S','L','',20,'SELECT team_id as ID, name FROM teams WHERE company_id = %company%',30,1,1,0,3,''),(19,'location_id','Location',10,'S','L','',20,'SELECT location_id as ID, name FROM locations WHERE company_id = %company%',30,1,1,0,3,''),(20,'title_id','Title',4,'S','L','',20,'SELECT title_id as ID, name FROM titles',30,1,1,0,3,''),(21,'username','Username',5,'C','L','',15,'',20,1,1,0,3,''),(23,'keycode','Keycode',8,'C','L','',15,'',10,1,1,0,3,'This must be unique within the company!'),(24,'email','Email',11,'C','L','',40,'',60,1,0,0,3,''),(25,'home_phone','Phone (H)',12,'C','L','',20,'',15,1,1,0,3,''),(26,'work_phone','Phone (W)',13,'C','L','',20,'',15,1,0,0,3,''),(27,'mobile_phone','Phone (M)',14,'C','L','',20,'',15,1,0,0,3,''),(28,'location_id','ID',0,'N','R','',5,'',0,0,0,0,4,''),(29,'name','Name',1,'C','L','',15,'',45,1,1,1,4,''),(30,'addr1','Address (1)',2,'C','L','',15,'',40,1,0,1,4,''),(31,'addr2','Address (2)',3,'C','L','',15,'',40,1,0,1,4,''),(32,'town','Town/City',4,'C','L','',10,'',40,1,0,1,4,''),(33,'postcode','Post Code',5,'C','L','',8,'',10,1,0,1,4,''),(34,'country','Country',6,'C','L','',12,'',0,0,0,1,4,''),(35,'ipaddress','IP Address',7,'C','C','',10,'',15,1,1,1,4,''),(36,'country_id','Country',0,'S','L','',20,'SELECT country_id as ID, name from countries',30,1,1,0,4,''),(37,'shift_id','ID',0,'N','R','',5,'',0,0,0,0,5,''),(38,'name','Name',1,'C','L','',16,'',100,1,1,1,5,''),(39,'start_time','Start Time',2,'T','C','%05.5s',6,'',8,1,1,1,5,''),(40,'end_time','End Time',3,'T','C','%05.5s',6,'',8,1,1,1,5,''),(53,'name','Holiday',1,'C','L','',30,'',30,1,1,1,6,''),(54,'hdate','Date',2,'D','C','',12,'',12,1,1,1,6,''),(55,'manager_id','Manager',4,'S','L','',20,'SELECT emp_id as ID, concat(sname, \", \", fname) as name from employees where company_id = %company%',30,1,1,0,1,''),(56,'company_id','ID',0,'N','R','',5,'',0,0,0,0,8,''),(57,'name','Name',1,'C','L','',30,'',45,1,1,1,8,''),(58,'manager_id','General Manager',2,'S','L','',20,'SELECT emp_id as ID, concat(sname, \", \", fname) as name from employees where company_id = %company% ORDER BY name',30,1,1,0,8,''),(59,'double_login','Use separate logins for work/presence',3,'B','L','',10,'',10,1,0,0,8,''),(60,'lone_worker_warning','Show warning when penultimate employee leaves',4,'B','L','',10,'',10,1,0,0,8,''),(61,'show_self_cert','Show self certificate after absence',5,'B','L','',10,'',10,1,0,0,8,''),(62,'leave_login','Allow login during leave',6,'B','L','',10,'',10,1,0,0,8,''),(63,'holiday_login','Allow login on a holiday',7,'B','L','',10,'',10,1,0,0,8,''),(64,'max_leave_block','Biggest block of leave without escalation',8,'N','R','',10,'',10,1,1,0,8,''),(65,'default_end_time','Default work end time',9,'T','L','',15,'',15,1,1,1,8,''),(66,'default_start_time','Default work start time',10,'T','L','',15,'',15,1,1,1,8,''),(67,'default_hours','Hours in a work day',11,'T','L','',15,'',15,1,1,0,8,''),(68,'year_start','Start of the business year',12,'D','L','',15,'',15,1,1,0,8,''),(69,'send_email','Enable e-mail notifications',13,'B','L','',10,'',10,1,0,0,8,''),(70,'enabled','enabled',15,'B','C','',7,'',10,1,0,1,3,''),(71,'strict_password','Enforce strict password rules',14,'B','L','',10,'',10,1,0,0,8,'If enabled, passwords must have at least 8 chars, upper/lower case letters and numbers.'),(72,'user_level_id','Access Level',18,'S','L','',20,'SELECT user_level_id as ID, name from user_levels where user_level_id <= %userlevel%',20,1,1,0,3,''),(73,'block_id','ID',0,'N','R','',5,'',0,0,0,0,15,''),(74,'name','Reason',1,'C','L','',50,'',80,0,0,1,15,''),(75,'block_start','Start Date',2,'D','L','',10,'',10,1,1,1,15,''),(76,'block_end','End Date',3,'D','L','',10,'',10,1,1,1,15,''),(77,'title_id','ID',0,'N','R','',5,'',5,0,0,0,17,''),(78,'name','Title',1,'C','L','',40,'',40,1,1,1,17,''),(79,'country_id','ID',0,'N','R','',5,'',5,0,0,0,16,''),(80,'name','Country',1,'C','L','',40,'',40,1,1,1,16,''),(81,'emp_leave_id','ID',0,'N','R','',5,'',0,0,0,0,10,''),(82,'emp_id','Employee',1,'N','R','',5,'',0,0,0,0,10,''),(83,'start_date','First Day',2,'D','L','',8,'',10,1,1,1,10,'The first day you are NOT at work'),(84,'end_date','Last Day',3,'D','L','',8,'',10,1,1,1,10,'The last day you are NOT at work'),(85,'type_id','Leave Type',20,'S','L','',10,'SELECT leave_type_id as ID, name FROM leave_types where company_id = %company% ORDER BY name ASC',10,1,1,0,10,''),(86,'note','Comments',35,'C','L','',20,'',200,1,0,1,10,''),(87,'submit_date','Submitted on',40,'D','L','',8,'',15,0,0,1,10,''),(88,'approved','Appr.',12,'N','C','',4,'',5,0,0,1,10,''),(89,'name','Leave Type',4,'C','L','',8,'',10,0,0,1,10,''),(90,'approved_by','Approver',45,'C','L','',8,'',15,0,0,1,10,''),(91,'approval_date','Appr. on',50,'D','L','',8,'',10,0,0,1,10,''),(92,'leave_type_id','ID',0,'N','R','',5,'',0,0,0,0,14,''),(93,'name','Type Name',1,'C','L','',15,'',15,1,1,1,14,''),(94,'description','Description',2,'C','L','',50,'',100,1,0,0,14,''),(95,'isPaid','Paid Leave',3,'B','C','',10,'',10,1,0,1,14,'This is leave that the company pays for'),(96,'isAWOL','AWOL',4,'B','C','',10,'',10,1,0,1,14,'This type constitutes \"absent without leave\"'),(97,'isAnnual','Annual',5,'B','C','',10,'',10,1,0,1,14,'This type of leave counts towards the annual allowance'),(98,'dept_block_id','ID',0,'N','R','',5,'',0,0,0,0,18,''),(99,'name','Block',1,'C','L','',20,'',20,0,0,1,18,''),(100,'block_start','Start Date',2,'D','C','',15,'',15,0,0,1,18,''),(101,'block_end','End date',3,'D','C','',15,'',15,0,0,1,18,''),(102,'block_id','Block',4,'S','L','',20,'SELECT block_id as ID, reason as name FROM blocks WHERE company_id = %company% ORDER BY name asc',20,1,1,0,18,''),(103,'exception_id','ID',0,'N','R','',5,'',0,0,0,0,12,''),(104,'emp_id','Employee',0,'N','R','',5,'',0,0,0,0,12,''),(105,'exception_date','Date',1,'D','C','',8,'',10,1,1,0,12,''),(106,'start_time','Start',3,'T','C','',8,'',10,1,1,1,12,''),(107,'end_time','End',4,'T','C','',8,'',10,1,1,1,12,''),(108,'reason','Reason',2,'C','L','',25,'',200,1,0,1,12,''),(109,'name','Date',1,'D','C','',8,'',10,0,0,1,12,''),(110,'approved','Appr.',5,'B','C','',5,'',5,0,0,1,12,''),(111,'approval_date','Appr. On',6,'D','C','',8,'',10,0,0,1,12,''),(112,'approved_by','Approver',7,'C','L','',15,'',15,0,0,1,12,''),(113,'annual_leave_id','ID',0,'N','L','',5,'',5,0,0,0,20,''),(114,'name','Year',1,'C','L','',10,'',10,0,0,1,20,''),(115,'allowance','Allowance',4,'N','L','',10,'',10,1,1,1,20,''),(116,'leave_left','Leave Left',5,'N','L','',10,'',10,0,0,1,20,''),(117,'name','Year',1,'C','L','',10,'',10,0,1,1,19,''),(118,'year_start','Start of year',2,'D','C','',10,'',10,1,1,1,19,''),(119,'year_end','End of year',3,'D','C','',10,'',10,1,1,1,19,''),(120,'business_year_id','ID',0,'N','L','',5,'',0,0,0,0,19,''),(121,'year_name','Year',1,'C','L','',10,'',10,1,1,0,19,''),(122,'year_id','Business Year',1,'S','L','',15,'SELECT business_year_id as ID, year_name as name FROM business_years WHERE company_id = %company%',15,1,1,0,20,''),(123,'dept_id','Department',4,'S','L','',15,'SELECT d.dept_id as ID, d.name FROM departments d WHERE company_id=%company% ORDER BY name',15,1,1,0,2,''),(124,'emp_shift_id','ID',0,'N','L','',0,'',0,0,0,0,9,''),(125,'emp_id','Employee',1,'N','L','',0,'',0,0,0,0,9,''),(126,'shift_id','Shift',2,'S','L','',15,'SELECT shift_id as ID, name FROM shifts WHERE company_id = %company% ORDER BY name',15,1,1,0,9,''),(127,'shift_date','Date',3,'D','C','',10,'',10,1,1,1,9,''),(129,'shift','Shift',4,'C','L','',25,'',25,0,0,1,9,''),(130,'default_shift','Default Shift',15,'S','L','',15,'SELECT shift_id as ID, name FROM shifts WHERE company_id=%company% ORDER BY name',15,1,1,0,8,''),(131,'year_start','From',2,'D','C','',10,'',10,0,0,1,20,''),(132,'year_end','To',3,'D','C','',10,'',10,0,0,1,20,''),(134,'allowance','Leave All.',7,'N','R','',5,'',5,0,0,1,3,''),(135,'name','Surname',3,'C','L','',11,'',11,0,0,1,3,''),(136,'page_size','Page Size (in table view)',17,'N','R','',5,'',5,1,1,0,8,''),(137,'password','Password',7,'P','L','',11,'',11,1,1,0,3,''),(138,'reason','Reason for Block',4,'C','L','',50,'',200,1,1,0,15,''),(139,'default_shift_wend','Default Weekend Shift',16,'S','L','',15,'SELECT shift_id as ID, name FROM shifts WHERE company_id=%company% ORDER BY name',15,1,1,0,8,''),(140,'description','Description',4,'C','L','',100,'',200,1,1,0,5,''),(141,'start_time','Start',5,'T','C','',10,'',10,0,0,1,9,''),(142,'end_time','End',6,'T','C','',10,'',10,0,0,1,9,''),(143,'weekday','',2,'C','R','',10,'',10,0,0,1,9,''),(144,'name','Date',0,'D','C','',8,'',8,0,0,1,21,''),(145,'half_date','Date',0,'D','C','',11,'',11,1,1,0,21,''),(146,'start_time','From',1,'T','C','',11,'',11,1,1,1,21,''),(147,'submit_date','Submitted on',2,'D','C','',11,'',11,0,0,1,21,''),(148,'approved','Approved',3,'B','L','',5,'',5,0,0,1,21,''),(149,'approver','Appr. By',4,'C','L','',15,'',15,0,0,1,21,''),(150,'approval_date','Appr. On',5,'D','C','',11,'',11,0,0,1,21,''),(151,'type','Leave type',3,'C','L','',10,'',10,0,0,1,21,''),(152,'type_id','Leave Type',3,'S','L','',10,'SELECT leave_type_id  as ID, name FROM leave_types WHERE company_id = %company%',10,1,1,0,21,''),(153,'visitor','Visitor',5,'B','C','',10,'',10,1,0,1,1,''),(154,'visitor','Visitor',5,'B','C','',10,'',10,1,0,1,2,''),(155,'visitor','Visitor',17,'B','C','',10,'',10,1,0,0,3,''),(156,'is_am','AM/PM',30,'B','L','',5,'',5,1,0,0,10,'Tick if the half day is in the morning'),(157,'is_half_day','Half Day',25,'B','L','',5,'',5,1,0,1,10,''),(158,'hr_email_adr','HR Email Address',18,'C','L','',10,'',50,1,0,0,8,''),(159,'show_disabled_items','Show disabled employees',19,'B','L','',10,'',10,1,0,0,8,''),(160,'payroll','Payroll',1,'C','C','',6,'',20,1,1,1,3,''),(161,'needsNote','Note required',6,'B','C','',10,'',10,1,0,0,14,'Tick this if employees must add a note when applying for leave of this type'),(162,'user_level','User Level',7,'S','L','',20,'SELECT user_level_id as ID, name from user_levels where user_level_id <= %userlevel% order by id asc;',20,1,1,0,14,'The minimum user level required to use this leave type'),(163,'approver_level','Appr. Level',8,'S','L','',20,'SELECT user_level_id as ID, name from user_levels where user_level_id <= %userlevel% order by id asc;',20,1,0,0,14,'The minimum user level required to approve an application of this type'),(164,'inandout_code','Access Code',20,'C','L','',10,'',10,1,1,0,8,'This is the code required to access the \"In & Out\" page.'),(165,'name','Template',0,'S','L','',20,'SELECT template_id as ID, name from template_types',20,0,0,1,22,''),(166,'subject','Email Subject',1,'C','L','',50,'',50,1,1,1,22,''),(167,'body','Text Body',2,'M','L','',80,'',8,1,1,0,22,''),(168,'html_body','HTML Body',3,'E','L','',80,'',12,1,1,0,22,''),(169,'manager','General Manager',2,'C','L','',20,'',30,0,0,1,8,''),(170,'taken','Taken',15,'N','C','',4,'',5,0,0,1,10,''),(171,'booked','Booked',10,'N','C','',4,'',5,0,0,1,10,''),(172,'monitored','Monitor Attendance',16,'B','C','',4,'',5,1,0,0,3,''),(173,'contact_phone','Contact Phone No.',21,'C','L','',20,'',20,1,1,1,8,'This phone no appears on your ID cards');
INSERT INTO `dependencies` VALUES (1,3,'annual_leave','emp_id','leave allowances'),(2,3,'emp_leave','emp_id','leave applications'),(3,3,'emp_half_days','emp_id','half day leave applications'),(4,3,'emp_shifts','emp_id','shift schedules'),(5,3,'exceptions','emp_id','exception applications'),(6,3,'attendance','emp_id','attendance records'),(7,2,'employees','team_id','employees'),(8,1,'dept_blocks','dept_id','department blocks'),(9,19,'annual_leave','year_id','leave allowances'),(10,5,'emp_shifts','shift_id','shift schedules'),(11,1,'teams','dept_id','teams'),(12,4,'employees','location_id','employees'),(13,14,'emp_leave','type_id','leave applications'),(14,3,'emp_leave','approval_emp_id','leave applications'),(15,3,'exceptions','approval_emp_id','exception applications'),(16,3,'emp_half_days','approved_by','half day leave applications'),(17,15,'dept_blocks','block_id','department blocks'),(18,16,'locations','country_id','locations'),(19,17,'employees','title_id','employees');
INSERT INTO `subjects` VALUES (1,'Departments',1,2,'SELECT d.dept_id, d.name , sum(if(e.emp_id is not null and e.enabled = 1,1,0))  as members, concat(e2.sname,\", \",e2.fname) as manager, d.visitor\r\nFROM departments d LEFT JOIN teams t using (dept_id) LEFT JOIN employees e on t.team_id = e.team_id LEFT JOIN employees e2 on d.manager_id = e2.emp_id \r\nWHERE d.company_id = %company% GROUP BY d.name ORDER BY %order%','http://www.latrix.org.uk/node/30',0),(2,'Teams',2,2,'SELECT t.team_id, t.name, d.name as deptname, sum(if(emp_id is not null and e.enabled = 1,1,0)) as members, t.visitor\r\nFROM teams t INNER JOIN departments d using (dept_id) LEFT JOIN employees e on t.team_id = e.team_id\r\nWHERE t.company_id = %company% GROUP BY t.name ORDER BY %order%','http://www.latrix.org.uk/node/31',0),(3,'Employees',3,1,'SELECT e.emp_id, e.payroll, e.fname, e.sname as name, t.name as teamname, d.name as deptname, l.name as location, \na.allowance, a.allowance - a.leave_left as taken, a.leave_left, e.enabled\nFROM employees e INNER JOIN teams t using (team_id)\nINNER JOIN departments d using (dept_id) INNER JOIN locations l on e.location_id = l.location_id\nLEFT JOIN (annual_leave a INNER JOIN business_years b ON a.year_id = b.business_year_id AND b.year_start <= curdate() AND b.year_end >= curdate()) ON a.emp_id = e.emp_id \nWHERE e.company_id = %company%\nORDER BY %order%','http://www.latrix.org.uk/node/32',0),(4,'Locations',4,3,'SELECT l.location_id, l.name, l.addr1, l.addr2, l.town, l.postcode, c.name as country, l.ipaddress\r\nFROM locations l INNER JOIN countries c using (country_id)\r\nWHERE l.company_id = %company%\r\nORDER BY %order%','http://www.latrix.org.uk/node/38',0),(5,'Shifts',5,3,'SELECT s.* FROM shifts s WHERE company_id = %company%\r\nORDER BY %order%','http://www.latrix.org.uk/node/39',0),(6,'Holidays',6,3,'SELECT h.holiday_id, h.hdate, h.name FROM holidays h\r\nWHERE company_id = %company% ORDER BY %order%','http://www.latrix.org.uk/node/40',0),(7,'Reports',8,1,'','',0),(8,'Config',9,4,'SELECT c.company_id, c.name, concat(e.fname, \", \", e.sname) as manager, c.double_login, c.lone_worker_warning,\r\nc.show_self_cert, c.contact_phone, c.leave_login, c.holiday_login, c.max_leave_block, c.default_start_time, c.default_end_time\r\nFROM companies c LEFT JOIN employees e on c.manager_id = e.emp_id\r\nWHERE c.company_id = %company% ORDER BY %order%','http://www.latrix.org.uk/node/43',0),(9,'Shift Schedule',0,3,'SELECT es.emp_shift_id, date_format(es.shift_date,\'%W\') as weekday, es.shift_date, s.name as shift, s.start_time, s.end_time\r\nFROM emp_shifts es INNER JOIN shifts s USING (shift_id) \r\nWHERE es.emp_id = %employee%\r\nORDER BY %order%','http://www.latrix.org.uk/node/37',3),(10,'Leave',0,3,'SELECT el.emp_leave_id, el.start_date, el.end_date, if(el.approval_emp_id = 0, el.workdays, 0) as booked,\nif(el.approval_emp_id != 0 and el.end_date >= curdate(), workdays,0) as approved, \nif(el.approval_emp_id != 0 and el.end_date < curdate(), workdays, 0) as taken,\nlt.name as name, el.note, el.approval_date,\r\nel.submit_date, concat(e.sname, \', \',e.fname) as approved_by, el.emp_id, el.is_half_day, el.is_am\r\nFROM emp_leave el inner join leave_types lt on el.type_id = lt.leave_type_id\r\nleft join employees e on el.approval_emp_id = e.emp_id inner join employees ec on el.emp_id = ec.emp_id \ninner join business_years bu on ec.company_id = bu.company_id and bu.year_start <= curdate() and bu.year_end >= curdate()\r\nWHERE el.start_date > date_sub(curdate(), interval 180 day) AND\nel.emp_id = %employee% ORDER BY %order%','http://www.latrix.org.uk/node/35',3),(11,'Attendance',0,3,'SELECT a.attendance_id, a.att_date, a.start_time, s.start_type, a.end_time, a.end_type, l.name\r\nFROM attendance a INNER JOIN locations l using (location_id)\r\nWHERE a.emp_id = %employee%\r\nORDER BY %order%','http://www.latrix.org.uk/node/30',3),(12,'Exceptions',0,3,'SELECT ee.exception_id, ee.start_time, ee.end_time, ee.exception_date as name, ee.reason, ee.submit_date, ee.approved,\r\nee.approval_date, concat(e.sname,\', \', e.fname) as approved_by, ee.emp_id\r\nFROM exceptions ee LEFT JOIN employees e on ee.approval_emp_id = e.emp_id\r\nWHERE ee.emp_id = %employee%\r\nORDER BY %order%','http://www.latrix.org.uk/node/36',3),(13,'Holidays',0,3,'SELECT h.holiday_id, h.hdate as holiday, h.name FROM holidays h\r\nWHERE company_id = %company% ORDER BY %order%','http://www.latrix.org.uk/node/40',8),(14,'Leave Types',0,3,'SELECT lt.leave_type_id, lt.name, lt.description, lt.isPaid, lt.isAWOL, lt.isAnnual \r\nFROM leave_types lt WHERE company_id = %company%\r\nORDER BY %order%','http://www.latrix.org.uk/node/43',8),(15,'Blocks',7,3,'SELECT b.block_id, b.reason as name, b.block_start, b.block_end FROM blocks b WHERE company_id = %company% ORDER BY %order%','http://www.latrix.org.uk/node/41',0),(16,'Countries',0,5,'SELECT * FROM countries ORDER BY %order%','http://www.latrix.org.uk/node/43',8),(17,'Titles',0,4,'SELECT * FROM titles ORDER BY %order%','http://www.latrix.org.uk/node/43',8),(18,'Department Blocks',0,2,'SELECT db.dept_block_id, b.reason as name, b.block_start, b.block_end FROM dept_blocks db\r\nINNER JOIN blocks b using (block_id) WHERE db.dept_id = %department% ORDER BY %order%','http://www.latrix.org.uk/node/41',1),(19,'Business Years',0,4,'SELECT business_year_id, year_name as name, year_start, year_end FROM business_years WHERE company_id=%company% ORDER BY %order%','http://www.latrix.org.uk/node/34',8),(20,'Annual Leave',0,3,'SELECT a.annual_leave_id, b.year_name as name, a.allowance, a.leave_left, a.emp_id, b.year_start, b.year_end\r\nFROM annual_leave a INNER JOIN business_years b ON a.year_id = b.business_year_id\r\nWHERE a.emp_id = %employee% ORDER BY %order%','http://www.latrix.org.uk/node/34',3),(21,'Half days off',0,1,'SELECT eh.half_day_id, eh.half_date as name, eh.start_time, eh.submit_date, eh. approved, eh.approval_date, \r\nconcat(e.fname, \' \', e.sname) as approver, lt.name as type, eh.emp_id\r\nFROM emp_half_days eh LEFT JOIN employees e on eh.approved_by = e.emp_id INNER JOIN leave_types lt ON eh.type_id = lt.leave_type_id\r\nWHERE eh.emp_id = %employee% \r\nORDER BY %order%','http://www.latrix.org.uk/node/30',3),(22,'Email Templates',0,4,'SELECT m.id, tt.name, m.subject, m.body, m.html_body\nFROM mail_templates m INNER JOIN template_types tt on m.template_id = tt.id\nWHERE company_id = %company% ORDER BY %order%','http://www.latrix.org.uk/node/43',8);
INSERT INTO `template_types` VALUES (1,'Leave application to employee'),(2,'Leave application to manager'),(3,'Leave approval to employee'),(4,'Leave approval to manager'),(5,'New employee to employee'),(6,'New employee to manager'),(7,'Employee disabled to employee'),(8,'Employee disabled to manager'),(9,'Leave application deleted to employee'),(10,'Leave application deleted to manager'),(11,'Exception application to employee'),(12,'Exception application to manager'),(13,'Exception approval to employee'),(14,'Exception approval to manager'),(15,'Exception application deleted to employee'),(16,'Exception application deleted to manager');
INSERT INTO `titles` VALUES (1,'Mr.'),(2,'Mrs.'),(3,'Ms.'),(4,'Dr.');
INSERT INTO `user_levels` VALUES (1,'Employee'),(2,'Manager'),(3,'HR/Admin'),(4,'GM/Director'),(5,'Owner');
INSERT INTO `mail_templates` VALUES (1,1,1,'Leave application submitted','Dear %emp%,\n\nyour application for %days% of %leavetype% leave, starting from %start% and\nending on %end%, has been received. Please note that if you do\nnot wish to use this leave, you must cancel it using the LATRIX administration tool.\n\nbest regards\n\nthe LATRIX website',''),(2,2,1,'Leave application submitted','Dear %receiver%,\n\nYour staff member %emp% has applied for %leavetype% leave.\nStart: %start%\nEnd:   %end%\nDays:  %days%\n\nPlease go to http://www.latrix.co.uk/admin and either approve, decline or escalate the application.\n\nbest regards\n\nthe LATRIX website',''),(3,3,1,'Leave application %result%','Dear %emp%,\n\nyour application for %days% of %leavetype% leave, starting from %start% and\nending on %end%, has been %result% by your manager. Please note that if you do\nnot wish to use this leave, you must cancel it using the LATRIX administration tool.\n\nbest regards\n\nthe LATRIX website\n',''),(4,4,1,'Leave application %result%','Dear %receiver%,\n\nyou have %result% this application : %emp%, starting from %start% and\nending on %end%, for a total of %days% of %leave_type% leave. If you believe that an error was made, please visit \nhttp://www.latrix.co.uk/admin and correct the mistake.\n\nbest regards\n\nthe LATRIX website\n',''),(5,5,1,'New employee registered','Dear %emp%,\n\nWelcome to the LATRIX. \nThe LATRIX is an easy-to-use website for the recording of presence and attendance at your place of work. Most likely your employer is using this system to fulfill his legal duty of keeping a fire register.\nPlease contact your HR team to receive a barcode card, a swipe card or a keycode number, that will allow you to use this system. \nYou can change your own details registered on the system by visiting http://www.latrix.co.uk/admin and using the\nfollowing details to log in:\n\nYour username: %username%\nYour password: %password%\n\nPlease note that you must use the LATRIX to apply for leave (any type of) or other periods of absence from, work, and that these applications must be approved by your line manager before you can use them. If this does not happen, you will\nbe recorded as AWOL (absent without leave), which may have severe disciplinary consequences.\n\nbest regards\n\nthe LATRIX website\n',''),(6,6,1,'New employee registered','Dear %receiver%,\n\nA new employee has been registered as a member of your team: %emp%. Please take the time to introduce him to the\nfunctions offered by the LATRIX and make him aware of this duties and obligations.\n\nbest regards\n\nthe LATRIX website\n',''),(7,7,1,'LATRIX Account disabled','Dear %emp%,\n\nYour account in the LATRIX has been disabled with effect from %curdate%. You will not be able to use any of the functionality offered by the LATRIX. If you believe that a mistake has been made, please contact your line manager or your HR team.\n\nbest regards\n\nthe LATRIX website\n',''),(8,8,1,'LATRIX Account disabled','Dear %receiver%,\n\nThe account in the LATRIX for %emp% has been disabled with effect from %curdate%. He will not be able to use any of the functionality offered by the LATRIX. If you believe that a mistake has been made, please visit http://www.latrix.co.uk/admin or contact your HR team.\n\nbest regards\n\nthe LATRIX website\n',''),(9,9,1,'Leave application canceled','Dear %emp%,\n\nYour application for %leavetype% leave of %days%, starting from %start% and ending on %end%, has been canceled. \nIf you believe that a mistake has been made, please visit http://www.latrix.co.uk/admin and use your login credentials to correct the mistake or contact your HR team.\n\nbest regards\n\nthe LATRIX website\n',''),(10,10,1,'Leave application canceled','Dear %receiver%,\n\nA leave application for your staff member %emp%, for %leavetype% leave of %days%, starting from %start% and ending on %end%, has been canceled. \nIf you believe that a mistake has been made, please visit http://www.latrix.co.uk/admin and use your login credentials to correct the mistake or contact your HR team.\n\nbest regards\n\nthe LATRIX website\n',''),(11,1,1,'Leave application submitted','Dear %emp%,\n\nyour application for %days% of %leavetype% leave, starting from %start% and\nending on %end%, has been received. Please note that if you do\nnot wish to use this leave, you must cancel it using the LATRIX administration tool.\n\nbest regards\n\nthe LATRIX website',''),(12,2,1,'Leave application submitted','Dear %receiver%,\n\nYour staff member %emp% has applied for %leavetype% leave.\nStart: %start%\nEnd:   %end%\nDays:  %days%\n\nPlease go to http://www.latrix.co.uk/admin and either approve, decline or escalate the application.\n\nbest regards\n\nthe LATRIX website',''),(13,3,1,'Leave application %result%','Dear %emp%,\n\nyour application for %days% of %leavetype% leave, starting from %start% and\nending on %end%, has been %result% by your manager. Please note that if you do\nnot wish to use this leave, you must cancel it using the LATRIX administration tool.\n\nbest regards\n\nthe LATRIX website\n',''),(14,4,1,'Leave application %result%','Dear %receiver%,\n\nyou have %result% this application : %emp%, starting from %start% and\nending on %end%, for a total of %days% of %leave_type% leave. If you believe that an error was made, please visit \nhttp://www.latrix.co.uk/admin and correct the mistake.\n\nbest regards\n\nthe LATRIX website\n',''),(15,5,1,'New employee registered','Dear %emp%,\n\nWelcome to the LATRIX. \nThe LATRIX is an easy-to-use website for the recording of presence and attendance at your place of work. Most likely your employer is using this system to fulfill his legal duty of keeping a fire register.\nPlease contact your HR team to receive a barcode card, a swipe card or a keycode number, that will allow you to use this system. \nYou can change your own details registered on the system by visiting http://www.latrix.co.uk/admin and using the\nfollowing details to log in:\n\nYour username: %username%\nYour password: %password%\n\nPlease note that you must use the LATRIX to apply for leave (any type of) or other periods of absence from, work, and that these applications must be approved by your line manager before you can use them. If this does not happen, you will\nbe recorded as AWOL (absent without leave), which may have severe disciplinary consequences.\n\nbest regards\n\nthe LATRIX website\n',''),(16,6,1,'New employee registered','Dear %receiver%,\n\nA new employee has been registered as a member of your team: %emp%. Please take the time to introduce him to the\nfunctions offered by the LATRIX and make him aware of this duties and obligations.\n\nbest regards\n\nthe LATRIX website\n','');
