-- --------------------------------------------------------

--
-- Table structure for table `website_data`
--

CREATE TABLE `website_data` (
  `id` int(11) NOT NULL,
  `url` text NOT NULL,
  `content_length` int(11) NOT NULL,
  `content_email_sent` date NOT NULL,
  `error_email_sent` date NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `website_data`
--

INSERT INTO `website_data` (`id`, `url`, `content_length`, `content_email_sent`, `error_email_sent`, `date_updated`) VALUES
(1, 'https://the-internet.herokuapp.com/status_codes/500', 1738, '0000-00-00', '2024-05-02', '2024-05-02 05:35:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `website_data`
--
ALTER TABLE `website_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `website_data`
--
ALTER TABLE `website_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
