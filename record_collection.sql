-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 02. 03 2020 kl. 12:11:16
-- Serverversion: 10.1.38-MariaDB
-- PHP-version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `record_collection`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `albums`
--
-- Fejl ved læsning af struktur for tabel record_collection.albums: #1932 - Table 'record_collection.albums' doesn't exist in engine
-- Fejl ved læsning af data i tabel record_collection.albums: #1064 - Der er en fejl i SQL syntaksen nær 'FROM `record_collection`.`albums`' på linje 1

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `artists`
--

CREATE TABLE `artists` (
  `id` int(150) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `sorting` varchar(255) DEFAULT NULL,
  `image_link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `profile` text,
  `website` varchar(255) DEFAULT NULL,
  `amazon_link` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `artists`
--

INSERT INTO `artists` (`id`, `firstname`, `lastname`, `sorting`, `image_link`, `image`, `profile`, `website`, `amazon_link`) VALUES
(2, 'Test', 'Testesen', 'Testesen, Test', '', 'photo1518489913881199b7c7a081d.jpg', '<h3>Test</h3>\r\n<p>This is just for testing.</p>\r\n<p>Should delete image and insert an image link instead.</p>\r\n<p>Testing no image info update</p>', 'http://google.com', ''),
(3, 'Testing', '', 'Testing', '', 'a_band.jpg', '<h1>More testing</h1>\r\n<p>This is just to see if bandname with a the before is working correctly.</p>\r\n<p>I do hope that it will work the first time.</p>', '', 'https://www.amazon.com/s?k=the+band'),
(5, 'The Testings', '', 'Testings', 'https://images.unsplash.com/photo-1500917293891-ef795e70e1f6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80', '', 'Just testing image upload, testing editing post.\r\nChecking to see if image_link resets', 'poiladfgjhoapi', ''),
(6, 'Wendy', 'Testaburger', 'Testaburger, Wendy', 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80', '', 'Just another test', 'http://rughtrade.co.uk', ''),
(8, 'The The', '', 'The', '', 'singer.jpg', 'Image upload again', '', ''),
(9, 'Some', 'Name', 'Name, Some', '', 'new.jpg', 'just testing uploading image to an artist without image informations', '', ''),
(10, 'Depeche Mode', '', 'Depeche Mode', '', 'DepecheMode.jpg', '<p>Depeche Mode are an English electronic music band formed in Basildon, Essex in 1980. The group as of now consists of a trio of Dave Gahan (lead vocals and co-songwriting), Martin Gore (keyboards, guitar, co-lead vocals and main songwriting), and Andy Fletcher (keyboards).</p>\r\n<p>Depeche Mode released their debut album Speak & Spell in 1981, bringing the band onto the British new wave scene. Founding member Vince Clarke left after the release of the album; they recorded A Broken Frame as a trio. Gore took over as main songwriter and, later in 1982, Alan Wilder replaced Clarke, establishing a lineup that continued for 13 years.</p>\r\n<p>The band\'s last albums of the 1980s, Black Celebration and Music for the Masses, established them as a dominant force within the electronic music scene. A highlight of this era was the band\'s June 1988 concert at the Pasadena Rose Bowl, where they drew a crowd in excess of 60,000 people. In early 1990, they released Violator, an international mainstream success. The following album, Songs of Faith and Devotion, released in 1993, was also a success, though internal struggles within the band during recording and touring resulted in Wilder\'s departure in 1995.</p>\r\n<p>Depeche Mode has had 54 songs in the UK Singles Chart and 17 top 10 albums in the UK chart; they have sold more than 100 million records worldwide. Q included the band in the list of the \"50 Bands That Changed the World!\". Depeche Mode also ranks number 98 on VH1\'s \"100 Greatest Artists of All Time\". In December 2016, Billboard named Depeche Mode the 10th most successful dance club artist of all time. They were nominated for induction into the Rock and Roll Hall of Fame in 2017 and 2018, and will be inducted as part of the Class of 2020.</p>\r\n<p>Information from <a href=\"https://en.wikipedia.org/wiki/Depeche_Mode\" target=\"_blank\">Wikipedia</a>.</p>\r\n<p>Image is by <a href=\"http://antoncorbijn.com/?domain=www.corbijn.co.uk\" target=\"_blank\">Anton Corbijn</a> and is from Depeche Modes official website.</p>\r\n', 'http://www.depechemode.com/', '');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `formats`
--

CREATE TABLE `formats` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `formats`
--

INSERT INTO `formats` (`id`, `name`) VALUES
(2, 'LP'),
(3, '12 inch Maxi Single');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `grades`
--

CREATE TABLE `grades` (
  `id` int(3) NOT NULL,
  `value` varchar(255) NOT NULL,
  `short` varchar(10) NOT NULL,
  `definition` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `grades`
--

INSERT INTO `grades` (`id`, `value`, `short`, `definition`, `image`) VALUES
(1, 'mint', 'M', '<h3>Vinyl</h3>\r\n<p>Absolutely perfect in every way. Certainly never been played, possibly even still sealed. Should be used sparingly as a grade, if at all.</p>  \r\n\r\n<h3>CD</h3> \r\n<p>Perfect. No scuffs/scratches, unplayed - possibly still sealed.<p>\r\n\r\n<p>Insert/Inlay/Booklet/Sleeve/Digipak: Perfect. No wear, marks, or any other imperfections - possibly still sealed.<p> ', 'mint.jpg'),
(2, 'near mint', 'NM', '<h3>Vinyl</h3>\r\n<p>A nearly perfect record. A NM- record has more than likely never been played, and the vinyl will play perfectly, with no imperfections during playback. Many dealers won\'t give a grade higher than this implying (perhaps correctly) that no record is ever truly perfect. The record should show no obvious signs of wear. A 45 RPM or EP sleeve should have no more than the most minor defects, such as any sign of slight handling. An LP cover should have no creases, folds, seam splits, cut-out holes, or other noticeable similar defects. The same should be true of any other inserts, such as posters, lyric sleeves, etc.</p>\r\n\r\n<h3>CD</h3>\r\n<p>Near perfect. No obvious signs of use, it may have been played - but it has been handled very carefully.<p>\r\n\r\n<p>Insert/Inlay/Booklet/Sleeve/Digipak: Near Perfect. No obvious wear, it may have only the slightest of marks from handling. </p>', 'nearMint.jpg'),
(4, 'very good plus', 'VG+', '<h3>Vinyl</h3>\r\n<p>Generally worth 50% of the Near Mint value. A Very Good Plus record will show some signs that it was played and otherwise handled by a previous owner who took good care of it. Defects should be more of a cosmetic nature, not affecting the actual playback as a whole. Record surfaces may show some signs of wear and may have slight scuffs or very light scratches that don\'t affect one\'s listening experiences. Slight warps that do not affect the sound are \"OK\". The label may have some ring wear or discoloration, but it should be barely noticeable. Spindle marks may be present. Picture sleeves and inner sleeves will have some slight wear, slightly turned-up corners, or a slight seam split. An LP cover may have slight signs of wear, and may be marred by a cut-out hole, indentation, or cut corner. In general, if not for a couple of minor things wrong with it, this would be Near Mint.</p>  \r\n\r\n<h3>CD</h3>\r\n<p>A few minor scuffs/scratches. This has been played, but handled with good care - and certainly not abused.</p>\r\n\r\n<p>Insert/Inlay/Booklet/Sleeve/Digipak: Slight wear, marks, indentations, it may possibly have a cut-out hole (or similar).</p>', 'vgPlus.jpg'),
(5, 'very good', 'VG', '<h3>Vinyl</h3>\r\n<p>Generally worth 25% of Near Mint value. Many of the defects found in a VG+ record will be more pronounced in a VG disc. Surface noise will be evident upon playing, especially in soft passages and during a song\'s intro and fade, but will not overpower the music otherwise. Groove wear will start to be noticeable, as with light scratches (deep enough to feel with a fingernail) that will affect the sound. Labels may be marred by writing, or have tape or stickers (or their residue) attached. The same will be true of picture sleeves or LP covers. However, it will not have all of these problems at the same time. Goldmine price guides with more than one price will list Very Good as the lowest price.</p>\r\n<h3>CD</h3>\r\n<p>Quite a few light scuffs/scratches, or several more-pronounced scratches. This has obviously been played, but not handled as carefully as a VG+.</p> \r\n\r\n<p>Insert/Inlay/Booklet/Sleeve/Digipak: More wear, marks, indentations than a VG+. May have slight fading, a small tear/rip, or some writing.</p>', 'veryGood.jpg'),
(6, 'good', 'G', '<h3>Vinyl</h3> \r\n<p>Generally worth 10-15% of the Near Mint value. A record in Good or Good Plus condition can be played through without skipping. But it will have significant surface noise, scratches, and visible groove wear. A cover or sleeve will have seam splits, especially at the bottom or on the spine. Tape, writing, ring wear, or other defects will be present. While the record will be playable without skipping, noticeable surface noise and \"ticks\" will almost certainly accompany the playback.</p>  \r\n\r\n<h3>CD</h3>\r\n<p>There are a lot of scuffs/scratches. However it will still play through without problems. This has not been handled with much care at all.</p>\r\n\r\n<p>Insert/Inlay/Booklet/Sleeve/Digipak: Well worn, marked, more obvious indentations, fading, writing, than a VG - possibly a more significant tear/rip.</p>', 'good.jpg'),
(7, 'fair', 'F', '<h3>Vinyl</h3> \r\n<p>Generally worth 0-5% of the Near Mint price. The record is cracked, badly warped, and won\'t play through without skipping or repeating. The picture sleeve is water damaged, split on all three seams and heavily marred by wear and writing. The LP cover barely keeps the LP inside it. Inner sleeves are fully split, crinkled, and written upon.</p>\r\n<h3>CD</h3> \r\n<p>The CD (if it is included) may or may not play some or all of the tracks. See the seller\'s comments for details.</p>\r\n\r\n<p>Insert/Inlay/Booklet/Sleeve/Digipak: Very worn. It may have obvious writing on it, it may be ripped/torn, or significantly faded, or water damaged.</p>', 'fair.jpg');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `records`
--

CREATE TABLE `records` (
  `id` int(10) NOT NULL,
  `artist_id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `year` int(4) NOT NULL,
  `information` text,
  `image_link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `records`
--

INSERT INTO `records` (`id`, `artist_id`, `title`, `year`, `information`, `image_link`, `image`) VALUES
(1, 5, 'Test of Sql', 2019, 'Somehow my sql were corrupted', '', 'test_cover.jpg');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `security_code` varchar(255) DEFAULT NULL,
  `created` int(50) NOT NULL,
  `last_logged_in` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`id`, `email`, `hashed_password`, `username`, `is_admin`, `security_code`, `created`, `last_logged_in`) VALUES
(1, 'michael@michael-h.dk', '$2y$10$q7DBVV7NlxH4FQ0/gcIBxe7r6S9DMSzcx3DXCuUo93Ec0jkWyA.ta', 'michael-h', 1, '', 1580750764, 1583145438),
(3, 'test@testing.com', '$2y$10$J9.oeo.HnxeZlNgqFmjuheO6niKB5GSxKYOgXzDbsMN1fvpS6NgIu', 'testing again 3', 0, '', 1580895301, 1581677116);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `formats`
--
ALTER TABLE `formats`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_id` (`artist_id`);

--
-- Indeks for tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tilføj AUTO_INCREMENT i tabel `formats`
--
ALTER TABLE `formats`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tilføj AUTO_INCREMENT i tabel `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tilføj AUTO_INCREMENT i tabel `records`
--
ALTER TABLE `records`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `records`
--
ALTER TABLE `records`
  ADD CONSTRAINT `records_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
