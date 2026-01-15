--
-- Database: `agmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE tbladmin (
  ID SERIAL PRIMARY KEY,
  AdminName VARCHAR(45) DEFAULT NULL,
  UserName VARCHAR(50) DEFAULT NULL,
  MobileNumber BIGINT DEFAULT NULL,
  Email VARCHAR(120) DEFAULT NULL,
  Password VARCHAR(120) DEFAULT NULL,
  AdminRegdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `tbladmin`
--

INSERT INTO tbladmin (ID, AdminName, UserName, MobileNumber, Email, Password, AdminRegdate) VALUES
(1, 'Admin', 'admin', 987654331, 'tester1@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2022-12-29 06:21:53');

-- --------------------------------------------------------

--
-- Table structure for table `tblartist`
--

CREATE TABLE tblartist (
  ID SERIAL PRIMARY KEY,
  Name VARCHAR(250) DEFAULT NULL,
  MobileNumber BIGINT DEFAULT NULL,
  Email VARCHAR(250) DEFAULT NULL,
  Education TEXT DEFAULT NULL,
  Award TEXT DEFAULT NULL,
  Profilepic VARCHAR(250) DEFAULT NULL,
  CreationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `tblartist`
--

INSERT INTO tblartist (ID, Name, MobileNumber, Email, Education, Award, Profilepic, CreationDate) VALUES
(1, 'Mohan Das', 7987987987, 'mohan@gmail.com', 'Completed his fine arts from kg fine arts college.\r\nSpecialized in drawing and ceramic.', 'Winner of Hugo Boss Prize in 2019, MacArthur Fellowship\r\n', 'ecebbecf28c2692aeb021597fbddb174.jpg', '2022-12-21 13:31:25'),
(2, 'Dev', 3287987987, 'dev@gmail.com', 'Completed his fine arts from kg fine arts college.\r\nSpecialized in painting and ceramic.', 'Winner of Hugo Boss Prize in 2019, MacArthur Fellowship\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25'),
(3, 'Kanha', 9687987987, 'kanha@gmail.com', 'Completed his fine arts from kg fine arts college.\r\nSpecialized in painting and ceramic.', 'Winner of Hugo Boss Prize in 2019, MacArthur Fellowship\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25'),
(4, 'Abir Rajwansh', 5687987987, 'abir@gmail.com', 'Completed his fine arts from klijfine arts college.\r\nSpecialized in painting and ceramic.', 'Winner of Hugo Boss Prize in 2019, MacArthur Fellowship\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25'),
(5, 'Krisna Dutt', 9187987987, 'krish@gmail.com', 'Completed his fine arts from kg fine arts college.\r\nSpecialized in painting and ceramic.', 'Winner of Hugo Boss Prize in 2019, MacArthur Fellowship\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25'),
(6, 'Kajol Mannati', 8187987987, 'kajol@gmail.com', 'Completed his fine arts from kg fine arts college.\r\nSpecialized in painting and ceramic.', 'Winner of Hugo Boss Prize in 2019, MacArthur Fellowship\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25'),
(7, 'Meera Singh', 2987987987, 'meera@gmail.com', 'Fine Arts in Painting from College of Art, New Delhi in 2012,\r\nSpecialized in printmaking and ceramic.', 'award-winning artist, and has received a scholarship from the Ministry of Culture, Government of India in 2014 as well as the Jean-Claude Reynal Scholarship (France) in 2019.\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25'),
(8, 'Narayan Das', 9987987987, 'narayan@gmail.com', 'Completed his fine arts from hjai fine arts college.\r\nSpecialized in painting and ceramic.', 'Winner of Young Artist Award in 2009, MacArthur Fellowship\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `tblartmedium`
--

CREATE TABLE tblartmedium (
  ID SERIAL PRIMARY KEY,
  ArtMedium varchar(250) DEFAULT NULL,
  CreationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `tblartmedium`
--

INSERT INTO tblartmedium (ID, ArtMedium, CreationDate) VALUES
(1, 'Wood and Bronze', '2022-12-22 04:57:04'),
(2, 'Acrylic on canvas', '2022-12-22 04:57:34'),
(3, 'Resin', '2022-12-22 04:58:00'),
(4, 'Mixed Media', '2022-12-22 06:09:12'),
(5, 'Bronze', '2022-12-22 06:09:35'),
(6, 'Fibre', '2022-12-22 06:09:53'),
(7, 'Steel', '2022-12-22 06:10:16'),
(8, 'Metal', '2022-12-22 06:10:35'),
(9, 'Oil on Canvas', '2022-12-22 06:11:31'),
(10, 'Oil on Linen', '2022-12-22 06:12:12'),
(11, 'Acrylics on paper', '2022-12-22 06:13:11'),
(12, 'Hand-painted on particle wood/MDF', '2022-12-22 06:14:03');

-- --------------------------------------------------------

--
-- Table structure for table `tblartproduct`
--

CREATE TABLE tblartproduct (
  ID SERIAL PRIMARY KEY,
  Title VARCHAR(250) DEFAULT NULL,
  Dimension VARCHAR(250) DEFAULT NULL,
  Orientation VARCHAR(100) DEFAULT NULL,
  Size VARCHAR(100) DEFAULT NULL,
  Artist INT DEFAULT NULL,
  ArtType INT DEFAULT NULL,
  ArtMedium INT DEFAULT NULL,
  SellingPricing DECIMAL(10,0) DEFAULT NULL,
  Description TEXT DEFAULT NULL,
  Image VARCHAR(250) DEFAULT NULL,
  Image1 VARCHAR(250) DEFAULT NULL,
  Image2 VARCHAR(250) DEFAULT NULL,
  Image3 VARCHAR(250) DEFAULT NULL,
  Image4 VARCHAR(250) DEFAULT NULL,
  RefNum INT DEFAULT NULL,
  CreationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `tblartproduct`
--

INSERT INTO tblartproduct (ID, Title, Dimension, Orientation, Size, Artist, ArtType, ArtMedium, SellingPricing, Description, Image, Image1, Image2, Image3, Image4, RefNum, CreationDate) VALUES
(2, 'Radhe Krishna Painting', '56x56', 'Landscape', 'Medium', 1, 4, 9, '200', 'It is a painting of Radha Krishna.\r\nIt is a painting of Radha Krishna.\r\nIt is a painting of Radha Krishna.It is a painting of Radha Krishna.\r\nIt is a painting of Radha Krishna.It is a painting of Radha Krishna.It is a painting of Radha Krishna.', 'c565ad988a4c6fc0a9f429af43c47cce1671771454.jpg', '48424793dc9ea732f6118d4ba4326509.jpg', '', '', '', 586429003, '2022-12-23 04:57:34'),
(3, 'Shiv Tandav Painting', '100X50 inches', 'Potrait', 'Large', 6, 4, 10, '350', 'It is a painting of shiv tandav.\r\nIt is a painting of shiv tandav.\r\nIt is a painting of shiv tandav.It is a painting of shiv tandav.It is a painting of shiv tandav.It is a painting of shiv tandav.It is a painting of shiv tandav.\r\nIt is a painting of shiv tandav.It is a painting of shiv tandav.', 'cd235e034297cda7b6f935dbd4881a2f1671771582.jpg', 'cd235e034297cda7b6f935dbd4881a2f1671771582.jpg', '', '', '', 686429002, '2022-12-23 04:59:42'),
(4, 'Stutue of Afel Tower', '45 inches tall', 'Landscape', 'Medium', 7, 1, 8, '500', 'It is a stute of afel tower which is made up of metal,It is a stute of afel tower which is made up of metal,It is a stute of afel tower which is made up of metal,It is a stute of afel tower which is made up of metal,It is a stute of afel tower which is made up of metal,It is a stute of afel tower which is made up of metal,It is a stute of afel tower which is made up of metal,', '508652faabdd333b34a0ce4a1dd443411671771753.jpg', '', '', '', '', 686429003, '2022-12-23 05:02:33'),
(5, 'HKjhkj', '100x200', 'Landscape', 'Large', 7, 3, 9, '200', 'gjhgj', '7d108db512f6a6a929cd0d0ad3b593e81671772410.jpg', '', '', '', '', 586429004, '2022-12-23 05:13:30');

-- --------------------------------------------------------

--
-- Table structure for table `tblarttype`
--

CREATE TABLE tblarttype (
  ID SERIAL PRIMARY KEY,
  ArtType VARCHAR(250) DEFAULT NULL,
  CreationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `tblarttype`
--

INSERT INTO tblarttype (ID , ArtType, CreationDate) VALUES
(1, 'Sculptures', '2022-12-21 14:21:13'),
(2, 'Serigraphs', '2022-12-21 14:24:46'),
(3, 'Prints', '2022-12-21 14:25:00'),
(4, 'Painting', '2022-12-21 14:25:31'),
(5, 'Street Art', '2022-12-21 14:26:06'),
(6, 'Visual art ', '2022-12-21 14:26:29'),
(7, 'Conceptual art', '2022-12-21 14:26:45');

-- --------------------------------------------------------

--
-- Table structure for table `tblenquiry`
--

CREATE TABLE tblenquiry (
  ID SERIAL PRIMARY KEY,
  EnquiryNumber VARCHAR(10) NOT NULL,
  Artpdid INTEGER,
  FullName VARCHAR(120),
  Email VARCHAR(250),
  MobileNumber VARCHAR(15), -- Changed from BIGINT to VARCHAR(15)
  Message VARCHAR(250),
  EnquiryDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  Status VARCHAR(10),
  AdminRemark VARCHAR(200) DEFAULT NULL, -- Allow NULL
  AdminRemarkdate TIMESTAMP NULL DEFAULT NULL
);


-- Dumping data for table tblenquiry
INSERT INTO tblenquiry (ID, EnquiryNumber, Artpdid, FullName, Email, MobileNumber, Message, EnquiryDate, Status, AdminRemark, AdminRemarkdate) 
VALUES
(1, '230873611', 4, 'Anuj kumar', 'ak@test.com', 1234567890, 'This is for testing Purpose.', '2023-01-02 18:16:47', 'Answer', 'test purpose', '2023-01-01 18:30:00'),
(2, '227883179', 5, 'Amit Kumar', 'amitk55@test.com', 1234434321, 'I want this painting', '2023-01-02 18:42:42', 'Answer', 'testing purpose', '2023-01-02 18:43:16');

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

CREATE TABLE tblpage (
  ID SERIAL PRIMARY KEY,
  PageType VARCHAR(200) DEFAULT NULL,
  PageTitle TEXT DEFAULT NULL,
  PageDescription TEXT DEFAULT NULL,
  Email VARCHAR(200) DEFAULT NULL,
  MobileNumber BIGINT DEFAULT NULL,
  UpdationDate DATE DEFAULT NULL,
  Timing VARCHAR(200) NOT NULL
);

--
-- Dumping data for table `tblpage`
--

INSERT INTO tblpage (ID, PageType, PageTitle, PageDescription, Email, MobileNumber, UpdationDate, Timing) VALUES
(1, 'aboutus', 'About Us', '<span style=\"color: rgb(32, 33, 36); font-family: arial, sans-serif; font-size: 16px;\">An art gallery is&nbsp;</span><b style=\"color: rgb(32, 33, 36); font-family: arial, sans-serif; font-size: 16px;\">an exhibition space to display and sell artworks</b><span style=\"color: rgb(32, 33, 36); font-family: arial, sans-serif; font-size: 16px;\">. As a result, the art gallery is a commercial enterprise working with a portfolio of artists. The gallery acts as the dealer representing, supporting, and distributing the artworks by the artists in question.</span><br>', NULL, NULL, NULL, ''),
(2, 'contactus', 'Contact Us', '890,Sector 62, Gyan Sarovar, GAIL Noida(Delhi/NCR)', 'info@gmail.com', 1234567890, NULL, '10:30 am to 7:30 pm');

--
-- Indexes for dumped tables
--

--

-- Foreign Key for tblenquiry referencing tblartproduct (if applicable)
CREATE INDEX idx_tblenquiry_artpdid ON tblenquiry (Artpdid);

-- Set AUTO_INCREMENT equivalent (SERIAL already handles auto-increment)
-- If IDs were manually assigned before, set the sequences properly:
SELECT setval('tbladmin_id_seq', COALESCE((SELECT MAX(ID) FROM tbladmin), 1), false);
SELECT setval('tblartist_id_seq', COALESCE((SELECT MAX(ID) FROM tblartist), 10), false);
SELECT setval('tblartmedium_id_seq', COALESCE((SELECT MAX(ID) FROM tblartmedium), 13), false);
SELECT setval('tblartproduct_id_seq', COALESCE((SELECT MAX(ID) FROM tblartproduct), 5), false);
SELECT setval('tblarttype_id_seq', COALESCE((SELECT MAX(ID) FROM tblarttype), 9), false);
SELECT setval('tblenquiry_id_seq', COALESCE((SELECT MAX(ID) FROM tblenquiry), 2), false);
SELECT setval('tblpage_id_seq', COALESCE((SELECT MAX(ID) FROM tblpage), 2), false);
