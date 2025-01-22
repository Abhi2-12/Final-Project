-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2025 at 04:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `member`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `ad_id` int(11) NOT NULL,
  `ad_image` varchar(255) NOT NULL,
  `ad_link` varchar(255) NOT NULL,
  `ad_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `post`) VALUES
(6, 'Bangladesh', 0),
(7, 'International', 0),
(9, 'Sports', 0),
(10, 'Cooking', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `comment_text`, `comment_date`) VALUES
(1, 17, 22, 'good', '2025-01-19 00:32:24'),
(2, 14, 22, 'god', '2025-01-19 03:50:36'),
(3, 15, 22, 'nice', '2025-01-19 03:50:45'),
(4, 14, 25, 'sad', '2025-01-19 06:01:43'),
(5, 11, 22, 'good job, good news!', '2025-01-19 13:46:38'),
(6, 13, 22, 'Congrates!', '2025-01-19 13:46:54'),
(7, 7, 22, 'yammi', '2025-01-19 13:53:14');

-- --------------------------------------------------------

--
-- Table structure for table `editor`
--

CREATE TABLE `editor` (
  `editor_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `editor`
--

INSERT INTO `editor` (`editor_id`, `username`, `email`, `phone`, `password`) VALUES
(5, 'editor2', 'editor2@gmail.com', '01735250170', 'editor2'),
(6, 'editor', 'editor@gmail.com', '01538382734', 'editor'),
(11, 'editor1', 'editor1@gmail.com', '01538382734', 'editor123');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(100) NOT NULL,
  `post_date` varchar(50) NOT NULL,
  `post_img` varchar(100) NOT NULL,
  `likes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `title`, `description`, `category_id`, `post_date`, `post_img`, `likes`) VALUES
(7, 'Baking Homemade Cookies: A Step-by-Step Guide', 'Get ready to indulge in the deliciousness of homemade cookies! This easy-to-follow recipe will guide you through every step of the cookie-making process, from mixing the ingredients to the perfect baking time. Whether you\'re making classic chocolate chip, oatmeal, or a unique flavor of your choice, you\'ll create mouthwatering treats that everyone will love. Grab your apron and let’s start baking these golden, gooey, and irresistible cookies that are sure to be a hit with family and friends!', 10, '2025-01-04 22:09:48', '../uploads/rm-piloncillo-chocolate-chip-cookies-cfgh-threeByTwoMediumAt2X.jpg', NULL),
(8, 'Savory Beef Curry: A Flavorful Comfort Dish', 'Savor the rich, aromatic flavors of this homemade beef curry! In this simple yet flavorful recipe, tender beef is simmered in a spiced, savory gravy made with onions, tomatoes, and a blend of fragrant spices. This dish pairs perfectly with rice or naan for a hearty, comforting meal. Follow the step-by-step guide to create this delicious curry that is sure to become a family favorite. Enjoy the tender meat, rich sauce, and perfect blend of spices in every bite!', 10, '2025-01-04 22:11:18', '../uploads/beef-curry.jpg', NULL),
(9, 'Homemade Chicken Pizza: A Flavorful Feast', 'Create your own delicious chicken pizza right at home with this easy recipe! Tender, seasoned chicken is paired with rich tomato sauce, gooey melted cheese, and your favorite toppings to make the perfect pizza. Whether you’re using a store-bought dough or making your own from scratch, this step-by-step guide will help you create a pizza that’s crispy on the outside, soft and cheesy on the inside, and bursting with flavor. Customize with vegetables, herbs, or extra cheese to make it truly your own. Perfect for pizza night with family and friends!', 10, '2025-01-04 22:12:49', '../uploads/download.jpg', NULL),
(10, 'Kacchi Biryani: A Royal Flavor Explosion', ' Indulge in the rich, aromatic, and flavorful Kacchi Biryani, a royal dish that’s sure to impress! This traditional recipe features marinated raw meat (usually mutton or chicken) cooked with fragrant basmati rice, saffron, and a blend of exotic spices like cardamom, cloves, and cinnamon. The meat is cooked slowly with the rice, infusing both the meat and the grains with deep, savory flavors. The result? A perfect balance of tender meat, aromatic rice, and mouthwatering spices in every bite. Serve it with a side of raita or a fresh salad to complete this indulgent and satisfying meal.', 10, '2025-01-04 22:14:21', '../uploads/images.jpg', NULL),
(11, 'The return of the \'old Man City\'? \'Absolutely not\' says Guardiola', 'Consecutive wins for the first time since October. Scoring four goals in a Premier League for the first time since August. Erling Haaland\'s first league double since September.\r\n\r\nHas Saturday\'s 4-1 demolition of West Ham marked the return of the old Manchester City? \'Absolutely not\' according to boss Pep Guardiola.\r\n\r\nThe win leaves the defending champions sixth in the Premier League, just three points off third-placed Nottingham Forest, and offers welcome relief after a forgettable last couple of months.\r\n\r\nBut, when asked if the result was a sign of his team regaining the form most people are used to seeing from them - following a run of two wins from 10 games - the Spaniard was unequivocal in his response.\r\n\r\n\"No,\" Guardiola, said. \"You judge the results. Our performance was not good. We saw in many years our level. We are not at our level.\r\n\r\n\"Don\'t misunderstand me. I\'m so happy. I will sleep better until the FA Cup [tie against Salford on 11 January].\r\n\r\n\"But he asked if the old Manchester City and the way we play is back? No. You have to know it. You watched the games for years. We\'re not at the level, come on.\r\n\r\n\"Of course there are an incredible lot of positives. But if you ask me the team is playing like it has played the years ago, no, absolutely not.\"\r\n\r\n', 9, '2025-01-04 22:16:23', '../uploads/718366e0-cad0-11ef-94df-33b0323b7c60.jpg.webp', NULL),
(12, 'Shakib might be available for ICC Champions Trophy, hints BCB chief', 'Farque Ahmed, president of the Bangladesh Cricket Board (BCB), has hinted that Shakib Al Hasan might be available for the ICC Champions Trophy that will take place in Pakistan and the UAE in February-March this year.\r\n\r\nFarque, while having a visit at the press box of the Sher-e-Bangla National Cricket Stadium on Friday during a BPL match, said that Shakib did not retire, so there is no issue with his availability.\r\nShakib retired from both T20I and Test cricket. He desired to play his last Test in October in Bangladesh. But due to his political affiliation with the ousted Awami League, he was unable to return home and play cricket.\r\n\r\n\"Shakib hasn\'t officially retired. If he had, we wouldn\'t be having this discussion,\" Farque said on Friday. \"The issues surrounding him need to be resolved at the government level. Once those are addressed, we can move forward. His fitness, mental state, and the selection committee\'s decision will determine his participation.\"\r\n\r\nAfter the ouster of the Awami League government in August, Shakib played for Bangladesh in India. But he was not able to return home fearing his safety due to political reasons. But the Champions Trophy will be held outside the country, so it\'s understandable that the player might get a chance to play if he is fit enough to play.', 9, '2025-01-04 22:17:25', '../uploads/prothomalo-english_2024-11-08_hutnzs1m_prothomalo-bangla2024-10-31kgkkssedShakib-ICC.webp', NULL),
(13, 'Australia 101-5 after India rip through top order', 'India tore through Australia\'s top order on day two of the decisive fifth and final Test on Saturday in Sydney with Steve Smith falling agonisingly short of joining an elite group with 10,000 runs.\r\n\r\nAt lunch the hosts had been reduced to 101-5 with debutant Beau Webster not-out 28 and Alex Carey on four, still 84 runs behind after India were dismissed for 185.\r\n\r\nAustralia lost Sam Konstas (23), Marnus Labuschagne (two), Travis Head (four) and Smith (33) in the session during fiery spells from Mohammed Siraj and Jasprit Bumrah.\r\n\r\nSmith looked poised to become only the 15th batsman ever and fourth Australian to reach 10,000 Test runs in front of his home crowd at the Sydney Cricket Ground.\r\n\r\nBut he will have to wait for another day after Prasidh Krishna enticed an edge just before the break and KL Rahul took the catch in the slips.', 9, '2025-01-04 22:18:14', '../uploads/prothomalo-english_2025-01-04_gwzrymff_531985-01-02.webp', NULL),
(14, 'Biden govt informs Congress of planned $8 bn weapons sale to Israel', 'The State Department has informed Congress of a planned $ 8 billion weapons sale to Israel, US officials say, as the American ally presses forward with its war against Hamas in Gaza.\r\n\r\nSome of the arms in the package could be sent through current US stocks but the majority would take a year or several years to deliver, according to two US officials Saturday who spoke on condition of anonymity because the notification to Congress hasn\'t been formally sent.\r\n\r\nThe sale includes medium-range air-to-air missiles to help Israel defend against airborne threats, 155 mm projectile artillery shells for long-range targeting, Hellfire AGM-114 missiles, 500-pound bombs and more.', 7, '2025-01-04 22:20:01', '../uploads/1735626099-0873.avif', NULL),
(15, 'NSA Sullivan to visit India to finalise important initiatives: White House', 'Outgoing US National Security Advisor Jake Sullivan will travel to India on January 5 and 6 to meet his counterpart Ajit K Doval and other top government officials for a final round of talks with them on a wide range of bilateral, regional and global issues and to finalise some ongoing initiatives.\r\n\r\nSullivan, 48, the youngest national security advisor when President Joe Bident appointed him on January 20, 2021, would also deliver a major India-centric foreign policy speech at IIT, New Delhi during his last trip to India before leaving office. He would be succeeded by Congressman Michael Waltz on January 20, when Donald J Trump would be sworn in as the 47th President of the United States.', 7, '2025-01-04 22:20:33', '../uploads/1718679253-7041.avif', NULL),
(16, 'Israeli airstrikes in southern Gaza kill at least 15, say hospital workers', 'Israeli airstrikes killed at least 15 people including a child early Saturday in southern Gaza, hospital staff said, while a new effort at ceasefire talks was said to be underway in Qatar.\r\n\r\nA small boy cried over his father, and a woman draped herself over one of the bodies wrapped in white plastic. The three airstrikes hit a car, a house and people on the street in the city of Khan Younis, according to staff at Nasser Hospital.\r\n And the Civil Defence, first responders affiliated with the Hamas-run government, said an airstrike destroyed a residential area behind the Saraya complex in Gaza City, killing at least five people.\r\n\r\nThere was no immediate comment from Israel\'s military.\r\n\r\nGaza\'s Health Ministry said at least 59 people had been killed and more than 270 injured by strikes in the past 24 hours.', 7, '2025-01-04 22:21:55', '../uploads/1723515963-9304.avif', NULL),
(17, 'টেকনাফে কোস্টগার্ডের গুলিতে ‘চোরাকারবারি’ নিহত, গ্রেপ্তার ১৬', 'কক্সবাজারের টেকনাফ উপজেলায় বন্দুকযুদ্ধে এক চোরাকারবারি নিহত হয়েছেন বলে জানিয়েছে কোস্টগার্ড। এ ছাড়া, ১৬ জনকে গ্রেপ্তার করা হয়েছে। এর মধ্যে পাঁচজন রোহিঙ্গা রয়েছেন।\r\nআজ শনিবার ভোরে শাহপরী দ্বীপের কাছে নাফ নদীর মোহনায় গোলার চর এলাকায় চোরাকারবারি দলের সঙ্গে বাংলাদেশ কোস্টগার্ড সদস্যদের বন্দুকযুদ্ধের ঘটনা ঘটে।\r\n\r\nকোস্টগার্ডের মিডিয়া অফিসার লেফটেন্যান্ট কমান্ডার মো. সিয়াম-উল-হক এ তথ্য নিশ্চিত করেছেন।\r\n\r\nতিনি জানান, নিহত জামাল উদ্দিন (৩৫) একটি চোরাচালান চক্রের সদস্য। এ ছাড়া, ১৬ জনকে গ্রেপ্তার করা হয়েছে। তাদের বিরুদ্ধে ডাকাতির সঙ্গে জড়িত থাকার অভিযোগও রয়েছে।\r\n\r\n\'মিয়ানমার থেকে মাদকের চালান আসছে এমন গোপন সংবাদের ভিত্তিতে কোস্টগার্ডের টহল দল বাংলাদেশের জলসীমায় প্রবেশের সময় একটি নৌকাকে থামার সংকেত দেয়। নৌকাটি সিগন্যাল অমান্য করে দ্রুত গতিতে কক্সবাজারের দিকে পালানোর চেষ্টা করে। \r\nকোস্টগার্ড সদস্যরা ফাঁকা গুলি ছুড়লে ট্রলার থেকে চোরাকারবারিরাও পাল্টা গুলি চালাতে শুরু করে,\' বলেন সিয়াম।\r\nতিনি আরও বলেন, \'কোস্টগার্ড সদস্যরা ট্রলার থেকে একজনকে গুলিবিদ্ধ অবস্থায় উদ্ধার করে। টেকনাফ হাসপাতালে নিয়ে গেলে কর্তব্যরত চিকিৎসক তাকে মৃত ঘোষণা করেন।\'', 6, '2025-01-04 22:23:54', '../uploads/smuggler_4jan24.avif', NULL),
(18, 'দেশে নতুন করে ষড়যন্ত্র ও চক্রান্ত শুরু হয়েছে: মির্জা ফরুখল', 'দেশে নতুন করে ষড়যন্ত্র ও চক্রান্ত শুরু হয়েছে উল্লেখ করে বাংলাদেশ জাতীয়তাবাদী দলের (বিএনপি) মহাসচিব মির্জা ফখরুল ইসলাম আলমগীর বলেছেন, \'এই ষড়যন্ত্র ও চক্রান্তের সামনে আমরা মাথা নত করবো না। সবখানে বৈষম্য রয়েছে, দুর্নীতি হয়েছে। বৈষম্য ও দুর্নীতি দূর করে জনগণের সরকার যেন প্রতিষ্ঠা করতে পারি, সেই লক্ষ্যে আমাদের কাজ করতে হবে।\'আজ শনিবার সন্ধ্যা ৬টায় ঠাকুরগাঁও পাবলিক মাঠে অনুষ্ঠিত ছাত্রদলের ৪৬তম প্রতিষ্ঠাবার্ষিকী উপলক্ষে ছাত্র সমাবেশে প্রধান অতিথি হিসেবে ভার্চুয়ালি যুক্ত হয়ে এ কথা বলেন তিনি।\r\n\r\nমির্জা ফখরুল বলেন, \'১৯৭৫ সাল পর্যন্ত দেশে আওয়ামী লীগ ক্ষমতায় ছিল। তারা তখনো সারা দেশে লুটপাট, ষড়যন্ত্র, হত্যা, গুম করে ক্ষমতায় টিকে ছিল এবং তাদের দুঃশাসনে দেশে দুর্ভিক্ষ হয়েছিল।\'\r\n\r\nতিনি বলেন, \'আওয়ামী লীগ গণতন্ত্র হত্যা করে একদলীয় শাসন ব্যবস্থা ও বাকশাল প্রতিষ্ঠা করেছিল। তারা যখনই ক্ষমতায় আসে, তখনি জোর করে ক্ষমতায় টিকে থাকতে চায় ও দেশের সবকিছু ধ্বংস করে দেয়।\'', 6, '2025-01-04 22:24:52', '../uploads/img_20250104_172822.avif', NULL),
(19, 'ব্রিটিশ উদ্যোক্তাদের বাংলাদেশে বিনিয়োগের আহ্বান লুৎফে সিদ্দিকীর', 'তিনি বলেন, \'অন্তর্বর্তী সরকার সরাসরি বিদেশি বিনিয়োগ আকৃষ্ট করতে ব্যাপক সংস্কার উদ্যোগ নিয়েছে।\'\r\n\r\nআজ শনিবার রাষ্ট্রীয় অতিথি ভবন যমুনায় ইউকেবিসিসিআইর সফররত একটি প্রতিনিধি দলের সঙ্গে বৈঠককালে তিনি এই আহ্বান জানান।\r\n\r\nবাংলাদেশে তিন দিনের সফরে প্রতিনিধি দলের নেতৃত্ব দিচ্ছেন ইউকেবিসিসিআই চেয়ারম্যান ইকবাল আহমেদ এবং ইউকেবিসিসিআই সভাপতি এম জি মওলা মিয়া।\r\n\r\nলুৎফে সিদ্দিকী প্রতিনিধি দলটিকে সামষ্টিক অর্থনৈতিক বিষয়ে বাংলাদেশের অগ্রগতির পাশাপাশি বর্তমান বিনিময় হার, বৈদেশিক মুদ্রার রিজার্ভ, রপ্তানি ও বন্দরের কর্মক্ষমতা সম্পর্কে অবহিত করেন।', 6, '2025-01-04 22:25:50', '../uploads/lutfey_siddiqi_4jan24.avif', NULL),
(37, 'project ', 'dsbksbljcblscbjsbacdnbbdmcmd mnc mnc m c  mcdnms s', 6, '2025-01-19 09:31:21', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `saved_articles`
--

CREATE TABLE `saved_articles` (
  `saved_article_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved_articles`
--

INSERT INTO `saved_articles` (`saved_article_id`, `user_id`, `post_id`, `title`, `content`) VALUES
(1, 22, 14, 'Biden govt informs Congress of planned $8 bn weapons sale to Israel', 'The State Department has informed Congress of a planned $ 8 billion weapons sale to Israel, US officials say, as the American ally presses forward with its war against Hamas in Gaza.\r\n\r\nSome of the arms in the package could be sent through current US stocks but the majority would take a year or several years to deliver, according to two US officials Saturday who spoke on condition of anonymity because the notification to Congress hasn\'t been formally sent.\r\n\r\nThe sale includes medium-range air-to-air missiles to help Israel defend against airborne threats, 155 mm projectile artillery shells for long-range targeting, Hellfire AGM-114 missiles, 500-pound bombs and more.'),
(2, 22, 14, 'Biden govt informs Congress of planned $8 bn weapons sale to Israel', 'The State Department has informed Congress of a planned $ 8 billion weapons sale to Israel, US officials say, as the American ally presses forward with its war against Hamas in Gaza.\r\n\r\nSome of the arms in the package could be sent through current US stocks but the majority would take a year or several years to deliver, according to two US officials Saturday who spoke on condition of anonymity because the notification to Congress hasn\'t been formally sent.\r\n\r\nThe sale includes medium-range air-to-air missiles to help Israel defend against airborne threats, 155 mm projectile artillery shells for long-range targeting, Hellfire AGM-114 missiles, 500-pound bombs and more.'),
(3, 22, 15, 'NSA Sullivan to visit India to finalise important initiatives: White House', 'Outgoing US National Security Advisor Jake Sullivan will travel to India on January 5 and 6 to meet his counterpart Ajit K Doval and other top government officials for a final round of talks with them on a wide range of bilateral, regional and global issues and to finalise some ongoing initiatives.\r\n\r\nSullivan, 48, the youngest national security advisor when President Joe Bident appointed him on January 20, 2021, would also deliver a major India-centric foreign policy speech at IIT, New Delhi during his last trip to India before leaving office. He would be succeeded by Congressman Michael Waltz on January 20, when Donald J Trump would be sworn in as the 47th President of the United States.'),
(4, 22, 16, 'Israeli airstrikes in southern Gaza kill at least 15, say hospital workers', 'Israeli airstrikes killed at least 15 people including a child early Saturday in southern Gaza, hospital staff said, while a new effort at ceasefire talks was said to be underway in Qatar.\r\n\r\nA small boy cried over his father, and a woman draped herself over one of the bodies wrapped in white plastic. The three airstrikes hit a car, a house and people on the street in the city of Khan Younis, according to staff at Nasser Hospital.\r\n And the Civil Defence, first responders affiliated with the Hamas-run government, said an airstrike destroyed a residential area behind the Saraya complex in Gaza City, killing at least five people.\r\n\r\nThere was no immediate comment from Israel\'s military.\r\n\r\nGaza\'s Health Ministry said at least 59 people had been killed and more than 270 injured by strikes in the past 24 hours.'),
(5, 22, 15, 'NSA Sullivan to visit India to finalise important initiatives: White House', 'Outgoing US National Security Advisor Jake Sullivan will travel to India on January 5 and 6 to meet his counterpart Ajit K Doval and other top government officials for a final round of talks with them on a wide range of bilateral, regional and global issues and to finalise some ongoing initiatives.\r\n\r\nSullivan, 48, the youngest national security advisor when President Joe Bident appointed him on January 20, 2021, would also deliver a major India-centric foreign policy speech at IIT, New Delhi during his last trip to India before leaving office. He would be succeeded by Congressman Michael Waltz on January 20, when Donald J Trump would be sworn in as the 47th President of the United States.'),
(6, 22, 15, 'NSA Sullivan to visit India to finalise important initiatives: White House', 'Outgoing US National Security Advisor Jake Sullivan will travel to India on January 5 and 6 to meet his counterpart Ajit K Doval and other top government officials for a final round of talks with them on a wide range of bilateral, regional and global issues and to finalise some ongoing initiatives.\r\n\r\nSullivan, 48, the youngest national security advisor when President Joe Bident appointed him on January 20, 2021, would also deliver a major India-centric foreign policy speech at IIT, New Delhi during his last trip to India before leaving office. He would be succeeded by Congressman Michael Waltz on January 20, when Donald J Trump would be sworn in as the 47th President of the United States.'),
(7, 22, 16, 'Israeli airstrikes in southern Gaza kill at least 15, say hospital workers', 'Israeli airstrikes killed at least 15 people including a child early Saturday in southern Gaza, hospital staff said, while a new effort at ceasefire talks was said to be underway in Qatar.\r\n\r\nA small boy cried over his father, and a woman draped herself over one of the bodies wrapped in white plastic. The three airstrikes hit a car, a house and people on the street in the city of Khan Younis, according to staff at Nasser Hospital.\r\n And the Civil Defence, first responders affiliated with the Hamas-run government, said an airstrike destroyed a residential area behind the Saraya complex in Gaza City, killing at least five people.\r\n\r\nThere was no immediate comment from Israel\'s military.\r\n\r\nGaza\'s Health Ministry said at least 59 people had been killed and more than 270 injured by strikes in the past 24 hours.'),
(8, 22, 7, 'Baking Homemade Cookies: A Step-by-Step Guide', 'Get ready to indulge in the deliciousness of homemade cookies! This easy-to-follow recipe will guide you through every step of the cookie-making process, from mixing the ingredients to the perfect baking time. Whether you\'re making classic chocolate chip, oatmeal, or a unique flavor of your choice, you\'ll create mouthwatering treats that everyone will love. Grab your apron and let’s start baking these golden, gooey, and irresistible cookies that are sure to be a hit with family and friends!'),
(9, 22, 14, 'Biden govt informs Congress of planned $8 bn weapons sale to Israel', 'The State Department has informed Congress of a planned $ 8 billion weapons sale to Israel, US officials say, as the American ally presses forward with its war against Hamas in Gaza.\r\n\r\nSome of the arms in the package could be sent through current US stocks but the majority would take a year or several years to deliver, according to two US officials Saturday who spoke on condition of anonymity because the notification to Congress hasn\'t been formally sent.\r\n\r\nThe sale includes medium-range air-to-air missiles to help Israel defend against airborne threats, 155 mm projectile artillery shells for long-range targeting, Hellfire AGM-114 missiles, 500-pound bombs and more.'),
(11, 22, 13, 'Australia 101-5 after India rip through top order', 'India tore through Australia\'s top order on day two of the decisive fifth and final Test on Saturday in Sydney with Steve Smith falling agonisingly short of joining an elite group with 10,000 runs.\r\n\r\nAt lunch the hosts had been reduced to 101-5 with debutant Beau Webster not-out 28 and Alex Carey on four, still 84 runs behind after India were dismissed for 185.\r\n\r\nAustralia lost Sam Konstas (23), Marnus Labuschagne (two), Travis Head (four) and Smith (33) in the session during fiery spells from Mohammed Siraj and Jasprit Bumrah.\r\n\r\nSmith looked poised to become only the 15th batsman ever and fourth Australian to reach 10,000 Test runs in front of his home crowd at the Sydney Cricket Ground.\r\n\r\nBut he will have to wait for another day after Prasidh Krishna enticed an edge just before the break and KL Rahul took the catch in the slips.'),
(12, 22, 14, 'Biden govt informs Congress of planned $8 bn weapons sale to Israel', 'The State Department has informed Congress of a planned $ 8 billion weapons sale to Israel, US officials say, as the American ally presses forward with its war against Hamas in Gaza.\r\n\r\nSome of the arms in the package could be sent through current US stocks but the majority would take a year or several years to deliver, according to two US officials Saturday who spoke on condition of anonymity because the notification to Congress hasn\'t been formally sent.\r\n\r\nThe sale includes medium-range air-to-air missiles to help Israel defend against airborne threats, 155 mm projectile artillery shells for long-range targeting, Hellfire AGM-114 missiles, 500-pound bombs and more.'),
(13, 22, 14, 'Biden govt informs Congress of planned $8 bn weapons sale to Israel', 'The State Department has informed Congress of a planned $ 8 billion weapons sale to Israel, US officials say, as the American ally presses forward with its war against Hamas in Gaza.\r\n\r\nSome of the arms in the package could be sent through current US stocks but the majority would take a year or several years to deliver, according to two US officials Saturday who spoke on condition of anonymity because the notification to Congress hasn\'t been formally sent.\r\n\r\nThe sale includes medium-range air-to-air missiles to help Israel defend against airborne threats, 155 mm projectile artillery shells for long-range targeting, Hellfire AGM-114 missiles, 500-pound bombs and more.');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` varchar(10) NOT NULL,
  `last_checked` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_logout` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `phone`, `password`, `last_checked`, `last_logout`) VALUES
(15, 'pppp', 'pppp@gmail.com', '45657979', 'pppp', '2025-01-18 20:03:43', NULL),
(16, 'zaman', 'zaman@gmail.com', '01538382734', 'zaman', '2025-01-18 20:03:43', NULL),
(20, 'Hasan', 'hasan@gmail.com', '123456789', 'hasan', '2025-01-18 20:03:43', NULL),
(21, 'xyz', 'xyz@gmail.com', '58754545', 'xyz', '2025-01-18 20:03:43', NULL),
(22, 'abirr', 'abir@gmail.com', '01735250170', 'Abir1234', '2025-01-18 23:56:45', NULL),
(24, 'Abdul', 'abdul@gmail.com', '01719917381', 'Abdul1234', '2025-01-18 20:03:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_preferences`
--

CREATE TABLE `user_preferences` (
  `preference_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_preferences`
--

INSERT INTO `user_preferences` (`preference_id`, `user_id`, `category_id`) VALUES
(3, 15, 7),
(5, 20, 9),
(6, 21, 10),
(7, 16, 10),
(10, 24, 9),
(14, 22, 10);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `video_id` int(11) NOT NULL,
  `video_title` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `editor`
--
ALTER TABLE `editor`
  ADD PRIMARY KEY (`editor_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `fk_category_id` (`category_id`);

--
-- Indexes for table `saved_articles`
--
ALTER TABLE `saved_articles`
  ADD PRIMARY KEY (`saved_article_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD PRIMARY KEY (`preference_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`video_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `editor`
--
ALTER TABLE `editor`
  MODIFY `editor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `saved_articles`
--
ALTER TABLE `saved_articles`
  MODIFY `saved_article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_preferences`
--
ALTER TABLE `user_preferences`
  MODIFY `preference_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `saved_articles`
--
ALTER TABLE `saved_articles`
  ADD CONSTRAINT `saved_articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `saved_articles_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`);

--
-- Constraints for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD CONSTRAINT `user_preferences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_preferences_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
