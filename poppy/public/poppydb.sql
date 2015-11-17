-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2015 at 03:41 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `poppydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_text` text NOT NULL,
  `submit_time` datetime NOT NULL,
  PRIMARY KEY (`answer_id`),
  KEY `question_id` (`question_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=805 ;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`answer_id`, `user_id`, `question_id`, `answer_text`, `submit_time`) VALUES
(760, 30, 1, 'Vaginal Birth', '2015-10-28 13:27:52'),
(761, 30, 2, '20', '2015-10-28 13:27:52'),
(762, 30, 4, 'Yes', '2015-10-28 13:27:52'),
(763, 30, 5, 'No', '2015-10-28 13:27:52'),
(764, 30, 6, 'Yes', '2015-10-28 13:27:52'),
(765, 30, 7, 'Bad', '2015-10-28 13:27:52'),
(766, 30, 8, 'Yes', '2015-10-28 13:27:52'),
(767, 35, 1, 'Vaginal Birth', '2015-10-28 13:28:34'),
(768, 35, 2, '20', '2015-10-28 13:28:34'),
(769, 35, 4, 'No', '2015-10-28 13:28:34'),
(770, 35, 8, 'No', '2015-10-28 13:28:34'),
(771, 35, 9, 'Sad', '2015-10-28 13:29:03'),
(772, 35, 10, 'Health Professional', '2015-10-28 13:29:03'),
(773, 35, 11, 'Midwife', '2015-10-28 13:29:03'),
(774, 35, 12, 'Known Midwife', '2015-10-28 13:29:03'),
(775, 35, 19, 'My Health', '2015-10-28 13:29:03'),
(776, 35, 22, 'Talking with me about my feelings', '2015-10-28 13:29:03'),
(777, 35, 30, '20', '2015-10-28 13:29:03'),
(778, 35, 31, 'Very Helpful', '2015-10-28 13:29:03'),
(779, 35, 32, 'Good', '2015-10-28 13:29:03'),
(780, 34, 1, 'Vaginal Birth with Instruments', '2015-10-28 13:29:55'),
(781, 34, 2, '40', '2015-10-28 13:29:55'),
(782, 34, 4, 'No', '2015-10-28 13:29:55'),
(783, 34, 8, 'No', '2015-10-28 13:29:55'),
(784, 34, 9, 'Very happy', '2015-10-28 13:31:05'),
(785, 34, 10, 'Health Professional', '2015-10-28 13:31:05'),
(786, 34, 11, 'Doctor', '2015-10-28 13:31:05'),
(787, 34, 13, 'Senior Dr', '2015-10-28 13:31:05'),
(788, 34, 19, 'My Health', '2015-10-28 13:31:05'),
(789, 34, 22, 'Pain Relief/Medications', '2015-10-28 13:31:05'),
(790, 34, 30, '50', '2015-10-28 13:31:05'),
(791, 34, 31, 'Very Helpful', '2015-10-28 13:31:05'),
(792, 34, 32, 'Good', '2015-10-28 13:31:05'),
(793, 34, 3, '50', '2015-10-28 13:32:25'),
(794, 34, 33, 'Happy', '2015-10-28 13:32:25'),
(795, 34, 34, '40', '2015-10-28 13:32:25'),
(796, 34, 35, 'Health Professional', '2015-10-28 13:32:25'),
(797, 34, 36, 'Doctor', '2015-10-28 13:32:25'),
(798, 34, 39, 'My Family GP', '2015-10-28 13:32:25'),
(799, 34, 44, 'My baby', '2015-10-28 13:32:25'),
(800, 34, 47, 'Information about baby care', '2015-10-28 13:32:25'),
(801, 34, 48, 'Baby', '2015-10-28 13:32:25'),
(802, 34, 50, '40', '2015-10-28 13:32:25'),
(803, 34, 51, 'Somewhat Helpful', '2015-10-28 13:32:25'),
(804, 34, 52, 'Good', '2015-10-28 13:32:25');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `message_order` enum('1','2','3') NOT NULL,
  `title` varchar(75) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order` (`message_order`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `message_order`, `title`, `text`) VALUES
(1, '1', 'Welcome!', 'The newly launched POPPY website is now available!'),
(3, '2', 'Already registered?', 'Check your email for your login credentials.'),
(4, '3', 'Forgot your password?', 'Check out the forgot password link.');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_question_id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `question_order` varchar(11) NOT NULL,
  `type` enum('dropdownlist','checkbox','radio','text','textarea','slider') NOT NULL,
  `options` varchar(500) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `dependant_question_order` varchar(11) NOT NULL,
  `dependant_value` varchar(255) NOT NULL,
  PRIMARY KEY (`question_id`),
  UNIQUE KEY `order` (`question_order`),
  KEY `survey_id` (`survey_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `parent_question_id`, `text`, `question_order`, `type`, `options`, `survey_id`, `dependant_question_order`, `dependant_value`) VALUES
(1, 0, 'What kind of birth did you have?', '1', 'dropdownlist', 'Vaginal Birth#Vaginal Birth with Instruments#Caesarean Section', 1, '', ''),
(2, 0, 'How old is your baby now? (Hours)', '2', 'slider', '', 1, '', ''),
(3, 0, 'How long did you stay in hospital after birth? (Days)', '3', 'slider', '', 3, '', ''),
(4, 0, 'Were there any complications related to your birth?', '4', 'dropdownlist', 'Yes#No', 1, '', ''),
(5, 4, 'Did the complications relate to you', '5', 'dropdownlist', 'Yes#No', 1, '', 'Yes'),
(6, 4, 'Did the complications relate to your baby?', '6', 'dropdownlist', 'Yes#No', 1, '', 'Yes'),
(7, 0, 'Please describe these health complications for you or your baby:', '7', 'textarea', '', 1, '', ''),
(8, 0, 'Did you breastfeed your baby in the delivery suite or the birth centre?', '8', 'dropdownlist', 'Yes#No', 1, '', ''),
(9, 0, 'How are you feeling now?', '9', 'slider', '', 2, '', ''),
(10, 0, 'Who came into your room in the hospital or performed a task for you and/or your baby?', '10', 'dropdownlist', 'Health Professional#Housekeeping/Catering#Visitors#Other`', 2, '', ''),
(11, 10, '', '10.1', 'dropdownlist', 'Midwife#Nurse#Doctor#Other Health Professionals', 2, '10', 'Health Professional'),
(12, 11, '', '10.1.1', 'dropdownlist', 'Known Midwife#New Midwife', 2, '10.1', 'Midwife'),
(13, 11, '', '10.1.2', 'dropdownlist', 'Senior Dr#Junior Dr#Paediatrician#GP', 2, '10.1', 'Doctor'),
(14, 11, '', '10.1.3', 'dropdownlist', 'Lactation Consultant#Student#Hearing Technician#Blood Collector#Social Worker#Mental Health#Physiotherapist', 2, '10.1', 'Other Health Professionals'),
(15, 10, '', '10.2', 'dropdownlist', 'Partner#Relatives#Friends#Other woman''s visitors in room', 2, '10', 'Visitors'),
(16, 10, '', '10.3', 'dropdownlist', 'Online Parent Support#Volunteer#Church Group or Volunteer#Wardsperson', 2, '10', 'Other'),
(17, 16, '', '10.3.1', 'dropdownlist', 'Online chat room/forum for parents#Searched internet for information ', 2, '10.3', 'Online Parent Support'),
(18, 16, '', '10.3.2', 'dropdownlist', 'ABA#Hospital Volunteer#Church group or volunteer', 2, '10.3', 'Volunteer'),
(19, 0, 'What was the purpose of this interaction and what did they do?', '11', 'dropdownlist', 'My Health#My Baby''s Health#Feeding My Baby#Discharge Information#Catering#Cleaning#Staff In My Room', 2, '', ''),
(22, 19, '', '11.1', 'dropdownlist', 'Talking with me about my feelings#Taking my temperature/pulse/BP#Blood tests#Checking my body (e.g. stitches)#Pain Relief/Medications#Supporting me with my personal hygiene#Doing Paperwork#Providing education about my health#Referred me to a service/professional#Other', 2, '11', 'My Health'),
(23, 19, '', '11.2', 'dropdownlist', 'Information about baby care#Checking my baby#Blood tests/weighing baby#Immunisation e.g. Hepatitis B#Doing paperwork about baby', 2, '11', 'My Baby''s Health'),
(24, 23, '', '11.2.1', 'dropdownlist', 'Bowel movements/Passing Urine/Jaundice#Umbilical core care#Baby bathing#Sleep/settling/crying#General baby care', 2, '11.2', 'Information about baby care'),
(25, 19, '', '11.3', 'dropdownlist', 'Breastfeeding support/education#Formula feeding assistance/education#Expressing breastmilk education/support#Group breastfeeding class', 2, '11', 'Feeding my baby'),
(26, 19, '', '11.4', 'dropdownlist', 'Told about community services e.g. child & family health nurse;#Blue book/SIDS/safe sleeping#Information prior to discharge e.g. contraception/physical signs to watch for', 2, '11', 'Discharge Information'),
(27, 19, '', '11.5', 'dropdownlist', 'Meal delivered/tray removed#Morning/Afternoon tea delivered#Made own breakfast in kitchen#Visit to kitchen/coffee shop for tea/coffee', 2, '11', 'Catering'),
(28, 19, '', '11.6', 'dropdownlist', 'In the room#Around my bed', 2, '11', 'Cleaning'),
(29, 19, '', '11.7', 'dropdownlist', 'Caring for other women/babies in room#Looking for other staff', 2, '11', 'Staff in my room'),
(30, 0, 'How long did the professional or other person take when performing this task? (Minutes)', '12', 'slider', '', 2, '', ''),
(31, 0, 'How helpful was this professional?', '13', 'slider', '', 2, '', ''),
(32, 0, 'Can you recount any memorable moments (good/bad) or do you have any particular concerns or worries at present?', '14', 'textarea', '', 2, '', ''),
(33, 0, 'How are you feeling today?', '15', 'slider', '', 3, '', ''),
(34, 0, 'How old is your baby today? (Weeks)', '16', 'slider', '', 3, '', ''),
(35, 0, 'Did you have contact either today or recently with a health professional or other service provider in your home or in the community? If so who was this contact with?', '17', 'dropdownlist', 'Health Professional#Other', 3, '', ''),
(36, 35, '', '17.1', 'dropdownlist', 'Midwife#Child & Family Health Nurse#Doctor#Other Health Professionals', 3, '17', 'Health Professional'),
(37, 36, '', '17.1.1', 'dropdownlist', 'First home visit by midwife#Follow-up home visit#Telephone call from midwife#Went back to hospital to see midwife', 3, '17.1', 'Midwife'),
(38, 36, '', '17.1.2', 'dropdownlist', 'First home visit#Follow-up visit by child & family health nurse in home#Telephone call from child & family health nurse#Went to clinic to see nurse#Saw nurse at mothers'' group#24 Hour patient advice phone line', 3, '17.1', 'Child & Family Health Nurse'),
(39, 36, '', '17.1.3', 'dropdownlist', 'My Family GP#A new GP#Paedatrician#Obstetrician#Other Doctor', 3, '17.1', 'Doctor'),
(40, 36, '', '17.1.4', 'dropdownlist', 'Lactation consultant in community#Lactation consultant in hospital#SWISH Hearing screener#Blood Collector#Other e.g. Social Worker or Naturopath', 3, '17.1', 'Other Health Professionals'),
(41, 35, '', '17.2', 'dropdownlist', 'Australian Breastfeeding Association#Parent/mother group through church or other community group#Online parent support', 3, '17', 'Other'),
(42, 41, '', '17.2.1', 'dropdownlist', 'ABA group#ABA phone line#ABA website/facebook', 3, '17.2', 'Australian Breastfeeding Association'),
(43, 41, '', '17.2.2', 'dropdownlist', 'Online chat room/forum for parents#Searched internet for information ', 3, '17.2', 'Online parent support'),
(44, 0, 'What did they do?', '18', 'dropdownlist', 'My Health#My baby''s health#Feeding my baby', 3, '', ''),
(46, 44, '', '18.1', 'dropdownlist', 'Talking with me about my feelings/My birth#Talked with me about my relationship with my  partner#Talked with me about my family#Talked with me about being a parent#Taking my temperature/ pulse/BP#Blood tests#Checking my body(e.g. stitches)#Advice on pain relief/medications#Doing paperwork/computer work#Providing education about my health#Other', 3, '18', 'My Health'),
(47, 44, '', '18.2', 'dropdownlist', 'Information about baby care#Checking my baby - e.g. weighing/reflexes/ vision#Blood tests#Immunisation#Doing paperwork/computer work#Other', 3, '18.2', 'My baby''s health'),
(48, 47, '', '18.2.1', 'dropdownlist', 'Baby''s growth and development#Bowel movements/passing urine/jaundice#Umbilical cord care#Baby bathing#Sleep/settling/crying#General baby care', 3, '18.2', 'Information about baby care'),
(49, 44, '', '18.3', 'dropdownlist', 'Breastfeeding support/education#Formula feeding assistance/education#Expressing breastmilk education/support#Breastfeeding Support group#Other', 3, '18', 'Feeding my baby'),
(50, 0, 'How long did the visit by the professional or other person last? (Minutes)', '19', 'slider', '', 3, '', ''),
(51, 0, 'How helpful was this professional?', '20', 'slider', '', 3, '', ''),
(52, 0, 'Can you recount any memorable moments (good/bad) or did you have any particular concerns or worries today?', '21', 'textarea', '', 3, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE IF NOT EXISTS `survey` (
  `survey_id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_name` varchar(255) NOT NULL,
  `survey_order` tinyint(4) NOT NULL,
  PRIMARY KEY (`survey_id`),
  UNIQUE KEY `survey_order` (`survey_order`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `survey`
--

INSERT INTO `survey` (`survey_id`, `survey_name`, `survey_order`) VALUES
(1, 'Introduction', 1),
(2, 'In Hospital', 2),
(3, 'At Home / In the Community', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `survey_stage` varchar(50) NOT NULL DEFAULT 'Introduction',
  `lastLogin` date NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `admin`, `survey_stage`, `lastLogin`) VALUES
(1, 'admin', '$6$rounds=5000$poppysaltforpass$4lTSSf4TNGTwtzFpDiLjKliotrV2Ot2Z5pAZF7bk9RYZIf0QnWwF7rkK/AKfwpVKFPZIUEhSqHbRX8/9AVQTH1', 'admin@admin.com', 1, 'Hospital', '0000-00-00'),
(2, 'test', '$6$rounds=5000$poppysaltforpass$uVbtCHha/MJn6yqSPGXzaPPgc5aZ0motZY828syoNAI7USJabc5TlVZ/YDbPj80yeGaoODuLoVeqUDKBQWzxW/', 'poppy@gmail.com', 0, 'Hospital', '2015-10-24'),
(30, 'sally', '$6$rounds=5000$poppysaltforpass$PhQsu9qtNng3RT.Uav5SACh2VrYkyqS/TNvvrOIO2RBYARBNh47G/ADdftlJVMG.j3zOL1x8YKyKRxqUDgYs6.', 'sally@hotmail.com', 0, 'Hospital', '2015-10-28'),
(34, 'sandra', '$6$rounds=5000$poppysaltforpass$2ojZqSQTrkpfd6kfAC3bmNICsVgEssDI7p.tz6D1opNtmkZmYVDq6jIhkfVmEy70nl55c3yqL/AJGjQy2Ll3v1', 'sandra@hotmail.com', 0, 'HomeAndCommunity', '2015-10-28'),
(35, 'jessica', '$6$rounds=5000$poppysaltforpass$DopOmDv3Ivt1II3hWFwzXivMvXH0CNX6h/eso6vn3e1w0e.NNlQx53dREKaS5meXP90.16cQvGROH9dqWTFW31', 'jessica1@gmail.com', 0, 'HomeAndCommunity', '2015-10-28');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`survey_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
