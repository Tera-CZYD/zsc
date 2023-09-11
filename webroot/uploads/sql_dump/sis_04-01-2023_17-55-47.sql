--
-- Pierre Baron 
-- export de la base `dblg1idkieu9g4` au 04-01-2023
--


-- -----------------------------
-- creation de la base `dblg1idkieu9g4`
-- -----------------------------
CREATE DATABASE `dblg1idkieu9g4` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dblg1idkieu9g4`;

-- --------------------------------------------------------

--
-- Structure de la table `backup_files`
--
CREATE TABLE `backup_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(500) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- entrees dans la table `backup_files`
--


-- --------------------------------------------------------


--
-- Structure de la table `memos`
--
CREATE TABLE `memos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `employeeNumber` varchar(255) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `memo_to` varchar(255) DEFAULT NULL,
  `subject` varchar(1000) DEFAULT NULL,
  `memo` varchar(1000) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `visible` tinyint(4) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- entrees dans la table `memos`
--
INSERT INTO memos (`id`, `code`, `employee_id`, `employeeNumber`, `employee_name`, `memo_to`, `subject`, `memo`, `date`, `visible`, `created`, `modified`) VALUES ('1', 'MEMO-00001', '13', '202200019', '202200019 - RAYMOND, LLOBRERA - (Permanent)', 'ALL ZSCMST EMPLOYEES', 'PRESCRIBED ATTIRE DURING THE VISIT  OF DR. J. PROSPERO DE VERA', 'The Chairperson of the Commission on Higher Education (CHED) DR. J. PROSPERO DE VERA is scheduled for a visit to our College tomorrow June 23, 2022, In view thereof all ZSCMST Employees are required to wear white polo/shirt with collar during the visit.', '2022-09-24', '1', '2022-09-24 13:50:55', '2022-09-24 13:50:55');
INSERT INTO memos (`id`, `code`, `employee_id`, `employeeNumber`, `employee_name`, `memo_to`, `subject`, `memo`, `date`, `visible`, `created`, `modified`) VALUES ('2', 'MEMO-00001', '16', '202200014', '202200014 - SAN PEDRO, MA FATIMA PATDU - (Contractual)', 'MCP INC. TEAM', 'ANNIVERSARY CELEBRATION', 'GET TOGETHER 3PM', '2022-09-24', '1', '2022-09-24 16:04:01', '2022-09-24 16:04:01');
INSERT INTO memos (`id`, `code`, `employee_id`, `employeeNumber`, `employee_name`, `memo_to`, `subject`, `memo`, `date`, `visible`, `created`, `modified`) VALUES ('3', 'MEMO-00001', '2', '202200021', '202200021 - VALDEZ, RANZ LOPEZ - (Coterminous)', 'HR DEPT', 'RECRUITMENT', 'RECRUITMENT', '2022-09-27', '1', '2022-09-27 08:54:05', '2022-09-27 08:54:05');
INSERT INTO memos (`id`, `code`, `employee_id`, `employeeNumber`, `employee_name`, `memo_to`, `subject`, `memo`, `date`, `visible`, `created`, `modified`) VALUES ('4', 'MEMO-00001', '16', '202200014', '202200014 - SAN PEDRO, MA FATIMA PATDU - (Contractual)', 'ALL EMPLOYEES', '123', '123', '2022-10-02', '1', '2022-10-02 23:03:15', '2022-10-02 23:03:15');
INSERT INTO memos (`id`, `code`, `employee_id`, `employeeNumber`, `employee_name`, `memo_to`, `subject`, `memo`, `date`, `visible`, `created`, `modified`) VALUES ('5', 'MEMO-00001', '1', '0001', '0001 - JALON, JAIME GARCING - (Permanent)', 'ALL', 'HOLIDAY', 'NO WORK', '2022-11-11', '1', '2022-11-11 10:49:08', '2022-11-11 10:49:08');
INSERT INTO memos (`id`, `code`, `employee_id`, `employeeNumber`, `employee_name`, `memo_to`, `subject`, `memo`, `date`, `visible`, `created`, `modified`) VALUES ('6', 'MEMO-00001', '91', '0091', '0091 - ABUBAKAR, ALUYA ELHANO - (Permanent)', 'ALL EMPLOYEES', 'FLAG CEREMONY', 'FLAG CEREMONY', '2022-11-13', '1', '2022-11-13 21:32:37', '2022-11-13 21:32:37');


-- --------------------------------------------------------


--
-- Structure de la table `permissions`
--
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- entrees dans la table `permissions`
--
INSERT INTO permissions (`id`, `module`, `action`, `visible`, `created`, `modified`) VALUES ('1', 'permission management', 'index', '1', '2023-01-04 13:54:08', '2023-01-04 13:54:08');
INSERT INTO permissions (`id`, `module`, `action`, `visible`, `created`, `modified`) VALUES ('2', 'permission management', 'add', '1', '2023-01-04 13:58:44', '2023-01-04 13:58:44');
INSERT INTO permissions (`id`, `module`, `action`, `visible`, `created`, `modified`) VALUES ('3', 'permission management', 'edit', '1', '2023-01-04 13:58:48', '2023-01-04 13:58:48');
INSERT INTO permissions (`id`, `module`, `action`, `visible`, `created`, `modified`) VALUES ('4', 'role management', 'index', '1', '2023-01-04 14:00:16', '2023-01-04 14:00:16');
INSERT INTO permissions (`id`, `module`, `action`, `visible`, `created`, `modified`) VALUES ('5', 'user management', 'index', '1', '2023-01-04 14:00:57', '2023-01-04 14:00:57');
INSERT INTO permissions (`id`, `module`, `action`, `visible`, `created`, `modified`) VALUES ('6', 'user logs', 'index', '1', '2023-01-04 14:01:04', '2023-01-04 14:01:04');
INSERT INTO permissions (`id`, `module`, `action`, `visible`, `created`, `modified`) VALUES ('7', 'backup manager', 'index', '1', '2023-01-04 14:01:10', '2023-01-04 14:01:10');


-- --------------------------------------------------------


--
-- Structure de la table `role_permissions`
--
CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL,
  `visible` tinyint(4) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- entrees dans la table `role_permissions`
--
INSERT INTO role_permissions (`id`, `role_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('1', '15', '7', '1', '2023-01-04 14:43:41', '2023-01-04 14:43:41');
INSERT INTO role_permissions (`id`, `role_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('2', '15', '1', '1', '2023-01-04 14:43:41', '2023-01-04 14:43:41');
INSERT INTO role_permissions (`id`, `role_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('3', '15', '2', '1', '2023-01-04 14:43:41', '2023-01-04 14:43:41');
INSERT INTO role_permissions (`id`, `role_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('4', '15', '3', '1', '2023-01-04 14:43:41', '2023-01-04 14:43:41');
INSERT INTO role_permissions (`id`, `role_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('5', '15', '4', '1', '2023-01-04 14:43:41', '2023-01-04 14:43:41');
INSERT INTO role_permissions (`id`, `role_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('6', '15', '6', '1', '2023-01-04 14:43:41', '2023-01-04 14:43:41');
INSERT INTO role_permissions (`id`, `role_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('7', '15', '5', '1', '2023-01-04 14:43:41', '2023-01-04 14:43:41');


-- --------------------------------------------------------


--
-- Structure de la table `roles`
--
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- entrees dans la table `roles`
--
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('1', 'superadmin', 'Superadmin', '', '1', '', '');
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('2', 'Office Admin', 'Office Admin', '', '1', '', '2022-05-21 16:40:28');
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('4', 'hr admin', 'HR Admin', '', '1', '', '');
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('5', 'Approver', 'Approver', '', '1', '', '2022-11-10 10:41:57');
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('6', 'auditor client', 'Auditor (Client)', '', '', '', '');
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('7', 'loan officer', 'Loan Officer', '', '', '', '');
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('8', 'cashier', 'Cashier', '', '', '', '');
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('9', 'auditor company', 'Auditor (Company)', '', '', '', '');
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('10', 'dtr-recorder', 'dtr-recorder', '', '1', '', '');
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('11', 'Ojt', 'Ojt', '', '1', '', '2022-11-13 22:11:14');
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('12', 'employee', 'Employee', '', '1', '2021-09-08 07:24:22', '2021-09-08 07:24:22');
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('13', 'external', 'External', '', '1', '2022-08-15 15:22:15', '2022-08-15 15:24:23');
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('14', 'New Role', 'New Role', '', '1', '2022-12-22 09:59:50', '2022-12-22 09:59:50');
INSERT INTO roles (`id`, `code`, `name`, `description`, `visible`, `created`, `modified`) VALUES ('15', 'Test 1', 'Test 1', '', '1', '2023-01-04 14:43:41', '2023-01-04 14:43:41');


-- --------------------------------------------------------


--
-- Structure de la table `settings`
--
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- entrees dans la table `settings`
--
INSERT INTO settings (`id`, `code`, `name`, `value`, `visible`, `created`, `modified`) VALUES ('1', 'lgu_name', 'Agency Name', 'Zamboanga State College of Marine Sciences and Technology', '1', '', '2014-11-14 04:58:14');
INSERT INTO settings (`id`, `code`, `name`, `value`, `visible`, `created`, `modified`) VALUES ('2', 'address', 'Address', 'Fort Pilar, Zamboanga City 7000', '1', '', '2014-10-23 04:21:38');
INSERT INTO settings (`id`, `code`, `name`, `value`, `visible`, `created`, `modified`) VALUES ('4', 'email', 'Email', 'support@mycreativepanda.ph', '1', '', '2019-12-06 10:50:54');
INSERT INTO settings (`id`, `code`, `name`, `value`, `visible`, `created`, `modified`) VALUES ('5', 'telephone', 'Telephone', 'Tel. No. : (062) 992-3092; Telefax: (062) 991-0777', '1', '', '2014-10-23 04:21:53');
INSERT INTO settings (`id`, `code`, `name`, `value`, `visible`, `created`, `modified`) VALUES ('7', 'mayor', 'Agency Head', '', '1', '', '2015-10-15 08:59:54');
INSERT INTO settings (`id`, `code`, `name`, `value`, `visible`, `created`, `modified`) VALUES ('11', 'ehris', 'eHRIS', '', '1', '', '2016-11-22 15:23:49');
INSERT INTO settings (`id`, `code`, `name`, `value`, `visible`, `created`, `modified`) VALUES ('12', 'system_title', 'System Title', 'Electronic Human Resource Management Information System', '1', '', '2014-11-25 01:58:32');
INSERT INTO settings (`id`, `code`, `name`, `value`, `visible`, `created`, `modified`) VALUES ('13', 'active_year', 'Active Year', '2023', '1', '2014-11-25 00:00:00', '2023-01-04 17:46:44');
INSERT INTO settings (`id`, `code`, `name`, `value`, `visible`, `created`, `modified`) VALUES ('24', 'website', 'Website', 'www.zscmst.edu.ph', '1', '2022-03-01 08:44:36', '2022-03-01 08:44:36');


-- --------------------------------------------------------


--
-- Structure de la table `user_logs`
--
CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `accounting_entry_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=latin1;

--
-- entrees dans la table `user_logs`
--
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('1', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:20:41', '2023-01-04 13:20:41');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('2', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:20:43', '2023-01-04 13:20:43');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('3', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:22:15', '2023-01-04 13:22:15');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('4', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:23:39', '2023-01-04 13:23:39');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('5', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:24:19', '2023-01-04 13:24:19');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('6', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:26:43', '2023-01-04 13:26:43');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('7', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:27:22', '2023-01-04 13:27:22');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('8', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:27:27', '2023-01-04 13:27:27');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('9', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:30:42', '2023-01-04 13:30:42');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('10', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:30:55', '2023-01-04 13:30:55');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('11', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:31:20', '2023-01-04 13:31:20');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('12', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:32:17', '2023-01-04 13:32:17');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('13', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:32:27', '2023-01-04 13:32:27');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('14', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:34:58', '2023-01-04 13:34:58');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('15', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:35:53', '2023-01-04 13:35:53');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('16', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:35:56', '2023-01-04 13:35:56');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('17', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:36:06', '2023-01-04 13:36:06');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('18', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:36:23', '2023-01-04 13:36:23');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('19', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:38:44', '2023-01-04 13:38:44');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('20', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:43:49', '2023-01-04 13:43:49');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('21', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:44:14', '2023-01-04 13:44:14');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('22', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:44:32', '2023-01-04 13:44:32');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('23', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:45:18', '2023-01-04 13:45:18');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('24', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:45:22', '2023-01-04 13:45:22');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('25', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:45:35', '2023-01-04 13:45:35');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('26', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:45:39', '2023-01-04 13:45:39');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('27', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:46:19', '2023-01-04 13:46:19');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('28', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:47:43', '2023-01-04 13:47:43');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('29', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:49:14', '2023-01-04 13:49:14');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('30', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:49:24', '2023-01-04 13:49:24');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('31', '1', ' ', 'Save', 'Permission Management', '', '', '', '1', '2023-01-04 13:54:08', '2023-01-04 13:54:08');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('32', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:54:09', '2023-01-04 13:54:09');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('33', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:54:45', '2023-01-04 13:54:45');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('34', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:56:23', '2023-01-04 13:56:23');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('35', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:57:19', '2023-01-04 13:57:19');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('36', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:58:08', '2023-01-04 13:58:08');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('37', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:58:39', '2023-01-04 13:58:39');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('38', '1', ' ', 'Save', 'Permission Management', '', '', '', '1', '2023-01-04 13:58:44', '2023-01-04 13:58:44');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('39', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:58:44', '2023-01-04 13:58:44');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('40', '1', ' ', 'Save', 'Permission Management', '', '', '', '1', '2023-01-04 13:58:48', '2023-01-04 13:58:48');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('41', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 13:58:48', '2023-01-04 13:58:48');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('42', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:00:10', '2023-01-04 14:00:10');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('43', '1', ' ', 'Save', 'Permission Management', '', '', '', '1', '2023-01-04 14:00:16', '2023-01-04 14:00:16');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('44', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:00:16', '2023-01-04 14:00:16');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('45', '1', ' ', 'Update', 'Permission Management', '', '', '', '1', '2023-01-04 14:00:27', '2023-01-04 14:00:27');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('46', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:00:28', '2023-01-04 14:00:28');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('47', '1', ' ', 'Save', 'Permission Management', '', '', '', '1', '2023-01-04 14:00:57', '2023-01-04 14:00:57');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('48', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:00:57', '2023-01-04 14:00:57');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('49', '1', ' ', 'Save', 'Permission Management', '', '', '', '1', '2023-01-04 14:01:04', '2023-01-04 14:01:04');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('50', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:01:04', '2023-01-04 14:01:04');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('51', '1', ' ', 'Save', 'Permission Management', '', '', '', '1', '2023-01-04 14:01:10', '2023-01-04 14:01:10');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('52', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:01:10', '2023-01-04 14:01:10');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('53', '1', ' ', 'Update', 'Permission Management', '', '', '', '1', '2023-01-04 14:01:16', '2023-01-04 14:01:16');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('54', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:01:17', '2023-01-04 14:01:17');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('55', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:01:33', '2023-01-04 14:01:33');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('56', '1', ' ', 'Update', 'Permission Management', '', '', '', '1', '2023-01-04 14:01:43', '2023-01-04 14:01:43');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('57', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:01:43', '2023-01-04 14:01:43');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('58', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:01:47', '2023-01-04 14:01:47');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('59', '1', ' ', 'Update', 'Permission Management', '', '', '', '1', '2023-01-04 14:03:08', '2023-01-04 14:03:08');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('60', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:03:08', '2023-01-04 14:03:08');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('61', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:23:23', '2023-01-04 14:23:23');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('62', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:23:36', '2023-01-04 14:23:36');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('63', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:27:09', '2023-01-04 14:27:09');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('64', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:27:14', '2023-01-04 14:27:14');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('65', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 14:38:57', '2023-01-04 14:38:57');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('66', '1', 'Test 1', 'Add', 'Role', '', '', '', '1', '2023-01-04 14:43:41', '2023-01-04 14:43:41');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('67', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 14:50:42', '2023-01-04 14:50:42');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('68', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 14:50:42', '2023-01-04 14:50:42');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('69', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 14:51:56', '2023-01-04 14:51:56');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('70', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 14:51:56', '2023-01-04 14:51:56');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('71', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 14:52:14', '2023-01-04 14:52:14');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('72', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 14:52:14', '2023-01-04 14:52:14');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('73', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 14:52:33', '2023-01-04 14:52:33');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('74', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 14:52:33', '2023-01-04 14:52:33');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('75', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 14:53:29', '2023-01-04 14:53:29');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('76', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 14:53:29', '2023-01-04 14:53:29');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('77', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 14:54:00', '2023-01-04 14:54:00');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('78', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 14:54:00', '2023-01-04 14:54:00');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('79', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:22:09', '2023-01-04 15:22:09');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('80', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:22:09', '2023-01-04 15:22:09');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('81', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:22:22', '2023-01-04 15:22:22');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('82', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:22:22', '2023-01-04 15:22:22');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('83', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:24:46', '2023-01-04 15:24:46');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('84', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:24:46', '2023-01-04 15:24:46');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('85', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:31:25', '2023-01-04 15:31:25');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('86', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:31:25', '2023-01-04 15:31:25');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('87', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:33:10', '2023-01-04 15:33:10');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('88', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:33:10', '2023-01-04 15:33:10');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('89', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:33:39', '2023-01-04 15:33:39');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('90', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:33:39', '2023-01-04 15:33:39');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('91', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:34:34', '2023-01-04 15:34:34');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('92', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:34:34', '2023-01-04 15:34:34');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('93', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:35:15', '2023-01-04 15:35:15');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('94', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:35:16', '2023-01-04 15:35:16');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('95', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:36:51', '2023-01-04 15:36:51');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('96', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:36:51', '2023-01-04 15:36:51');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('97', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:37:03', '2023-01-04 15:37:03');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('98', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:37:03', '2023-01-04 15:37:03');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('99', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:37:24', '2023-01-04 15:37:24');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('100', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:37:25', '2023-01-04 15:37:25');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('101', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:44:57', '2023-01-04 15:44:57');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('102', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:44:57', '2023-01-04 15:44:57');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('103', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:45:31', '2023-01-04 15:45:31');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('104', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:45:31', '2023-01-04 15:45:31');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('105', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 15:54:54', '2023-01-04 15:54:54');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('106', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 15:54:58', '2023-01-04 15:54:58');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('107', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:55:02', '2023-01-04 15:55:02');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('108', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 15:55:02', '2023-01-04 15:55:02');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('109', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 16:01:06', '2023-01-04 16:01:06');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('110', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 16:01:06', '2023-01-04 16:01:06');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('111', '1', ' ', 'Log Out', 'logged out - MY CREATIVE PANDA', '', '', '', '1', '2023-01-04 16:27:10', '2023-01-04 16:27:10');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('112', '1', ' ', 'Log In', 'logged in - MY CREATIVE PANDA', '', '', '', '1', '2023-01-04 16:27:31', '2023-01-04 16:27:31');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('113', '1', ' ', 'Log In', 'logged in - MY CREATIVE PANDA', '', '', '', '1', '2023-01-04 16:27:45', '2023-01-04 16:27:45');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('114', '3', ' ', 'Log In', 'logged in - Inah Lim', '', '', '', '1', '2023-01-04 16:38:07', '2023-01-04 16:38:07');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('115', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 16:48:45', '2023-01-04 16:48:45');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('116', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 16:48:59', '2023-01-04 16:48:59');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('117', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 16:49:11', '2023-01-04 16:49:11');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('118', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 16:49:41', '2023-01-04 16:49:41');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('119', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 16:49:46', '2023-01-04 16:49:46');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('120', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 16:49:46', '2023-01-04 16:49:46');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('121', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 16:49:48', '2023-01-04 16:49:48');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('122', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 17:00:21', '2023-01-04 17:00:21');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('123', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 17:07:00', '2023-01-04 17:07:00');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('124', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 17:07:10', '2023-01-04 17:07:10');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('125', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 17:12:10', '2023-01-04 17:12:10');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('126', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 17:14:05', '2023-01-04 17:14:05');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('127', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 17:16:52', '2023-01-04 17:16:52');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('128', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 17:20:08', '2023-01-04 17:20:08');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('129', '1', ' ', 'Index', 'Permission Management', '', '', '', '1', '2023-01-04 17:20:38', '2023-01-04 17:20:38');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('130', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:24:46', '2023-01-04 17:24:46');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('131', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:24:46', '2023-01-04 17:24:46');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('132', '1', ' ', 'Log In', 'logged in - MY CREATIVE PANDA', '', '', '', '1', '2023-01-04 17:29:10', '2023-01-04 17:29:10');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('133', '1', ' ', 'Save', 'User', '', '', '', '1', '2023-01-04 17:40:05', '2023-01-04 17:40:05');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('134', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:40:05', '2023-01-04 17:40:05');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('135', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:40:05', '2023-01-04 17:40:05');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('136', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:40:47', '2023-01-04 17:40:47');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('137', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:40:47', '2023-01-04 17:40:47');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('138', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:41:28', '2023-01-04 17:41:28');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('139', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:41:29', '2023-01-04 17:41:29');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('140', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:41:52', '2023-01-04 17:41:52');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('141', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:41:52', '2023-01-04 17:41:52');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('142', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:41:54', '2023-01-04 17:41:54');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('143', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:41:54', '2023-01-04 17:41:54');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('144', '1', ' ', 'View', 'User', '', '', '', '1', '2023-01-04 17:41:56', '2023-01-04 17:41:56');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('145', '1', ' ', 'View', 'User', '', '', '', '1', '2023-01-04 17:42:27', '2023-01-04 17:42:27');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('146', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:44:46', '2023-01-04 17:44:46');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('147', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:44:46', '2023-01-04 17:44:46');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('148', '1', ' ', 'View', 'User', '', '', '', '1', '2023-01-04 17:44:47', '2023-01-04 17:44:47');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('149', '1', ' ', 'View', 'User', '', '', '', '1', '2023-01-04 17:45:17', '2023-01-04 17:45:17');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('150', '1', ' ', 'View', 'User', '', '', '', '1', '2023-01-04 17:45:22', '2023-01-04 17:45:22');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('151', '1', ' ', 'View', 'User', '', '', '', '1', '2023-01-04 17:45:25', '2023-01-04 17:45:25');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('152', '1', ' ', 'View', 'User', '', '', '', '1', '2023-01-04 17:45:28', '2023-01-04 17:45:28');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('153', '1', ' ', 'View', 'User', '', '', '', '1', '2023-01-04 17:45:54', '2023-01-04 17:45:54');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('154', '1', ' ', 'View', 'User', '', '', '', '1', '2023-01-04 17:45:56', '2023-01-04 17:45:56');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('155', '1', ' ', 'View', 'User', '', '', '', '1', '2023-01-04 17:45:58', '2023-01-04 17:45:58');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('156', '1', ' ', 'View', 'User', '', '', '', '1', '2023-01-04 17:46:13', '2023-01-04 17:46:13');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('157', '1', ' ', 'Update', 'User', '', '', '', '1', '2023-01-04 17:46:20', '2023-01-04 17:46:20');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('158', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:46:20', '2023-01-04 17:46:20');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('159', '1', ' ', 'Index', 'User Management', '', '', '', '1', '2023-01-04 17:46:20', '2023-01-04 17:46:20');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('160', '1', ' ', 'Log Out', 'logged out - MY CREATIVE PANDA', '', '', '', '1', '2023-01-04 17:46:29', '2023-01-04 17:46:29');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('161', '175', ' ', 'Log In', 'logged in - Cardo Dalisay', '', '', '', '1', '2023-01-04 17:46:32', '2023-01-04 17:46:32');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('162', '1', ' ', 'Log In', 'logged in - MY CREATIVE PANDA', '', '', '', '1', '2023-01-04 17:46:44', '2023-01-04 17:46:44');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('163', '1', '', 'Download - ehris_04-01-2023_17-53-19.sql', 'Backup', '', '', '', '1', '2023-01-04 17:53:19', '2023-01-04 17:53:19');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('164', '1', ' ', 'Index', 'Back-up Manager', '', '', '', '1', '2023-01-04 17:55:25', '2023-01-04 17:55:25');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('165', '1', '', 'Delete', 'Back-up Manager', '', '', '', '1', '2023-01-04 17:55:28', '2023-01-04 17:55:28');
INSERT INTO user_logs (`id`, `userId`, `code`, `action`, `description`, `remarks`, `accounting_entry_id`, `member_id`, `visible`, `created`, `modified`) VALUES ('166', '1', '', 'Delete', 'Back-up Manager', '', '', '', '1', '2023-01-04 17:55:30', '2023-01-04 17:55:30');


-- --------------------------------------------------------


--
-- Structure de la table `user_permissions`
--
CREATE TABLE `user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- entrees dans la table `user_permissions`
--
INSERT INTO user_permissions (`id`, `user_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('1', '175', '7', '1', '2023-01-04 17:45:22', '2023-01-04 17:45:22');
INSERT INTO user_permissions (`id`, `user_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('2', '175', '2', '1', '2023-01-04 17:45:22', '2023-01-04 17:45:22');
INSERT INTO user_permissions (`id`, `user_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('3', '175', '3', '1', '2023-01-04 17:45:22', '2023-01-04 17:45:22');
INSERT INTO user_permissions (`id`, `user_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('4', '175', '1', '1', '2023-01-04 17:45:22', '2023-01-04 17:45:22');
INSERT INTO user_permissions (`id`, `user_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('5', '175', '4', '1', '2023-01-04 17:45:22', '2023-01-04 17:45:22');
INSERT INTO user_permissions (`id`, `user_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('6', '175', '6', '1', '2023-01-04 17:45:22', '2023-01-04 17:45:22');
INSERT INTO user_permissions (`id`, `user_id`, `permission_id`, `visible`, `created`, `modified`) VALUES ('8', '175', '5', '1', '2023-01-04 17:45:28', '2023-01-04 17:45:28');


-- --------------------------------------------------------


--
-- Structure de la table `users`
--
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branchId` int(3) DEFAULT NULL,
  `employeeId` int(11) DEFAULT NULL,
  `officeId` int(11) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tmp_password` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `image` varchar(2500) DEFAULT NULL,
  `roleId` int(11) DEFAULT NULL,
  `developer` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) DEFAULT 1,
  `verified` tinyint(1) DEFAULT 0,
  `visible` tinyint(1) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=176 DEFAULT CHARSET=latin1;

--
-- entrees dans la table `users`
--
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('1', '', '', '', '', 'superadmin', '2aaa61b3b641df0a2e88a9ab2dcb55feb111186a', '', '', 'PANDA', 'MY CREATIVE', '', '', '', 'rsr-logo.jpg', '1', '1', '1', '1', '1', '2017-09-01 14:03:40', '2017-09-01 14:03:40');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('3', '', '', '', '', 'admin02', '8bdf6267506fee569635265fd521229663e970e0', '', '', 'Lim', 'Inah', '', '', '', 'MCP-INC-LOGO-a3c56cc4.png', '1', '1', '1', '1', '1', '2019-08-20 09:08:14', '2019-08-20 09:08:14');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('4', '', '', '2', '', 'dev02', '5efa49771b249bc313bcc9489104ce2eae968fe8', '', '', 'Developer', 'Software', '', '', '', 'sole.png', '1', '1', '1', '1', '1', '', '2021-12-07 16:02:14');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('83', '', '2', '', '', 'support02', '8bdf6267506fee569635265fd521229663e970e0', '', '', '02', 'support', '', '', '', '142435450_3736384733116231_6586983090904936382_n.jpg', '1', '', '1', '1', '1', '2022-03-14 09:50:38', '2022-03-14 09:50:38');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('84', '', '4', '', '', 'super', '4f45ba16cea5921533dac47b3c9d8700d2f3e06b', '', '', 'Dalisay', 'Cardo', '', '', '', 'rsr-logo.jpg', '12', '1', '1', '1', '1', '2022-03-15 10:17:08', '2022-03-15 10:17:08');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('85', '', '42', '', '', 'editha2022', '7675593775560188dfb35ec0d6a876f2d3458e19', '', '', 'ABAD', 'EDITHA', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:11:42', '2022-04-20 11:11:42');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('86', '', '1', '', '', 'lourdes2008', 'a06554c8cff0bd17ff1f4bac003a2e8be0054c5c', '', '', 'ABEJO', 'BERNADETTE', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:12:38', '2022-04-20 11:12:38');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('87', '', '43', '', '', 'rowena2022', '41944b05b408a19fd612ee4dd2041b8f266fd301', '', '', 'ANTONIO', 'ROWENA', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:14:05', '2022-04-20 11:14:05');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('88', '', '40', '', '', 'alan2021', '8bdf6267506fee569635265fd521229663e970e0', '', '', 'ARANETA', 'ALAN', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:14:51', '2022-04-20 11:14:51');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('89', '', '44', '', '', 'edilberto2022', '6fdc1f51ab70eda46ee37b53ad8b6af1e4e0740e', '', '', 'ARANETA', 'EDILBERTO', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:15:33', '2022-04-20 11:15:33');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('91', '', '30', '', '', 'khryza2021', 'fb6cd96056dae93bca592dc92e9658967bd2aa55', '', '', 'CABALLERO', 'KHRYZA JELEEN', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:18:24', '2022-04-20 11:18:24');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('92', '', '22', '', '', 'jane2016', 'f0d91f5824f02c7a58dcc46172b4e4c751d48a17', '', '', 'CABREDO', 'SARAH JANE', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:19:31', '2022-04-20 11:19:31');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('93', '', '9', '', '', 'argin2016', '372e3191726060c1f91930796749c9c7ada539ed', '', '', 'CLARIÑO', 'ARGIN', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:20:29', '2022-04-20 11:20:29');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('94', '', '19', '', '', 'lea2021', 'a65b6c42d3258cab42e3936c08aec76e49c6d41e', '', '', 'CORDOVALES', 'LEA', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:22:01', '2022-04-20 11:22:01');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('95', '', '48', '', '', 'sherwin2022', '9254651e61a3355cd79c687f5bcbe336eccf1dce', '', '', 'DALUPANG', 'SHERWIN', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:22:47', '2022-04-20 11:22:47');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('96', '', '20', '', '', 'cherryl2012', 'f309329a25513b62bc73db01a2013e01e97a0a5e', '', '', 'DEL MUNDO', 'CHERRYL', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:26:48', '2022-04-20 11:26:48');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('97', '', '15', '', '', 'kath2012', 'a44dd5084f572a36a54756754ae82555c0ee2d5d', '', '', 'DELA CRUZ', 'KATHERINE', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:27:28', '2022-04-20 11:27:28');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('98', '', '47', '', '', 'nelia2022', '0af0b84e1d2d3b2b084ee053a093923fa8a0eff5', '', '', 'DELA CRUZ', 'NELIA', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:28:14', '2022-04-20 11:28:14');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('99', '', '2', '', '', 'jaybie2016', '2167bcc6f4149a5db68ddb5b8a50fa8a9c394061', '', '', 'DIAZ', 'JAYBIE', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:30:04', '2022-04-20 11:30:04');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('100', '', '41', '', '', 'jumar2020', 'f90d1aedd9ac4bcadb3c95903a6960b21f0fb66c', '', '', 'DURAN', 'JUMAR', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:31:16', '2022-04-20 11:31:16');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('102', '', '17', '', '', 'irene2012', '02a8dd05e1420653859eb4417ad3209acfc2dee0', '', '', 'FAGAYAN', 'IRENE', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:34:04', '2022-04-20 11:34:04');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('103', '', '11', '', '', 'maan2017', 'cb54beb47caa4e40fdeaa84028bd4b51512a2296', '', '', 'GAOAT', 'MA-AN', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:34:58', '2022-04-20 11:34:58');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('105', '', '28', '', '', 'jodie2021', '516e4e7015911e09411f0c253dd8979810a2a439', '', '', 'GREGORE', 'JODIE MAE', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:36:18', '2022-04-20 11:36:18');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('106', '', '23', '', '', 'myrel2012', '5b8102e84d0e623ce02a5d6deb6f677a4e673d8b', '', '', 'LEIDO', 'MYREL ANNE', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:37:04', '2022-04-20 11:37:04');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('107', '', '8', '', '', 'leodell2016', '845acea777c5fffe53f642187c2b8a96a88f2343', '', '', 'LIGON', 'LEODELL', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:37:47', '2022-04-20 11:37:47');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('108', '', '29', '', '', 'rodalyn2016', '6938427be7c306ca0cdddb2fe53cd7abe1ae362d', '', '', 'MADRID', 'RODALYN', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:38:28', '2022-04-20 11:38:28');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('109', '', '46', '', '', 'caloduado2022', '8f45bab50794c1dc5fb7f23648415ef2dbe2bbbf', '', '', 'MALDO', 'CALODUADO', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:39:16', '2022-04-20 11:39:16');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('110', '', '7', '', '', 'ryan2018', 'dd06ee29c46647230f609bbc4cf5ccd15f110447', '', '', 'MANALO', 'RYAN CHRISTOPHER', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:40:00', '2022-04-20 11:40:00');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('112', '', '45', '', '', 'myra2022', 'ae94cbcd96e455e6e398be6fecb226ab5b4425dc', '', '', 'MARILAG', 'MYRA', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:41:29', '2022-04-20 11:41:29');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('113', '', '49', '', '', 'jonie2022', '180f8eb1ef07f3276f75ed05d03431d9227aac79', '', '', 'MARTIN', 'JONIE', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:42:13', '2022-04-20 11:42:13');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('114', '', '31', '', '', 'faith2020', '224cdc8e1fd1edfb813ca70d4d49013d2746126d', '', '', 'MIRANDA', 'ERIN FAITH', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:43:02', '2022-04-20 11:43:02');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('115', '', '32', '', '', 'austine2019', '8ab1a077a2c2970225a7f4e34ac1ce577ed7d2cb', '', '', 'NATIVIDAD', 'JOE AUSTINE', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:44:13', '2022-04-20 11:44:13');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('116', '', '53', '', '', 'teresita2022', '42b596bac713fe556aa2c9072063b27c8c9bff41', '', '', 'OCASLA', 'teresita2022', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:45:17', '2022-04-20 11:45:17');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('117', '', '55', '', '', 'lovely2021', '2d51059cf11fa6d22b8ef6272607ebcd4aa62868', '', '', 'ORDOVEZ', 'LOVELY', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:45:51', '2022-04-20 11:45:51');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('118', '', '24', '', '', 'amelia2012', '619c1dfddce6f7e9a1c28b6de73ab6f836f87116', '', '', 'PALPAG', 'AMELIA', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:46:37', '2022-04-20 11:46:37');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('119', '', '12', '', '', 'mary2018', '774c34382521b0197221663bb9f70021c0151daa', '', '', 'PELAEZ', 'MARY ANN', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:47:18', '2022-04-20 11:47:18');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('120', '', '26', '', '', 'cath2021', 'cdeff18923b959cf5f8aa185ccd9d04f443a7cf8', '', '', 'PIOL', 'CATHYRINE', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:47:59', '2022-04-20 11:47:59');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('121', '', '18', '', '', 'rutchel2011', '456082104a967f42c78fec4a87d13d13754f98a4', '', '', 'POCDIHON', 'RUTCHEL', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:48:59', '2022-04-20 11:48:59');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('122', '', '52', '', '', 'alieta2022', '737799ae0e79d220de766134e8bb6cf43c78ba5f', '', '', 'RABARIA', 'ALIETA', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:49:47', '2022-04-20 11:49:47');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('123', '', '51', '', '', 'jocelyn2022', '99c29f394216455608f4a27151c0b0ab6d5d5968', '', '', 'RAMORES', 'JOCELYN', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:55:45', '2022-04-20 11:55:45');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('125', '', '50', '', '', 'linda2022', 'cbdd64f81d94b4a906643a97ddb278891a23ef19', '', '', 'ROSADA', 'SHERLINDA', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:57:31', '2022-04-20 11:57:31');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('126', '', '21', '', '', 'cedie2021', '8134e571c66ba80be2f36d46b324b7e757cf3263', '', '', 'SAN PEDRO', 'CEDIE', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:58:30', '2022-04-20 11:58:30');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('127', '', '5', '', '', 'janet1998', 'c34bc8b4afb279eb510a3aeedf5d4cade724cca6', '', '', 'SANTOS', 'JANET', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:59:14', '2022-04-20 11:59:14');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('128', '', '3', '', '', 'maria2021', 'fdd09515690d166a6938bf2424c8e75162307a75', '', '', 'SEBASTIAN', 'MARIA TERESA', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 11:59:54', '2022-04-20 11:59:54');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('129', '', '27', '', '', 'rose2012', '46215066b9ac293cc197e24d20e9dd0bd443a2b7', '', '', 'TEJONES', 'ROSA MARIE', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 12:00:37', '2022-04-20 12:00:37');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('130', '', '10', '', '', 'lorna2019', 'f9f70a1e7b44f231b1662296ebb23b115bb90210', '', '', 'TOMINEZ', 'LORNA', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 12:02:44', '2022-04-20 12:02:44');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('131', '', '6', '', '', 'ephraim2014', 'bf044bff33ad7882fae09ea302db355c45eda252', '', '', 'TORRES', 'EPHRAIM', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 12:57:42', '2022-04-20 12:57:42');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('132', '', '54', '', '', 'vicente2022', 'ad81c4a1635624796bd3381afad9147cb43f772e', '', '', 'VERGARA', 'VICENTE', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 12:58:28', '2022-04-20 12:58:28');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('133', '', '25', '', '', 'lyra2013', '537cdc1739ed9ff13d33c26178a5022bcca83ef7', '', '', 'VILLAMARIN', 'LYRA GAY', '', '', '', '', '12', '', '1', '1', '1', '2022-04-20 13:00:50', '2022-04-20 13:00:50');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('134', '', '58', '', '', 'kath2022', '333e87ea9bae1c5f6cf1b5c9cb10975165808274', '', '', 'ABAD', 'ANTOINETTE KATRINA', '', '', '', '', '12', '', '1', '1', '1', '2022-04-21 08:34:51', '2022-04-21 08:34:51');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('135', '', '60', '', '', 'wilson2022', '71b102829178cd411d8cba08bb24a98e1f9424ab', '', '', 'DABU', 'WILSON', '', '', '', '', '12', '', '1', '1', '1', '2022-04-21 08:35:38', '2022-04-21 08:35:38');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('136', '', '61', '', '', 'mark2022', '6171c080ba6009e2edfa0e57c092579935f74e53', '', '', 'SEE', 'MARK BERNARD', '', '', '', '', '12', '', '1', '1', '1', '2022-04-21 08:36:47', '2022-04-21 08:36:47');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('137', '', '59', '', '', 'jonalyn2022', '69d4feb3111d6c87345eb31e9c229e528c965a23', '', '', 'BAUAN', 'MA. JONALYN', '', '', '', '', '12', '', '1', '1', '1', '2022-04-21 08:37:33', '2022-04-21 08:37:33');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('139', '', '39', '', '', 'john1994', '425ca7a7203ffe0808a5c74b79f88b4a1f00651a', '', '', 'John Michael', 'Bermillo', '', '', '', '', '12', '', '1', '1', '1', '2022-05-06 10:27:23', '2022-05-06 10:27:23');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('143', '', '4', '', '', 'EMPLOYEE', 'f1254fe30864a04576ef8198d8f3296e6f1a3dd8', '', '', 'EMPLOYEE', 'EMPLOYEE', '', '', '', 'viber_image_2022-03-28_14-12-51-734.jpg', '12', '', '1', '1', '1', '2022-06-08 13:30:19', '2022-06-08 13:30:19');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('144', '', '2', '', '', 'ranz', '23a32899314207ef71c71975e7c933fa7b5d48e3', '', '', '02', 'Support', '', '', '', '142435450_3736384733116231_6586983090904936382_n.jpg', '1', '', '1', '1', '1', '2022-06-10 13:49:29', '2022-06-10 13:49:29');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('145', '', '285', '', '', 'raymond', '73d6156a59098f0f465ebc85061658f25771ce56', '%_7Mx&pe', '', 'Llobrera', 'Raymond', '', '', '', 'image_2022_05_25T06_21_08_945Z.png', '1', '', '1', '1', '1', '2022-06-11 11:23:34', '2022-06-11 11:23:34');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('149', '', '', '', '', 'cardo', 'e3b7d006b53a461c4cf8b51f07e588c0433a35fa', '', '', 'DALISAY', 'CARDO', '', '', '', 'tala.png', '1', '1', '1', '1', '1', '2022-08-15 15:42:17', '2022-08-15 15:42:17');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('150', '', '', '', '', '4', '26a1a24bbe4a61d03f43916f95d4310e47d6d35b', '', '', '3', '1', '2', '', '', '', '', '', '1', '', '1', '2022-09-06 15:39:48', '2022-09-06 15:39:48');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('151', '', '', '', '', '5', '8bdf6267506fee569635265fd521229663e970e0', '', '', 'GACAYAN', 'JOHN', 'CORREA', '', 'johngacayan202@gmail.com', '', '13', '', '1', '1', '1', '2022-09-06 15:41:21', '2022-09-06 15:41:21');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('152', '', '', '', '', 'users', '7d0ef0b9a0f8d706638957d06670362a213f6a6b', '', '', 'LLOBRERA', 'RAYMON', 'A', '', '', '', '13', '', '1', '1', '1', '2022-09-06 15:51:48', '2022-09-06 15:51:48');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('153', '', '1', '', '', 'Fatima', '8bdf6267506fee569635265fd521229663e970e0', 'r_Q690Na', '', 'San Pedro', 'Ma. Fatima', 'Patdu', '', 'sanpedroma.fatima@gmail.com', '', '12', '', '1', '1', '1', '2022-09-07 13:28:20', '2022-09-07 13:28:20');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('157', '', '', '', '', 'johns', '8bdf6267506fee569635265fd521229663e970e0', '', '', 'Gacayan', 'John', 'Correa', '', '', '', '5', '', '1', '1', '1', '2022-09-23 08:39:18', '2022-09-23 08:39:18');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('161', '', '', '', '', '123', '73d6156a59098f0f465ebc85061658f25771ce56', '', '', 'Llobrera', 'Raymond', 'Bascos', '', '', '', '13', '', '1', '1', '1', '2022-10-03 14:03:58', '2022-10-03 14:03:58');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('163', '', '2', '', '', 'charo', '23a32899314207ef71c71975e7c933fa7b5d48e3', '', '', 'SERVICE', 'SELF', '', '', '', '', '12', '', '1', '1', '1', '2022-10-25 16:22:04', '2022-10-25 16:22:04');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('164', '', '', '', '', 'raymond123', 'f699aa6d3be08b73c9844195b8e82d40702d317f', 'pUq$!rZ8', '', 'Llobrera', 'Raymond', '', '', 'mllobrera25@gmail.com', '', '13', '', '1', '1', '1', '2022-10-26 17:32:33', '2022-10-26 17:32:33');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('169', '', '', '', '', 'Username', '950d798221f9d0d57d3c4b28c359c0a13ffd5cfd', '', '', 'Last', 'First', '', '', 'qwe@qwe.qwe', '', '13', '', '1', '1', '1', '2022-10-28 08:41:12', '2022-10-28 08:41:12');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('170', '', '', '', '', 'Trainee01', '8bdf6267506fee569635265fd521229663e970e0', '', '', 'trainee', '01', '', '', '', '', '14', '', '1', '1', '1', '2022-11-03 08:27:48', '2022-11-03 08:27:48');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('171', '', '1', '', '', 'support03', '8bdf6267506fee569635265fd521229663e970e0', '', '', 'San Pedro', 'Ma Fatima', '', '', '', '2x2.jpeg', '1', '', '1', '1', '1', '2022-11-04 08:57:14', '2022-11-04 08:57:14');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('172', '', '1', '', '', 'user', '62ff3811d56812b5f115c9957d8e30f56aa07050', '', '', 'access', 'user', '', '', '', '', '12', '', '1', '1', '1', '2022-11-05 13:02:59', '2022-11-05 13:02:59');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('173', '', '', '', '', 'approver01', '8bdf6267506fee569635265fd521229663e970e0', '', '', '01', 'Approver', '', '', '', '', '14', '', '1', '1', '1', '2022-11-10 10:45:37', '2022-11-10 10:45:37');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('174', '', '288', '', '', 'ranz0107', '2119731a9f5b751125e2546c6e82d708c8fad1cd', 'xdluq%O0', '', 'SUPPORT', '02', '', '', '', '', '12', '', '1', '1', '1', '2022-12-10 16:46:51', '2022-12-10 16:46:51');
INSERT INTO users (`id`, `branchId`, `employeeId`, `officeId`, `code`, `username`, `password`, `tmp_password`, `token`, `last_name`, `first_name`, `middle_name`, `gender`, `email`, `image`, `roleId`, `developer`, `active`, `verified`, `visible`, `created`, `modified`) VALUES ('175', '', '', '', '', 'cardos', 'c745d646a157f39875d18275eb028b766931d20f', '', '', 'Dalisay', 'Cardo', '', '', '', 'index.png', '1', '1', '1', '1', '1', '2023-01-04 17:40:05', '2023-01-04 17:40:05');


-- --------------------------------------------------------


