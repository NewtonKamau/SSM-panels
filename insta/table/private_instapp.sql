-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 27, 2018 at 02:17 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `private_instapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `account_username` varchar(55) NOT NULL,
  `account_password` varchar(155) NOT NULL,
  `account_id` varchar(155) NOT NULL,
  `account_userid` int(11) NOT NULL,
  `account_name` varchar(155) NOT NULL,
  `account_category` varchar(155) NOT NULL,
  `account_proxy` varchar(155) NOT NULL,
  `account_profile` text NOT NULL,
  `account_followers` int(11) NOT NULL,
  `account_likes` int(11) NOT NULL,
  `account_media` int(11) NOT NULL,
  `account_level` int(11) NOT NULL,
  `account_added` datetime NOT NULL,
  `system_followers` text NOT NULL,
  `system_likes` int(11) NOT NULL,
  `system_comments` int(11) NOT NULL,
  `system_index1` int(11) NOT NULL,
  `system_index2` int(11) NOT NULL,
  `system_index3` int(11) NOT NULL,
  `system_comment_index1` int(11) NOT NULL,
  `system_comment_index2` int(11) NOT NULL,
  `system_comment_index3` int(11) NOT NULL,
  `system_comment_index4` int(11) NOT NULL,
  `system_index4` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_username`, `account_password`, `account_id`, `account_userid`, `account_name`, `account_category`, `account_proxy`, `account_profile`, `account_followers`, `account_likes`, `account_media`, `account_level`, `account_added`, `system_followers`, `system_likes`, `system_comments`, `system_index1`, `system_index2`, `system_index3`, `system_comment_index1`, `system_comment_index2`, `system_comment_index3`, `system_comment_index4`, `system_index4`) VALUES
(53, 'hamptonscollection', 'hamptons2012', '5461490717', 30, 'Hamptons Collections', 'fahsionnstyle', '', 'https://scontent-dfw5-2.cdninstagram.com/vp/7e77533db036fe1f9cd1ad2a9b0412e3/5BCF940F/t51.2885-19/18512517_828682543947754_3631456571743010816_a.jpg', 19832, 0, 16, 3, '2018-07-24 05:55:30', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(54, 'actionpicgirl', 'bill040506', '', 32, '', 'all', '', '', 0, 0, 0, 0, '2018-07-28 00:13:24', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(55, 'juicingforenergy', 'xavier1413blake', '', 32, '', 'foodnnutrition', '', '', 0, 0, 0, 0, '2018-07-28 00:15:18', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(56, 'elmehdielboukili', 'n0th1ngh3r3@', '1837794196', 29, 'el mehdi el boukili', 'fahsionnstyle', '', 'https://scontent-iad3-1.cdninstagram.com/vp/4fcc2ec06da05e202319bea8f4cab3df/5BDE6593/t51.2885-19/10533110_1411172069200591_16185321_a.jpg', 131, 0, 10, 1, '2018-07-28 08:33:34', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(57, 'funpupdog', 'xavier1413blake', '4457196791', 32, 'Bruno', 'petsnanimals', '', 'https://scontent-iad3-1.cdninstagram.com/vp/2fa909ecbb2101d736b9ee99fa62ac9f/5BECE0B8/t51.2885-19/17932199_1212103638907628_1814390603274780672_a.jpg', 2784, 0, 895, 1, '2018-07-31 00:30:04', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(58, 'cannafrezze.de', 'bufuhowhirgh420', '', 34, '', 'luxurynmotivation', '', '', 0, 0, 0, 0, '2018-08-02 08:01:24', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(59, 'omostorm', 'cutie1', '', 36, '', 'personalntalent', '', '', 0, 0, 0, 0, '2018-08-02 10:41:32', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(62, 'thecelebstagram ', 'cutie1', '8022728137', 36, 'Celebstagram', 'all', '', 'https://scontent-iad3-1.cdninstagram.com/vp/8caeec058e529f820153268b748a5b06/5BEF9F68/t51.2885-19/36159831_1029777013855367_304746213326979072_n.jpg', 529, 0, 14, 1, '2018-08-02 17:33:26', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(63, 'horwitzmary', '6vkfs8d9', '', 40, '', 'carsnbikes', '', '', 0, 0, 0, 0, '2018-08-02 22:22:10', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(64, 'fireychicks', 'stosek21', '5799992827', 41, 'Daily Babes ????', 'fitnessnsports', '', 'https://scontent-iad3-1.cdninstagram.com/vp/f40cd7feca5573dcb3b344396ebafc7b/5BED81C0/t51.2885-19/29095285_158762344814919_5893287650915254272_n.jpg', 36316, 0, 197, 4, '2018-08-03 03:30:16', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(65, 'nextlvlig@gmail.com', 'taco4you', '', 44, '', 'Account Category *', '', '', 0, 0, 0, 0, '2018-08-03 10:18:17', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(67, 'basketballhistorymuseum', 'taco4you', '', 44, '', 'fitnessnsports', '', '', 0, 0, 0, 0, '2018-08-03 10:19:28', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(68, 'denexir', '$@$@r52252288', '', 47, '', 'foodnnutrition', '', '', 0, 0, 0, 0, '2018-08-19 19:02:40', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(69, 'quotiva8er', 'xavier1413blake', '', 32, '', 'quotesntextes', '', '', 0, 0, 0, 0, '2018-09-03 21:42:47', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(70, 'toniphotoqueen', 'xavier1413blake', '8539307400', 32, 'toni a holt', 'fahsionnstyle', '', 'https://scontent-arn2-1.cdninstagram.com/vp/74d4a001973ffb1c519909dc584b0316/5C328D7A/t51.2885-19/11906329_960233084022564_1448528159_a.jpg', 0, 0, 0, 0, '2018-09-04 21:26:07', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(71, 'shoes.in.city', 'stosek21', '2973573764', 41, 'Lady', 'fahsionnstyle', '', 'https://scontent-iad3-1.cdninstagram.com/vp/1b29a41f5b3744de473120742c6ea5f8/5C284ED5/t51.2885-19/16228644_382355708791584_7218023210460119040_n.jpg', 16934, 0, 176, 3, '2018-09-11 06:42:15', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(72, 'charismaticlabs', 'Charismatic@123', '7497092697', 31, 'Charismatic Labs', 'fahsionnstyle', '', 'https://scontent-dfw5-2.cdninstagram.com/vp/261e661511daf4c59ae9fed725e093ed/5C1C1723/t51.2885-19/29738897_1074963189309413_5663989672083193856_n.jpg', 4, 0, 1, 0, '2018-09-19 22:45:22', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(73, 'ram_sharma82', 'ram12345', '8610122207', 50, 'Ram Sharma', 'all', '', 'https://scontent-iad3-1.cdninstagram.com/vp/afe25a4fea5a860cb39b2c7f423bd21c/5C418838/t51.2885-19/41687570_320188691870309_426042124195069952_n.jpg', 1, 0, 2, 0, '2018-09-23 21:57:00', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(74, 'laughfydotcom', 'VJ_9587902040', '', 50, '', 'humournmemes', '', '', 0, 0, 0, 0, '2018-09-23 22:06:30', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(75, 'lovesharingeconomy.com@gmail.com', 'LOveSharing@123', '5549894623', 50, 'LoveSharingEconomy', 'quotesntextes', '', 'https://scontent-iad3-1.cdninstagram.com/vp/454d10962e0e23ae0e28c50370412017/5C3FB226/t51.2885-19/30953998_2027877177460334_513404400400596992_n.jpg', 67, 0, 12, 0, '2018-09-23 22:09:13', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(76, 'lovesharingeconomy.com1@gmail.com', '2324324234', '', 50, '', 'Account Category *', '', '', 0, 0, 0, 0, '2018-09-24 02:00:53', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(77, 'lovesharingeconomy.com12@gmail.com', 'LOveSharing@123', '', 50, '', 'Account Category *', '', '', 0, 0, 0, 0, '2018-09-24 02:01:57', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password_hash`) VALUES
(1, 'elmehdi', 'elmehdi.elboukili@gmail.com', '$2y$10$lsSb4LzIOuwaUn5aILZ4BuLvnZgsz22TNTXeCtQpItSPmisgjKKuW');

-- --------------------------------------------------------

--
-- Table structure for table `proxies`
--

CREATE TABLE `proxies` (
  `id` int(11) NOT NULL,
  `proxy` text NOT NULL,
  `working` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proxies`
--

INSERT INTO `proxies` (`id`, `proxy`, `working`, `userid`) VALUES
(91, '157.65.168.93:3128', 1, 1),
(92, '45.70.147.130:3128', 1, 0),
(93, '140.227.61.70:3128', 1, 0),
(94, '94.130.14.146:31288', 1, 0),
(95, '23.97.215.153:3128', 1, 0),
(96, '35.227.54.242:3128', 1, 0),
(97, '89.236.17.106:3128', 1, 0),
(98, '191.252.100.87:3128', 1, 0),
(99, '80.211.175.118:3128', -1, 0),
(100, '51.15.237.146:3128', 1, 0),
(101, '159.203.116.50:3128', 1, 0),
(102, '177.67.83.134:3128', -1, 0),
(103, '66.63.9.26:3128', 1, 0),
(104, '129.213.76.9:3128', 1, 0),
(105, '152.157.119.253:3128', 1, 0),
(106, '217.61.23.234:3128', -1, 0),
(107, '204.48.19.88:3128', 1, 0),
(108, '167.99.188.36:3128', 1, 0),
(109, '51.15.227.220:3128', 1, 0),
(110, '163.172.86.64:3128', 1, 0),
(111, '54.233.85.126:3128', 1, 0),
(112, '54.209.135.103:3128', -1, 0),
(113, '179.43.141.201:3128', -1, 0),
(114, '157.65.171.205:3128', 1, 0),
(115, '52.27.170.239:3128', -1, 0),
(116, '182.23.28.188:3128', 1, 0),
(117, '190.205.40.43:3128', -1, 0),
(118, '212.237.15.218:3128', 1, 0),
(119, '177.86.31.153:3128', 1, 0),
(120, '45.77.3.238:3128', 1, 0),
(121, '202.29.238.161:3128', -1, 0),
(122, '119.42.87.98:3128', -1, 0),
(123, '144.217.248.59:3128', 1, 0),
(124, '201.249.118.245:3128', -1, 0),
(125, '157.65.170.226:3128', 1, 0),
(126, '157.7.141.56:3128', 1, 0),
(127, '139.59.152.254:3128', -1, 0),
(128, '128.199.254.244:3128', 1, 0),
(129, '176.123.230.146:3128', 1, 0),
(130, '148.153.1.78:3128', -1, 0),
(131, '189.5.21.217:3128', -1, 0),
(132, '177.69.217.40:3128', 1, 0),
(133, '138.201.63.123:31288', 1, 0),
(134, '157.65.31.132:3128', 1, 0),
(135, '211.75.82.206:3128', 1, 0),
(136, '157.65.25.61:3128', -1, 0),
(137, '157.65.29.185:3128', 1, 0),
(138, '201.16.239.34:3128', 1, 0),
(139, '157.65.30.235:3128', 1, 0),
(140, '177.207.193.221:3128', 1, 0),
(141, '49.51.86.151:3128', -1, 0),
(142, '43.255.29.164:3128', -1, 0),
(143, '157.7.140.207:3128', -1, 0),
(144, '140.227.28.139:3128', 1, 0),
(145, '54.251.182.165:3128', -1, 0),
(146, '61.7.219.52:3128', -1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `id` int(11) NOT NULL,
  `record_id` text NOT NULL,
  `record_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`id`, `record_id`, `record_value`) VALUES
(1, '7518038625', 'homielandny'),
(2, '2263837445', 'anooshahmer12official'),
(3, '269761346', 'ayogithatlovesmakeup'),
(4, '16320055', 'nosidamurray'),
(5, '3088890545', 'coloringchaos'),
(6, '340737166', 'viva_zerimar'),
(7, '56191395', 'crisandriato'),
(8, '644997505', 'lando_augusto'),
(9, '2923505580', 'hineni.gottenbos'),
(10, '38913964', 'hortonsheroes'),
(11, '191624606', 'bedazzledwitchery'),
(12, '1102118512', 'everyone_loves_rozay'),
(13, '41561085', 'charliemacxo'),
(14, '1594764058', 'adj_wanderlust'),
(15, '1570668808', 'danny3s'),
(16, '1419250719', 'sakura.87'),
(17, '53255452', 'planet_tori'),
(18, '7039581617', 'centralfovia'),
(19, '4226711339', 'nelinlee'),
(20, '18944247', 'ohbogado'),
(21, '144966961', 'emmamcdizzle'),
(22, '204505082', 'georgfannar'),
(23, '230040843', 'bigquakerboy'),
(24, '3283924509', 'bobbirebell1'),
(25, '3206092231', 'zaynahmusic'),
(26, '44943828', 'adriaticjewelry'),
(27, '1306090451', 'habanerohakan'),
(28, '7982081408', 'actordothprotesttoomuch'),
(29, '6125835312', 'samdanzbakes'),
(30, '1449948731', 'on_the_go_veterinary_services'),
(31, '16369740', 'ckgalli'),
(32, '5667858209', 'ses425'),
(33, '5659355', 'rebeccajarvis'),
(34, '56097365', 'cchhaacchhee'),
(35, '327123238', 'abcworldnewstonight'),
(36, '459426640', 'zeeshaanshabbir'),
(37, '1946090554', 'ed.rodz'),
(38, '145538397', '__arthr'),
(39, '2979476292', 'evmeyerphoto'),
(40, '607394181', 'theguyfrommexico'),
(41, '577029321', 'iamrcm'),
(42, '1934728292', 'mohamedgharafi'),
(43, '5880904408', 'aabiryazami'),
(44, '2145215446', 'abdelaziz_zbidi'),
(45, '3286387534', 'abdelhakimakaoui'),
(46, '1308824772', 'r.abdennasser'),
(47, '3703379000', 'abderrahimdouini'),
(48, '3545395128', 'a.elhilali00'),
(49, '3191100898', 'abdrazzakelboukili'),
(50, '4917600837', 'ayou.b.elkhadir'),
(51, '625168099', 'ach.andalou'),
(52, '4859459842', 'adilmaaqoul'),
(53, '4473659005', 'turabi_gift_creation'),
(54, '865682977', 'aybouaicha'),
(55, '5661475962', 'abarca5064'),
(56, '2097355096', 'russnutt'),
(57, '6042770177', 'elmesnaouiamine'),
(58, '1529044675', 'runhardty'),
(59, '1807595243374175022', 'BkV3kv7AOMu'),
(60, '1807402320112370916', 'BkVLtWIg8Tk'),
(61, '1807388708129608678', 'BkVInQ_HhPm'),
(62, '1807379359401990249', 'BkVGfOTh1hp'),
(63, '1807355578865182148', 'BkVBFK9FGXE'),
(64, '1807609354757789430', 'BkV6yGLAtb2'),
(65, '1807608562881748052', 'BkV6mkrhVxU'),
(66, '1807600065733397598', 'BkV4q7GAwxe'),
(67, '1807599333785584161', 'BkV4gRahcIh'),
(68, '1807599286096336076', 'BkV4flABZTM'),
(69, '1807609672293611300', 'BkV62t5nvck'),
(70, '1807578045864538190', 'BkVzqffjPBO'),
(71, '1807569803269724480', 'BkVxyi-nVlA'),
(72, '1807539999644474335', 'BkVrA2MHlvf'),
(73, '1807530633753757872', 'BkVo4jhh4iw'),
(74, '1806757785705012137', 'BkS5KIsHlup'),
(75, '1805433368809173033', 'BkOMBVVgfAp'),
(76, '1804042481258419721', 'BkJPxQXH1YJ'),
(77, '1803908391280399729', 'BkIxR_VnVVx'),
(78, '1803159996886597108', 'BkGHHavnr30'),
(79, '1805312950098338896', 'BkNwpArBiRQ'),
(80, '1803681577177469684', 'BkH9taPlFL0'),
(81, '1803680484494401255', 'BkH9dgml97n'),
(82, '1808048060116518040', 'BkXeiGYFESY'),
(83, '1808048044211242401', 'BkXeh3kDQWh'),
(84, '1808046405437128333', 'BkXeKBVgH6N'),
(85, '1808047624083860076', 'BkXebwSgeps'),
(86, '1808047432188033579', 'BkXeY9kn_or'),
(87, '1808046866408288587', 'BkXeQuphjFL'),
(88, '1808046656759923886', 'BkXeNrZggSu'),
(89, '1808046651123468033', 'BkXeNmJjIcB'),
(90, '1808046461389174963', 'BkXeK1cgPiz'),
(91, '1808046453178687410', 'BkXeKtzHt-y'),
(92, '1808046090824350784', 'BkXeFcVHnxA'),
(93, '1808045935918463476', 'BkXeDMEAjn0'),
(94, '1808045445664937048', 'BkXd8DenxRY'),
(95, '1808045363011407079', 'BkXd62gFkzn'),
(96, '1808044955080724568', 'BkXd06lhhBY'),
(97, '1808044829907444888', 'BkXdzGAnWSY'),
(98, '1808044738035394282', 'BkXdxwcnSbq'),
(99, '1808044725022987353', 'BkXdxkVA5RZ'),
(100, '1808044668844715807', 'BkXdwwAhy8f'),
(101, '1808044291231472556', 'BkXdrQVBlus'),
(102, '1808044145789641792', 'BkXdpI4BCRA'),
(103, '1808043972348412743', 'BkXdmnWHQNH'),
(104, '1808043977069795475', 'BkXdmrvh5iT'),
(105, '1808043738698630709', 'BkXdjNvgEY1'),
(106, '1808043730109136795', 'BkXdjFvhv-b'),
(107, '1808043671474394374', 'BkXdiPIn9UG'),
(108, '1808043577999554038', 'BkXdg4FFvX2'),
(109, '1808043409295100795', 'BkXdea9hUt7'),
(110, '1808043330399983152', 'BkXddRfAVYw'),
(111, '1808043065530979925', 'BkXdZazlRZV'),
(112, '1808043057780547297', 'BkXdZTlnt7h'),
(113, '1808043032437021316', 'BkXdY7_B1qE'),
(114, '1808084199849298855', 'BkXmwAIA4un'),
(115, '1808056767599392630', 'BkXggz2gLd2'),
(116, '1808020613699055607', 'BkXYSs6Ha_3'),
(117, '1808090787062531221', 'BkXoP28hMSV'),
(118, '1808079638895803266', 'BkXltoaADuC'),
(119, '1808073737048768247', 'BkXkXv4gT73'),
(120, '1808075469573113305', 'BkXkw9bAMXZ'),
(121, '1808059949390224957', 'BkXhPHIA949'),
(122, '1808045491666920586', 'BkXd8uUjaSK'),
(123, '1808055222201673608', 'BkXgKUlnueI'),
(124, '1808050804869189632', 'BkXfKCoFlAA'),
(125, '7644815827', 'katelonney'),
(126, '3119315053', 'lhuanran'),
(127, '7700667698', 'switchuppjay'),
(128, '7791192935', 'affiliate.marketing_jobs'),
(129, '7656025331', 'making_a_million'),
(130, '325324938', 'jbramble23'),
(131, '8249363402', 'kaenjohnson'),
(132, '8249363402', 'kaenjohnson'),
(133, '435174746', 'deeprootssalon'),
(134, '435174746', 'deeprootssalon'),
(135, '7461712222', '11rahil123_charak'),
(136, '7461712222', '11rahil123_charak'),
(137, '197167745', 'mrsmummypennyuk'),
(138, '197167745', 'mrsmummypennyuk'),
(139, '7408942528', 'homemoneytree'),
(140, '7408942528', 'homemoneytree'),
(141, '4465678309', 'sandstormdigital'),
(142, '7229844617', 'effe_srl'),
(143, '5478221252', 'up.design.spain'),
(144, '8251836243', 'mr._flip_cash_agent'),
(145, '6199161786', 'thebartorg'),
(146, '6198631212', 'nkdforex'),
(147, '2308933103', 'lesstosuccess'),
(148, '5799900402', 'trevormozingo'),
(149, '6999630970', 'northstardigitalmedia'),
(150, '7947422903', 'juanchobolas'),
(151, '5869226412', 'expert_trader101'),
(152, '8011464796', 'adventuretravelig'),
(153, '5483680424', 'anas.zinit'),
(154, '40177637', 'anass9'),
(155, '1182224124', 'anas.tzn'),
(156, '329127658', 'andersonvsantos'),
(157, '7816020852', 'ayoubjoghraf'),
(158, '2236835691', 'aissamzinit'),
(159, '2258450629', 'bahaa_eddine_benhayoun'),
(160, '3255660300', 'boubakerboughazroun'),
(161, '3597430100', 'brahimfatriq'),
(162, '475886150', 'dazzling_may23'),
(163, '6965267843', 'younes_chekrouni'),
(164, '3287428483', 'club_happy_travel'),
(165, '1972151916', 'ayoub.dali90'),
(166, '2298106515', 'dr.aristide'),
(167, '7605951357', 'doctor_beh'),
(168, '5619155933', 'barbo_abdel'),
(169, '7869896611', 'elkitaniasmaa'),
(170, '1372656352', 'elmehdidikouk'),
(171, '30039149', 'evards'),
(172, '6102974720', 'farahqouicem'),
(173, '3283692436', 'garimabajoria017'),
(174, '1556869559', 'hamzakadd5'),
(175, '2533515802', 'hassandraoui'),
(176, '2695898212', 'hichamelmekkaoui'),
(177, '5592319382', 'hind_hinnd'),
(178, '294570808', 'imanenow'),
(179, '7281170793', 'ismail_housni09'),
(180, '2154052392', 'jihade_makhlouf'),
(181, '1833582719', 'kamal.ghannam'),
(182, '2289288742', 'bellarkhadija'),
(183, '1416739327', 'khalid.aitikken'),
(184, '1821167764', 'khalid_belmouden'),
(185, '3176859950', 'machchatekhalid'),
(186, '1548445133', 'marbouhkhalid'),
(187, '2278843864', 'my_khal'),
(188, '5602802767', 'komalscreation'),
(189, '2135832905', 'manal.boo'),
(190, '3624046645', 'meddahabi'),
(191, '33923898', 'm.ayouche'),
(192, '1140255437', 'rhmehdi'),
(193, '519551585', 'adammerz'),
(194, '1974516386', 'mia_ezz'),
(195, '7517335136', 'micheldunlap3500'),
(196, '7942985888', 'arnove12'),
(197, '2899510577', 'hammanemohamed'),
(198, '291516353', 'aminetarib'),
(199, '3217325182', 'mohammedjadiri'),
(200, '2366268574', 'taha__rhazi'),
(201, '1649093640', 'mourad.ahayan'),
(202, '6723513365', 'nabilejjabri'),
(203, '5523983587', 'nabileljerrari'),
(204, '5926761491', 'naimakmichou'),
(205, '362211817', 'ibenyaich'),
(206, '1491689049', 'snawfel'),
(207, '1984521778', 'noraaaaa__1'),
(208, '7738365760', 'noureddinelamini'),
(209, '2337032290', 'noureddine.sedki'),
(210, '5679800247', 'omaranej'),
(211, '2003875511', 'elkhiwakh'),
(212, '2533632560', 'otmanehaddy'),
(213, '3103558635', 'philipjohnedwards'),
(214, '220384456', 'coldfire911'),
(215, '3554485842', 'redwanalaoui'),
(216, '3932354955', 'rim2871'),
(217, '3478075366', 'rima_mery_maya'),
(218, '7123644770', 'roman.blasko1'),
(219, '2205463710', 'saadmilanista'),
(220, '2273548288', 'said_ballouch'),
(221, '6841167143', 'saifedn'),
(222, '298738997', 'salimelmalaki'),
(223, '3305850367', 'samahbo'),
(224, '551835489', 'sami_elharrachi'),
(225, '1477307668', 'sarou_bel'),
(226, '1414996911', 'ooulghazi'),
(227, '1276245166', 'simomarzouq'),
(228, '1676453522', 'simoohameed'),
(229, '5533852442', 'soha.chana'),
(230, '426500840', 'khatirtaha'),
(231, '1582384631', 'dchich_driss'),
(232, '7411639706', 'tropicalvibin'),
(233, '3614844278', 'digitaldreamsbd'),
(234, '1713608157', 'unes.ma'),
(235, '480711286', 'arioua_yacine'),
(236, '1278558706', 'yassinei1'),
(237, '1245499682', 'yassine.bagh'),
(238, '5426136582', 'younesbahiaoui'),
(239, '192441543', 'youns_mks'),
(240, '6369391376', 'youssef.amari.3517'),
(241, '5914370954', 'b.ucf06'),
(242, '6080240513', 'youssef.ouazani'),
(243, '7028585098', 'cheyouyoussef'),
(244, '1028938525', 'ysfh90'),
(245, '2482841863', 'youssef.marruecosdeviajess'),
(246, '331697057', 'gauss212'),
(247, '6092624329', 'youss.el0312'),
(248, '3429989476', 'zakariaelalouani'),
(249, '1783249807', 'zakarialamalem'),
(250, '1488237882', 'zantarabdelhaq'),
(251, '6014965031', 'zouhirxsino'),
(252, '3421916392', '_comme.tu.veux_'),
(253, '7958008802', 'cantavecantainegol'),
(254, '1451666564', 'htioui'),
(255, '445651368', 'layla_harrasse'),
(256, '5693888114', 'chahrazad_ou'),
(257, '1507200414', 'sanaa.armal'),
(258, '1782702084', 'abidiada_m5'),
(259, '1563774340', 'cassiehowardbiz'),
(260, '2126726159', 'printyourstyle'),
(261, '1732697188', 'makeupbychaychay'),
(262, '7112055252', 'thenaturalnipple'),
(263, '2312230443', 'factsofhumanlife'),
(264, '5964546886', 'basualdomedia'),
(265, '1434201079', 'mehdikml'),
(266, '699846158', 'sirry_ismail'),
(267, '1459629217', 'modeo3'),
(268, '1708394319', 'mustapha_goool'),
(269, '384309877', 'anouaraquib'),
(270, '1156430115', 'readingwithjiji'),
(271, '201877674', 'hamza_j'),
(272, '346476098', 'anaschafai'),
(273, '671369410', 'oulayabenaddi'),
(274, '1834153798', 'hajar.hdya'),
(275, '1352827167', 'drisslaouad'),
(276, '181758289', 'benaboudmehdi'),
(277, '371909050', 'rhitout'),
(278, '1335920701', 'bachir.derfoufi'),
(279, '375449168', 'kaou_boukhrissi'),
(280, '645668505', 'mednaoufalel'),
(281, '245439570', 'melmehraz'),
(282, '1461770743', 'hadouchaimaa'),
(283, '523715070', 'rachidihicham'),
(284, '554128466', 'anaslahjouji'),
(285, '1173303251', 'ahmedlamarti'),
(286, '1118379484', 'mohamedalhamouti'),
(287, '1550869989', 'switchingmusic'),
(288, '449749977', 'mehdihadd'),
(289, '1350186407', 'hodaifa_el'),
(290, '209911716', 'mouradhimmi'),
(291, '306326429', 'covitis'),
(292, '1418658285', 'asmaaazzahaboubat'),
(293, '223110533', 'eddie05170925'),
(294, '1684208497', 'badr_tachfouti'),
(295, '255486295', 'ans_77'),
(296, '298344772', 'skinny_coffee'),
(297, '1540821327', 'othmane_semmate'),
(298, '381557567', 'oussamatouiri'),
(299, '38701889', 'imadyufayyur'),
(300, '1283603251', 'saidiahmedfouad'),
(301, '1110717711', 'chekrouniyounes'),
(302, '1291365646', 'faizchima'),
(303, '468637478', 'mohasahiri'),
(304, '1524174113', 'amineouahouah'),
(305, '593214207', 'imadegohan'),
(306, '1405926154', 'sarachell'),
(307, '1480954150', 'rachid_aitidir'),
(308, '257196251', 'graceprevails'),
(309, '1170250491', 'achrafdayyaa'),
(310, '618180857', 'safaakouiyed'),
(311, '350971098', 'asmae.bu'),
(312, '211079383', 'tlgaskins22'),
(313, '1448315570', 'moncefbenlamkaddem'),
(314, '1591718577', 'benhames23'),
(315, '43604669', 'cruise7565'),
(316, '1461055131', 'hatimnouamani'),
(317, '982495904', 'jesusanez'),
(318, '263901355', 'mcagotti'),
(319, '588496034', 'ghassane_the_maverick'),
(320, '786293901', 'gaurav291ingle'),
(321, '1185011337', 'hammoudbrahim'),
(322, '566062725', 'eliasbeg'),
(323, '297384361', 'louiseloughranmua'),
(324, '286052495', 'amineelalami'),
(325, '1435987513', 'otmanebouzekri'),
(326, '603838564', 'masterbebyka'),
(327, '201996893', 'ami_ne92'),
(328, '223859769', 'anouarraquib'),
(329, '397926038', 'zlhalas'),
(330, '1030003787', 'joobkelevra'),
(331, '1574881790', 'tahadaoudia'),
(332, '928091759', 'moradfares1'),
(333, '1579977250', 'yousseflamzouri'),
(334, '269420870', 'wailbouhichia'),
(335, '301091851', 'runforcomfort'),
(336, '207047941', 'bahij_anas'),
(337, '299524354', 'ayoub.elhaddouj'),
(338, '1526955530', 'imadtsouli'),
(339, '349622436', 'mer.y6'),
(340, '1978558430', 'ali_zamane'),
(341, '1152118444', 'haidaroumaima'),
(342, '1407739515', 'rajat__vashisht'),
(343, '1264206907', 'poutivar.adam'),
(344, '5728267972', 'cinthia_tamayo16'),
(345, '7863189905', 'otisdeceasedfather'),
(346, '3171536379', 'mehdimisane'),
(347, '5334549103', 'johnstrt1'),
(348, '5668035226', 'moryst.leeon'),
(349, '3428167248', 'fadwael.fe'),
(350, '6342461531', 'salma_tnassi'),
(351, '2571481525', 'meriemettaibi'),
(352, '3305377148', 'mesbahjihane'),
(353, '5925985973', 'hassnaerami'),
(354, '4230087406', 'azizmoutawakkil'),
(355, '3083266445', 'chaimaa_bfa'),
(356, '5619375570', 'nhwd_24'),
(357, '6026625708', 'pavlova.new.alena9626'),
(358, '5753831697', 'ouijdaneoumnia'),
(359, '6051969201', 'nomadev.co'),
(360, '6141511613', 'assasaliha55'),
(361, '3533003699', 'ziinoucha_fati'),
(362, '2224425898', 'imane_bhr'),
(363, '4024195414', 'nabilkhalidi'),
(364, '8216814874', 'diigits01'),
(365, '6917959787', 'makemoremoneymaster'),
(366, '6963003641', 'bitcoinquebec'),
(367, '8246451066', 'harris.wyatt.9'),
(368, '1503478142', 'alexgminfo'),
(369, '22765311', 'oscarmikolsmedia'),
(370, '7495710303', 'vitaliysmr'),
(371, '11910023', 'mell_dash'),
(372, '1313023507', 'justinrp98'),
(373, '3245623507', 'muskankhan9593'),
(374, '1765979809', 'idcorpcolombia'),
(375, '3688168004', 'purpleagency_sm'),
(376, '6172863499', 'agencia.geodesign'),
(377, '5990481156', 'realworks.oficial'),
(378, '4348801160', 'wydaembalagens'),
(379, '2045817472', 'digitello'),
(380, '5390658488', 'nardi.hidayat'),
(381, '7692757134', 'hack_your_mindset'),
(382, '7331002078', 'purplesquirrelmb'),
(383, '4544148339', 'get.paid.daily_'),
(384, '1827662072706390777', 'BldKPjFHlr5'),
(385, '1827661775361853124', 'BldKLOKAMbE'),
(386, '1827661573724893463', 'BldKISXgPEX'),
(387, '1827661207780426414', 'BldKC9jg4Ku'),
(388, '1827661048180516147', 'BldKAo6niUz'),
(389, '1827660800698017360', 'BldJ9CbguZQ'),
(390, '1827660609638981366', 'BldJ6QfgV72'),
(391, '1827660435407671789', 'BldJ3uOgpHt'),
(392, '1827660181836871319', 'BldJ0CEgzaX'),
(393, '1827658252533744002', 'BldJX9RFcGC'),
(394, '1827660008646913545', 'BldJxgxli4J'),
(395, '1827659985989793597', 'BldJxLrHfc9'),
(396, '1827659910951968825', 'BldJwFyg6A5'),
(397, '1827659666331626403', 'BldJsh-AWuj'),
(398, '1827659562858193493', 'BldJrBmgiJV'),
(399, '1827659341826646529', 'BldJnzwAGIB'),
(400, '1827659294515002556', 'BldJnHsAfy8'),
(401, '1827659119620809790', 'BldJkkzgGQ-'),
(402, '1827659088306476858', 'BldJkHpBZc6'),
(403, '1827658877779066312', 'BldJhDknD3I'),
(404, '1827658786115121320', 'BldJfuNA3Co'),
(405, '1827658678465438329', 'BldJeJ8l6J5');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `task_name` varchar(155) NOT NULL,
  `task_action` varchar(55) NOT NULL,
  `task_fuids_queue` text NOT NULL,
  `task_fuids_done` text NOT NULL,
  `task_fuids_done_today` text NOT NULL,
  `task_userid` int(11) NOT NULL,
  `task_accid` int(11) NOT NULL,
  `task_typeid` int(11) NOT NULL,
  `task_message` text NOT NULL,
  `task_done` int(11) NOT NULL,
  `task_stop` int(11) NOT NULL,
  `task_update` datetime NOT NULL,
  `task_processing` int(11) NOT NULL DEFAULT '0',
  `task_max_total` int(11) NOT NULL,
  `task_max_day` int(11) NOT NULL,
  `task_delay` varchar(10) NOT NULL,
  `task_threads` int(11) NOT NULL,
  `task_schedule` text NOT NULL,
  `task_scrap_elements` text NOT NULL,
  `task_category` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `task_name`, `task_action`, `task_fuids_queue`, `task_fuids_done`, `task_fuids_done_today`, `task_userid`, `task_accid`, `task_typeid`, `task_message`, `task_done`, `task_stop`, `task_update`, `task_processing`, `task_max_total`, `task_max_day`, `task_delay`, `task_threads`, `task_schedule`, `task_scrap_elements`, `task_category`) VALUES
(60, 'Add Story', 'addstory', '', '[\"a10b8e1a78bbe968f729aa8abbd1caf4\"]', '[\"a10b8e1a78bbe968f729aa8abbd1caf4\"]', 30, 53, 12, '\"Casual Summer Dress\"', 0, 0, '2018-07-28 08:54:04', 0, 0, 0, '1m', 0, '', '[\"a10b8e1a78bbe968f729aa8abbd1caf4\"]', ''),
(61, 'Add Story', 'addstory', '', '[\"c515c2fac7077b98a23c3ac977699a54\"]', '[\"c515c2fac7077b98a23c3ac977699a54\"]', 29, 56, 12, '\"\"', 0, 0, '2018-07-28 08:46:16', 0, 0, 0, '1m', 0, '', '[\"c515c2fac7077b98a23c3ac977699a54\"]', ''),
(62, 'Get Likes', 'getlikes', '', '', '', 32, 57, 1, '', 0, 0, '2018-07-31 00:35:43', 0, 30, 150, '1h', 20, '', '[]', 'petsnanimals'),
(63, 'Get Likes', 'getlikes', '', '', '', 32, 54, 1, '', 0, 0, '2018-07-31 00:37:59', 0, 30, 150, '1h', 20, '', '[]', 'all'),
(64, 'Get Likes', 'getlikes', '', '', '', 44, 67, 1, '', 0, 0, '2018-08-03 10:27:31', 0, 0, 150, '1h', 20, '', '[\"1837854624717330002\"]', 'fitnessnsports'),
(65, 'Get Likes', 'getlikes', '', '', '', 41, 64, 1, '', 0, 0, '2018-08-05 04:32:14', 0, 100, 150, '1h', 20, '', '[]', 'fitnessnsports'),
(66, 'Auto Like By Tags', 'autoliketags', '', '', '', 40, 63, 8, '', 0, 0, '2018-08-06 05:04:01', 0, 100, 100, '1h', 5, '', '[\"urbanandstreet\",\"dametraveler\",\"sheisnotlost\",\"worldnomads\",\"travellife\",\"travelingram\",\"travel\",\"instatravel\",\"nightshooters\",\"voyage\",\"amazingworld\"]', ''),
(67, 'Auto Like By Tags', 'autoliketags', '', '', '', 40, 63, 8, '', 0, 0, '2018-08-06 05:04:26', 0, 100, 100, '1h', 5, '', '[\"urbanandstreet\",\"dametraveler\",\"sheisnotlost\",\"worldnomads\",\"travellife\",\"travelingram\",\"travel\",\"instatravel\",\"nightshooters\",\"voyage\",\"amazingworld\",\"instavacation\",\"aroundtheworld\",\"travelgram\",\"bestvactions\"]', ''),
(68, 'Auto Direct Messages', 'automessage', '', '', '', 36, 62, 3, '', 0, 0, '2018-08-06 15:14:46', 0, 0, 0, '1m', 0, '', '[\"Hey! If you want to find out how to get any celebrity to interact with your page and respond to your dms then Check Out Celebstagram!\"]', ''),
(69, 'Get Likes', 'getlikes', '', '', '', 32, 55, 1, '', 0, 0, '2018-09-03 20:44:23', 0, 20, 150, '1h', 20, '', '[]', 'foodnnutrition'),
(70, 'Get Likes', 'getlikes', '', '', '', 32, 55, 1, '', 0, 0, '2018-09-03 20:44:50', 0, 20, 150, '1h', 20, '', '[\"1860782455227578959\"]', 'foodnnutrition'),
(71, 'Get Likes', 'getlikes', '', '', '', 41, 64, 1, '', 0, 0, '2018-09-11 06:33:46', 0, 200, 150, '1h', 20, '', '[]', 'fahsionnstyle'),
(72, 'Auto Like By Tags', 'autoliketags', '', '', '', 41, 71, 8, '', 0, 0, '2018-09-11 06:47:03', 0, 600, 300, '1h', 20, '', '[]', ''),
(73, 'Auto Like By Tags', 'autoliketags', '', '', '', 31, 72, 8, '', 0, 0, '2018-09-19 22:57:22', 0, 30, 30, '1h', 5, '', '[\"#startups\",\"#WebDeveloper\",\"#sharingeconomy\",\"#ecommerce\"]', ''),
(74, 'Add Post', 'addpost', '', '[\"d7882a28ab8bca9e1fb1709e3ff372f6\"]', '[\"d7882a28ab8bca9e1fb1709e3ff372f6\"]', 50, 73, 11, '\"#RNS\\nHey\"', 0, 0, '2018-09-23 21:59:55', 0, 0, 0, '1m', 0, '', '[\"d7882a28ab8bca9e1fb1709e3ff372f6\"]', ''),
(75, 'Auto Like By Username', 'autolikeusername', '', '', '', 50, 73, 9, '', 0, 0, '2018-09-23 22:02:08', 0, 1000, 100, '1h', 20, '', '[\"laughfydotcom\"]', ''),
(76, 'Get Likes', 'getlikes', '', '', '', 50, 73, 1, '', 0, 0, '2018-09-23 22:03:55', 0, 100, 150, '1h', 20, '', '[]', 'all'),
(77, 'Get Likes', 'getlikes', '', '', '', 50, 73, 1, '', 0, 0, '2018-09-23 22:04:53', 0, 100, 150, '1h', 20, '', '[\"1875353607579133889\"]', 'all'),
(78, 'Add Post', 'addpost', '', '[\"d7882a28ab8bca9e1fb1709e3ff372f6\"]', '[\"d7882a28ab8bca9e1fb1709e3ff372f6\"]', 50, 73, 11, '\"#hello\"', 0, 0, '2018-09-23 22:07:18', 0, 0, 0, '1m', 0, '', '[\"d7882a28ab8bca9e1fb1709e3ff372f6\"]', ''),
(79, 'Add Story', 'addstory', '', '[\"d7882a28ab8bca9e1fb1709e3ff372f6\"]', '[\"d7882a28ab8bca9e1fb1709e3ff372f6\"]', 50, 73, 12, '\"\"', 0, 0, '2018-09-24 02:06:06', 0, 0, 0, '1m', 0, '', '[\"d7882a28ab8bca9e1fb1709e3ff372f6\"]', '');

-- --------------------------------------------------------

--
-- Table structure for table `tasks_types`
--

CREATE TABLE `tasks_types` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_url` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks_types`
--

INSERT INTO `tasks_types` (`id`, `task_name`, `task_url`) VALUES
(1, 'Get Likes', 'getlikes'),
(2, 'Get Comments', 'getcomments'),
(3, 'Auto Direct Messages', 'automessage'),
(4, 'Auto Follow By Username', 'autofollowusername'),
(5, 'Auto Follow By Locations', 'autofollowlocations'),
(6, 'Auto Follow By Hashtags', 'autofollowtags'),
(7, 'Auto Unfollow', 'autounfollows'),
(8, 'Auto Like By Tags', 'autoliketags'),
(9, 'Auto Like By Username', 'autolikeusername'),
(10, 'Auto Like By Location', 'autolikelocations'),
(11, 'Add Post', 'addpost'),
(12, 'Add Story', 'addstory'),
(13, 'Add Album', 'addalbum');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_proxy` text NOT NULL,
  `user_timezone` text NOT NULL,
  `user_activation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_email`, `user_name`, `user_password`, `user_proxy`, `user_timezone`, `user_activation`) VALUES
(29, 'elmehdi.elboukili@gmail.com', 'elmehdi elboukili', '$2y$10$AkxXYHJ8BUVxEPGmEWlrr.QiHecNncqJynvCndWRwB83oqdvv9jY.', '', '1.0', ''),
(30, 'oikonomoutony@gmail.com', 'Tony Oikonomou', '$2y$10$OgRsFPpnxSknC1d7ayydzeKAiiKAbN4nX1Oul2O1DX8.IvCHLjefS', '', '0.0', ''),
(31, 'charismaticlabs@gmail.com', 'charismatic labs', '$2y$10$AGCC5LFwIu8VMUqcF1KtgeqsUlYn5AAERZYLEu6KZAvKkylcnmvje', '', '5.5', ''),
(32, 'williamgor@gmail.com', 'william gordon', '$2y$10$0PW/U.rUQ7WGLzgCB1DrrOPfFzJg64E44rBw8rpuhfP/dV8u17s9K', '', '0.0', ''),
(33, 'shivankarguptax1@gmail.com', 'Shivankar Gupta', '$2y$10$Ajtok6OZVdX5Q26lRT1W6eL./3PccbUXGF717ZMRKQFy1ZJVNLvtu', '', '5.5', ''),
(34, 'ignaciorw@gmail.com', 'Ignacio Rodriguez', '$2y$10$FsTUGKI0RQus5TIrV8/H8ef6pafRG8XMp6rNz0Jf4Uq4Dogseo.vC', '', '0.0', ''),
(35, 'sairosman20@gmail.com', 's b', '$2y$10$B8wjq9k4kq35gWQRY9iBrOFjtJOP5F9d1m/stPyLZ9t.OYnqEONy.', '', '1.0', ''),
(36, 'portialmorris@gmail.com', 'Portia Morris', '$2y$10$OmG4jQ.FDGyo94WMhKXik.kqY14tQxIE0bufeFXJGrUEZcA6rJDna', '', '-6.0', ''),
(37, 'kuemxblservice@gmail.com', 'Matthew Hellman', '$2y$10$c15.Q8fnFoMqItBIyP6erOY7f4jBqjX3gVM7yj7Zjz4XJ3OY.v2iO', '', '-5.0', ''),
(38, 'rettop_zsaul_@hotmail.com', 'rettop back', '$2y$10$QnT3H6RMi3TVUWxupTuk0e0yjX7n19FipPRkNdgrF72EUOgrUsirK', '', '-6.0', ''),
(39, 'rettop_zsaul_@mail.com', 'rettop back', '$2y$10$bvotGtbUENG9znwapUflS.2B8lEEtJimgvfvm.DtuO0BlWAx8evWy', '', '-6.0', ''),
(40, 'ym102666@gmail.com', 'Jervis  Stark', '$2y$10$zc2pTklSjADejOc7WYjXKO4/EOzPsWN4Wl3weQwLMKTs4ZflgMcL.', '', '8.0', ''),
(41, 'fallriv@senpuu.net', 'Artur Zawadzki', '$2y$10$kj/46Wl3o2DnM2g5I81MCecKUIx0lcBQO8Rcnyk7.HbW3PKlGL04q', '', '1.0', ''),
(42, 'varunr107@gmail.com', 'Varun Rathee', '$2y$10$gn472WkVCEiA.uN19yldH.yVSd3S4dQnZK4JAE9hGJ71s7XOJzT8S', '', '5.5', ''),
(43, 'xinnal4@gmail.com', 'Ali Arslan', '$2y$10$EtxL8Kgb8M7KAWaug6oKK.ZeONCfZ1p/d44/RunH56w6Zx2z2x7Ve', '', '3.0', ''),
(44, 'nextlvlig@gmail.com', 'Next IG', '$2y$10$WniIErk.V7R0vds2w6pccupVggzqrAH2G0ke1on94/WbkCYXp6Wjq', '', '-8.0', ''),
(45, 'ucanstudy@gmail.com', 'mel smith', '$2y$10$n3W1m536WlScZpmOmFsm.OCnpWgVcTEcuAqLJ94MIOMlR/0H9kKvG', '', '-11.0', ''),
(46, 'nestaandrei@gmail.com', 'Andrei Nastase', '$2y$10$98TPsVVVlO2gmyQgn4aXtOZAUWIbzGFNGNMDN0n8uGwa7AxmgYhpW', '', '0.0', ''),
(47, 'moeinbeheshti@gmail.com', 'Moein Beheshti', '$2y$10$eodGNw8MFAz/PVI0PJbr3O87uFV1qBOjMVPA5RSUkgUTqG/n5Hlne', '', '3.5', ''),
(48, 'rusgenya@gmail.com', 'Genya Grigoriev', '$2y$10$ZJdtkIz0Tkc/YfQ02ZKKPu5lL2liwTJy.NRwcqw3nfbFnU6J50mGe', '', '5.0', ''),
(49, 'tan.noel@gmail.com', 'Noel Tan', '$2y$10$kE/c4PmKX/w2WjEbI9Yeye16fmWpCmRVQPFJcH9PBLgTevm1.LX1u', '', '8.0', ''),
(50, 'lovesharingeconomy.com@gmail.com', 'lovesharing economy', '$2y$10$Kjd2UYfZahQzTqYiZLDvb.RITuqZJTqCIzQL7ETjfJxVvbuJ2JDdu', '', '5.0', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proxies`
--
ALTER TABLE `proxies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks_types`
--
ALTER TABLE `tasks_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `proxies`
--
ALTER TABLE `proxies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=406;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `tasks_types`
--
ALTER TABLE `tasks_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
