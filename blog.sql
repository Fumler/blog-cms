-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 08, 2013 at 12:11 AM
-- Server version: 5.5.29
-- PHP Version: 5.4.6-1ubuntu1.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `reports` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`cid`, `content`, `approved`, `created`, `pid`, `uid`, `reports`) VALUES
(21, 'I agree, looks great!', 1, '2013-03-07 19:32:47', 15, 11, 7),
(22, 'great stuff as always', 1, '2013-03-07 19:33:11', 22, 9, 6),
(23, 'I need to try Journey, everyone says it is awesome.', 1, '2013-03-07 19:33:12', 21, 11, 6),
(24, 'Journey is indeed an epic game!', 1, '2013-03-07 19:33:20', 21, 10, 6),
(25, 'lol', 1, '2013-03-07 19:33:29', 20, 11, 6),
(26, 'yu gi oh is way higher that it should be :S', 1, '2013-03-07 19:33:48', 21, 9, 6),
(27, 'Too bad about the server issues.', 1, '2013-03-07 19:33:51', 18, 11, 6),
(28, 'Thanks', 1, '2013-03-07 19:34:30', 22, 11, 6),
(29, 'really?!?!?!?!', 1, '2013-03-07 19:34:30', 16, 9, 6),
(30, 'We should have the school sponsor a trip to the GDC. ', 1, '2013-03-07 19:34:41', 22, 10, 6),
(31, '<em>Comment removed by administrator</em>', 1, '2013-03-07 19:34:53', 22, 9, 1),
(32, 'yeah it sucks :/', 1, '2013-03-07 19:36:12', 18, 9, 6),
(33, 'Useless post.', 1, '2013-03-07 19:36:23', 21, 11, 6),
(34, 'Stupid :P', 1, '2013-03-07 19:39:06', 25, 11, 6),
(35, 'What the fuck.', 1, '2013-03-07 19:41:13', 26, 11, 6),
(36, 'Derp!', 1, '2013-03-07 19:45:05', 7, 14, 7),
(37, 'yay! can''t wait for the finished product :D', 1, '2013-03-07 19:53:25', 28, 9, 6),
(38, 'love this dog', 1, '2013-03-07 22:45:22', 29, 9, 0),
(39, 'Herpderp', 1, '2013-03-07 22:49:43', 29, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `tags` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `uid` int(3) NOT NULL,
  `visits` int(11) NOT NULL DEFAULT '0',
  `reports` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`pid`, `title`, `content`, `tags`, `created`, `updated`, `approved`, `uid`, `visits`, `reports`) VALUES
(4, 'Even in the Next BioShock, America Was a Woman. But Not a Nice One.', 'We all know Uncle Sam. The guy in the Old Glory-styled top hat and tails is the personification of the United States that American schoolkids grow up learning about. You probably know him from the famous poster strongly urging that you enlist and maybe you''ve seen him done up as a superhero.\r\n\r\nBut did you know that Uncle Sam has an older sister? And that she''s where the floating city in BioShock Infinite gets its name from?', '', '2013-03-06 22:53:00', '0000-00-00 00:00:00', 1, 11, 11, 6),
(5, 'Yep, SimCity Still Isn’t Working', 'See that image? If you try to play SimCity on the U.S. servers right now, you probably will. It''s a little different from the image we saw last night, and the server issues we saw all throughout yesterday, but the problem remains the same: people who bought SimCity can''t play it.\r\n\r\nRight now it''s 8pm GMT (Greenwich Mean Time, or 5 hours ahead of Eastern), and the servers that were supposed to reopen at 7pm GMT are still not open. It seems like you can play on some European servers at the moment, although that doesn''t help anyone who has already started cities on regions with their friends on the U.S. servers.', '', '2013-03-06 22:53:37', '0000-00-00 00:00:00', 1, 11, 18, 6),
(6, 'A Quick Fix For Tomb Raider’s Crash-Happy PC Version', 'I''ve been looking forward to playing Tomb Raider on PC for the last week, ever since Evan''s review made me think, "Okay, yep, sounds like this is indeed my kinda game."\r\n\r\nI booted it up, played through the opening bit that I''d played at press events, and upon making my way past the dangling LOST-airplane… the game crashed to desktop. Uh-oh. I fired it up again, and it crashed again. I made it to the first campsite… and crash.', '', '2013-03-06 22:54:26', '0000-00-00 00:00:00', 1, 11, 8, 7),
(7, 'Don’t Ever Leave Me Again, Mini Ninjas', 'I contend that one of Square Enix''s finest acquisitions in 2010''s take-over of Eidos Interactive was the six miniature trained killers of 2009''s action-adventure, Mini Ninjas. Soon they will be an animated series, but for now they''re an endless runner, and I''ve missed them so much.\r\n\r\nI didn''t play the Kinect-powered Mini Ninjas Adventures last year because of that whole Kinect-powered bit (no room to groove in Faheyland), so today''s iOS runner is my first heady hit of the tiny blade-dancers in three years, not counting replays of the original. So fond am I of these little bastards that I singled them out from this week''s crop of four big-name endless-running mobile games (Temple Run: Oz and two more to be named later) for a little special attention.', '', '2013-03-06 22:54:54', '0000-00-00 00:00:00', 1, 11, 49, 6),
(15, 'First post!', 'This seems like a great site to blog on. updates will follow!', '', '2013-03-07 19:19:32', '0000-00-00 00:00:00', 1, 9, 19, 6),
(16, 'Did you know?', 'Some countries&nbsp;in&nbsp;the&nbsp;world, like&nbsp;Japan, has&nbsp;women-only&nbsp;section&nbsp;on trains to avoid&nbsp;groping&nbsp;from&nbsp;men.&nbsp;<br><br>', '', '2013-03-07 19:23:28', '0000-00-00 00:00:00', 1, 10, 20, 6),
(18, 'SimCity Review', '<h2>SimCity offers up myriad tantalizing delights for the would-be city-builder, but encases them in an infrastructure that feels at odds with itself.</h2><span>To talk of this game is to tell a tale of two SimCities. On one side of the border is a brilliant, vibrantly realized reboot of&nbsp;<a target="_blank" rel="nofollow" href="http://www.giantbomb.com/maxis-software/3010-205/">Maxis</a>'' classic&nbsp;<a target="_blank" rel="nofollow" href="http://www.giantbomb.com/simcity/3030-37620/">SimCity</a>&nbsp;franchise. After a 10-year break, here is a game that presents the modern city builder with nearly every possible tool one could hope for to build the bustling metropolis of their dreams. It is gorgeous to look at when properly taken advantage of with the latest&nbsp;<a target="_blank" rel="nofollow" href="http://www.giantbomb.com/pc/3045-94/">PC</a>&nbsp;hardware, artfully designed for minimal user interface turmoil, and just exquisitely charming across the board. Across the border, however, is another SimCity entirely. This one is a stricter game than the one franchise fans have come to know over the years, one more dedicated to a single-minded way of cooperative thinking. In this SimCity, a single city cannot survive without another nearby to pick up the slack. Multiplayer is heavily encouraged, to the point of insistence, and yet the safeguards that aim to prevent problematic behavior on the part of others are minimal, and frankly unreliable. Which is to say nothing of its overall, online-always infrastructure, one which has, at times already, hamstrung the entirety of this new SimCity''s lush, yet disappointingly underutilized region.<br><br>...<br><br></span>It is therefore difficult to completely reconcile a game like SimCity. This is a game with startling clarity of vision, but that vision often feels narrow and intractable. It knows precisely what it wants to be, and in most key ways, executes on those ideas with precision. But in setting that course, it all but dismisses the way in which many played SimCity sequel after sequel. And while I expect many will fall head-over-heels in love with this SimCity''s cooperative design, at its best, the game feels more like a really thoughtfully designed multiplayer mode for a larger, single-player capable game that, sadly, doesn''t exist. Go in with the right expectations, and there''s a good chance you''ll enjoy your time with SimCity. Assuming, of course, EA''s servers will let you play it in the first place.<br>', '', '2013-03-07 19:23:46', '0000-00-00 00:00:00', 1, 9, 31, 6),
(20, '   5 things to know about ''core'' game players in the United States', 'Analysts at the NPD Group recently surveyed 6,322 United States citizens over the age of 9 to find out their gaming habits and, specifically, what "core gamer" habits were in 2012.<br><br> How the NPD Group defines the "core" is a person who plays specific genres of games on consoles or PCs an average of five hours or more per week.<br><br>&nbsp;The specifics behind the survey are available here. Below, we''ve highlighted our five key takeaways, both from the information publicly available and through follow-up conversations with NPD analyst Liam Callahan.<br><h2>Roughly 14 percent of Americans over 9 are core gamers<br></h2>And by comparison, almost half of the U.S. population in that age range plays games on what the NPD calls "core gaming devices," meaning dedicated home game consoles as well as Windows and Macintosh-based PCs.<br><h2>Their mean age is 30<br></h2>And while younger players are more likely to be considered "core," the likelihood doesn''t diminish dramatically until people reach 45.<br><br> Specifically, 26 percent of surveyed 9-17 year-olds were identified as core, which drops to 21 percent in the 18-34 crowd.<br><h2>They skew heavily male<br></h2>This probably is no surprise. While the overall U.S. population that plays games of any kind is split 50/50 between genders, males dominate the core demographic at 71 percent.<br><h2>They''re spending less than they used to...<br></h2>Approximately ten percent more of the NPD''s identified core say that their spending decreased versus one year ago than those stating that their spending increased, which is roughly in line with the 22 percent decrease in retail game sales in 2012.<br><h2>...but what they do spend tends to be on new, retail games<br></h2>The majority of core gamers spent the most on new physical games, for an average of $129 during the last three months of 2012 alone. The amount they spent on digital full games and physical used games both came in at less than half that amount.', '', '2013-03-07 19:31:11', '0000-00-00 00:00:00', 1, 10, 21, 6),
(21, 'Top 20 PSN/Digital PS3 Games ', '<img alt=""><img src="http://thatgamecompany.com/wp-content/themes/thatgamecompany/_include/img/journey/journey-game-screenshot-1-b.jpg" alt=""><br><span><b>\r\n\r\n    \r\n        \r\n        </b><b>\r\n                        \r\n                \r\n        \r\n                \r\n                \r\n        \r\n    </b><b>\r\n        \r\n    </b></span><b>\r\n</b><ul><li><b>1.) Journey</b></li><li><b>2.) NBA 2K13</b></li><li><b>3.) Yu-Gi-Oh! 5D’s Decade Duels Plus</b></li><li><b>4.) Call of Duty: Black Ops II</b></li><li><b>5.) Dead Space 3</b></li><li><b>6.) Grand Theft Auto IV</b></li><li><b>7.) Sly Cooper: Thieves in Time</b></li><li><b>8.) Dynasty Warriors 7 Empires</b></li><li><b>9.) Mass Effect</b></li><li><b>10.) Crysis 3</b></li><li><b>11.) Ni No Kuni: Wrath of the White Witch</b></li><li><b>12.) One Piece: Pirate Warriors</b></li><li><b>13.) Beyond Good &amp; Evil HD</b></li><li><b>14.) Urban Trial Freestyle</b></li><li><b>15.) Sonic Adventure 2</b></li><li><b>16.) NBA Jam: On Fire Edition</b></li><li><b>17.) The Cave</b></li><li><b>18.) PlayStation All-Stars Battle Royale</b></li><li><b>19.) Tokyo Jungle</b></li><li><b>20.) Far Cry 3</b></li></ul><b>\r\n\r\nTop 10 Vita Games\r\n\r\n</b><span><b>\r\n\r\n    \r\n        \r\n        </b><b>\r\n                        \r\n                \r\n        \r\n                \r\n                \r\n        \r\n    </b><b>\r\n        \r\n    </b></span><b>\r\n</b><br><ul><li><b>1.) Urban Trial Freestyle</b></li><li><b>2.) Sly Cooper: Thieves in Time</b></li><li><b>3.) Rocketbirds: Hardboiled Chicken</b></li><li><b>4.) PlayStation All-Stars Battle Royale</b></li><li><b>5.) Persona 4 Golden</b></li><li><b>6.) Plants vs. Zombies</b></li><li><b>7.) Super Stardust Delta</b></li><li><b>8.) Mortal Kombat</b></li><li><b>9.) Bentley’s Hackpack</b></li><li><b>10.) Sound Shapes</b></li></ul><b>\r\n\r\nTop 5 PS3 DLC\r\n\r\n</b><ul><li><b>1.) Call of Duty: Black Ops II -- Revolution</b></li><li><b>2.) The Elder Scrolls V: Skyrim -- Dragonborn</b></li><li><b>3.) Call of Duty: Black Ops II – Season Pass</b></li><li><b>4.) The Elder Scrolls V: Skyrim -- Hearthfire</b></li><li><b>5.) The Elder Scrolls V: Skyrim -- Dawnguard</b></li><li><b>6.) NBA 2K13 – All-Star Game</b></li><li><b>7.) Assassin’s Creed III – The Infamy</b></li><li><b>8.) PlayStation All-Stars Battle Royale – Heavenly Sword/WipeOut Stage</b></li><li><b>9.) Metal Gear Rising: Revengeance – MGS4 Raiden Custom Body</b></li><li><b>10.) DMC: Devil May Cry – Costumes Pack</b></li></ul><b>\r\n\r\nTop 5 PS2 Classics\r\n\r\n</b><ul><li><b>1.) Grand Theft Auto: San Andreas</b></li><li><b>2.) Grand Theft Auto: Vice City</b></li><li><b>3.) Bully</b></li><li><b>4.) Midnight Club 3 DUB Edition Remix</b></li><li><b>5.) Grand Theft Auto III</b></li></ul><b>\r\n\r\nTop 5 PSone Classics\r\n\r\n</b><ul><li><b>1.) Final Fantasy VII</b></li><li><b>2.) Final Fantasy IX</b></li><li><b>3.) Final Fantasy VIII</b></li><li><b>4.) Final Fantasy VI</b></li><li><b>5.) Final Fantasy Origins</b></li></ul><b>\r\n\r\nTop 5 PSP Games\r\n\r\n</b><ul><li><b>1.) Final Fantasy IV: The Complete Collection</b></li><li><b>2.) Dissidia 012 Duodecim: Final Fantasy</b></li><li><b>3.) Final Fantasy Tactics: The War of the Lions</b></li><li><b>4.) Dissidia 012 Prologus: Final Fantasy</b></li><li><b>5.) NBA 2K13</b></li></ul><b>\r\n\r\nTop 5 PS Minis\r\n\r\n</b><ul><li><b>1.) Monopoly</b></li><li><b>2.) The Impossible Game</b></li><li><b>3.) Jetpack Joyride</b></li><li><b>4.) Zombie Racers</b></li><li><b>5.) </b><b>Carnivores: Dinosaur Hunter</b></li></ul><br>', '', '2013-03-07 19:31:31', '0000-00-00 00:00:00', 1, 14, 47, 6),
(22, 'The road to IGF: The students and the innovators', '<img alt=""><img alt="" src="http://cdn1.sbnation.com/uploads/chorus_image/image/8904655/studentigf.0_cinema_960.0.jpg"><br><br><br>In the days leading up to this year''s Game Developer''s Conference and the Independent Games Festival, Polygon will be speaking with the Student Showcase winners and the finalists for the festival''s prestigious Nuovo award. The Nuovo award honors "abstract shortform and unconventional game development."<span>Check back daily during the week for the stories of these student developers and shortform artists.<br><br>Source:&nbsp;</span><a target="_blank" rel="nofollow" href="http://www.polygon.com/2013/3/1/4043210/the-road-to-igf-the-students-and-the-innovators">http://www.polygon.com/2013/3/1/4043210/the-road-to-igf-the-students-and-the-innovators</a>', '', '2013-03-07 19:31:57', '0000-00-00 00:00:00', 1, 11, 47, 6),
(23, 'EA Disables Non-Critical Features in SimCity to Ease Server Problems', '<span>The <a href="http://pc.ign.com/objects/128/128952.html" rel="nofollow" target="_blank">SimCity</a>\r\n server difficulties continue, but EA has taken steps to put things \r\nright. The publisher has taken the decision to disable some of the \r\ngame''s non-essential features to soothe some of the server problems.</span>\r\n<span>On the game''s <a href="http://forum.ea.com/eaforum/posts/list/0/9341242.page" rel="nofollow" target="_blank">EA Forum</a>,\r\n the community manager gave details about what was being done.&nbsp;“We are \r\ncontinuing to do everything we can to address the server issues,” the \r\npost explained. “In the meantime, so that we can give you as good an \r\nexperience as possible, we are in the process of deploying a hotfix to \r\nall servers. This includes various improvements and also disables a few \r\nnon-critical gameplay features (leaderboards, achievements and region \r\nfilters). Disabling these features will in no way affect your core \r\ngameplay experience.</span>\r\n"We will continue to let you know as we have more information. We \r\nknow it has been said before, but we do appreciate your patience as we \r\ncomplete this latest update. Getting you playing is our absolute highest\r\n priority."\r\n<span>\r\n\r\n    \r\n        \r\n        \r\n                        \r\n                \r\n        \r\n                \r\n                \r\n        \r\n    \r\n        \r\n    </span>\r\n<span>This is the latest incident in what has been a troubled launch for \r\nthe highly-anticipated game. Disgruntled fans have already taken to \r\nsocial media and aggregate websites such as <a href="http://www.metacritic.com/game/pc/simcity/user-reviews" rel="nofollow" target="_blank">Metacritic</a>\r\n to register their discontent, with a lot of vitriol being aimed at the \r\ngame''s always-on DRM. (You can find out what IGN thinks of the game in \r\nour <a href="http://uk.ign.com/articles/2013/03/04/simcity-review-in-progress" rel="nofollow" target="_blank">review in progress</a>.)</span>\r\nWhile some players have taken to aggregate site to register their \r\ndiscontent, Maxis – the game''s developer – has promised on Twitter that \r\nits working around the clock to fix the problems.<br><br><img alt=""><img src="http://pcmedia.gamespy.com/pc/image/article/122/1224950/simcity3_1338651840.jpg" alt=""><br>', '', '2013-03-07 19:34:29', '0000-00-00 00:00:00', 1, 14, 10, 6),
(25, 'Voices of women in technology ', 'A diverse workforce is critical in helping us build products that can \r\nhelp people change the world. That includes diversity of all life \r\nexperiences, including gender. <br>\r\n<br>\r\n<a href="http://www.google.com/diversity/women/our-inspiration/index.html" rel="nofollow" target="_blank">Women were some of the first programmers</a>\r\n and continue to make a major impact on the programming world today. We \r\nthink it’s&nbsp;important to highlight the great work women are doing in \r\ncomputer science, to help provide role models for young women thinking \r\nabout careers in computing.<br>\r\n<br>\r\nTomorrow is <a href="http://www.internationalwomensday.com/" rel="nofollow" target="_blank">International Women’s Day</a>, and as one of our contributions to the celebration, we’re proud to support <a href="http://www.globaltechwomen.com/voices-global-conference.html" rel="nofollow" target="_blank">Voices Global Conference</a>, presented by <a href="http://www.globaltechwomen.com/" rel="nofollow" target="_blank">Global Tech Women</a>.\r\n As part of this 24-hour live streamed event, Google will provide more \r\nthan a dozen hours of free talks featuring women working in computer \r\nscience, beginning today. To access the full schedule and our ongoing \r\nbroadcasts, see our section on the <a href="http://www.globaltechwomen.com/google-channel.html" rel="nofollow" target="_blank">Voices website</a>, which will be updated throughout the day.<br>\r\n<br>\r\nThe Voices Global Conference is the brainchild of Global Tech Women’s founder Deanna Kosaraju, who also started <a href="http://gracehopper.org.in/2012/blog/" rel="nofollow" target="_blank">India’s Grace Hopper Celebration of Women in Computing</a>\r\n in 2010 with grant support from Google. The India conferences, which \r\nprovide a forum for women to share their professional and research work \r\nin computing, have grown rapidly, with more than 800 attendees in 2012. \r\nSo when Deanna proposed this global, 24-hour streamed conference, we \r\nknew it was a great opportunity to help women and other audiences around\r\n the world learn more and get inspired about the contributions women are\r\n making to technology and computer science.<br>\r\n<br>\r\nOur sessions will feature a range of material, from new episodes of the <a href="https://developers.google.com/women-techmakers/" rel="nofollow" target="_blank">Women Techmakers</a> series and interviews with women leaders like the head of <a href="http://lexity.com/about/about" rel="nofollow" target="_blank">Lexity</a> India <a href="http://lexity.com/about/team" rel="nofollow" target="_blank">Mani Abrol</a>, to discussions focusing on technologies like <a href="https://cloud.google.com/products/compute-engine" rel="nofollow" target="_blank">Google Compute Engine</a>. For a sneak peek of the type of content we’ll be providing, check out Pavni’s story below, produced in conjunction with PBS’ <a href="http://www.makers.com/" rel="nofollow" target="_blank">MAKERS</a>\r\n series. I’ve provided advice to many young people in India interested \r\nin studying computer science and pursuing their own dreams—so Pavni’s \r\ntenacity, coupled with the encouragement and support she received from \r\nher father, resonated with me. We’re excited to share her story and \r\nothers like it alongside technical conversations and discussions on \r\nwomen in technology as part of this conference. <br>', '', '2013-03-07 19:36:57', '2013-03-07 19:37:22', 1, 14, 24, 7),
(26, 'Har Fobos en aktiv ET-base?', 'Det internasjonale Phobos 2-romfartsprogrammet (1988-89) ble brått avsluttet da rom­sonden Phobos 2 nærmet seg Fobos’ overflate. Trolig ble den skutt ned. Astronauten Buzz Aldrin nevnte i 2009 en monolitt som kan ses på Fobos. Det russiske Fobos-Grunt-romfartsprogrammet (2011) hadde som offisielt mål å foreta en landing på Fobos og bringe grusprøver tilbake til Jorden, men dette ble avbrutt etter et uhell kort etter utskytningen. Ifølge zetaene har nibiruanerne en base under Fobos’ overflate for gullgruve­drift, og de motsetter seg ethvert forsøk på å bli observert av jord­menneskene.&nbsp;<br><b><br>Mars sine to små måner</b><span>Mars er omgitt av to små måner: Fobos (”Skrekk”) og Deimos (”Frykt”) [Wiki:&nbsp;<a target="_blank" rel="nofollow" href="http://en.wikipedia.org/wiki/Phobos_(moon)">Phobos (moon)</a>]. De to månene ble i moderne tid først oppdaget av den amerikanske astronomen Asaph Hall, den 12. august 1877. Hans navnevalg for de to månene var inspirert av den 15. sangen i Homers episke verk&nbsp;<i>Iliaden</i>, der Fobos og Deimos nevnes som sønner av krigs­guden Ares. Velikovsky (1950, Part II, kap. 5) viet et eget kapittel til å diskutere en rekke eldre historiske tekster som kan tolkes som kjennskap til Mars’ to måner.&nbsp;</span>&nbsp;<br><b><br>Phobos 2-romfartsprogrammet (1988-89)</b><span>Den 7. og 12. juli 1988 skjøt Sovjetunionen opp to Proton-K-bæreraketter med hver sin romsonde,&nbsp;<i>Phobos 1</i>og&nbsp;<i>Phobos 2</i>&nbsp;(Wiki:&nbsp;<a target="_blank" rel="nofollow" href="http://en.wikipedia.org/wiki/Fobos_2#Phobos_2">Phobos program</a>). Det offisielle formålet var å utføre avanserte studier av Mars, dens to måner og det interplanetariske rommet.&nbsp;<i>Phobos 1</i>&nbsp;var en fiasko som aldri nådde frem til Mars.&nbsp;<i>Phobos 2</i>&nbsp;var et stort internasjonalt prosjekt der også USA deltok.&nbsp;<i>Phobos 2</i>&nbsp;kom trygt frem til den planlagte omløpsbanen rundt Mars i januar 1989. Noen bilder av Hydraote Chaos-regionen på Mars, tatt den 1. mars 1989, minner om et 60 km vidt byområde.</span><span>&nbsp;<br><br>Den 27. mars 1989 kom&nbsp;</span><i>Phobos 2</i><span>&nbsp;vellykket frem til Fobos. Romsonden gikk så inn i siste fase av sitt oppdrag: Gå ned til ca. 50 meter over bakkenivå der to moduler skulle frigjøres for å kunne operere på bakken. Det var i denne siste fasen at kontakten mellom romsonden og kommando­sentralen på Jorden plutselig ble brutt. Kontakten ble aldri gjenetablert. Noen av de siste bildene som ble overført tilbake til Jorden, inneholder et uforklarlig uidentifisert objekt, en tynn elliptisk skygge, mellom Fobos-overflaten og romsonden.<br><br></span>Zecharia Sitchin (1990) mente at romsonden hadde blitt skutt ned av en ET-gruppe, trolig dem fra Nibiru som tidligere hadde hatt base på Mars, og som på sumererne kalte for&nbsp;<i>anunnakiene</i>. Sitchin mente at med denne nedskytningen hadde ”Star Wars” blitt innledet. Noen russiske forskere som var tilknyttet&nbsp;<i>Phobos 2</i>-prosjektet holdt en historisk men lite kjent pressekonferanse i London. Se web-siden&nbsp;<a target="_blank" rel="nofollow" href="http://www.marsnews.com/news/20020920-phobos2images.html">Whither Phobos 2?</a>&nbsp;av James Burk for mer informa­sjon.&nbsp;<br>', '', '2013-03-07 19:38:53', '0000-00-00 00:00:00', 1, 9, 21, 7),
(27, '<em>Deleted by admin</em>', '<strong>Deleted by admin</strong>', '', '2013-03-07 19:41:27', '0000-00-00 00:00:00', 0, 9, 26, 9),
(28, 'Just another blogpost', 'I&nbsp;felt like&nbsp;I&nbsp;had&nbsp;to&nbsp;keep you&nbsp;guys&nbsp;updated!<br><br>We fixed&nbsp;a&nbsp;few&nbsp;more&nbsp;bugs,&nbsp;and&nbsp;now&nbsp;we''re&nbsp;just about ready&nbsp;to deliver (we&nbsp;hope!).&nbsp;<br><br><br><br><br>', '', '2013-03-07 19:49:06', '0000-00-00 00:00:00', 1, 10, 31, 6),
(29, 'Have you seen this dog?', '<img alt=""><img alt="" src="http://i.imgur.com/vTOLBcn.gif"><br><br><br>You&nbsp;have&nbsp;now...&nbsp;<br><br>', '', '2013-03-07 22:02:37', '0000-00-00 00:00:00', 1, 10, 32, 1),
(30, 'Another one of these I guess', 'Still here! This site has sure come along swimmingly', '', '2013-03-07 22:09:09', '0000-00-00 00:00:00', 1, 9, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tid` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `pic` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'img/profile.png',
  `info` text COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `uname`, `pwd`, `fname`, `lname`, `address`, `email`, `pic`, `info`, `admin`, `banned`) VALUES
(1, 'test', '8c6b70a3b71bfdd36b6ccd11f71ddfd8124ccdac91a18e9d6234b84a8c0ac09c8001dc62465e6ae98be2b112d1a7009dd829e43a7f7c347a39fd3309f075fc1a', 'test', 'testersson', 'testelia 15', 'test@test.com', 'img/profile.png', 'test', 1, 0),
(9, 'zeox', '4deffc83eada26b0f923e417e8a94ceac0b7b1742bbf64fa2c75ac7d7ee81286896228162da2ed35e8d85a45ef1a312288b9cf9f88f6ab568f137b05d5226cb5', 'Inge', 'Dalby', 'Holtenga', 'inge.dalby@gmail.com', 'img/1362585406.png', 'Jepp', 1, 0),
(10, 'Sidaroth', 'ff79872a507fe244722c2f3c678e502bdbe0f4c6cc69cc2642f28af9a05870a2ee611c3a0d2957e1f19d4dfd6ffaae8871edb533caa2a7dc9dae84f6c15e6b4c', '', '', '', '', 'img/1362679598.jpeg', '', 0, 0),
(11, 'Fumler', 'f23964c7a8010e8d57ad7555bd09d8e592ce4dddaaf581f37eadf6223e5cec25b44156c0a68a475f4b88bc77fc9c5504e0d7aaf76857711ba979d104aa9905a7', 'Fredrik', 'Pettersen', 'Derperstreet 17', 'derp@derp.com', 'img/1362606655.png', 'Jepp', 1, 0),
(12, 'kolloenadmin', 'dc3caa4ce684d142948af0c8fc1d697f8ec620eb0e73c58aadc48f199d258dadbbffa0770349b659de952e9570686d1114d4623f443482a14e1218a9a3f8b9cc', '', '', '', '', 'img/profile.png', '', 1, 0),
(13, 'kolloenuser', 'c4c347236da4eacefb8a363b4b8d1090b9166f64384d2eb129dda04ac7434d06cd0415bf3e802ee77242ede3d5a349b65644f68abb6594e6beb352cbba3716ba', '', '', '', '', 'img/profile.png', '', 0, 0),
(14, 'garlov', 'a7c611290975a88ba2327efe55d7bd43e5f5925a7e87ceff2f400e860cce98d40cc93975f1ef8d4c4f2079a88a230bf249936c3f789986dffeb7760138ab601a', '', '', '', '', 'img/profile.png', '', 0, 0),
(15, 'kolloenbanned', '2df70f3240601011fa5e911f4af97b27433c5a5b25a8103b80a8d3f694bd3f44114ce06febd505434d56c53b29973424f6bfc6da72cc1a96e6b25565f45dabd4', '', '', '', '', 'img/profile.png', '', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
