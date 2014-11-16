CREATE TABLE IF NOT EXISTS `tutor` (
  `username` varchar(10) NOT NULL,
  `course` varchar(100) NOT NULL,
  `level` varchar(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS `tutee` (
  `username` varchar(10) NOT NULL,
  `course` varchar(100) NOT NULL,
  `level` varchar(20) NOT NULL
);