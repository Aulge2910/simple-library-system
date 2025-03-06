
CREATE TABLE `author` (
  `author_id` int(11) NOT NULL,
  `author_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `author_status` enum('Enable','Disable') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`author_id`, `author_name`, `author_status`) VALUES
(2, 'Alan Forbes', 'Enable'),
(3, 'Lynn Beighley &amp; Michael Morrison', 'Enable');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `rack_id` int(11) NOT NULL,
  `book_name` text COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `isbn` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `no_of_copy` int(5) NOT NULL,
  `book_status` enum('Enable','Disable') COLLATE utf8_unicode_ci NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `category_id`, `author_id`, `rack_id`, `book_name`, `picture`, `publisher_id`,
 `isbn`, `no_of_copy`, `book_status`, `added_on`, `updated_on`) VALUES
(1, 2, 2, 2, 'The Joy of PHP Programming', 'joy-php.jpg', 8, 'B00BALXN70', 10, 'Enable', '2022-06-12 11:12:48', '2022-06-12 11:13:27'),
(2, 2, 3, 2, 'Head First PHP &amp; MySQL', 'header-first-php.jpg', 9, '0596006306', 10, 'Enable', '2022-06-12 11:16:01', '2022-06-12 11:16:01'),
(3, 2, 2, 1, 'dsgsdgsd', '', 7, 'sdfsd2334', 23, 'Enable', '2022-06-12 13:29:14', '2022-06-12 13:29:14');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `category_status` enum('Enable','Disable') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_status`) VALUES
(1, 'Web Design', 'Enable'),
(2, 'Programming', 'Enable'),
(3, 'Commerce', 'Enable'),
(4, 'Math', 'Enable'),
(6, 'Web Development', 'Enable');

-- --------------------------------------------------------

--
-- Table structure for table `issued_book`
--

CREATE TABLE `issued_book` (
  `issuebook_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `issue_date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `expected_return_date` datetime NOT NULL,
  `return_date_time` datetime NOT NULL,
  `issued_book_status` enum('Issued','Returned','Not Return') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `issued_book`
--

INSERT INTO `issued_book` (`issuebook_id`, `book_id`, `user_id`, `issue_date_time`,
 `expected_return_date`, `return_date_time`, `issued_book_status`) VALUES
(1, 2, 2, '2022-06-12 15:33:45', '2022-06-15 16:27:59', '2022-06-16 16:27:59', 'Issued'),
(3, 3, 3, '2022-06-12 18:46:07', '2022-06-30 18:46:02', '2022-06-12 18:46:14', 'Returned');

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `publisher_id` int(11) NOT NULL,
  `publisher_name` varchar(255) NOT NULL,
  `publisher_status` enum('Enable','Disable') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`publisher_id`, `publisher_name`, `publisher_status`) VALUES
(2, 'Amazon publishing', 'Enable'),
(3, 'Penguin books ltd.', 'Enable'),
(4, 'Vintage Publishing', 'Enable'),
(5, 'Macmillan Publishers', 'Enable'),
(6, 'Simon &amp; Schuster', 'Enable'),
(7, 'HarperCollins', 'Enable'),
(8, 'Plum Island', 'Enable'),
(9, 'O’Reilly', 'Enable');

-- --------------------------------------------------------

--
-- Table structure for table `rack`
--

CREATE TABLE `rack` (
  `rack_id` int(11) NOT NULL,
  `rack_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `rack_status` enum('Enable','Disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rack`
--

INSERT INTO `rack` (`rack_id`, `rack_name`, `rack_status`) VALUES
(1, 'R1', 'Enable'),
(2, 'R2', 'Enable');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `role` enum('admin','user') DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`) VALUES
(2, 'Mark', 'Wood', 'mark@phpzag.com', '202cb962ac59075b964b07152d234b70', 'user'),
(3, 'George', 'Smith', 'goerge@phpzag.com', '202cb962ac59075b964b07152d234b70', 'user'),
(4, 'Adam', NULL, 'adam@phpzag.com', '202cb962ac59075b964b07152d234b70', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `issued_book`
--
ALTER TABLE `issued_book`
  ADD PRIMARY KEY (`issuebook_id`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`publisher_id`);

--
-- Indexes for table `rack`
--
ALTER TABLE `rack`
  ADD PRIMARY KEY (`rack_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `issued_book`
--
ALTER TABLE `issued_book`
  MODIFY `issuebook_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `publisher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rack`
--
ALTER TABLE `rack`
  MODIFY `rack_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

