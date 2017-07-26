-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017 年 7 月 26 日 18:25
-- サーバのバージョン： 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `japanival`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `chat_room_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `accept_user_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `chat_rooms`
--

INSERT INTO `chat_rooms` (`chat_room_id`, `request_id`, `accept_user_id`, `created`) VALUES
(19, 3, 3, '2017-07-26 08:31:49'),
(20, 2, 3, '2017-07-26 08:31:59'),
(21, 8, 3, '2017-07-26 09:23:18'),
(22, 6, 3, '2017-07-26 09:34:36'),
(23, 11, 3, '2017-07-26 15:01:48');

-- --------------------------------------------------------

--
-- テーブルの構造 `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `o_id` int(11) NOT NULL,
  `e_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `e_start_date` date NOT NULL,
  `e_end_date` date NOT NULL,
  `e_prefecture` varchar(255) CHARACTER SET utf8 NOT NULL,
  `e_postal` varchar(255) CHARACTER SET utf8 NOT NULL,
  `e_address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `e_lat` double NOT NULL,
  `e_lng` double NOT NULL,
  `e_venue` varchar(255) CHARACTER SET utf8 NOT NULL,
  `e_access` text CHARACTER SET utf8 NOT NULL,
  `e_o_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `e_o_tel` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `e_o_email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `explanation` text CHARACTER SET utf8 NOT NULL,
  `priority` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `start_year` int(11) DEFAULT NULL,
  `year_p` int(11) DEFAULT NULL,
  `year_pp` int(11) DEFAULT NULL,
  `year_ppp` int(11) DEFAULT NULL,
  `attendance_p` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `attendance_pp` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `attendance_ppp` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `official_url` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `related_url` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `events`
--

INSERT INTO `events` (`event_id`, `o_id`, `e_name`, `e_start_date`, `e_end_date`, `e_prefecture`, `e_postal`, `e_address`, `e_lat`, `e_lng`, `e_venue`, `e_access`, `e_o_name`, `e_o_tel`, `e_o_email`, `explanation`, `priority`, `start_year`, `year_p`, `year_pp`, `year_ppp`, `attendance_p`, `attendance_pp`, `attendance_ppp`, `official_url`, `related_url`, `created`, `modified`) VALUES
(1, 1, 'Setoyasiki Hinamaturi', '2018-02-18', '2018-03-05', 'Kanagawa', '258-0028', 'Ashigami-gun Kanari Machi Kanai 1336', 35.342912, 139.115025, 'Kanai Prefecture Ashigami-gun Kanari Machi Kanai 1336', '15 minutes on foot from JR Matsuda station', '', '', '', 'The hinamatsuri held in the 300-year old private house \"Seto residence\" is filled with the atmosphere of the Edo period.\nThree hundred years ago \"Kyoho Chin\" discovered from the local warehouse and a number of set doll collection dolls, \"Tsurushi chicks\" handmade by the Women\'s Association more than 7,000 pieces and \"Large Tsurushina\" with a height of 2.4 m On display', '', 0, 0, 0, 0, 'about 100', 'about 100', 'about 100', 'http://www.kaisei-hinamatsuri.com/index.html', '', '2017-06-21 22:17:00', '2017-06-22 14:17:00'),
(2, 2, 'YOKOHAMA Beach Sports Festa', '2018-07-29', '2018-07-30', 'Kanagawa', '236-0013', 'Yokohama Sea Park ', 35.333317, 139.634385, 'Yubinbango236-0013 Kanazawa-ku, Yokohama Sea Park # 10', 'Kanazawa Seaside Line \"Sea Park south exit\" station, immediately from the \"Sea Park Shiba opening\" station or \"Hakkeijima\" station', '', '', '', 'A beach sports festa that started in 1989 and became a summer tradition of Yokohama will be held this year.\n\n\"Yokohama beach sports festa 2017supported by Nippatsu\" has become a rich content than ever.\n\nBesides pre-entry type beach sports competition (beach volleyball, beach volleyball, beach hand, beach tennis, beach football), beach clean · beach flags experience · experience of SUP (stand up paddle board) · beach tag rugby, beach yoga etc. Free Participation events will also be held.', '', 0, 0, 0, 0, 'about 200', 'about 200', 'about 200', 'https://www.hamaspo.com', '', '2017-06-22 22:17:00', '2017-06-23 14:17:00'),
(3, 3, 'NARITASAN KOUYOUMATURI', '2018-11-12', '2018-11-28', 'Tiba', '', 'Chiba prefecture Narita-shi, Narita 1', 35.78522, 140.317494, 'Chiba prefecture Narita-shi, Narita 1', 'About 15 minutes on foot from JR Narita station and Keisei main line Narita station', '', '', '', 'Naritasan Shinshoji Temple The Naritasan Park spreading on the hillside behind the main hall is a large park with 165,000 square meters. And in autumn this autumn can enjoy the autumn leaves of about 250 trees of maple, ginkgo, oak, oak, oak, maple.\n\nAlso during the autumn leaves festival, many people are visiting because various events are held.', '', 0, 0, 0, 0, 'about 20,000', 'about 20,000', 'about 20,000', '', '', '2017-06-23 22:17:00', '2017-06-24 14:17:00'),
(4, 4, 'Tokamachi Snow Festival', '2018-02-17', '2018-02-17', 'Nigata', '948-0079', '251 Asahi-cho, Tokamachi-shi Niigata Prefecture 17', 37.135188, 138.7563, '251 Asahi-cho, Tokamachi-shi Niigata Prefecture 17\nTokamachi-shi', 'Tokamachi is located 250km from Tokyo', '', '', '', 'The Tokamachi Snow Festival was first held about 67 years ago on the 4th February, 1950.\nTokamachi is located in the heart of one of Japan’s heaviest snowfall regions. Every winter, heavy snowfall can cause great adversity and disruption to the lives of the local residents. This Snow Festival was born from the idea that we should “befriend and enjoy the snow??_ a spontaneous feeling shared among many of Tokamachi\'s residents at the time. As such, the Tokamachi Snow Festival was an expression of their determination to overcome the hardships brought about by heavy snowfall, recognising fully ??_both the difficulties and beauty of the winter season. Likewise, amid the economic and social conditions of the time, it was an event that sought to bring energy to Tokamachi’s textile industry following the lift on the war-time ban of the use of silks in textile production.', '', 0, 0, 0, 0, 'about 10,000', 'about 10,000', 'about 10,000', 'http://snowfes.jp/', '', '2017-06-24 22:17:00', '2017-06-25 14:17:00'),
(5, 5, 'Nakamami Sun Festival', '2017-08-27', '2017-08-27', 'Ibaraki', '311-0192', 'Tokamachi-shi', 36.466079, 140.439053, 'Naka city Tosaki 428-2', 'About 10 minutes from Jobai Expressway Naka IC', '', '', '', '\"Naka-sunflower festival\" is a typical festival of Naka city, alongside the \"Yaezakura Festival\" held at Shimonomori Furusato Park. \nThe highlight of this event, based on the flower \"Himawari\" in Naka City, is a sunflower field. \n250 thousand sunflowers bloom in the field of about 4 ha, you will be surprised by the scenery of one side of the flowers seen from the observatory. \nIn addition, at the event site, we have held stage events, stalls, fireworks festivals and so many other visitors. \nPlease come to \"Nakamatomi Festival\" by all means. ', '', 0, 0, 0, 0, 'about2,000', 'about2,000', 'about2,000', '', '', '2017-06-25 22:17:00', '2017-06-26 14:17:00'),
(6, 6, 'Okazaki SAKURA Maturi', '2018-04-01', '2018-04-13', 'Aiti', '444-0052', 'Aichi Prefecture Okazaki-shi Yasuicho 561', 34.957728, 137.159392, 'Okazaki-shi Yasuicho 561 Okazakikouen', '15 minutes walk from Higashi Okazaki station', '', '', '', 'About 800 Yoshino cherry blossoms blooming in Okazaki Park, which is one of 100 cherry blossom squares in Japan, and Ogawa and Iga rivers around it. At the time of full bloom the cherry blossoms on one side will bloom and still compete. A cherry tree blizzard full of sight is a word of a masterpiece. The contrast which feels the sum with Okazaki castle is also an amazing thing!', '', 0, 0, 0, 0, 'about 5,000', 'about 5,000', 'about 5,000', 'https://okazaki-kanko.jp/feature/sakuramaturi/top', '', '2017-06-26 22:17:00', '2017-06-27 14:17:00'),
(7, 7, 'Fukaya Negi Maturi', '2018-01-29', '2018-01-29', 'Saitama', '366-0824', 'Saitama prefecture Fukaya city Nishijima 5 - Saitama prefecture Fukaya city Nishijima 5 - chome 6-1', 36.190553, 139.279667, 'Nishijima 5 - chome 6-1', '1 minute on foot from Fukaya station south exit of JR Takasaki Line', '', '', '', 'In recent years, the name has been reputed by the popularity of the city\'s image character \"Fuka-chan\", but it was \"Fukaya no Ogi\" spreading this land nationwide as a symbol of Fukaya long before that.\nWe share the gratitude for \"food\" through that \"Fukaya no Onagi\", and further widely appeal the charm of \"Fukaya neiguchi\" further by various expression methods! The festival that the general citizen gathered under the concept of \"Fukaya Negi Festival\" is.', '', 0, 0, 0, 0, 'about 500', 'about 500', 'about 500', 'https://negimatsuri.com/', '', '2017-06-27 22:17:00', '2017-06-28 14:17:00'),
(8, 1, 'SAKE MATURI', '2017-10-07', '2017-10-08', 'Hiroshima', '739-0011', 'Hiroshima prefecture Higashi Hiroshima-shi Nishijimoto-cho 12-3', 34.426363, 132.743265, 'Hiroshima prefecture Higashi Hiroshima-shi Nishijimoto-cho 12-3', '\nAround JR Saijo station', '', '', '', '\"Sake Festival\" is a festival of symbols \"sake\" worthy of Hoshihiroshima is the symbol of fuselage.Both adults and children, as well as those who do not drink alcohol, continue to be a festival of Higashihiroshima City, which carries the name of a drinking city that all the people gathering and gathering with the rim will enjoy.', '', 0, 0, 0, 0, 'about 2,000', 'about 2,000', 'about 2,000', 'https://sakematsuri.com/', '', '2017-06-28 22:17:00', '2017-06-29 14:17:00'),
(9, 2, 'Niu Shrine and the Laughter Festival', '2017-10-08', '2017-10-08', 'Wakayama', '', '丹生神社', 33.88866, 135.225011, '1956 Ekawa, Hidakagawa-cho, Hidaka-gun', 'From “Wasa Sta.??_of JR Kinokuni Line, 10min. by taxi.', '', '', '', 'The current Niu Shrine was established in 1909 as part of the Meiji Restoration initiative to unite the many Shinto shrines of each village and town into a single main shrine. Several shrines in Niu village were united into Niu Shrine, however, the town still preserved all of their old festivals including the famous ‘Laughter Festival??_The festival is held in early October on the Sunday following the National Athletic holiday (a holiday commemorating the opening of Tokyo Olympic Games in 1964). The festival itself is registered as Prefectural Cultural Heritage asset and is called the ‘Laughter Festival??_because a festival leader called ‘Suzu Furi??_or ‘Bell Jingler??_dresses up in a humorous clown-like costume and leads the attendees in synchronized bouts of laughter with each bell jingle.\n', '', 0, 0, 0, 0, 'about 3,000', 'about 3,000', 'about 3,000', 'http://kanko.hidakagawa.jp/eng/history/niu-shrine.html', '', '2017-06-29 22:17:00', '2017-06-30 14:17:00'),
(10, 3, 'KAMAKURA GION OMACHI MATSURI', '2018-07-08', '2018-07-10', 'Kanagawa', '', 'Yakumo Shrine (Omachi) (Yakumo Shinko · Okachi)', 35.31509, 139.554642, 'Kamakura City Omachi 1-11-22', '10 minutes on foot from Kamakura Station', '', '', '', 'The Kamakura Gion Omachi Matsuri commemorates and gives thanks for the founding of the Yakumo Shrine, a Shinto shrine, within the Omachi neighborhood of Kamakura. This grand festival is held annually on the second Saturday of July and continues for three days, during which time four mikoshi or portable representations of the shrine are carried through the local streets. The festival is said to have begun in 1349.\n2017\nKAMAKURA GION OMACHI MATSURI', '', 0, 0, 0, 0, 'about 3,000', 'about 3,000', 'about 3,000', 'http://www.kamakura-omachi.jp/gallery_2017.html', '', '2017-06-30 22:17:00', '2017-07-01 14:17:00'),
(11, 4, 'Sendai・Aoba Festival', '2018-05-20', '2018-05-21', 'Miyagi', '980-0012 ', 'Sendai', 38.270364, 140.7968598, 'Sendai City', 'Sendai City central area', '', '', '', 'It is a festival loved by many people as one of the three biggest festivals in Sendai.', '', 0, 0, 0, 0, '', '', '960000', 'http://www.aoba-matsuri.com/', '', '2017-07-01 22:17:00', '2017-07-02 14:17:00'),
(12, 5, 'The Yamagata Hanagasa Festival', '2018-08-05', '2018-08-07', 'Yamagata', '990-8540', 'Yamagata City', 38.2480308, 140.2149369, 'Yamagata City', 'Yamagata City central area', '', '', '', 'The Yamagata Hanagasa Festival is highlighted by the booming cries of \"Yassho, Makasho\" accompanied by the gallant sound of the Hanagasa Taiko drums and gorgeously decorated floats leading more than 10,000 dancers adorned in beautiful costume with Hanagasa flower hats through the main street of Yamagata city.\nIn recent years, the \'Yamagata Hanagasa Festival\' has been added to the big three festivals of Tohoku, as a fourth member representing the major festivals in Tohoku.\nIt is said that more than one million people flock to the city during the term of the festival.', '', 0, 0, 0, 0, '', '', '', 'http://www.hanagasa.jp/', '', '2017-07-02 22:17:00', '2017-07-03 14:17:00'),
(13, 6, 'Kawagoe Festival', '2017-10-14', '2017-10-14', 'Saitama', '350-8601', 'Kawagoe City', 35.9070915, 139.4804254, 'Kawagoe City', 'Get off at Kawagoe station', '', '', '', 'The Kawagoe Festival\'s strongest feature is the festival float event which reproduces the ’Edo Tenka Matsuri??_festival. Spectacular festival floats carrying exquisitely crafted dolls are pulled around the center of Koedo-Kawagoe’s landmark Kurazukuri (traditional architecture) Zone. Spectators will be overwhelmed by the sheer scale of the many festival floats as they pass by each other when meeting at an intersection.', '', 0, 0, 0, 0, '1000000', '1000000', '1000000', 'http://www.kawagoematsuri.jp/English/about.html', '', '2017-07-03 22:17:00', '2017-07-04 14:17:00'),
(14, 7, 'The Sapporo Snow Festival', '2018-02-05', '2018-02-12', 'Hokkaido', '060-8611', '4 Chome Ōdōrinishi\r\nChū?_ Sapporo City, Hokkaid?_,43.0595541,141.3004599,Sapporo City,From New Chitose Airport', 0, 0, '', '', '', 'The Sapporo Snow Festival, one of Japan\'s largest winter events, attracts a growing number of visitors from Japan and abroad every year. Every winter, about two million people come to Sapporo to see a large number of splendid snow and ice sculptures linin', '', '', '', 0, 0, 0, 0, '', 'http://www.snowfes.com/', '', '2017/7/4 22:17', '2017/7/5 22:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 1, 'The Sunflower field', '2017-08-10', '2017-08-15', 'Kanagawa', '', '3 Chome-42-46 Sōbudai\r\nZama-shi, Kanagawa-ken 252-0011', 35.4991676, 139.4072978, 'Zama City', '· From Odakyu Odawara line \"Aibutai-mae Station\" Bus ??_Minami-Ryoga Station Line (via Liberghiga) \"Get off at Zama High School\" immediately\r\n· About 30 minutes on foot from \"Odakyu Odawara line\" Aiba-daie station\r\n· Get off at Odakyu Line Aibutai-mae Station Get off at Hibarugaoka via Nambaigaoka bus ??_Get off at \"Zama High School front\" immediately\r\n· Odakyu Enoshima Line From \"Namborin Station\" Bus ??_Aibaidaie Station Line (via Hibarigaoka) Get off at \"Zama High School\" immediately\r\n· From Sogetsu Line \"Sagamino Station\" Bus ??_Get to Aiba-dorie Station Get off at \"Kita-dori\" before walking about 5 minutes on foot', '', '', '', 'In the Zama Sunflower Festival, a total of about 550,000 sunflowers are blooming in the Zama venue and the Kurihara venue.', '', 0, 0, 0, 0, '', '', '', 'http://momos-navi.net/1498.html', '', '2017-07-05 22:17:00', '2017-07-06 14:17:00'),
(16, 2, 'Hirosaki Cherry Blossom Festival', '2017-04-22', '2017-05-07', 'Aomori', '036-8551', '1-1 Kamishirogane-machi, Hirosaki-shi, Aomori-ken 036-8551', 40.603111, 140.463833, 'Hirosaki Park', 'Limited Express Tsugaru approx. 30mins from Aomori to Hirosaki', '', '', '', 'Hirosaki Cherry Blossom Festival is usually held from 4/23 to 5/5. \r\nDue to the 100th year of the festival, the festival period will be extended.', '', 0, 0, 0, 0, '', '', '', 'http://www.hirosakipark.jp/sakura/', '', '2017-07-06 22:17:00', '2017-07-07 14:17:00'),
(17, 3, 'Japanese best Imoni Festival', '2017-09-17', '2017-09-17', 'Yamagata', '990-0041', '4-14-57 Midori-Machi Yamagata City, Yamagata', 38.253258, 140.352766, 'Mamigasaki River', 'Bus:Yamagata Station Get off at Numazono Line - Get off at Yamagata Fire Station', '', '', '', 'imoni is cooked in a 6-meter-wide (20 ft) pot that needs special cranes to help stir it. Inside the pot, 3 tons of taro, 1.2 tons of beef and thousands of onions are simmered in a soup that requires 6 tons of water and 700 liters (185 gal) of soy sauce and other seasonings—enough to serve 30,000 visitors!', '', 0, 0, 0, 0, '', '', '', 'http://www.y-yeg.jp/imoni/', '', '2017-07-07 22:17:00', '2017-07-08 14:17:00'),
(18, 4, 'KURASANKAN', '2017-03-04', '2017-03-05', 'Yamagata', '999-3702', '3 Chome-17-7 Onsenmachi\nHigashine City', 38.4690744, 140.3863274, '3 Chome-17-7 Onsenmachi\nHigashine City', '5 minutes by car from JR Murayama station · 15 minutes on foot 15 minutes by car from Yamagata Airport', '', '', '', 'Opening only once a year.\r\n\"Kurasankan\" will be held which you want to listen to the collection of Rokko and the delicious seasonal drink and listen to it.\r\nIt is packed with variegated events unique to sake brew, as well as exploration.', '', 0, 0, 0, 0, '', '', '', 'http://www.yamagata-rokkasen.co.jp/', '', '2017-07-08 22:17:00', '2017-07-09 14:17:00'),
(19, 5, 'Hukuotokoerabi', '2017-01-10', '2017-01-10', 'Hyogo ', '662-0974', '1-17 Shakecho Nishinomiya', 34.7357318, 135.3323892, 'Nishinomiya Shrine', 'From Bus Northern Terminal to Hanshin Bus or Hankyu Bus \"Hanshin Nishinomiya\"\nFrom Bus South Terminal, Take the Hanshin Bus \"Hanshin Nishinomiya\"\nGet off at \"Hanshin Nishinomiya\" and walk south-west to Ebetsu line', '', '', '', 'Ebisu-sama is the Japanese deity that brings good fortune. Revered for ages by fisherman and merchants, shrines worshipping this god can be found all throughout Japan. The main shrine out of all of them is the Nishinomiya Shrine that holds the Toka Ebisu Festival. The festival, held over three days during what is said to be the period that the energy of Ebisu-sama is at its highest, attracts roughly 1,000,000 visitors from all over the country in search of good luck, in particular, in fishing, business sales and safety in the household to name a few. With out a doubt, the highlight of the festival is the Kaimon Shinji Fukuotoko Erabi, or \"Choosing of the Lucky Man Gate Opening Ritual,\" held at the main hall on the 10th. As the gates open at 6:00am, the eager visitors who gathered to be the first to receive the deity\'s good fortune sprint the 230 meters to the main hall. The first three to reach the finish line are crowned \"Fukuotoko\", or \"Lucky Man\", and are deemed the owners of immense fortune for that year which they will share with others around them. Because of this, there is an incomparable amount of passion during this early morning dash. If you are planning to visit this shrine, be sure to take part in this ritual and get a hands-on feel of it yourself.', '', 0, 0, 0, 0, '', '', '', 'http://nishinomiya-ebisu.com/index.html', '', '2017-07-09 22:17:00', '2017-07-10 14:17:00'),
(20, 6, 'Aizudajima Gion Festival', '2017-07-22', '2017-07-24', 'Fukushima', '967-0004', 'Minami-Aizu', 37.1955163, 139.7714403, 'Aizu Dajima ', 'About 56 Km from Nishinasuno I. C via National Highway Route  400\r\nApproximately 50 km from Aizuwakamatsu I. C via Route 121', '', '', '', 'Aizutajima Gion Festival, the Kamakura period of Bunji year (1185 BC), the Gion faith at the time of the lords Somasashi Naganuma, of Gion in the land God Festival (the Gozu Emperor Susa Noriyuki Otokoinochi) as God of residence Chingo, the Gion Festival defines a control, it was done with the festival of the field and out UGA shrine of Tajima village shrine of than the old has to be the origin. The festival than the old \"west of Gion, Inc., Tsushima, Inc. in the east of the field and out UGA company\" has been told it is said that is referred to as one of Japan\'s three major Gion Festival.', '', 0, 0, 0, 0, '', '', '', 'http://www.minamiaizu.org/gion/', '', '2017-07-10 22:17:00', '2017-07-11 14:17:00'),
(21, 7, 'Obasama no Ennen', '2018-04-01', '2018-04-01', 'Miyagi', '989-5181', '\nMMiyagi, Kurihara,Kinsei Kamimo mountain god 77', 38.8141834, 141.0630642, 'Hakusan Jinja,', 'Approx. 15 min. by car from Kurikomakogen station on the Tohoku Shinkansen line.\n', '', '', '', 'Conjunction with the Gion Festival Date of Polygonum UGA shrine from 1879, it has been determined that carried out in accordance with the Kumano Shrine festival, which enshrines the adjacent land to the rating example of the Gion Festival.', '', 0, 0, 0, 0, '', '', '', 'http://www.kuriharacity.jp/index.cfm/12,5401,80,html', '', '2017-07-11 22:17:00', '2017-07-12 14:17:00'),
(22, 1, 'Matsumae Jinja Reitaisai', '2017-08-04', '2017-08-05', 'Hokkaido', '049-1511', 'Hokkaid?_ Sapporo-shi, Matsumae-gun,Mathumae-cho', 41.4303436, 41.4303436, 'Matsushiro-aza', 'Approx. 10 min. walk from Yamamoto Jichi Shinko Center Mae bus stop on the Shinnan Koutsu Komaba Route.Get off at JR Kikonai station. Take a Hakodate Bus approx. 1 hr. 30 mins. to Matsushiro. Approx. 10 min. walk.\n', '', '', '', 'From using a lot of wiping the catering menu of the festival, it has been commonly also referred to as \"Fukisai = wipe Festival\". The \"Doburoku Festival\" from the use of Nigorizake to sacred sake, is also known as the \"fight festival\" because it stalls service is fierce.', '', 0, 0, 0, 0, '', '', '', '', '', '2017-07-14 22:17:00', '2017-07-15 14:17:00'),
(23, 2, 'Nanakuri Jinja Hadaka Matsuri', '2017-10-12', '2017-10-12', 'Nagano', '395-0244', 'Naganoken,iidashi,yamamoto', 35.4754873, 137.7554838, 'Nanakuri Jinja', 'Approx. 10 min. walk from Yamamoto Jichi Shinko Center Mae bus stop on the Shinnan Koutsu Komaba Route.', '', '', '', 'Nanakuri Jinja Hadaka Matsuri is the autumn matsuri of Nanakuri Shrine in Iida City. It is said to have started in the Nanbokucho period. It has continued for around 700 years as a harvest festival in which people pray and give thanks for bumper crops and good health. Youths selected from each of the seven settlements in the Yamamoto district tie shimenawa ropes around their waists, and swing barrels wrapped with shimenawa ropes above their heads. They dance under a shower of sparks, which fall like rain.', '', 0, 0, 0, 0, '', '', '', '', '', '2017-07-14 22:17:00', '2017-07-15 14:17:00'),
(24, 3, 'Ashinoshiri Dosojin Matsuri', '2018-01-07', '2018-01-07', 'Nagano', '381-2702', 'Ookahei, Nagano, Nagano Prefecture', 36.4866592, 137.9776795, 'Ashinoshiri Village', 'From JR Shinonoi station, take the Ooka Shinonoi route bus from Shinonoi-eki bus stop, get off at Ooka shisho-mae bus stop (approx. 1 hr). Approx. 40 min. walk, or 10 min. taxi ride from the bus stop', '', '', '', 'In the Ashinoshiri Dosojin Matsuri, a stone monument 1.5 meters in height is decorated with sacred rope to create a mysterious, god-like face. This stone statue becomes the guardian deity of the village for the year. It is derived from the tradition of creating the face of a deity with straw from the villagers??_New Year pine decorations, to pray for good health. It is also called Shinmen Soshoku Dosojin Matsuri. The statue of the deity\'s face famously appeared in the opening ceremony of the Nagano Winter Olympics.', '', 0, 0, 0, 0, '', '', '', 'http://www.janis.or.jp/users/dosozin/', '', '2017-07-12 22:17:00', '2017-07-13 14:17:00'),
(25, 4, 'Shoju Raiko Nerikuyoeshiki', '2017-10-08', '2017-10-08', 'Nara', '639-0276', 'Nara-ken, Katsuragi-shi, Taima,1263', 34.5160956, 135.6924488, 'Taima dera', 'From Shin-Osaka, go to Tennoji station on the JR line / Underground, then walk to Osaka-Abenobashi station on Kintetsu line, then go to Taimadera station (approx. 35 min.), then walk 15 min.\n', '', '', '', 'The high priest Eshin Sozu began Shoju Raiko Nerikuyoeshiki in 1005, to mark the anniversary of the death of Chujo Hime who died at the age of 29. She was the Nara period princess known for embroidering a mandala of the Pure Land of Amitabha Buddha in one night, using lotus thread. The ceremony consists of the preaching of Buddhist teachings at the temple, and a memorial service for the deceased. A procession is held, in which participants are disguised as the Bodhisattvas coming to welcome the spirit of the dead. Nerikuyo ceremonies in Japan are said to have started here. When the sun starts to set over Mt. Nijo, the parade of Kannon and other deities accompanied by 25 Bodhisattvas is a magnificent sight, and people pray for peace in their lives.', '', 0, 0, 0, 0, '', '', '', '', '', '2017-07-15 22:17:00', '2017-07-16 14:17:00'),
(26, 5, 'Kawazu Cherry Blossom Festival', '2018-02-10', '2018-03-10', 'Shizuoka', '413-0512', 'Kawazu Tourist Association, 72-12, sasahara, kawazu-cho, kamo-gun, Shizuoka', 34.7507109, 138.9897319, 'Kawazu Sakura Matsuri in Kawazu Town', 'about 4 hours from tokyo by car', '', '', '', 'Here, I share with you my insider tips on the best things to do and explore. My all time favorite part of any hanami expedition is viewing sakura as long as I get tired, and Kawazu Cherry Blossom Festival has it in abundance as you really have to walk to experience millions of sakura blossoms. With the festival on, there are so many things you could explore here such as you can taste local dishes, buy unique souvenirs, stroll around the whole town, stage performance, and have a relax time at local onsen including footbath. Staying a night will not be a bad idea. In fact, I stayed a night at one of the local onsen in Kawazu. The service was excellent!', '', 0, 0, 0, 0, '', '', '', 'http://kawazu-onsen.com/sakura/index.html', '', '2017-07-16 22:17:00', '2017-07-17 14:17:00'),
(27, 6, 'dessert tour in Wakura-Onsen 2017', '2017-04-01', '2018-03-31', 'Ishikawa', '926-0175', ' Ishikawa-ken, Nanao-sh,Wakuramachi,wa5-1', 37.0882791, 136.9144146, 'Wakura Onsen', 'about 6 hours from tokyo by car', '', '', '', 'you can eat some sweet foods here', '', 0, 0, 0, 0, '', '', '', 'http://www.wakura.or.jp/sightseeing/event/item285/', '', '2017-07-17 22:17:00', '2017-07-18 14:17:00'),
(29, 1, 'Kokusekiji Sominsai', '2018-02-03', '2018-02-03', 'Iwate', '023-0101', '\nIwate,Oshu,Mizusawa Ward Kuroishi Town Yamauchi 17', 39.084301, 141.2043822, 'Mizusawaku Kuroishicho', 'about 6hours from tokyo by car', '', '', '', 'All these men fighting with all their hearts in the bitter cold to become blessed makes it closer to a sport than a festival. Actually, this festival is open to anyone who applies, but there are rules like you can\'t eat meat, fish, eggs, or garlic for a week before the festival, so it\'s actually pretty difficult...', '', 0, 0, 0, 0, '', '', '', '', '', '2017-07-19 22:17:00', '2017-07-20 14:17:00'),
(30, 2, 'Sapporo Matsuri', '2018-06-14', '2018-06-16', 'Hokkaido', '064-0946', 'Hokkaid?_ Sapporo-shi, Chū?_ku, Futagoyama, 4 Chome??_??_??_3\n', 43.049104, 141.325607, 'Hokkaido Jingu', 'Get off at JR Sapporo station, take the Namboku subway line to Odori station, then the Tozai subway line to Maruyama Koen station. Approx. 15 min. walk.Approx. 15 min. by taxi from JR Sapporo station.', '', '', '', '', '', 0, 0, 0, 0, '', '', '', 'http://www.hokkaidojingu.or.jp/', '', '2017-07-11 22:17:00', '2017-07-12 14:17:00'),
(31, 3, 'Takayama Festival(Spring Festival)', '2018-04-14', '2018-04-15', 'Gifu', '506-0822', '156 Shiroyama, Takayama-shi', 36.133214, 137.261459, 'Hie Shrine', 'Train: Takayama Station on JR Takayama Main Line. 25 minutes??_walk from the station.\nCar: Takashiyama-Nishi IC on Chubu- Jukan Expressway. Free parking is available. ', '', '', '', 'The Takayama Festival (高山祭, Takayama Matsuri) is ranked as one of Japan\'s three most beautiful festivals alongside Kyoto\'s Gion Matsuri and the Chichibu Yomatsuri. It is held twice a year in spring and autumn in the old town of Takayama and attracts large numbers of spectators.\nThe Spring Festival (April 14-15) is the annual festival of the Hie Shrine in the southern half of Takayama\'s old town. Since the shrine is also known as Sanno-sama, the spring festival is also called Sanno Festival.\n\nLikewise, the Autumn Festival (October 9-10) is the annual festival of the Hachiman Shrine in the northern half of the old town, and the festival is also known as Hachiman Festival.\n\nThe spring and autumn festivals have similar attractions and schedules. Each festival features its own set of about a dozen festival floats (yatai). During the year, the tall and heavily decorated floats are stored in storehouses, which are scattered across Takayama\'s old town (except the floats exhibited in the Yatai Kaikan). A set of replica floats are, furthermore, exhibited year round at the Matsuri no Mori festival museum.', '', 0, 0, 0, 0, 'about 210,000', 'about 210,000', 'about 210,000', 'http://kankou.city.takayama.lg.jp/2000002/2000024/', '', '2017-07-30 22:17:00', '2017-07-30 14:17:00'),
(32, 4, 'Hakata Gion Yamakasa', '2017-07-01', '2017-07-15', 'Fukuoka', '812-0026', '1-41, Kamikawabata-machi, Hakata-ku, Fukuoka', 33.592996, 130.41049, 'around Kushida Shrine', 'The festival takes place in the Hakata district of Fukuoka. Kushida Shrine is located a five minute walk from Canal City Hakata or Gion Subway Station, or a 15-20 minute walk from Hakata Station.', '', '', '', 'Hakata Gion Yamakasa (博多祇園山笠) is a Japanese festival celebrated from the 1st until the 15th of July in Hakata, Fukuoka. The festivities are centered on the Kushida Jinja. The festival is famous for the Kakiyama, that weigh around one ton and are carried around the city as an act of float-racing. The festival is believed to be over 770 years old and attracts up to a million spectators each year. It was designated an Important Intangible Folk Cultural Property of Japan in 1979. The sound of the Yamakasa has also been selected by the Ministry of the Environment as one of the 100 Soundscapes of Japan.', '', 0, 0, 0, 0, 'about 700,000', 'about 700,000', 'about 700,000', 'http://www.hakatayamakasa.com/', '', '2017-07-22 22:17:00', '2017-07-23 14:17:00'),
(33, 5, 'Fuji-kawaguchiko Autumn Colors Festival', '2017-11-01', '2017-11-30', 'Yamanashi', '', 'Lake Kawaguchiko (north side)', 35.517095, 138.751779, 'Lake Kawaguchiko (north side)', 'Car: 20 minutes from the Chuo Expressway-Kawaguchiko IC. (Free parking.)\nBus: 20 minutes Retro Bus from Kawaguchiko Station. Get off at Kubota Itchiku Bijutsukan-mae.', '', '', '', 'Enjoy the beauty of Japan\'s autumn through the Japanese tradition of viewing koyo, or autumn colors. With Lake Kawaguchiko and Mt. Fuji as the backdrop, the Fuji-kawaguchiko Autumn Leaves Festival is the perfect place to view the autumn colors. The main event will be a light-up at night, with food stands, craft stands, a farmer\'s market, and much more! You can easily relax by eating, enjoying the great view, and walking around the lake with family, friends, and pets.', '', 0, 0, 0, 0, 'N/A', 'N/A', 'N/A', '', '', '2017-07-23 22:17:00', '2017-07-23 14:17:00'),
(34, 6, 'Kamakura Festival', '2017-12-29', '2018-01-03', 'Akita', '', 'Yokote-shi', 39.313782, 140.566649, 'Yokote Station to Yokote Castle', 'Via Omagari\n\nYokote and Omagari are connected by hourly local trains along the JR Ou Line (20 minutes, 320 yen). Omagari Station can be reached by the Akita Shinkansen from Tokyo (3.5 hours, about 17,000 yen) or from Sendai (2 hours, about 9,000 yen). The train rides are covered by the Japan Rail Pass, the JR East Tohoku Area Pass and the JR East South Hokkaido Pass.', '', '', '', 'The Yokote Kamakura Festival (横手?_雪祭??_ Yokote no Yuki Matsuri) has a history of about 450 years. It is held every year on February 15 and 16 in the city of Yokote in southeastern Akita Prefecture. The festival features many igloo-like snow houses, called kamakura, which are built at various locations.\nWithin each kamakura there is a snow altar dedicated to the water deity, to whom people pray for ample water. A charcoal brazier is set up to provide warmth and grill rice cakes. In the evenings (18:00 to 21:00), children invite festival visitors into their kamakura and offer them rice cakes and amazake, a type of warm sweet rice wine with zero or very low alcohol content. In return, the visitors make an offering to the water deity at the altar.\nThe festival area extends east of Yokote Station to Yokote Castle, which is located about two kilometers away across Yokote River. Starting from the station, visitors can enjoy a leisurely stroll along the streets of the town and appreciate scenes of kamakura built beside houses in the neighborhood. It is also possible to take part in kamakura making at one of the hands-on sessions at Komyoji Park.\n\nThe Kamakurakan Hall preserves a couple of kamakura all year round in a small -10 degree Celsius room, making it possible for visitors to see these snow houses even during warmer months. In the area close to the hall, many kamakura, snow sculptures and festival food stalls can be found, contributing to a lively atmosphere.', '', 0, 0, 0, 0, 'about 50,000', 'about 50,000', 'about 50,000', '', '', '2017-07-24 22:17:00', '2017-07-24 14:17:00'),
(35, 7, 'Bunkyo Ume Matsuri (Plum Festival)', '2017-02-17', '2017-03-13', 'Tokyo', '113-0034', '3-30-1 Yushima, Bunkyo-ku', 35.707818, 139.768219, 'Yushima Shrine', 'Yushima Subway Station, Exit 3, Oeda and Chiyoda subway lines. 2 minutes walk.', '', '', '', 'Yushima Tenmangu Shrine (Yushima Tenjin) has been beloved since the Edo period as a famous place to view plum blossoms. The precincts, which enshrine Sugawara no Michizane (the deity of scholarship), are an amazing sight when the approximately 300 plum trees - mainly Shirokaga white plums - bloom. Lord Sugawara was exiled to Dazaifu in Kyushu. He wrote a famous poem that read, \"Let the east wind blow and send your fragrance / Oh, plum blossoms / Do not forget the spring / Even though your master is gone.\" The plums are at their best from mid- to late February each year, but it\'s a good idea to check the flower information before you go (see the below URL).', '', 0, 0, 0, 0, 'about 400,000', 'about 400,000', 'about 400,000', 'http://www.yushimatenjin.or.jp/pc/ume/', '', '2017-07-25 22:17:00', '2017-07-25 14:17:00'),
(36, 1, 'Ueno Sakura Matsuri (Cherry Blossom Festival)', '2017-03-18', '2017-04-09', 'Tokyo', '110-0007', 'Uenokoen, Taito', 35.718123, 139.777882, 'Ueno Park', 'Ueno Park is just next to JR Ueno Station. Easiest access is provided by the station\'s \"Park Exit\".', '', '', '', 'Lined endlessly with a number of cherry trees, Ueno Parks main street is probably the first place that many Japanese people would think of when it comes to a beautiful scene of cherry blossoms in spring. During the festival, 1000 lanterns, which were originally intended for nighttime security, illuminate the park and invite people to celebrate the arrival of spring under a night sky. Located in the precinct of Toeisan Kaneiji Temple where the Tokugawa Shogunate family is buried, the park expects several hundred thousand visitors daily to come for the blossom viewing during the season. Stroll through the park tinted in pale pink by 600 Somei-yoshino (Yoshino cherry) trees before you head to an antique market or other special events also held at the park.', '', 0, 0, 0, 0, 'about 2,000,000', 'about 2,000,000', 'about 2,000,000', 'http://www.yushimatenjin.or.jp/pc/ume/', '', '2017-07-26 22:17:00', '2017-07-26 14:17:00'),
(37, 2, 'Meguro Sanma Festival', '2018-09-02', '2018-09-02', 'Tokyo', '152-0000', 'Meguro-ku', 35.633472, 139.715586, 'aroud Meguro Station', 'From Meguro station on the Yamanote line:\n-- 12 minute direct ride to Shinjuku\n-- 5 minute direct ride to Shibuya\n-- 18 minute direct ride to Tokyo', '', '', '', '\nDoes the prospect of free fish get you excited? If the answer is yes, head down to Meguro Station on the JR Yamanote Line and the Mita and Namboku Subway Lines for the annual Meguro Sanma Festival from 10am on the first Sunday of September. About 6,000 grilled Sanma (pacific saury) will be given away to mark the beginning of the season. You’ll have to wait in perhaps the longest queue you have ever seen, but presumably it’s worth it! The fish will be sourced from the tsunami affected port of Miyako in Iwate Prefecture.', '', 0, 0, 0, 0, '', '', '', '', '', '2017-07-27 22:17:00', '2017-07-27 14:17:00'),
(38, 3, 'Takayama Festival(Fall Festival)', '2018-04-14', '2018-04-15', 'Gifu', '506-0822', '156 Shiroyama, Takayama-shi', 36.133214, 137.261459, 'Hie Shrine', 'Train: Takayama Station on JR Takayama Main Line. 25 minutes??_walk from the station.\nCar: Takashiyama-Nishi IC on Chubu- Jukan Expressway. Free parking is available. ', '', '', '', 'The Takayama Festival (高山祭, Takayama Matsuri) is ranked as one of Japan\'s three most beautiful festivals alongside Kyoto\'s Gion Matsuri and the Chichibu Yomatsuri. It is held twice a year in spring and autumn in the old town of Takayama and attracts large numbers of spectators.\nThe Spring Festival (April 14-15) is the annual festival of the Hie Shrine in the southern half of Takayama\'s old town. Since the shrine is also known as Sanno-sama, the spring festival is also called Sanno Festival.\n\nLikewise, the Autumn Festival (October 9-10) is the annual festival of the Hachiman Shrine in the northern half of the old town, and the festival is also known as Hachiman Festival.\n\nThe spring and autumn festivals have similar attractions and schedules. Each festival features its own set of about a dozen festival floats (yatai). During the year, the tall and heavily decorated floats are stored in storehouses, which are scattered across Takayama\'s old town (except the floats exhibited in the Yatai Kaikan). A set of replica floats are, furthermore, exhibited year round at the Matsuri no Mori festival museum.', '', 0, 0, 0, 0, 'about 210,000', 'about 210,000', 'about 210,000', 'http://kankou.city.takayama.lg.jp/2000002/2000024/', '', '2017-07-30 22:17:00', '2017-07-30 14:17:00'),
(39, 4, 'Tamaseseri', '2018-01-03', '2018-01-03', 'Fukuoka', '812-8655', '1-22-1, Hakozaki, Higashi-ku, Fukuoka', 33.614593, 130.423405, 'Hakozaki Shrine', '5 minutes walk from the subway Hakozaki Miyamae Station', '', '', '', 'Men wearing only loincloths compete for an 8-kg treasure ball (takara-no-tama) 30-cm in diameter which is believed to bring good fortune upon the person who can lift it over his head. The men are divided into the Land Team made up of farmers who mainly work on the land and the Sea Team consisting of fishermen who work at sea. Whether the New Year will bring a rich harvest or a large catch will be determined by which team wins the ball and hands it to the Shinto priest. This is one of the three main festivals of Kyushu. With a history of 500 years, its origins are said to lie in the legend of the dragon god (ryujin) offering two balls to Empress Jingu (170-269).\n\nOne o’clock in the afternoon. Two purified balls ??_a “yang??_(representing masculinity) ball and a “yin??_(representing femininity) ball ??_are carried to Tamatori Ebisu Shrine. The “yin??_ball is dedicated to this shrine. At first, children carry the “yang??_ball in the direction of Hakozaki Shrine. They then hand it to some men waiting halfway. These men start scrambling for the ball, and amid cries of “Oisa! Oisa!??_the atmosphere becomes one of feverish excitement. This excitement reaches its peak by the time the men pass under the torii gate. All the while, they are splashed relentlessly with cold water despite the winter cold, as are the spectators who get soaked from head to toe. Because it is believed that just touching the ball will bring good luck, the spectators also struggle to reach the ball, creating greater panic. The Shinto priest at the shrine is waiting at the romon tower gate. If the Land Team hands him the ball it means a year of rich harvest. But if the Sea Team is the winner, it will be a year with a bumper catch.', '', 0, 0, 0, 0, 'about 50,000', 'about 50,000', 'about 50,000', 'http://www.hakozakigu.or.jp/omatsuri/tamatorisai/', '', '2017-07-29 22:17:00', '2017-07-29 14:17:00'),
(40, 5, 'Omizutori', '2018-03-01', '2018-03-14', 'Nara', '630-8587', '1 Zōshi-ch?_ Nara,', 34.890969, 135.667758, 'Todai-ji', 'Omizutori is held at Nigatsudo, a ten minute walk uphill from Todaiji Temple\'s main building.', '', '', '', 'Todaiji (東大寺, Tōdaiji, \"Great Eastern Temple\") is one of Japan\'s most famous and historically significant temples and a landmark of Nara. The temple was constructed in 752 as the head temple of all provincial Buddhist temples of Japan and grew so powerful that the capital was moved from Nara to Nagaoka in 784 in order to lower the temple\'s influence on government affairs.\n\nTodaiji\'s main hall, the Daibutsuden (Big Buddha Hall) is the world\'s largest wooden building, despite the fact that the present reconstruction of 1692 is only two thirds of the original temple hall\'s size. The massive building houses one of Japan\'s largest bronze statues of Buddha (Daibutsu). The 15 meters tall, seated Buddha represents Vairocana and is flanked by two Bodhisattvas.\n\nSeveral smaller Buddhist statues and models of the former and current buildings are also on display in the Daibutsuden Hall. Another popular attraction is a pillar with a hole in its base that is the same size as the Daibutsu\'s nostril. It is said that those who can squeeze through this opening will be granted enlightenment in their next life.\n\nAlong the approach to Todaiji stands the Nandaimon Gate, a large wooden gate watched over by two fierce looking statues. Representing the Nio Guardian Kings, the statues are designated national treasures together with the gate itself. Temple visitors will also encounter some deer from the adjacent Nara Park, begging for shika senbei, special crackers for deer that are sold for around 150 yen.', '', 0, 0, 0, 0, 'about 30,000', 'about 30,000', 'about 30,000', '', '', '2017-07-29 22:17:00', '2017-07-29 14:17:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `event_categories`
--

CREATE TABLE `event_categories` (
  `e_category_id` int(11) NOT NULL,
  `e_category` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `event_categories`
--

INSERT INTO `event_categories` (`e_category_id`, `e_category`) VALUES
(1, 'spring'),
(2, 'summer'),
(3, 'fall'),
(4, 'winter'),
(5, 'flower'),
(6, 'sakura'),
(7, 'food_drink'),
(8, 'alcohol'),
(9, 'strange_festival'),
(10, '100years_lasting');

-- --------------------------------------------------------

--
-- テーブルの構造 `event_connects`
--

CREATE TABLE `event_connects` (
  `e_category_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `event_connects`
--

INSERT INTO `event_connects` (`e_category_id`, `event_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(1, 11),
(2, 12),
(3, 13),
(4, 14),
(5, 15),
(6, 16),
(7, 17),
(8, 18),
(9, 19),
(10, 20),
(1, 21),
(2, 22),
(3, 23),
(4, 24),
(5, 25),
(6, 26),
(7, 27),
(8, 28),
(9, 29),
(10, 30),
(1, 31),
(2, 32),
(3, 33),
(4, 34),
(5, 35),
(6, 36),
(7, 37),
(3, 38),
(9, 39),
(10, 40);

-- --------------------------------------------------------

--
-- テーブルの構造 `event_movies`
--

CREATE TABLE `event_movies` (
  `e_movie_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `e_mov_url` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `event_pics`
--

CREATE TABLE `event_pics` (
  `e_pic_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `e_pic_path` varchar(255) CHARACTER SET utf8 NOT NULL,
  `top_pic_flag` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `event_pics`
--

INSERT INTO `event_pics` (`e_pic_id`, `event_id`, `e_pic_path`, `top_pic_flag`, `created`) VALUES
(1, 5, '../../event_pictures/1364378982_1.jpg', 0, '2017-06-21 22:17:00'),
(2, 5, '../../event_pictures/1383781983_1.jpg', 0, '2017-06-21 22:17:00'),
(3, 5, '../../event_pictures/1378431839_1.jpg', 0, '2017-06-21 22:17:00'),
(4, 5, '../../event_pictures/1-1374815210_8.jpg', 0, '2017-06-21 22:17:00'),
(5, 5, '../../event_pictures/1-1383885972_8.jpg', 0, '2017-06-21 22:17:00'),
(6, 5, '../../event_pictures/1383782074_1.jpg', 0, '2017-06-21 22:17:00'),
(7, 2, '../../event_pictures/valleyball.JPG', 0, '2017-06-21 22:17:00'),
(8, 2, '../../event_pictures/handball.JPG', 0, '2017-06-21 22:17:00'),
(9, 2, '../../event_pictures/tennis.JPG', 0, '2017-06-21 22:17:00'),
(10, 2, '../../event_pictures/soccer.JPG', 0, '2017-06-21 22:17:00'),
(11, 2, '../../event_pictures/yokohamabeachfesta.jpg', 0, '2017-06-21 22:17:00'),
(12, 9, '../../event_pictures/waraimaturi.jpg', 0, '2017-06-21 22:17:00'),
(13, 9, '../../event_pictures/warau.jpg', 0, '2017-06-21 22:17:00'),
(14, 9, '../../event_pictures/niu-shrine.jpg', 0, '2017-06-21 22:17:00'),
(15, 4, '../../event_pictures/toukaiti.jpg', 0, '2017-06-21 22:17:00'),
(16, 4, '../../event_pictures/toukaiti2.jpg', 0, '2017-06-21 22:17:00'),
(17, 4, '../../event_pictures/toukaiti3.jpg', 0, '2017-06-21 22:17:00'),
(18, 4, '../../event_pictures/toukaiti4.jpg', 0, '2017-06-21 22:17:00'),
(19, 4, '../../event_pictures/toukaiti5.jpg', 0, '2017-06-21 22:17:00'),
(20, 7, '../../event_pictures/negi2.jpg', 0, '2017-06-21 22:17:00'),
(21, 7, '../../event_pictures/poster-min.jpg', 0, '2017-06-21 22:17:00'),
(22, 7, '../../event_pictures/negi.jpg', 0, '2017-06-21 22:17:00'),
(23, 7, '../../event_pictures/annai.jpg', 0, '2017-06-21 22:17:00'),
(24, 7, '../../event_pictures/negi3.jpg', 0, '2017-06-21 22:17:00'),
(25, 10, '../../event_pictures/kamakura.jpg', 0, '2017-06-21 22:17:00'),
(26, 10, '../../event_pictures/kamakura2.jpg', 0, '2017-06-21 22:17:00'),
(27, 10, '../../event_pictures/kamakura3.jpg', 0, '2017-06-21 22:17:00'),
(28, 10, '../../event_pictures/kamakura4.jpg', 0, '2017-06-21 22:17:00'),
(29, 10, '../../event_pictures/kamakura5.jpg', 0, '2017-06-21 22:17:00'),
(30, 8, '../../event_pictures/sake.jpg', 0, '2017-06-21 22:17:00'),
(31, 8, '../../event_pictures/sake2.jpg', 0, '2017-06-21 22:17:00'),
(32, 8, '../../event_pictures/sake3.jpg', 0, '2017-06-21 22:17:00'),
(33, 8, '../../event_pictures/sake4.jpg', 0, '2017-06-21 22:17:00'),
(34, 8, '../../event_pictures/sake5.jpg', 0, '2017-06-21 22:17:00'),
(35, 6, '../../event_pictures/32.jpg', 0, '2017-06-21 22:17:00'),
(36, 6, '../../event_pictures/13.jpeg', 0, '2017-06-21 22:17:00'),
(37, 6, '../../event_pictures/18.jpeg', 0, '2017-06-21 22:17:00'),
(38, 6, '../../event_pictures/28.jpeg', 0, '2017-06-21 22:17:00'),
(39, 1, '../../event_pictures/hinamaturi.jpeg', 0, '2017-06-21 22:17:00'),
(40, 1, '../../event_pictures/hinamaturi4.jpeg', 0, '2017-06-21 22:17:00'),
(41, 1, '../../event_pictures/hinamaturi2.jpeg', 0, '2017-06-21 22:17:00'),
(42, 1, '../../event_pictures/hinamaturi3.jpeg', 0, '2017-06-21 22:17:00'),
(43, 3, '../../event_pictures/narita.jpg', 0, '2017-06-21 22:17:00'),
(44, 3, '../../event_pictures/narita2.jpg', 0, '2017-06-21 22:17:00'),
(45, 3, '../../event_pictures/narita3.jpg', 0, '2017-06-21 22:17:00'),
(46, 3, '../../event_pictures/narita4.jpg', 0, '2017-06-21 22:17:00'),
(47, 3, '../../event_pictures/narita5.jpg', 0, '2017-06-21 22:17:00'),
(48, 0, '../../event_pictures/', 0, '2017-06-21 22:17:00'),
(49, 0, '../../event_pictures/', 0, '2017-06-21 22:17:00'),
(50, 0, '../../event_pictures/', 0, '2017-06-21 22:17:00'),
(51, 11, '../../event_pictures/Sendai_aoba1.jpg', 0, '2017-06-21 22:17:00'),
(52, 11, '../../event_pictures/Sendai_aoba2.jpg', 0, '2017-06-21 22:17:00'),
(53, 11, '../../event_pictures/Sendai_aoba3.jpg', 0, '2017-06-21 22:17:00'),
(54, 11, '../../event_pictures/Sendai_aoba4.jpg', 0, '2017-06-21 22:17:00'),
(55, 11, '../../event_pictures/Sendai_aoba5.jpg', 0, '2017-06-21 22:17:00'),
(56, 12, '../../event_pictures/hanagasa1.jpg', 0, '2017-06-21 22:17:00'),
(57, 12, '../../event_pictures/hanagasa2.jpg', 0, '2017-06-21 22:17:00'),
(58, 12, '../../event_pictures/hanagasa3.jpg', 0, '2017-06-21 22:17:00'),
(59, 12, '../../event_pictures/hanagasa4.jpg', 0, '2017-06-21 22:17:00'),
(60, 12, '../../event_pictures/hanagasa5.jpg', 0, '2017-06-21 22:17:00'),
(61, 13, '../../event_pictures/kawagoe1.jpg', 0, '2017-06-21 22:17:00'),
(62, 13, '../../event_pictures/kawagoe2.jpg', 0, '2017-06-21 22:17:00'),
(63, 13, '../../event_pictures/kawagoe3.jpg', 0, '2017-06-21 22:17:00'),
(64, 13, '../../event_pictures/kawagoe4.jpg', 0, '2017-06-21 22:17:00'),
(65, 13, '../../event_pictures/kawagoe5.jpg', 0, '2017-06-21 22:17:00'),
(66, 14, '../../event_pictures/Sapporo_yuki1.jpg', 0, '2017-06-21 22:17:00'),
(67, 14, '../../event_pictures/Sapporo_yuki2.jpg', 0, '2017-06-21 22:17:00'),
(68, 14, '../../event_pictures/Sapporo_yuki3.jpg', 0, '2017-06-21 22:17:00'),
(69, 14, '../../event_pictures/Sapporo_yuki4.jpg', 0, '2017-06-21 22:17:00'),
(70, 14, '../../event_pictures/Sapporo_yuki5.jpg', 0, '2017-06-21 22:17:00'),
(71, 15, '../../event_pictures/SunFlower1.jpg', 0, '2017-06-21 22:17:00'),
(72, 15, '../../event_pictures/SunFlower2.jpg', 0, '2017-06-21 22:17:00'),
(73, 15, '../../event_pictures/SunFlower3.jpg', 0, '2017-06-21 22:17:00'),
(74, 15, '../../event_pictures/SunFlower4.jpg', 0, '2017-06-21 22:17:00'),
(75, 15, '../../event_pictures/SunFlower5.jpg', 0, '2017-06-21 22:17:00'),
(76, 16, '../../event_pictures/hirosaki_sakura1.jpg', 0, '2017-06-21 22:17:00'),
(77, 16, '../../event_pictures/hirosaki_sakura2.jpg', 0, '2017-06-21 22:17:00'),
(78, 16, '../../event_pictures/hirosaki_sakura3.jpg', 0, '2017-06-21 22:17:00'),
(79, 16, '../../event_pictures/hirosaki_sakura4.jpg', 0, '2017-06-21 22:17:00'),
(80, 16, '../../event_pictures/hirosaki_sakura5.jpg', 0, '2017-06-21 22:17:00'),
(81, 17, '../../event_pictures/imoni3.jpg', 0, '2017-06-21 22:17:00'),
(82, 17, '../../event_pictures/imoni2.jpg', 0, '2017-06-21 22:17:00'),
(83, 17, '../../event_pictures/imoni1.jpg', 0, '2017-06-21 22:17:00'),
(84, 18, '../../event_pictures/Kurasankan4.jpg', 0, '2017-06-21 22:17:00'),
(85, 18, '../../event_pictures/Kurasankan2.jpg', 0, '2017-06-21 22:17:00'),
(86, 18, '../../event_pictures/Kurasankan3.jpg', 0, '2017-06-21 22:17:00'),
(87, 18, '../../event_pictures/Kurasankan1.jpg', 0, '2017-06-21 22:17:00'),
(88, 18, '../../event_pictures/Kurasankan5.jpg', 0, '2017-06-21 22:17:00'),
(89, 19, '../../event_pictures/Fukuotoko_erabi1.jpg', 0, '2017-06-21 22:17:00'),
(90, 19, '../../event_pictures/Fukuotoko_erabi2.jpg', 0, '2017-06-21 22:17:00'),
(91, 19, '../../event_pictures/Fukuotoko_erabi3.jpg', 0, '2017-06-21 22:17:00'),
(92, 19, '../../event_pictures/Fukuotoko_erabi4.jpg', 0, '2017-06-21 22:17:00'),
(93, 20, '../../event_pictures/Aizu1.jpg', 0, '2017-06-21 22:17:00'),
(94, 20, '../../event_pictures/Aizu2.jpg', 0, '2017-06-21 22:17:00'),
(95, 20, '../../event_pictures/Aizu3.jpg', 0, '2017-06-21 22:17:00'),
(96, 20, '../../event_pictures/Aizu4.jpg', 0, '2017-06-21 22:17:00'),
(97, 20, '../../event_pictures/Aizu5.jpg', 0, '2017-06-21 22:17:00'),
(98, 0, '../../event_pictures/', 0, '2017-06-21 22:17:00'),
(99, 0, '../../event_pictures/', 0, '2017-06-21 22:17:00'),
(100, 0, '../../event_pictures/', 0, '2017-06-21 22:17:00'),
(101, 21, '../../event_pictures/obasama1.jpg', 0, '2017-06-21 22:17:00'),
(102, 21, '../../event_pictures/obasama2.jpg', 0, '2017-06-21 22:17:00'),
(103, 21, '../../event_pictures/obasama3.jpg', 0, '2017-06-21 22:17:00'),
(104, 21, '../../event_pictures/obasama4.jpg', 0, '2017-06-21 22:17:00'),
(105, 21, '../../event_pictures/obasama5.jpg', 0, '2017-06-21 22:17:00'),
(106, 22, '../../event_pictures/Matsumae1.jpg', 0, '2017-06-21 22:17:00'),
(107, 22, '../../event_pictures/Matsumae2.jpg', 0, '2017-06-21 22:17:00'),
(108, 22, '../../event_pictures/Matsumae3.jpg', 0, '2017-06-21 22:17:00'),
(109, 22, '../../event_pictures/Matsumae4.jpg', 0, '2017-06-21 22:17:00'),
(110, 22, '../../event_pictures/Matsumae5.jpg', 0, '2017-06-21 22:17:00'),
(111, 23, '../../event_pictures/Ashinoshiri1.jpg', 0, '2017-06-21 22:17:00'),
(112, 23, '../../event_pictures/Ashinoshiri2.jpg', 0, '2017-06-21 22:17:00'),
(113, 23, '../../event_pictures/Ashinoshiri3.jpg', 0, '2017-06-21 22:17:00'),
(114, 23, '../../event_pictures/Ashinoshiri4.jpg', 0, '2017-06-21 22:17:00'),
(115, 23, '../../event_pictures/Ashinoshiri5.jpg', 0, '2017-06-21 22:17:00'),
(116, 24, '../../event_pictures/Nanakuri5.jpg', 0, '2017-06-21 22:17:00'),
(117, 24, '../../event_pictures/Nanakuri2.jpg', 0, '2017-06-21 22:17:00'),
(118, 24, '../../event_pictures/Nanakuri3.jpg', 0, '2017-06-21 22:17:00'),
(119, 24, '../../event_pictures/Nanakuri4.jpg', 0, '2017-06-21 22:17:00'),
(120, 24, '../../event_pictures/Nanakuri1.jpg', 0, '2017-06-21 22:17:00'),
(121, 25, '../../event_pictures/Ashinoshiri5.jpg', 0, '2017-06-21 22:17:00'),
(122, 25, '../../event_pictures/Ashinoshiri2.jpg', 0, '2017-06-21 22:17:00'),
(123, 25, '../../event_pictures/Ashinoshiri3.jpg', 0, '2017-06-21 22:17:00'),
(124, 25, '../../event_pictures/Ashinoshiri4.jpg', 0, '2017-06-21 22:17:00'),
(125, 25, '../../event_pictures/Ashinoshiri1.jpg', 0, '2017-06-21 22:17:00'),
(126, 26, '../../event_pictures/Kawazu1.jpg', 0, '2017-06-21 22:17:00'),
(127, 26, '../../event_pictures/Kawazu2.jpg', 0, '2017-06-21 22:17:00'),
(128, 26, '../../event_pictures/Kawazu3.jpg', 0, '2017-06-21 22:17:00'),
(129, 26, '../../event_pictures/Kawazu4.jpg', 0, '2017-06-21 22:17:00'),
(130, 26, '../../event_pictures/Kawazu5.jpg', 0, '2017-06-21 22:17:00'),
(131, 27, '../../event_pictures/desert1.jpg', 0, '2017-06-21 22:17:00'),
(132, 27, '../../event_pictures/desert1.jpg', 0, '2017-06-21 22:17:00'),
(133, 27, '../../event_pictures/desert1.jpg', 0, '2017-06-21 22:17:00'),
(134, 27, '../../event_pictures/desert1.jpg', 0, '2017-06-21 22:17:00'),
(135, 27, '../../event_pictures/desert1.jpg', 0, '2017-06-21 22:17:00'),
(141, 29, '../../event_pictures/Kokusekiji1.jpg', 0, '2017-06-21 22:17:00'),
(142, 29, '../../event_pictures/Kokusekiji2.jpg', 0, '2017-06-21 22:17:00'),
(143, 29, '../../event_pictures/Kokusekiji3.jpg', 0, '2017-06-21 22:17:00'),
(144, 29, '../../event_pictures/Kokusekiji4.jpg', 0, '2017-06-21 22:17:00'),
(145, 29, '../../event_pictures/Kokusekiji5.jpg', 0, '2017-06-21 22:17:00'),
(146, 30, '../../event_pictures/Sapporo1.jpg', 0, '2017-06-21 22:17:00'),
(147, 30, '../../event_pictures/Sapporo2.jpg', 0, '2017-06-21 22:17:00'),
(148, 30, '../../event_pictures/Sapporo3.jpg', 0, '2017-06-21 22:17:00'),
(149, 30, '../../event_pictures/Sapporo4.jpg', 0, '2017-06-21 22:17:00'),
(150, 30, '../../event_pictures/Sapporo5.jpg', 0, '2017-06-21 22:17:00'),
(151, 31, '../../event_pictures/takayama_haru_1.jpeg', 0, '2017-06-21 22:17:00'),
(152, 31, '../../event_pictures/takayama_haru_2.jpg', 0, '2017-06-21 22:17:00'),
(153, 31, '../../event_pictures/takayama_haru_3.jpeg', 0, '2017-06-21 22:17:00'),
(154, 31, '../../event_pictures/takayama_haru_4.jpg', 0, '2017-06-21 22:17:00'),
(155, 32, '../../event_pictures/yamakasa_1.jpg', 0, '2017-06-21 22:17:00'),
(156, 32, '../../event_pictures/yamakasa_2.jpg', 0, '2017-06-21 22:17:00'),
(157, 32, '../../event_pictures/yamakasa_3.jpg', 0, '2017-06-21 22:17:00'),
(158, 32, '../../event_pictures/yamakasa_4.jpg', 0, '2017-06-21 22:17:00'),
(159, 32, '../../event_pictures/yamakasa_5.jpg', 0, '2017-06-21 22:17:00'),
(160, 33, '../../event_pictures/koyo_matsuri_1.jpg', 0, '2017-06-21 22:17:00'),
(161, 33, '../../event_pictures/koyo_matsuri_2.jpg', 0, '2017-06-21 22:17:00'),
(162, 33, '../../event_pictures/koyo_matsuri_3.jpg', 0, '2017-06-21 22:17:00'),
(163, 33, '../../event_pictures/koyo_matsuri_4.jpg', 0, '2017-06-21 22:17:00'),
(164, 34, '../../event_pictures/yokote_1.jpeg', 0, '2017-06-21 22:17:00'),
(165, 34, '../../event_pictures/yokote_2.jpeg', 0, '2017-06-21 22:17:00'),
(166, 34, '../../event_pictures/yokote_3.jpg', 0, '2017-06-21 22:17:00'),
(167, 34, '../../event_pictures/yokote_4.jpeg', 0, '2017-06-21 22:17:00'),
(168, 35, '../../event_pictures/ume_matsuri_1.jpeg', 0, '2017-06-21 22:17:00'),
(169, 35, '../../event_pictures/ume_matsuri_2.jpeg', 0, '2017-06-21 22:17:00'),
(170, 35, '../../event_pictures/ume_matsuri_3.jpg', 0, '2017-06-21 22:17:00'),
(171, 35, '../../event_pictures/ume_matsuri_4.jpeg', 0, '2017-06-21 22:17:00'),
(172, 36, '../../event_pictures/sakura_matsuri_1.jpg', 0, '2017-06-21 22:17:00'),
(173, 36, '../../event_pictures/sakura_matsuri_2.jpg', 0, '2017-06-21 22:17:00'),
(174, 36, '../../event_pictures/sakura_matsuri_3.jpg', 0, '2017-06-21 22:17:00'),
(175, 36, '../../event_pictures/sakura_matsuri_4.jpg', 0, '2017-06-21 22:17:00'),
(176, 36, '../../event_pictures/sakura_matsuri_5.jpeg', 0, '2017-06-21 22:17:00'),
(177, 37, '../../event_pictures/sanma_5.jpeg', 0, '2017-06-21 22:17:00'),
(178, 37, '../../event_pictures/sanma_2.jpg', 0, '2017-06-21 22:17:00'),
(179, 37, '../../event_pictures/sanma_3.jpg', 0, '2017-06-21 22:17:00'),
(180, 37, '../../event_pictures/sanma_4.jpg', 0, '2017-06-21 22:17:00'),
(181, 37, '../../event_pictures/sanma_1.jpg', 0, '2017-06-21 22:17:00'),
(182, 38, '../../event_pictures/takayama_aki_1.jpg', 0, '2017-06-21 22:17:00'),
(183, 38, '../../event_pictures/takayama_aki_2.jpeg', 0, '2017-06-21 22:17:00'),
(184, 38, '../../event_pictures/takayama_aki_3.jpeg', 0, '2017-06-21 22:17:00'),
(185, 39, '../../event_pictures/tamaseseri_6.jpg', 0, '2017-06-21 22:17:00'),
(186, 39, '../../event_pictures/tamaseseri_2.jpg', 0, '2017-06-21 22:17:00'),
(187, 39, '../../event_pictures/tamaseseri_3.jpg', 0, '2017-06-21 22:17:00'),
(188, 39, '../../event_pictures/tamaseseri_4.jpg', 0, '2017-06-21 22:17:00'),
(189, 39, '../../event_pictures/tamaseseri_5.jpg', 0, '2017-06-21 22:17:00'),
(190, 39, '../../event_pictures/tamaseseri_1.jpg', 0, '2017-06-21 22:17:00'),
(191, 40, '../../event_pictures/omizutori_1.jpeg', 0, '2017-06-21 22:17:00'),
(192, 40, '../../event_pictures/omizutori_2.jpeg', 0, '2017-06-21 22:17:00'),
(193, 40, '../../event_pictures/omizutori_3.jpg', 0, '2017-06-21 22:17:00'),
(194, 40, '../../event_pictures/omizutori_4.jpg', 0, '2017-06-21 22:17:00'),
(195, 0, '../../event_pictures/', 0, '2017-06-21 22:17:00'),
(196, 0, '../../event_pictures/', 0, '2017-06-21 22:17:00'),
(197, 0, '../../event_pictures/', 0, '2017-06-21 22:17:00'),
(198, 0, '../../event_pictures/', 0, '2017-06-21 22:17:00'),
(199, 0, '../../event_pictures/', 0, '2017-06-21 22:17:00'),
(200, 0, '../../event_pictures/', 0, '2017-06-21 22:17:00'),
(201, 21, '../../event_pictures/20170726090637スクリーンショット 2017-07-14 5.08.46.png', 0, '2017-07-26 15:07:38'),
(202, 21, '../../event_pictures/20170726090637スクリーンショット 2017-07-14 4.29.04.png', 0, '2017-07-26 15:07:38'),
(203, 21, '../../event_pictures/20170726090637スクリーンショット 2017-07-14 4.28.55.png', 0, '2017-07-26 15:07:38'),
(204, 21, '../../event_pictures/20170726090637スクリーンショット 2017-07-14 4.28.47.png', 0, '2017-07-26 15:07:38');

-- --------------------------------------------------------

--
-- テーブルの構造 `joins`
--

CREATE TABLE `joins` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `joins`
--

INSERT INTO `joins` (`user_id`, `event_id`, `created`) VALUES
(1, 1, '0000-00-00 00:00:00'),
(1, 2, '0000-00-00 00:00:00'),
(1, 3, '0000-00-00 00:00:00'),
(2, 1, '0000-00-00 00:00:00'),
(2, 2, '0000-00-00 00:00:00'),
(2, 3, '0000-00-00 00:00:00'),
(3, 1, '0000-00-00 00:00:00'),
(3, 2, '0000-00-00 00:00:00'),
(3, 3, '0000-00-00 00:00:00'),
(3, 16, '0000-00-00 00:00:00'),
(3, 15, '0000-00-00 00:00:00'),
(8, 15, '0000-00-00 00:00:00'),
(8, 13, '0000-00-00 00:00:00'),
(8, 16, '0000-00-00 00:00:00'),
(8, 17, '0000-00-00 00:00:00'),
(8, 10, '0000-00-00 00:00:00'),
(8, 11, '0000-00-00 00:00:00'),
(0, 12, '0000-00-00 00:00:00'),
(9, 11, '0000-00-00 00:00:00'),
(9, 10, '0000-00-00 00:00:00'),
(9, 14, '0000-00-00 00:00:00'),
(9, 13, '0000-00-00 00:00:00'),
(9, 17, '0000-00-00 00:00:00'),
(11, 14, '0000-00-00 00:00:00'),
(11, 10, '0000-00-00 00:00:00'),
(11, 11, '0000-00-00 00:00:00'),
(3, 18, '0000-00-00 00:00:00'),
(3, 13, '0000-00-00 00:00:00'),
(3, 14, '0000-00-00 00:00:00'),
(3, 109, '0000-00-00 00:00:00'),
(3, 108, '0000-00-00 00:00:00'),
(5, 11, '0000-00-00 00:00:00'),
(3, 11, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `likes`
--

INSERT INTO `likes` (`user_id`, `event_id`, `created`) VALUES
(1, 1, '2017-07-07 00:00:00'),
(1, 2, '2017-07-07 00:00:00'),
(1, 3, '2017-07-07 00:00:00'),
(2, 1, '2017-07-07 00:00:00'),
(2, 2, '2017-07-07 00:00:00'),
(2, 3, '2017-07-07 00:00:00'),
(3, 1, '2017-07-07 00:00:00'),
(3, 2, '2017-07-07 00:00:00'),
(3, 3, '2017-07-07 00:00:00'),
(3, 15, '0000-00-00 00:00:00'),
(3, 15, '0000-00-00 00:00:00'),
(3, 11, '0000-00-00 00:00:00'),
(3, 16, '0000-00-00 00:00:00'),
(3, 17, '0000-00-00 00:00:00'),
(8, 15, '0000-00-00 00:00:00'),
(8, 14, '0000-00-00 00:00:00'),
(8, 13, '0000-00-00 00:00:00'),
(8, 16, '0000-00-00 00:00:00'),
(8, 17, '0000-00-00 00:00:00'),
(8, 10, '0000-00-00 00:00:00'),
(8, 11, '0000-00-00 00:00:00'),
(9, 12, '0000-00-00 00:00:00'),
(9, 13, '0000-00-00 00:00:00'),
(11, 14, '0000-00-00 00:00:00'),
(11, 10, '0000-00-00 00:00:00'),
(11, 17, '0000-00-00 00:00:00'),
(3, 18, '0000-00-00 00:00:00'),
(3, 13, '0000-00-00 00:00:00'),
(3, 14, '0000-00-00 00:00:00'),
(3, 15, '0000-00-00 00:00:00'),
(3, 109, '0000-00-00 00:00:00'),
(3, 108, '0000-00-00 00:00:00'),
(5, 11, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `chat_room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `read_flag` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `messages`
--

INSERT INTO `messages` (`message_id`, `chat_room_id`, `user_id`, `message`, `read_flag`, `created`) VALUES
(1, 1, 3, 'aa', 0, '2017-07-23 20:06:27'),
(2, 0, 3, 'ああああああああ', 0, '2017-07-23 21:27:22'),
(3, 0, 3, 'iiiiiiiiiiiiiiiiiiiiiii', 0, '2017-07-23 21:27:29'),
(4, 0, 3, 'lllllllllllllllll', 0, '2017-07-26 08:12:31');

-- --------------------------------------------------------

--
-- テーブルの構造 `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `news_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `news_comment` text CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `news`
--

INSERT INTO `news` (`news_id`, `event_id`, `news_title`, `news_comment`, `created`, `modified`) VALUES
(1, 1, '', '天気悪し', '2017-07-08 21:48:30', '2017-07-14 05:00:08'),
(2, 1, 'お知らせです', 'っっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっｂっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっｂっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっｂっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっｂっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっｂっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっｂっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっｂっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっｂ', '2017-07-13 00:00:00', '2017-07-14 05:00:08'),
(3, 11, '天気悪目', 'ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ', '2017-07-24 00:00:00', '2017-07-23 16:00:00'),
(4, 11, '天気良さげ', 'っっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっっｋ', '2017-07-25 00:00:00', '2017-07-24 16:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `notification_user_id` int(11) NOT NULL,
  `notification_category_id` int(11) NOT NULL,
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- テーブルの構造 `notification_categories`
--

CREATE TABLE `notification_categories` (
  `notification_category_id` int(11) NOT NULL,
  `notification_category` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `notification_categories`
--

INSERT INTO `notification_categories` (`notification_category_id`, `notification_category`) VALUES
(1, 'message'),
(2, 'like'),
(3, 'review');

-- --------------------------------------------------------

--
-- テーブルの構造 `organizers`
--

CREATE TABLE `organizers` (
  `o_id` int(11) NOT NULL,
  `o_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_f_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_l_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `o_email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_pref` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_postal` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_tel` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `o_intro` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `o_pic` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `organizers`
--

INSERT INTO `organizers` (`o_id`, `o_name`, `o_f_name`, `o_l_name`, `o_email`, `o_pref`, `o_postal`, `o_address`, `o_tel`, `o_password`, `o_intro`, `o_pic`, `created`, `modified`) VALUES
(1, 'umetani', 'umetani', '', 'umetani@gmail.com', '東京都', '1700002', '豊島区巣鴨', '09050896307', '56ca78f2319ab20ed3c881bb89f02d608111bb69', '', '20170704145241japanival_logo_red_black_cropped (1).png', '2017-07-04 20:52:41', '2017-07-04 12:52:41'),
(2, '梅谷', '梅谷', '', 'yumetani@gmail.com', '東京都', '1700002', '豊島区巣鴨', '09050896307', 'ff594fca1a4bc1ad86f227c2bf9df5210c5a8a1e', '', 'スクリーンショット 2017-07-14 5.08.46.png', '2017-07-04 20:58:34', '2017-07-24 22:16:27'),
(3, 'o1umetani', 'o1umetani', NULL, 'o1umetani@gmail.com', '福岡県', '8030816', '北九州市', '0935612169', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, '2017-07-17 21:20:04', '2017-07-17 13:20:04'),
(4, 'o2umetani', 'o2umetani', NULL, 'o2umetani@gmail.com', '福岡県', '8030816', '北九州市', '0935612169', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', NULL, NULL, '2017-07-17 21:26:13', '2017-07-17 13:26:13'),
(5, 'o3umetani', 'o3umetani', NULL, 'o3umetani@gmail.com', '福岡県', '8030816', '北九州市', '0935612169', 'c86fdc162394ce7e318f5e159ecac361031151a9', '', 'a', '2017-07-17 21:42:52', '2017-07-17 13:42:52'),
(6, 'o4umetani', 'o4umetani', NULL, 'o4umetani@gmail.com', '福岡県', '8030816', '北九州市', '0935612169', 'e27da9e75e8899b1e2df18caa76bd6bd87d6b973', '', 'a', '2017-07-17 22:09:39', '2017-07-17 14:09:39'),
(7, 'o5umetani', 'o5umetani', NULL, '05umetani', '福岡県', '8030816', '北九州市', '0935612169', '04c8d1dc95db8cfc57746c4817414218edb0cdd0', '', 'a', '2017-07-17 22:11:12', '2017-07-17 14:11:12'),
(8, 'o6umetani', 'o6umetani', NULL, 'o6umetani@gmail.com', '福岡県', '8030816', '北九州市', '0935612169', '9272f680e241de0c088ed8437436058f36c9890c', '', 'a', '2017-07-17 22:12:51', '2017-07-17 14:12:51'),
(9, 'o7umetani', 'o7umetani', NULL, 'o7umetani@gmail.com', '福岡県', '8030816', '北九州市', '0935612169', '53af8daf68524a78a4c784e138c7cd8ef319ac2b', '', 'a', '2017-07-17 22:17:41', '2017-07-17 14:17:41');

-- --------------------------------------------------------

--
-- テーブルの構造 `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `request_category_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- テーブルのデータのダンプ `requests`
--

INSERT INTO `requests` (`request_id`, `user_id`, `event_id`, `request_category_id`, `created`, `modified`) VALUES
(1, 4, 10, 1, '2017-08-23 00:00:00', '2017-07-23 06:59:36'),
(6, 3, 11, 3, '2017-07-25 22:10:11', '2017-07-25 14:10:11'),
(7, 3, 11, 0, '2017-07-25 22:11:12', '2017-07-25 14:11:12'),
(8, 5, 11, 1, '2017-07-26 09:01:13', '2017-07-26 01:01:13'),
(9, 5, 11, 1, '2017-07-26 09:04:05', '2017-07-26 01:04:05'),
(10, 3, 11, 2, '2017-07-26 09:31:45', '2017-07-26 01:31:45'),
(11, 3, 3, 1, '2017-07-26 14:51:07', '2017-07-26 06:51:07'),
(12, 3, 3, 1, '2017-07-26 14:57:55', '2017-07-26 06:57:55'),
(13, 3, 3, 3, '2017-07-26 14:58:06', '2017-07-26 06:58:06'),
(14, 3, 3, 3, '2017-07-26 15:01:26', '2017-07-26 07:01:26');

-- --------------------------------------------------------

--
-- テーブルの構造 `request_categories`
--

CREATE TABLE `request_categories` (
  `request_category_id` int(11) NOT NULL,
  `request_category` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- テーブルのデータのダンプ `request_categories`
--

INSERT INTO `request_categories` (`request_category_id`, `request_category`) VALUES
(1, 'inquiry'),
(2, 'navigation'),
(3, 'accompany');

-- --------------------------------------------------------

--
-- テーブルの構造 `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `reviews`
--

INSERT INTO `reviews` (`review_id`, `event_id`, `user_id`, `rating`, `comment`, `created`, `modified`) VALUES
(1, 1, 3, 3, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2017-07-15 00:00:00', '2017-07-14 05:00:37'),
(2, 14, 2, 4, 'どりゃああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああどりゃああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああどりゃああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああどりゃああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああどりゃああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ', '2017-07-25 00:00:00', '2017-07-24 16:00:00'),
(3, 14, 3, 5, 'せろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろせろろろろ', '2017-07-26 00:00:00', '2017-07-25 16:00:00'),
(4, 14, 4, 1, 'じょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょじょ', '2017-07-27 00:00:00', '2017-07-26 16:00:00'),
(5, 16, 3, 4, 'よかった', '2017-07-26 15:03:34', '2017-07-26 07:03:34');

-- --------------------------------------------------------

--
-- テーブルの構造 `review_photos`
--

CREATE TABLE `review_photos` (
  `review_pic_id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `review_pic_path` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `TABLE 19`
--

CREATE TABLE `TABLE 19` (
  `COL 1` int(2) DEFAULT NULL,
  `COL 2` varchar(34) DEFAULT NULL,
  `COL 3` varchar(45) DEFAULT NULL,
  `COL 4` varchar(10) DEFAULT NULL,
  `COL 5` varchar(10) DEFAULT NULL,
  `COL 6` varchar(9) DEFAULT NULL,
  `COL 7` varchar(48) DEFAULT NULL,
  `COL 8` varchar(108) DEFAULT NULL,
  `COL 9` varchar(294) DEFAULT NULL,
  `COL 10` varchar(21) DEFAULT NULL,
  `COL 11` varchar(165) DEFAULT NULL,
  `COL 12` varchar(618) DEFAULT NULL,
  `COL 13` varchar(10) DEFAULT NULL,
  `COL 14` varchar(457) DEFAULT NULL,
  `COL 15` varchar(1111) DEFAULT NULL,
  `COL 16` varchar(1709) DEFAULT NULL,
  `COL 17` varchar(10) DEFAULT NULL,
  `COL 18` varchar(10) DEFAULT NULL,
  `COL 19` varchar(10) DEFAULT NULL,
  `COL 20` varchar(10) DEFAULT NULL,
  `COL 21` varchar(13) DEFAULT NULL,
  `COL 22` varchar(15) DEFAULT NULL,
  `COL 23` varchar(23) DEFAULT NULL,
  `COL 24` varchar(52) DEFAULT NULL,
  `COL 25` varchar(54) DEFAULT NULL,
  `COL 26` varchar(15) DEFAULT NULL,
  `COL 27` varchar(15) DEFAULT NULL,
  `COL 28` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `TABLE 19`
--

INSERT INTO `TABLE 19` (`COL 1`, `COL 2`, `COL 3`, `COL 4`, `COL 5`, `COL 6`, `COL 7`, `COL 8`, `COL 9`, `COL 10`, `COL 11`, `COL 12`, `COL 13`, `COL 14`, `COL 15`, `COL 16`, `COL 17`, `COL 18`, `COL 19`, `COL 20`, `COL 21`, `COL 22`, `COL 23`, `COL 24`, `COL 25`, `COL 26`, `COL 27`, `COL 28`) VALUES
(1, '1', 'Setoyasiki Hinamaturi', '2018/2/18', '2018/3/5', 'Kanagawa', '258-0028', 'Ashigami-gun Kanari Machi Kanai 1336', '35.342912', '139.115025', 'Kanai Prefecture Ashigami-gun Kanari Machi Kanai 1336', '15 minutes on foot from JR Matsuda station', '', '', '', 'The hinamatsuri held in the 300-year old private house \"Seto residence\" is filled with the atmosphere of the Edo period.\nThree hundred years ago \"Kyoho Chin\" discovered from the local warehouse and a number of set doll collection dolls, \"Tsurushi chicks\" handmade by the Women\'s Association more than 7,000 pieces and \"Large Tsurushina\" with a height of 2.4 m On display', '', '', '', '', '', 'about 100', 'about 100', 'about 100', 'http://www.kaisei-hinamatsuri.com/index.html', '', '2017/6/21 22:17', '2017/6/22 22:17'),
(2, '2', 'YOKOHAMA Beach Sports Festa', '2018/7/29', '2018/7/30', 'Kanagawa', '236-0013', 'Yokohama Sea Park ', '35.333317', '139.634385', 'Yubinbango236-0013 Kanazawa-ku, Yokohama Sea Park # 10', 'Kanazawa Seaside Line \"Sea Park south exit\" station, immediately from the \"Sea Park Shiba opening\" station or \"Hakkeijima\" station', '', '', '', 'A beach sports festa that started in 1989 and became a summer tradition of Yokohama will be held this year.\n\n\"Yokohama beach sports festa 2017supported by Nippatsu\" has become a rich content than ever.\n\nBesides pre-entry type beach sports competition (beach volleyball, beach volleyball, beach hand, beach tennis, beach football), beach clean · beach flags experience · experience of SUP (stand up paddle board) · beach tag rugby, beach yoga etc. Free Participation events will also be held.', '', '', '', '', '', 'about 200', 'about 200', 'about 200', 'https://www.hamaspo.com', '', '2017/6/22 22:17', '2017/6/23 22:17'),
(3, '3', 'NARITASAN KOUYOUMATURI', '2018/11/12', '2018/11/28', 'Tiba', '', 'Chiba prefecture Narita-shi, Narita 1', '35.78522', '140.317494', 'Chiba prefecture Narita-shi, Narita 1', 'About 15 minutes on foot from JR Narita station and Keisei main line Narita station', '', '', '', 'Naritasan Shinshoji Temple The Naritasan Park spreading on the hillside behind the main hall is a large park with 165,000 square meters. And in autumn this autumn can enjoy the autumn leaves of about 250 trees of maple, ginkgo, oak, oak, oak, maple.\n\nAlso during the autumn leaves festival, many people are visiting because various events are held.', '', '', '', '', '', 'about 20,000', 'about 20,000', 'about 20,000', '', '', '2017/6/23 22:17', '2017/6/24 22:17'),
(4, '4', 'Tokamachi Snow Festival', '2018/2/17', '2018/2/17', 'Nigata', '948-0079', '251 Asahi-cho, Tokamachi-shi Niigata Prefecture 17', '37.135188', '138.7563', '251 Asahi-cho, Tokamachi-shi Niigata Prefecture 17\nTokamachi-shi', 'Tokamachi is located 250km from Tokyo', '', '', '', 'The Tokamachi Snow Festival was first held about 67 years ago on the 4th February, 1950.\nTokamachi is located in the heart of one of Japan’s heaviest snowfall regions. Every winter, heavy snowfall can cause great adversity and disruption to the lives of the local residents. This Snow Festival was born from the idea that we should “befriend and enjoy the snow??_ a spontaneous feeling shared among many of Tokamachi\'s residents at the time. As such, the Tokamachi Snow Festival was an expression of their determination to overcome the hardships brought about by heavy snowfall, recognising fully ??_both the difficulties and beauty of the winter season. Likewise, amid the economic and social conditions of the time, it was an event that sought to bring energy to Tokamachi’s textile industry following the lift on the war-time ban of the use of silks in textile production.', '', '', '', '', '', 'about 10,000', 'about 10,000', 'about 10,000', 'http://snowfes.jp/', '', '2017/6/24 22:17', '2017/6/25 22:17'),
(5, '5', 'Nakamami Sun Festival', '2017/8/27', '2017/8/27', 'Ibaraki', '311-0192', 'Tokamachi-shi', '36.466079', '140.439053', 'Naka city Tosaki 428-2', 'About 10 minutes from Jobai Expressway Naka IC', '', '', '', '\"Naka-sunflower festival\" is a typical festival of Naka city, alongside the \"Yaezakura Festival\" held at Shimonomori Furusato Park. \nThe highlight of this event, based on the flower \"Himawari\" in Naka City, is a sunflower field. \n250 thousand sunflowers bloom in the field of about 4 ha, you will be surprised by the scenery of one side of the flowers seen from the observatory. \nIn addition, at the event site, we have held stage events, stalls, fireworks festivals and so many other visitors. \nPlease come to \"Nakamatomi Festival\" by all means. ', '', '', '', '', '', 'about2,000', 'about2,000', 'about2,000', '', '', '2017/6/25 22:17', '2017/6/26 22:17'),
(6, '6', 'Okazaki SAKURA Maturi', '2018/4/1', '2018/4/13', 'Aiti', '444-0052', 'Aichi Prefecture Okazaki-shi Yasuicho 561', '34.957728', '137.159392', 'Okazaki-shi Yasuicho 561 Okazakikouen', '15 minutes walk from Higashi Okazaki station', '', '', '', 'About 800 Yoshino cherry blossoms blooming in Okazaki Park, which is one of 100 cherry blossom squares in Japan, and Ogawa and Iga rivers around it. At the time of full bloom the cherry blossoms on one side will bloom and still compete. A cherry tree blizzard full of sight is a word of a masterpiece. The contrast which feels the sum with Okazaki castle is also an amazing thing!', '', '', '', '', '', 'about 5,000', 'about 5,000', 'about 5,000', 'https://okazaki-kanko.jp/feature/sakuramaturi/top', '', '2017/6/26 22:17', '2017/6/27 22:17'),
(7, '7', 'Fukaya Negi Maturi', '2018/1/29', '2018/1/29', 'Saitama', '366-0824', 'Saitama prefecture Fukaya city Nishijima 5 - Saitama prefecture Fukaya city Nishijima 5 - chome 6-1', '36.190553', '139.279667', 'Nishijima 5 - chome 6-1', '1 minute on foot from Fukaya station south exit of JR Takasaki Line', '', '', '', 'In recent years, the name has been reputed by the popularity of the city\'s image character \"Fuka-chan\", but it was \"Fukaya no Ogi\" spreading this land nationwide as a symbol of Fukaya long before that.\nWe share the gratitude for \"food\" through that \"Fukaya no Onagi\", and further widely appeal the charm of \"Fukaya neiguchi\" further by various expression methods! The festival that the general citizen gathered under the concept of \"Fukaya Negi Festival\" is.', '', '', '', '', '', 'about 500', 'about 500', 'about 500', 'https://negimatsuri.com/', '', '2017/6/27 22:17', '2017/6/28 22:17'),
(8, '1', 'SAKE MATURI', '2017/10/7', '2017/10/8', 'Hiroshima', '739-0011', 'Hiroshima prefecture Higashi Hiroshima-shi Nishijimoto-cho 12-3', '34.426363', '132.743265', 'Hiroshima prefecture Higashi Hiroshima-shi Nishijimoto-cho 12-3', '\nAround JR Saijo station', '', '', '', '\"Sake Festival\" is a festival of symbols \"sake\" worthy of Hoshihiroshima is the symbol of fuselage.Both adults and children, as well as those who do not drink alcohol, continue to be a festival of Higashihiroshima City, which carries the name of a drinking city that all the people gathering and gathering with the rim will enjoy.', '', '', '', '', '', 'about 2,000', 'about 2,000', 'about 2,000', 'https://sakematsuri.com/', '', '2017/6/28 22:17', '2017/6/29 22:17'),
(9, '2', 'Niu Shrine and the Laughter Festival', '2017/10/8', '2017/10/8', 'Wakayama', '', '丹生神社', '33.88866', '135.225011', '1956 Ekawa, Hidakagawa-cho, Hidaka-gun', 'From “Wasa Sta.??_of JR Kinokuni Line, 10min. by taxi.', '', '', '', 'The current Niu Shrine was established in 1909 as part of the Meiji Restoration initiative to unite the many Shinto shrines of each village and town into a single main shrine. Several shrines in Niu village were united into Niu Shrine, however, the town still preserved all of their old festivals including the famous ‘Laughter Festival??_The festival is held in early October on the Sunday following the National Athletic holiday (a holiday commemorating the opening of Tokyo Olympic Games in 1964). The festival itself is registered as Prefectural Cultural Heritage asset and is called the ‘Laughter Festival??_because a festival leader called ‘Suzu Furi??_or ‘Bell Jingler??_dresses up in a humorous clown-like costume and leads the attendees in synchronized bouts of laughter with each bell jingle.\n', '', '', '', '', '', 'about 3,000', 'about 3,000', 'about 3,000', 'http://kanko.hidakagawa.jp/eng/history/niu-shrine.html', '', '2017/6/29 22:17', '2017/6/30 22:17'),
(10, '3', 'KAMAKURA GION OMACHI MATSURI', '2018/7/8', '2018/7/10', 'Kanagawa', '', 'Yakumo Shrine (Omachi) (Yakumo Shinko · Okachi)', '35.31509', '139.554642', 'Kamakura City Omachi 1-11-22', '10 minutes on foot from Kamakura Station', '', '', '', 'The Kamakura Gion Omachi Matsuri commemorates and gives thanks for the founding of the Yakumo Shrine, a Shinto shrine, within the Omachi neighborhood of Kamakura. This grand festival is held annually on the second Saturday of July and continues for three days, during which time four mikoshi or portable representations of the shrine are carried through the local streets. The festival is said to have begun in 1349.\n2017\nKAMAKURA GION OMACHI MATSURI', '', '', '', '', '', 'about 3,000', 'about 3,000', 'about 3,000', 'http://www.kamakura-omachi.jp/gallery_2017.html', '', '2017/6/30 22:17', '2017/7/1 22:17'),
(11, '4', 'Sendai・Aoba Festival', '2018/5/20', '2018/5/21', 'Miyagi', '980-0012 ', 'Sendai', '38.270364', '140.7968598', 'Sendai City', 'Sendai City central area', '', '', '', 'It is a festival loved by many people as one of the three biggest festivals in Sendai.', '', '', '', '', '', '', '', '960000', 'http://www.aoba-matsuri.com/', '', '2017/7/1 22:17', '2017/7/2 22:17'),
(12, '5', 'The Yamagata Hanagasa Festival', '2018/8/5', '2018/8/7', 'Yamagata', '990-8540', 'Yamagata City', '38.2480308', '140.2149369', 'Yamagata City', 'Yamagata City central area', '', '', '', 'The Yamagata Hanagasa Festival is highlighted by the booming cries of \"Yassho, Makasho\" accompanied by the gallant sound of the Hanagasa Taiko drums and gorgeously decorated floats leading more than 10,000 dancers adorned in beautiful costume with Hanagasa flower hats through the main street of Yamagata city.\nIn recent years, the \'Yamagata Hanagasa Festival\' has been added to the big three festivals of Tohoku, as a fourth member representing the major festivals in Tohoku.\nIt is said that more than one million people flock to the city during the term of the festival.', '', '', '', '', '', '', '', '', 'http://www.hanagasa.jp/', '', '2017/7/2 22:17', '2017/7/3 22:17'),
(13, '6', 'Kawagoe Festival', '2017/10/14', '2017/10/14', 'Saitama', '350-8601', 'Kawagoe City', '35.9070915', '139.4804254', 'Kawagoe City', 'Get off at Kawagoe station', '', '', '', 'The Kawagoe Festival\'s strongest feature is the festival float event which reproduces the ’Edo Tenka Matsuri??_festival. Spectacular festival floats carrying exquisitely crafted dolls are pulled around the center of Koedo-Kawagoe’s landmark Kurazukuri (traditional architecture) Zone. Spectators will be overwhelmed by the sheer scale of the many festival floats as they pass by each other when meeting at an intersection.', '', '', '', '', '', '1000000', '1000000', '1000000', 'http://www.kawagoematsuri.jp/English/about.html', '', '2017/7/3 22:17', '2017/7/4 22:17'),
(14, '7', 'The Sapporo Snow Festival', '2018/2/5', '2018/2/12', 'Hokkaido', '060-8611', '4 Chome Ōdōrinishi\r\nChū?_ Sapporo City, Hokkaid?_,43.0595541,141.3004599,Sapporo City,From New Chitose Airpo', ' you can take a JR train or a bus to Sapporo. Rental cars are also available at the airport. There is a special information counter for foreign travelers next to the JR ticket counter (midori-no-madoguchi) in the basement floor of the airport. The information staff provides services in English', ' Chinese and Korean.\"', '', '', '', 'The Sapporo Snow Festival, one of Japan\'s largest winter events, attracts a growing number of visitors from Japan and abroad every year. Every winter, about two million people come to Sapporo to see a large number of splendid snow and ice sculptures lining Odori Park, the grounds at Community Dome Tsudome, and along the main street in Susukino. During the festival in February, Sapporo is turned into a winter dreamland of crystal-like ice and white snow.', '', '', '', '', '', '', '', '', 'http://www.snowfes.com/', '', '2017/7/4 22:17', '2017/7/5 22:17', '', ''),
(15, '1', 'The Sunflower field', '2017/8/10', '2017/8/15', 'Kanagawa', '', '3 Chome-42-46 Sōbudai\r\nZama-shi, Kanagawa-ken 252-0011', '35.4991676', '139.4072978', 'Zama City', '· From Odakyu Odawara line \"Aibutai-mae Station\" Bus ??_Minami-Ryoga Station Line (via Liberghiga) \"Get off at Zama High School\" immediately\r\n· About 30 minutes on foot from \"Odakyu Odawara line\" Aiba-daie station\r\n· Get off at Odakyu Line Aibutai-mae Station Get off at Hibarugaoka via Nambaigaoka bus ??_Get off at \"Zama High School front\" immediately\r\n· Odakyu Enoshima Line From \"Namborin Station\" Bus ??_Aibaidaie Station Line (via Hibarigaoka) Get off at \"Zama High School\" immediately\r\n· From Sogetsu Line \"Sagamino Station\" Bus ??_Get to Aiba-dorie Station Get off at \"Kita-dori\" before walking about 5 minutes', '', '', '', 'In the Zama Sunflower Festival, a total of about 550,000 sunflowers are blooming in the Zama venue and the Kurihara venue.', '', '', '', '', '', '', '', '', 'http://momos-navi.net/1498.html', '', '2017/7/5 22:17', '2017/7/6 22:17'),
(16, '2', 'Hirosaki Cherry Blossom Festival', '2017/4/22', '2017/5/7', 'Aomori', '036-8551', '1-1 Kamishirogane-machi, Hirosaki-shi, Aomori-ken 036-8551', '40.603111', '140.463833', 'Hirosaki Park', 'Limited Express Tsugaru approx. 30mins from Aomori to Hirosaki', '', '', '', 'Hirosaki Cherry Blossom Festival is usually held from 4/23 to 5/5. \r\nDue to the 100th year of the festival, the festival period will be extended.', '', '', '', '', '', '', '', '', 'http://www.hirosakipark.jp/sakura/', '', '2017/7/6 22:17', '2017/7/7 22:17'),
(17, '3', 'Japanese best Imoni Festival', '2017/9/17', '2017/9/17', 'Yamagata', '990-0041', '4-14-57 Midori-Machi Yamagata City, Yamagata', '38.253258', '140.352766', 'Mamigasaki River', 'Bus:Yamagata Station Get off at Numazono Line - Get off at Yamagata Fire Station', '', '', '', 'imoni is cooked in a 6-meter-wide (20 ft) pot that needs special cranes to help stir it. Inside the pot, 3 tons of taro, 1.2 tons of beef and thousands of onions are simmered in a soup that requires 6 tons of water and 700 liters (185 gal) of soy sauce and other seasonings—enough to serve 30,000 visitors!', '', '', '', '', '', '', '', '', 'http://www.y-yeg.jp/imoni/', '', '2017/7/7 22:17', '2017/7/8 22:17'),
(18, '4', 'KURASANKAN', '2017/3/4', '2017/3/5', 'Yamagata', '999-3702', '3 Chome-17-7 Onsenmachi\nHigashine City', '38.4690744', '140.3863274', '3 Chome-17-7 Onsenmachi\nHigashine City', '5 minutes by car from JR Murayama station · 15 minutes on foot 15 minutes by car from Yamagata Airport', '', '', '', 'Opening only once a year.\r\n\"Kurasankan\" will be held which you want to listen to the collection of Rokko and the delicious seasonal drink and listen to it.\r\nIt is packed with variegated events unique to sake brew, as well as exploration.', '', '', '', '', '', '', '', '', 'http://www.yamagata-rokkasen.co.jp/', '', '2017/7/8 22:17', '2017/7/9 22:17'),
(19, '5', 'Hukuotokoerabi', '2017/1/10', '2017/1/10', 'Hyogo ', '662-0974', '1-17 Shakecho Nishinomiya', '34.7357318', '135.3323892', 'Nishinomiya Shrine', 'From Bus Northern Terminal to Hanshin Bus or Hankyu Bus \"Hanshin Nishinomiya\"\nFrom Bus South Terminal, Take the Hanshin Bus \"Hanshin Nishinomiya\"\nGet off at \"Hanshin Nishinomiya\" and walk south-west to Ebetsu line', '', '', '', 'Ebisu-sama is the Japanese deity that brings good fortune. Revered for ages by fisherman and merchants, shrines worshipping this god can be found all throughout Japan. The main shrine out of all of them is the Nishinomiya Shrine that holds the Toka Ebisu Festival. The festival, held over three days during what is said to be the period that the energy of Ebisu-sama is at its highest, attracts roughly 1,000,000 visitors from all over the country in search of good luck, in particular, in fishing, business sales and safety in the household to name a few. With out a doubt, the highlight of the festival is the Kaimon Shinji Fukuotoko Erabi, or \"Choosing of the Lucky Man Gate Opening Ritual,\" held at the main hall on the 10th. As the gates open at 6:00am, the eager visitors who gathered to be the first to receive the deity\'s good fortune sprint the 230 meters to the main hall. The first three to reach the finish line are crowned \"Fukuotoko\", or \"Lucky Man\", and are deemed the owners of immense fortune for that year which they will share with others around them. Because of this, there is an incomparable amount of passion during this early morning dash. If you are planning to visit this shrine, be sure to take part in this ritual and get a hands-on feel of it yourself.', '', '', '', '', '', '', '', '', 'http://nishinomiya-ebisu.com/index.html', '', '2017/7/9 22:17', '2017/7/10 22:17'),
(20, '6', 'Aizudajima Gion Festival', '2017/7/22', '2017/7/24', 'Fukushima', '967-0004', 'Minami-Aizu', '37.1955163', '139.7714403', 'Aizu Dajima ', 'About 56 Km from Nishinasuno I. C via National Highway Route  400\r\nApproximately 50 km from Aizuwakamatsu I. C via Route 121', '', '', '', 'Aizutajima Gion Festival, the Kamakura period of Bunji year (1185 BC), the Gion faith at the time of the lords Somasashi Naganuma, of Gion in the land God Festival (the Gozu Emperor Susa Noriyuki Otokoinochi) as God of residence Chingo, the Gion Festival defines a control, it was done with the festival of the field and out UGA shrine of Tajima village shrine of than the old has to be the origin. The festival than the old \"west of Gion, Inc., Tsushima, Inc. in the east of the field and out UGA company\" has been told it is said that is referred to as one of Japan\'s three major Gion Festival.', '', '', '', '', '', '', '', '', 'http://www.minamiaizu.org/gion/', '', '2017/7/10 22:17', '2017/7/11 22:17'),
(7, 'Obasama no Ennen', '2018/4/1', '2018/4/1', 'Miyagi', '989-5181', '\nMMiyagi, Kurihara,Kinsei Kamimo mountain god 77', '38.8141834', '141.0630642', 'Hakusan Jinja,', 'Approx. 15 min. by car from Kurikomakogen station on the Tohoku Shinkansen line.\n', '', '', '', 'Conjunction with the Gion Festival Date of Polygonum UGA shrine from 1879, it has been determined that carried out in accordance with the Kumano Shrine festival, which enshrines the adjacent land to the rating example of the Gion Festival.', '', '', '', '', '', '', '', '', 'http://www.kuriharacity.jp/index.cfm/12,5401,80,html', '', '2017/7/11 22:17', '2017/7/12 22:17', ''),
(22, '1', 'Matsumae Jinja Reitaisai', '2017/8/4', '2017/8/5', 'Hokkaido', '049-1511', 'Hokkaid?_ Sapporo-shi, Matsumae-gun,Mathumae-cho', '41.4303436', '41.4303436', 'Matsushiro-aza', 'Approx. 10 min. walk from Yamamoto Jichi Shinko Center Mae bus stop on the Shinnan Koutsu Komaba Route.Get off at JR Kikonai station. Take a Hakodate Bus approx. 1 hr. 30 mins. to Matsushiro. Approx. 10 min. walk.\n', '', '', '', 'From using a lot of wiping the catering menu of the festival, it has been commonly also referred to as \"Fukisai = wipe Festival\". The \"Doburoku Festival\" from the use of Nigorizake to sacred sake, is also known as the \"fight festival\" because it stalls service is fierce.', '', '', '', '', '', '', '', '', '', '', '2017/7/14 22:17', '2017/7/15 22:17'),
(23, '2', 'Nanakuri Jinja Hadaka Matsuri', '2017/10/12', '2017/10/12', 'Nagano', '395-0244', 'Naganoken,iidashi,yamamoto', '35.4754873', '137.7554838', 'Nanakuri Jinja', 'Approx. 10 min. walk from Yamamoto Jichi Shinko Center Mae bus stop on the Shinnan Koutsu Komaba Route.', '', '', '', 'Nanakuri Jinja Hadaka Matsuri is the autumn matsuri of Nanakuri Shrine in Iida City. It is said to have started in the Nanbokucho period. It has continued for around 700 years as a harvest festival in which people pray and give thanks for bumper crops and good health. Youths selected from each of the seven settlements in the Yamamoto district tie shimenawa ropes around their waists, and swing barrels wrapped with shimenawa ropes above their heads. They dance under a shower of sparks, which fall like rain.', '', '', '', '', '', '', '', '', '', '', '2017/7/14 22:17', '2017/7/15 22:17'),
(24, '3', 'Ashinoshiri Dosojin Matsuri', '2018/1/7', '2018/1/7', 'Nagano', '381-2702', 'Ookahei, Nagano, Nagano Prefecture', '36.4866592', '137.9776795', 'Ashinoshiri Village', 'From JR Shinonoi station, take the Ooka Shinonoi route bus from Shinonoi-eki bus stop, get off at Ooka shisho-mae bus stop (approx. 1 hr). Approx. 40 min. walk, or 10 min. taxi ride from the bus stop', '', '', '', 'In the Ashinoshiri Dosojin Matsuri, a stone monument 1.5 meters in height is decorated with sacred rope to create a mysterious, god-like face. This stone statue becomes the guardian deity of the village for the year. It is derived from the tradition of creating the face of a deity with straw from the villagers??_New Year pine decorations, to pray for good health. It is also called Shinmen Soshoku Dosojin Matsuri. The statue of the deity\'s face famously appeared in the opening ceremony of the Nagano Winter Olympics.', '', '', '', '', '', '', '', '', 'http://www.janis.or.jp/users/dosozin/', '', '2017/7/12 22:17', '2017/7/13 22:17'),
(25, '4', 'Shoju Raiko Nerikuyoeshiki', '2017/10/8', '2017/10/8', 'Nara', '639-0276', 'Nara-ken, Katsuragi-shi, Taima,1263', '34.5160956', '135.6924488', 'Taima dera', 'From Shin-Osaka, go to Tennoji station on the JR line / Underground, then walk to Osaka-Abenobashi station on Kintetsu line, then go to Taimadera station (approx. 35 min.), then walk 15 min.\n', '', '', '', 'The high priest Eshin Sozu began Shoju Raiko Nerikuyoeshiki in 1005, to mark the anniversary of the death of Chujo Hime who died at the age of 29. She was the Nara period princess known for embroidering a mandala of the Pure Land of Amitabha Buddha in one night, using lotus thread. The ceremony consists of the preaching of Buddhist teachings at the temple, and a memorial service for the deceased. A procession is held, in which participants are disguised as the Bodhisattvas coming to welcome the spirit of the dead. Nerikuyo ceremonies in Japan are said to have started here. When the sun starts to set over Mt. Nijo, the parade of Kannon and other deities accompanied by 25 Bodhisattvas is a magnificent sight, and people pray for peace in their lives.', '', '', '', '', '', '', '', '', '', '', '2017/7/15 22:17', '2017/7/16 22:17'),
(26, '5', 'Kawazu Cherry Blossom Festival', '2018/2/10', '2018/3/10', 'Shizuoka', '413-0512', 'Kawazu Tourist Association, 72-12, sasahara, kawazu-cho, kamo-gun, Shizuoka', '34.7507109', '138.9897319', 'Kawazu Sakura Matsuri in Kawazu Town', 'about 4 hours from tokyo by car', '', '', '', 'Here, I share with you my insider tips on the best things to do and explore. My all time favorite part of any hanami expedition is viewing sakura as long as I get tired, and Kawazu Cherry Blossom Festival has it in abundance as you really have to walk to experience millions of sakura blossoms. With the festival on, there are so many things you could explore here such as you can taste local dishes, buy unique souvenirs, stroll around the whole town, stage performance, and have a relax time at local onsen including footbath. Staying a night will not be a bad idea. In fact, I stayed a night at one of the local onsen in Kawazu. The service was excellent!', '', '', '', '', '', '', '', '', 'http://kawazu-onsen.com/sakura/index.html', '', '2017/7/16 22:17', '2017/7/17 22:17'),
(27, '6', 'dessert tour in Wakura-Onsen 2017', '2017/4/1', '2018/3/31', 'Ishikawa', '926-0175', ' Ishikawa-ken, Nanao-sh,Wakuramachi,wa5-1', '37.0882791', '136.9144146', 'Wakura Onsen', 'about 6 hours from tokyo by car', '', '', '', 'you can eat some sweet foods here', '', '', '', '', '', '', '', '', 'http://www.wakura.or.jp/sightseeing/event/item285/', '', '2017/7/17 22:17', '2017/7/18 22:17'),
(28, '7', 'Kyushu Beer Festival 2017 in Kurume', '2017/8/8', '2017/8/13', 'Fukuoka', '\n830-0031', '\n8-1 Rokkunmachi Kurume-shi, Fukuoka ', '33.313936', '130.513155', 'Kurume city plaza', 'about 3 hours from haneda airport by car', '', '', '', 'Kyushu\'s largest craft-beer festival is making its second appearance in Kurume this year, featuring craft beers from all over Japan as well as food booths from local Kurume restaurants.', '', '', '', '', '', '', '', '', 'http://www.kyushubeerfestival.com/', '', '2017/7/18 22:17', '2017/7/19 22:17'),
(29, '1', 'Kokusekiji Sominsai', '2018/2/3', '2018/2/3', 'Iwate', '023-0101', '\nIwate,Oshu,Mizusawa Ward Kuroishi Town Yamauchi 17', '39.084301', '141.2043822', 'Mizusawaku Kuroishicho', 'about 6hours from tokyo by car', '', '', '', 'All these men fighting with all their hearts in the bitter cold to become blessed makes it closer to a sport than a festival. Actually, this festival is open to anyone who applies, but there are rules like you can\'t eat meat, fish, eggs, or garlic for a week before the festival, so it\'s actually pretty difficult...', '', '', '', '', '', '', '', '', '', '', '2017/7/19 22:17', '2017/7/20 22:17'),
(30, '2', 'Sapporo Matsuri', '2018/6/14', '2018/6/16', 'Hokkaido', '064-0946', 'Hokkaid?_ Sapporo-shi, Chū?_ku, Futagoyama, 4 Chome??_??_??_3\n', '43.049104', '141.325607', 'Hokkaido Jingu', 'Get off at JR Sapporo station, take the Namboku subway line to Odori station, then the Tozai subway line to Maruyama Koen station. Approx. 15 min. walk.Approx. 15 min. by taxi from JR Sapporo station.', '', '', '', '', '', '', '', '', '', '', '', '', 'http://www.hokkaidojingu.or.jp/', '', '2017/7/11 22:17', '2017/7/12 22:17'),
(3, 'Takayama Festival(Spring Festival)', '2018/4/14', '2018/4/15', 'Gifu', '506-0822', '156 Shiroyama, Takayama-shi', '36.133214', '137.261459', 'Hie Shrine', 'Train: Takayama Station on JR Takayama Main Line. 25 minutes??_walk from the station.\nCar: Takashiyama-Nishi IC on Chubu- Jukan Expressway. Free parking is available', '', '', '', 'The Takayama Festival (高山祭, Takayama Matsuri) is ranked as one of Japan\'s three most beautiful festivals alongside Kyoto\'s Gion Matsuri and the Chichibu Yomatsuri. It is held twice a year in spring and autumn in the old town of Takayama and attracts large numbers of spectators.\nThe Spring Festival (April 14-15) is the annual festival of the Hie Shrine in the southern half of Takayama\'s old town. Since the shrine is also known as Sanno-sama, the spring festival is also called Sanno Festival.\n\nLikewise, the Autumn Festival (October 9-10) is the annual festival of the Hachiman Shrine in the northern half of the old town, and the festival is also known as Hachiman Festival.\n\nThe spring and autumn festivals have similar attractions and schedules. Each festival features its own set of about a dozen festival floats (yatai). During the year, the tall and heavily decorated floats are stored in storehouses, which are scattered across Takayama\'s old town (except the floats exhibited in the Yatai Kaikan). A set of replica floats are, furthermore, exhibited year round at the Matsuri no Mori festival museum.', '', '', '', '', '', 'about 210,000', 'about 210,000', 'about 210,000', 'http://kankou.city.takayama.lg.jp/2000002/2000024/', '', '2017/7/30 22:17', '2017/7/30 22:17', ''),
(32, '4', 'Hakata Gion Yamakasa', '2017/7/1', '2017/7/15', 'Fukuoka', '812-0026', '1-41, Kamikawabata-machi, Hakata-ku, Fukuoka', '33.592996', '130.41049', 'around Kushida Shrine', 'The festival takes place in the Hakata district of Fukuoka. Kushida Shrine is located a five minute walk from Canal City Hakata or Gion Subway Station, or a 15-20 minute walk from Hakata Station.', '', '', '', 'Hakata Gion Yamakasa (博多祇園山笠) is a Japanese festival celebrated from the 1st until the 15th of July in Hakata, Fukuoka. The festivities are centered on the Kushida Jinja. The festival is famous for the Kakiyama, that weigh around one ton and are carried around the city as an act of float-racing. The festival is believed to be over 770 years old and attracts up to a million spectators each year. It was designated an Important Intangible Folk Cultural Property of Japan in 1979. The sound of the Yamakasa has also been selected by the Ministry of the Environment as one of the 100 Soundscapes of Japan.', '', '', '', '', '', 'about 700,000', 'about 700,000', 'about 700,000', 'http://www.hakatayamakasa.com/', '', '2017/7/22 22:17', '2017/7/23 22:17'),
(33, '5', 'Fuji-kawaguchiko Autumn Colors Festival', '2017/11/1', '2017/11/30', 'Yamanashi', '', 'Lake Kawaguchiko (north side)', '35.517095', '138.751779', 'Lake Kawaguchiko (north side)', 'Car: 20 minutes from the Chuo Expressway-Kawaguchiko IC. (Free parking.)\nBus: 20 minutes Retro Bus from Kawaguchiko Station. Get off at Kubota Itchiku Bijutsukan-mae.', '', '', '', 'Enjoy the beauty of Japan\'s autumn through the Japanese tradition of viewing koyo, or autumn colors. With Lake Kawaguchiko and Mt. Fuji as the backdrop, the Fuji-kawaguchiko Autumn Leaves Festival is the perfect place to view the autumn colors. The main event will be a light-up at night, with food stands, craft stands, a farmer\'s market, and much more! You can easily relax by eating, enjoying the great view, and walking around the lake with family, friends, and pets.', '', '', '', '', '', 'N/A', 'N/A', 'N/A', '', '', '2017/7/23 22:17', '2017/7/23 22:17'),
(34, '6', 'Kamakura Festival', '2017/12/29', '2018/1/3', 'Akita', '', 'Yokote-shi', '39.313782', '140.566649', 'Yokote Station to Yokote Castle', 'Via Omagari\n\nYokote and Omagari are connected by hourly local trains along the JR Ou Line (20 minutes, 320 yen). Omagari Station can be reached by the Akita Shinkansen from Tokyo (3.5 hours, about 17,000 yen) or from Sendai (2 hours, about 9,000 yen). The train rides are covered by the Japan Rail Pass, the JR East Tohoku Area Pass and the JR East South Hokkaido Pass.', '', '', '', 'The Yokote Kamakura Festival (横手?_雪祭??_ Yokote no Yuki Matsuri) has a history of about 450 years. It is held every year on February 15 and 16 in the city of Yokote in southeastern Akita Prefecture. The festival features many igloo-like snow houses, called kamakura, which are built at various locations.\nWithin each kamakura there is a snow altar dedicated to the water deity, to whom people pray for ample water. A charcoal brazier is set up to provide warmth and grill rice cakes. In the evenings (18:00 to 21:00), children invite festival visitors into their kamakura and offer them rice cakes and amazake, a type of warm sweet rice wine with zero or very low alcohol content. In return, the visitors make an offering to the water deity at the altar.\nThe festival area extends east of Yokote Station to Yokote Castle, which is located about two kilometers away across Yokote River. Starting from the station, visitors can enjoy a leisurely stroll along the streets of the town and appreciate scenes of kamakura built beside houses in the neighborhood. It is also possible to take part in kamakura making at one of the hands-on sessions at Komyoji Park.\n\nThe Kamakurakan Hall preserves a couple of kamakura all year round in a small -10 degree Celsius room, making it possible for visitors to see these snow houses even during warmer months. In the area close to the hall, many kamakura, snow sculptures and festival food stalls can be found, contributing to a lively atmosphere.', '', '', '', '', '', 'about 50,000', 'about 50,000', 'about 50,000', '', '', '2017/7/24 22:17', '2017/7/24 22:17'),
(35, '7', 'Bunkyo Ume Matsuri (Plum Festival)', '2017/2/17', '2017/3/13', 'Tokyo', '113-0034', '3-30-1 Yushima, Bunkyo-ku', '35.707818', '139.768219', 'Yushima Shrine', 'Yushima Subway Station, Exit 3, Oeda and Chiyoda subway lines. 2 minutes walk.', '', '', '', 'Yushima Tenmangu Shrine (Yushima Tenjin) has been beloved since the Edo period as a famous place to view plum blossoms. The precincts, which enshrine Sugawara no Michizane (the deity of scholarship), are an amazing sight when the approximately 300 plum trees - mainly Shirokaga white plums - bloom. Lord Sugawara was exiled to Dazaifu in Kyushu. He wrote a famous poem that read, \"Let the east wind blow and send your fragrance / Oh, plum blossoms / Do not forget the spring / Even though your master is gone.\" The plums are at their best from mid- to late February each year, but it\'s a good idea to check the flower information before you go (see the below URL).', '', '', '', '', '', 'about 400,000', 'about 400,000', 'about 400,000', 'http://www.yushimatenjin.or.jp/pc/ume/', '', '2017/7/25 22:17', '2017/7/25 22:17'),
(36, '1', 'Ueno Sakura Matsuri (Cherry Blossom Festival)', '2017/3/18', '2017/4/9', 'Tokyo', '110-0007', 'Uenokoen, Taito', '35.718123', '139.777882', 'Ueno Park', 'Ueno Park is just next to JR Ueno Station. Easiest access is provided by the station\'s \"Park Exit\".', '', '', '', 'Lined endlessly with a number of cherry trees, Ueno Parks main street is probably the first place that many Japanese people would think of when it comes to a beautiful scene of cherry blossoms in spring. During the festival, 1000 lanterns, which were originally intended for nighttime security, illuminate the park and invite people to celebrate the arrival of spring under a night sky. Located in the precinct of Toeisan Kaneiji Temple where the Tokugawa Shogunate family is buried, the park expects several hundred thousand visitors daily to come for the blossom viewing during the season. Stroll through the park tinted in pale pink by 600 Somei-yoshino (Yoshino cherry) trees before you head to an antique market or other special events also held at the park.', '', '', '', '', '', 'about 2,000,000', 'about 2,000,000', 'about 2,000,000', 'http://www.yushimatenjin.or.jp/pc/ume/', '', '2017/7/26 22:17', '2017/7/26 22:17'),
(37, '2', 'Meguro Sanma Festival', '2018/9/2', '2018/9/2', 'Tokyo', '152-0000', 'Meguro-ku', '35.633472', '139.715586', 'aroud Meguro Station', 'From Meguro station on the Yamanote line:\n-- 12 minute direct ride to Shinjuku\n-- 5 minute direct ride to Shibuya\n-- 18 minute direct ride to Tokyo', '', '', '', '\nDoes the prospect of free fish get you excited? If the answer is yes, head down to Meguro Station on the JR Yamanote Line and the Mita and Namboku Subway Lines for the annual Meguro Sanma Festival from 10am on the first Sunday of September. About 6,000 grilled Sanma (pacific saury) will be given away to mark the beginning of the season. You’ll have to wait in perhaps the longest queue you have ever seen, but presumably it’s worth it! The fish will be sourced from the tsunami affected port of Miyako in Iwate Prefecture.', '', '', '', '', '', '', '', '', '', '', '2017/7/27 22:17', '2017/7/27 22:17'),
(38, '3', 'Takayama Festival(Fall Festival)', '2018/4/14', '2018/4/15', 'Gifu', '506-0822', '156 Shiroyama, Takayama-shi', '36.133214', '137.261459', 'Hie Shrine', 'Train: Takayama Station on JR Takayama Main Line. 25 minutes??_walk from the station.\nCar: Takashiyama-Nishi IC on Chubu- Jukan Expressway. Free parking is available. ', '', '', '', 'The Takayama Festival (高山祭, Takayama Matsuri) is ranked as one of Japan\'s three most beautiful festivals alongside Kyoto\'s Gion Matsuri and the Chichibu Yomatsuri. It is held twice a year in spring and autumn in the old town of Takayama and attracts large numbers of spectators.\nThe Spring Festival (April 14-15) is the annual festival of the Hie Shrine in the southern half of Takayama\'s old town. Since the shrine is also known as Sanno-sama, the spring festival is also called Sanno Festival.\n\nLikewise, the Autumn Festival (October 9-10) is the annual festival of the Hachiman Shrine in the northern half of the old town, and the festival is also known as Hachiman Festival.\n\nThe spring and autumn festivals have similar attractions and schedules. Each festival features its own set of about a dozen festival floats (yatai). During the year, the tall and heavily decorated floats are stored in storehouses, which are scattered across Takayama\'s old town (except the floats exhibited in the Yatai Kaikan). A set of replica floats are, furthermore, exhibited year round at the Matsuri no Mori festival museum.', '', '', '', '', '', 'about 210,000', 'about 210,000', 'about 210,000', 'http://kankou.city.takayama.lg.jp/2000002/2000024/', '', '2017/7/30 22:17', '2017/7/30 22:17'),
(39, '4', 'Tamaseseri', '2018/1/3', '2018/1/3', 'Fukuoka', '812-8655', '1-22-1, Hakozaki, Higashi-ku, Fukuoka', '33.614593', '130.423405', 'Hakozaki Shrine', '5 minutes walk from the subway Hakozaki Miyamae Station', '', '', '', 'Men wearing only loincloths compete for an 8-kg treasure ball (takara-no-tama) 30-cm in diameter which is believed to bring good fortune upon the person who can lift it over his head. The men are divided into the Land Team made up of farmers who mainly work on the land and the Sea Team consisting of fishermen who work at sea. Whether the New Year will bring a rich harvest or a large catch will be determined by which team wins the ball and hands it to the Shinto priest. This is one of the three main festivals of Kyushu. With a history of 500 years, its origins are said to lie in the legend of the dragon god (ryujin) offering two balls to Empress Jingu (170-269).\n\nOne o’clock in the afternoon. Two purified balls ??_a “yang??_(representing masculinity) ball and a “yin??_(representing femininity) ball ??_are carried to Tamatori Ebisu Shrine. The “yin??_ball is dedicated to this shrine. At first, children carry the “yang??_ball in the direction of Hakozaki Shrine. They then hand it to some men waiting halfway. These men start scrambling for the ball, and amid cries of “Oisa! Oisa!??_the atmosphere becomes one of feverish excitement. This excitement reaches its peak by the time the men pass under the torii gate. All the while, they are splashed relentlessly with cold water despite the winter cold, as are the spectators who get soaked from head to toe. Because it is believed that just touching the ball will bring good luck, the spectators also struggle to reach the ball, creating greater panic. The Shinto priest at the shrine is waiting at the romon tower gate. If the Land Team hands him the ball it means a year of rich harvest. But if the Sea Team is the winner, it will be a year with a', '', '', '', '', '', 'about 50,000', 'about 50,000', 'about 50,000', 'http://www.hakozakigu.or.jp/omatsuri/tamatorisai/', '', '2017/7/29 22:17', '2017/7/29 22:17'),
(40, '5', 'Omizutori', '2018/3/1', '2018/3/14', 'Nara', '630-8587', '1 Zōshi-ch?_ Nara,', '34.890969', '135.667758', 'Todai-ji', 'Omizutori is held at Nigatsudo, a ten minute walk uphill from Todaiji Temple\'s main building.', '', '', '', 'Todaiji (東大寺, Tōdaiji, \"Great Eastern Temple\") is one of Japan\'s most famous and historically significant temples and a landmark of Nara. The temple was constructed in 752 as the head temple of all provincial Buddhist temples of Japan and grew so powerful that the capital was moved from Nara to Nagaoka in 784 in order to lower the temple\'s influence on government affairs.\n\nTodaiji\'s main hall, the Daibutsuden (Big Buddha Hall) is the world\'s largest wooden building, despite the fact that the present reconstruction of 1692 is only two thirds of the original temple hall\'s size. The massive building houses one of Japan\'s largest bronze statues of Buddha (Daibutsu). The 15 meters tall, seated Buddha represents Vairocana and is flanked by two Bodhisattvas.\n\nSeveral smaller Buddhist statues and models of the former and current buildings are also on display in the Daibutsuden Hall. Another popular attraction is a pillar with a hole in its base that is the same size as the Daibutsu\'s nostril. It is said that those who can squeeze through this opening will be granted enlightenment in their next life.\n\nAlong the approach to Todaiji stands the Nandaimon Gate, a large wooden gate watched over by two fierce looking statues. Representing the Nio Guardian Kings, the statues are designated national treasures together with the gate itself. Temple visitors will also encounter some deer from the adjacent Nara Park, begging for shika senbei, special crackers for deer that are sold for around 150 yen.', '', '', '', '', '', 'about 30,000', 'about 30,000', 'about 30,000', '', '', '2017/7/29 22:17', '2017/7/29 22:17');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_flag` int(11) NOT NULL,
  `f_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `l_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `nickname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `nationality` varchar(255) CHARACTER SET utf8 NOT NULL,
  `gender` varchar(255) CHARACTER SET utf8 NOT NULL,
  `japanese_level` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `self_intro` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `pic_path` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`user_id`, `user_flag`, `f_name`, `l_name`, `nickname`, `email`, `nationality`, `gender`, `japanese_level`, `password`, `self_intro`, `pic_path`, `created`, `modified`) VALUES
(1, 0, '', '', 'manager', 'manager@gmail.com', 'Afganistan', 'male', NULL, '1a8565a9dc72048ba03b4156be3e569f22771f23', '管理者です。', '20170705130810japanival_icon.png', '2017-07-05 19:08:10', '2017-07-05 11:08:39'),
(2, 1, '', '', 'umetani', 'umetani@gmail.com', 'Albania', 'female', NULL, '56ca78f2319ab20ed3c881bb89f02d608111bb69', 'umetani', '20170705130941スクリーンショット 2017-07-03 18.41.01.png', '2017-07-05 19:09:41', '2017-07-05 11:09:41'),
(3, 1, '', '', 'uumetani', 'uumetani@gmail.com', 'Afganistan', 'male', NULL, '4a9318160a56a36c151476167f282968c8de6b74', 'ユーザーです', '../../event_pictures/20170719004953スクリーンショット 2017-07-14 4.28.55.png', '2017-07-05 20:00:40', '2017-07-25 12:00:59'),
(4, 1, '', '', 'wada tamotsu', 'wadatamotsu@gmail.com', 'Afganistan', 'male', NULL, 'e94046d2b2b705ab3ab7b81b2c8da846d9931e81', 'aaaaaaa', '../../event_pictures/20170719004953スクリーンショット 2017-07-14 4.28.52.png', '2017-07-15 20:32:53', '2017-07-25 12:00:33'),
(5, 1, '', '', '1umetani', '1umetani@gmail.com', 'nationality', 'other', 'Advanced', '65c5eaefc61d0ebcf4539344a84518bab2fea9d4', '', 'a', '2017-07-16 21:25:32', '2017-07-16 13:25:32'),
(6, 1, '', '', '2umetani', '2umetani@gmail.com', 'nationality', 'other', 'Advanced', 'ff41bca6222a3871635341e86b3cfe097eff1dfe', '', 'a', '2017-07-16 21:31:30', '2017-07-16 13:31:30'),
(7, 1, '', '', '3umetani', '3umetani', 'nationality', 'other', 'Advanced', 'c0fc1925fcc79786f6a821b136aa040ddb898e34', '', 'a', '2017-07-16 21:33:40', '2017-07-16 13:33:40'),
(8, 1, '', '', '4umetani', '4umetani@gmail.com', 'nationality', 'other', 'Advanced', '46878cc5f7c13790bb61cdfb093617ea9c5ce509', '', 'a', '2017-07-16 22:05:43', '2017-07-16 14:05:43'),
(9, 1, '', '', '5umetani', '5umetani@gmail.com', 'nationality', 'other', 'Advanced', '826970b3e0784fa6f319377d72cd4d878557a344', '', 'a', '2017-07-17 21:23:12', '2017-07-17 13:23:12'),
(10, 1, '', '', 'o7umetani', 'o7umetani@gmail.com', 'nationality', 'other', 'Advanced', '53af8daf68524a78a4c784e138c7cd8ef319ac2b', '', 'a', '2017-07-19 15:10:06', '2017-07-19 07:10:06'),
(11, 1, '', '', '6umetani', '6umetani@gmail.com', 'nationality', 'other', 'Advanced', 'f2cf4066fa3fcbb6739ccfbe4b09c2c2d6333852', '', 'a', '2017-07-21 15:39:07', '2017-07-21 07:39:07'),
(12, 1, '', '', '梅谷梅谷', 'umetaniumetani@gmail.com', 'nationality', 'other', 'Advanced', '083a8ffd06a17e0feb1955de198bd52b928678c2', '', 'a', '2017-07-23 18:04:03', '2017-07-23 10:04:03'),
(13, 1, '', '', 'umeume', 'umeume@gmail.com', 'nationality', 'other', 'Advanced', '28a1cc19abf355a0085cf9145ba8bb7f120b5844', '', 'a', '2017-07-23 18:10:39', '2017-07-23 10:10:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD PRIMARY KEY (`chat_room_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_movies`
--
ALTER TABLE `event_movies`
  ADD PRIMARY KEY (`e_movie_id`);

--
-- Indexes for table `event_pics`
--
ALTER TABLE `event_pics`
  ADD PRIMARY KEY (`e_pic_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `notification_categories`
--
ALTER TABLE `notification_categories`
  ADD PRIMARY KEY (`notification_category_id`);

--
-- Indexes for table `organizers`
--
ALTER TABLE `organizers`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `review_photos`
--
ALTER TABLE `review_photos`
  ADD PRIMARY KEY (`review_pic_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `chat_room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `event_movies`
--
ALTER TABLE `event_movies`
  MODIFY `e_movie_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event_pics`
--
ALTER TABLE `event_pics`
  MODIFY `e_pic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notification_categories`
--
ALTER TABLE `notification_categories`
  MODIFY `notification_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `organizers`
--
ALTER TABLE `organizers`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `review_photos`
--
ALTER TABLE `review_photos`
  MODIFY `review_pic_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
