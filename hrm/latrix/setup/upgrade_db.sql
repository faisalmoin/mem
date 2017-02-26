/* [ANY] */
/* Before version 0.6.0, there was no proper upgrade script and version were not registered in the database*/
/* In consequence we have to assume that any site that has not got a version, is actually V0.5.1a */

ALTER TABLE `companies` ADD COLUMN `contact_phone` VARCHAR(20)  NOT NULL AFTER `name`;
INSERT INTO data_columns VALUES(default, 'contact_phone', 'Contact Phone No.', 21, 'C','L','', 20, '', 20, 1,1,1,8, 
'This phone no appears on your ID cards');

UPDATE subjects SET query = 'SELECT t.team_id, t.name, d.name as deptname, sum(if(emp_id is not null and e.enabled = 1,1,0)) as members
FROM teams t INNER JOIN departments d using (dept_id) LEFT JOIN employees e on t.team_id = e.team_id
WHERE t.company_id = %company% GROUP BY t.name ORDER BY %order%' where subject_id = 2;

UPDATE subjects SET query = 'SELECT d.dept_id, d.name , sum(if(e.emp_id is not null and e.enabled = 1,1,0))  as members, concat(e2.sname,", ",e2.fname) as manager
FROM departments d LEFT JOIN teams t using (dept_id) LEFT JOIN employees e on t.team_id = e.team_id LEFT JOIN employees e2 on d.manager_id = e2.emp_id 
WHERE d.company_id = %company% GROUP BY d.name ORDER BY %order%' WHERE subject_id = 1;

UPDATE subjects SET query = 'SELECT c.company_id, c.name, concat(e.fname, ", ", e.sname) as manager, c.double_login, c.lone_worker_warning,
c.show_self_cert, c.contact_phone, c.leave_login, c.holiday_login, c.max_leave_block, c.default_start_time, c.default_end_time
FROM companies c LEFT JOIN employees e on c.manager_id = e.emp_id
WHERE c.company_id = %company% ORDER BY %order%' WHERE subject_id = 8;

ALTER TABLE `subjects` ADD COLUMN `help_url` VARCHAR(80)  NOT NULL AFTER `query`;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/30' WHERE subject_id = 1;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/31' WHERE subject_id = 2;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/32' WHERE subject_id = 3;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/38' WHERE subject_id = 4;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/39' WHERE subject_id = 5;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/40' WHERE subject_id = 6;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/43' WHERE subject_id = 8;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/37' WHERE subject_id = 9;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/35' WHERE subject_id = 10;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/30' WHERE subject_id = 11;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/36' WHERE subject_id = 12;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/40' WHERE subject_id = 13;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/43' WHERE subject_id = 14;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/41' WHERE subject_id = 15;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/43' WHERE subject_id = 16;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/43' WHERE subject_id = 17;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/41' WHERE subject_id = 18;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/34' WHERE subject_id = 19;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/34' WHERE subject_id = 20;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/30' WHERE subject_id = 21;
UPDATE subjects SET help_url = 'http://www.latrix.org.uk/node/43' WHERE subject_id = 22;

CREATE TABLE `version` (
  `version` VARCHAR(20)  NOT NULL DEFAULT ''
)
ENGINE = MyISAM;

INSERT INTO version VALUES ('0.6.0');