-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2016 at 06:19 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prueba`
--

-- --------------------------------------------------------

--
-- Table structure for table `anteproyecto`
--

CREATE TABLE `anteproyecto` (
  `id` int(11) NOT NULL,
  `periodo` int(11) NOT NULL,
  `periodo_anterior` int(11) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `cambios` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aprovalstatus`
--

CREATE TABLE `aprovalstatus` (
  `id` bigint(20) NOT NULL,
  `AprovalStatus` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aula`
--

CREATE TABLE `aula` (
  `id` int(11) NOT NULL,
  `nombre` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `activa` tinyint(1) DEFAULT NULL,
  `enlinea` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `aula`
--

INSERT INTO `aula` (`id`, `nombre`, `capacidad`, `activa`, `enlinea`) VALUES
(1, '1', 1, 1, 1),
(2, '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `autoasignacion_aula`
--

CREATE TABLE `autoasignacion_aula` (
  `id` int(11) NOT NULL,
  `aula` int(11) NOT NULL,
  `materia` int(11) DEFAULT NULL,
  `comentario` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

CREATE TABLE `campus` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carrera`
--

CREATE TABLE `carrera` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `center`
--

CREATE TABLE `center` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `typeCenter` bigint(20) NOT NULL,
  `country` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config_html_part`
--

CREATE TABLE `config_html_part` (
  `id` bigint(20) NOT NULL,
  `denominacion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `html` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `config_html_part`
--

INSERT INTO `config_html_part` (`id`, `denominacion`, `html`) VALUES
(1, 'portada_html', '<p>sdfsdf</p><p>sdf</p><p>s</p><p>df</p><p>sdf</p><p><br></p><p><img alt="" data-cke-saved-src="http://localhost/totalplanning/web/tmp/ef41b855f355229fd1fc2dff2303360a.jpeg" src="http://localhost/totalplanning/web/tmp/ef41b855f355229fd1fc2dff2303360a.jpeg" style="width: 720px; height: 123px;"><br></p>');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `country_code`, `country_name`) VALUES
(427, 'RO', 'Romania'),
(426, 'RE', 'Reunion'),
(425, 'QA', 'Qatar'),
(424, 'PR', 'Puerto Rico'),
(423, 'PT', 'Portugal'),
(422, 'PL', 'Poland'),
(421, 'PN', 'Pitcairn'),
(420, 'PH', 'Philippines'),
(419, 'PE', 'Peru'),
(418, 'PY', 'Paraguay'),
(417, 'PG', 'Papua New Guinea'),
(416, 'PA', 'Panama'),
(415, 'PS', 'Palestine'),
(414, 'PW', 'Palau'),
(413, 'PK', 'Pakistan'),
(412, 'OM', 'Oman'),
(411, 'NO', 'Norway'),
(410, 'MP', 'Northern Mariana Islands'),
(409, 'NF', 'Norfolk Island'),
(408, 'NU', 'Niue'),
(407, 'NG', 'Nigeria'),
(406, 'NE', 'Niger'),
(405, 'NI', 'Nicaragua'),
(404, 'NZ', 'New Zealand'),
(403, 'NC', 'New Caledonia'),
(402, 'AN', 'Netherlands Antilles'),
(401, 'NL', 'Netherlands'),
(400, 'NP', 'Nepal'),
(399, 'NR', 'Nauru'),
(398, 'NA', 'Namibia'),
(397, 'MM', 'Myanmar'),
(396, 'MZ', 'Mozambique'),
(395, 'MA', 'Morocco'),
(394, 'MS', 'Montserrat'),
(393, 'ME', 'Montenegro'),
(392, 'MN', 'Mongolia'),
(391, 'MC', 'Monaco'),
(390, 'MD', 'Moldova, Republic of'),
(389, 'FM', 'Micronesia, Federated States of'),
(388, 'MX', 'Mexico'),
(387, 'TY', 'Mayotte'),
(386, 'MU', 'Mauritius'),
(385, 'MR', 'Mauritania'),
(384, 'MQ', 'Martinique'),
(383, 'MH', 'Marshall Islands'),
(382, 'MT', 'Malta'),
(381, 'ML', 'Mali'),
(380, 'MV', 'Maldives'),
(379, 'MY', 'Malaysia'),
(378, 'MW', 'Malawi'),
(377, 'MG', 'Madagascar'),
(376, 'MK', 'Macedonia'),
(375, 'MO', 'Macau'),
(374, 'LU', 'Luxembourg'),
(373, 'LT', 'Lithuania'),
(372, 'LI', 'Liechtenstein'),
(371, 'LY', 'Libyan Arab Jamahiriya'),
(370, 'LR', 'Liberia'),
(369, 'LS', 'Lesotho'),
(368, 'LB', 'Lebanon'),
(367, 'LV', 'Latvia'),
(366, 'LA', 'Lao People''s Democratic Republic'),
(365, 'KG', 'Kyrgyzstan'),
(364, 'KW', 'Kuwait'),
(363, 'XK', 'Kosovo'),
(362, 'KR', 'Korea, Republic of'),
(361, 'KP', 'Korea, Democratic People''s Republic of'),
(360, 'KI', 'Kiribati'),
(359, 'KE', 'Kenya'),
(358, 'KZ', 'Kazakhstan'),
(357, 'JO', 'Jordan'),
(356, 'JP', 'Japan'),
(355, 'JM', 'Jamaica'),
(354, 'JE', 'Jersey'),
(353, 'CI', 'Ivory Coast'),
(352, 'IT', 'Italy'),
(351, 'IL', 'Israel'),
(350, 'IE', 'Ireland'),
(349, 'IQ', 'Iraq'),
(348, 'IR', 'Iran (Islamic Republic of)'),
(347, 'ID', 'Indonesia'),
(346, 'IM', 'Isle of Man'),
(345, 'IN', 'India'),
(344, 'IS', 'Iceland'),
(343, 'HU', 'Hungary'),
(342, 'HK', 'Hong Kong'),
(341, 'HN', 'Honduras'),
(340, 'HM', 'Heard and Mc Donald Islands'),
(339, 'HT', 'Haiti'),
(338, 'GY', 'Guyana'),
(337, 'GW', 'Guinea-Bissau'),
(336, 'GN', 'Guinea'),
(335, 'GT', 'Guatemala'),
(334, 'GU', 'Guam'),
(333, 'GP', 'Guadeloupe'),
(332, 'GD', 'Grenada'),
(331, 'GL', 'Greenland'),
(330, 'GR', 'Greece'),
(329, 'GK', 'Guernsey'),
(328, 'GI', 'Gibraltar'),
(327, 'GH', 'Ghana'),
(326, 'DE', 'Germany'),
(325, 'GE', 'Georgia'),
(324, 'GM', 'Gambia'),
(323, 'GA', 'Gabon'),
(322, 'TF', 'French Southern Territories'),
(321, 'PF', 'French Polynesia'),
(320, 'GF', 'French Guiana'),
(319, 'FX', 'France, Metropolitan'),
(318, 'FR', 'France'),
(317, 'FI', 'Finland'),
(316, 'FJ', 'Fiji'),
(315, 'FO', 'Faroe Islands'),
(314, 'FK', 'Falkland Islands (Malvinas)'),
(313, 'ET', 'Ethiopia'),
(312, 'EE', 'Estonia'),
(311, 'ER', 'Eritrea'),
(310, 'GQ', 'Equatorial Guinea'),
(309, 'SV', 'El Salvador'),
(308, 'EG', 'Egypt'),
(307, 'EC', 'Ecuador'),
(306, 'TP', 'East Timor'),
(305, 'DO', 'Dominican Republic'),
(304, 'DM', 'Dominica'),
(303, 'DJ', 'Djibouti'),
(302, 'DK', 'Denmark'),
(301, 'CZ', 'Czech Republic'),
(300, 'CY', 'Cyprus'),
(299, 'CU', 'Cuba'),
(298, 'HR', 'Croatia (Hrvatska)'),
(297, 'CR', 'Costa Rica'),
(296, 'CK', 'Cook Islands'),
(295, 'CG', 'Congo'),
(294, 'KM', 'Comoros'),
(293, 'CO', 'Colombia'),
(292, 'CC', 'Cocos (Keeling) Islands'),
(291, 'CX', 'Christmas Island'),
(290, 'CN', 'China'),
(289, 'CL', 'Chile'),
(288, 'TD', 'Chad'),
(287, 'CF', 'Central African Republic'),
(286, 'KY', 'Cayman Islands'),
(285, 'CV', 'Cape Verde'),
(284, 'CA', 'Canada'),
(283, 'CM', 'Cameroon'),
(282, 'KH', 'Cambodia'),
(281, 'BI', 'Burundi'),
(280, 'BF', 'Burkina Faso'),
(279, 'BG', 'Bulgaria'),
(278, 'BN', 'Brunei Darussalam'),
(277, 'IO', 'British Indian Ocean Territory'),
(276, 'BR', 'Brazil'),
(275, 'BV', 'Bouvet Island'),
(274, 'BW', 'Botswana'),
(273, 'BA', 'Bosnia and Herzegovina'),
(272, 'BO', 'Bolivia'),
(271, 'BT', 'Bhutan'),
(270, 'BM', 'Bermuda'),
(269, 'BJ', 'Benin'),
(268, 'BZ', 'Belize'),
(267, 'BE', 'Belgium'),
(266, 'BY', 'Belarus'),
(265, 'BB', 'Barbados'),
(264, 'BD', 'Bangladesh'),
(263, 'BH', 'Bahrain'),
(262, 'BS', 'Bahamas'),
(261, 'AZ', 'Azerbaijan'),
(260, 'AT', 'Austria'),
(259, 'AU', 'Australia'),
(258, 'AW', 'Aruba'),
(257, 'AM', 'Armenia'),
(256, 'AR', 'Argentina'),
(255, 'AG', 'Antigua and Barbuda'),
(254, 'AQ', 'Antarctica'),
(253, 'AI', 'Anguilla'),
(252, 'AO', 'Angola'),
(251, 'AD', 'Andorra'),
(250, 'DS', 'American Samoa'),
(249, 'DZ', 'Algeria'),
(248, 'AL', 'Albania'),
(247, 'AF', 'Afghanistan'),
(428, 'RU', 'Russian Federation'),
(429, 'RW', 'Rwanda'),
(430, 'KN', 'Saint Kitts and Nevis'),
(431, 'LC', 'Saint Lucia'),
(432, 'VC', 'Saint Vincent and the Grenadines'),
(433, 'WS', 'Samoa'),
(434, 'SM', 'San Marino'),
(435, 'ST', 'Sao Tome and Principe'),
(436, 'SA', 'Saudi Arabia'),
(437, 'SN', 'Senegal'),
(438, 'RS', 'Serbia'),
(439, 'SC', 'Seychelles'),
(440, 'SL', 'Sierra Leone'),
(441, 'SG', 'Singapore'),
(442, 'SK', 'Slovakia'),
(443, 'SI', 'Slovenia'),
(444, 'SB', 'Solomon Islands'),
(445, 'SO', 'Somalia'),
(446, 'ZA', 'South Africa'),
(447, 'GS', 'South Georgia South Sandwich Islands'),
(448, 'ES', 'Spain'),
(449, 'LK', 'Sri Lanka'),
(450, 'SH', 'St. Helena'),
(451, 'PM', 'St. Pierre and Miquelon'),
(452, 'SD', 'Sudan'),
(453, 'SR', 'Suriname'),
(454, 'SJ', 'Svalbard and Jan Mayen Islands'),
(455, 'SZ', 'Swaziland'),
(456, 'SE', 'Sweden'),
(457, 'CH', 'Switzerland'),
(458, 'SY', 'Syrian Arab Republic'),
(459, 'TW', 'Taiwan'),
(460, 'TJ', 'Tajikistan'),
(461, 'TZ', 'Tanzania, United Republic of'),
(462, 'TH', 'Thailand'),
(463, 'TG', 'Togo'),
(464, 'TK', 'Tokelau'),
(465, 'TO', 'Tonga'),
(466, 'TT', 'Trinidad and Tobago'),
(467, 'TN', 'Tunisia'),
(468, 'TR', 'Turkey'),
(469, 'TM', 'Turkmenistan'),
(470, 'TC', 'Turks and Caicos Islands'),
(471, 'TV', 'Tuvalu'),
(472, 'UG', 'Uganda'),
(473, 'UA', 'Ukraine'),
(474, 'AE', 'United Arab Emirates'),
(475, 'GB', 'United Kingdom'),
(476, 'US', 'United States'),
(477, 'UM', 'United States minor outlying islands'),
(478, 'UY', 'Uruguay'),
(479, 'UZ', 'Uzbekistan'),
(480, 'VU', 'Vanuatu'),
(481, 'VA', 'Vatican City State'),
(482, 'VE', 'Venezuela'),
(483, 'VN', 'Vietnam'),
(484, 'VG', 'Virgin Islands (British)'),
(485, 'VI', 'Virgin Islands (U.S.)'),
(486, 'WF', 'Wallis and Futuna Islands'),
(487, 'EH', 'Western Sahara'),
(488, 'YE', 'Yemen'),
(489, 'YU', 'Yugoslavia'),
(490, 'ZR', 'Zaire'),
(491, 'ZM', 'Zambia'),
(492, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `descarga_administrativa`
--

CREATE TABLE `descarga_administrativa` (
  `id` int(11) NOT NULL,
  `periodo` int(11) NOT NULL,
  `profesor` int(11) NOT NULL,
  `comentario` longtext COLLATE utf8_unicode_ci,
  `tipoDescarga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dia`
--

CREATE TABLE `dia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estado`
--

CREATE TABLE `estado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estado_civil`
--

CREATE TABLE `estado_civil` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estado_periodo`
--

CREATE TABLE `estado_periodo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estudiante`
--

CREATE TABLE `estudiante` (
  `id` int(11) NOT NULL,
  `genero` int(11) NOT NULL,
  `nombres` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `foto` longtext COLLATE utf8_unicode_ci,
  `correo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel_celular` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grupo_estudiantes`
--

CREATE TABLE `grupo_estudiantes` (
  `id` int(11) NOT NULL,
  `turno` int(11) DEFAULT NULL,
  `aula` int(11) DEFAULT NULL,
  `licenciatura` int(11) DEFAULT NULL,
  `semestre` int(11) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `campus` int(11) NOT NULL,
  `plan_estudio` int(11) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `nombre_completo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `aula_string` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bilingue` tinyint(1) NOT NULL,
  `terceros` tinyint(1) NOT NULL,
  `paquete` tinyint(1) DEFAULT NULL,
  `enlinea` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grupo_estudiantes_cambio`
--

CREATE TABLE `grupo_estudiantes_cambio` (
  `id` int(11) NOT NULL,
  `anterior` int(11) DEFAULT NULL,
  `actual` int(11) DEFAULT NULL,
  `anteproyecto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grupo_horario_anteproyecto`
--

CREATE TABLE `grupo_horario_anteproyecto` (
  `id` int(11) NOT NULL,
  `materia` int(11) DEFAULT NULL,
  `hora_periodo` int(11) DEFAULT NULL,
  `grupo_estudiantes` int(11) DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `aula` int(11) DEFAULT NULL,
  `profe_periodo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grupo_permiso`
--

CREATE TABLE `grupo_permiso` (
  `grupo` int(11) NOT NULL,
  `permiso` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historico_materia_manual`
--

CREATE TABLE `historico_materia_manual` (
  `profe_periodo` int(11) NOT NULL,
  `materia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hora`
--

CREATE TABLE `hora` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hora` time NOT NULL,
  `activa` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hora_dia`
--

CREATE TABLE `hora_dia` (
  `hora` int(11) NOT NULL,
  `dia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hora_periodo`
--

CREATE TABLE `hora_periodo` (
  `id` int(11) NOT NULL,
  `periodo` int(11) DEFAULT NULL,
  `turno` int(11) DEFAULT NULL,
  `hora_time` time NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `idioma`
--

CREATE TABLE `idioma` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `idioma_profe`
--

CREATE TABLE `idioma_profe` (
  `id` int(11) NOT NULL,
  `idioma` int(11) DEFAULT NULL,
  `profesor` int(11) DEFAULT NULL,
  `porciento` int(11) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `licenciatura`
--

CREATE TABLE `licenciatura` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maestria_doctorado`
--

CREATE TABLE `maestria_doctorado` (
  `id` int(11) NOT NULL,
  `profesor` int(11) DEFAULT NULL,
  `pasante` tinyint(1) DEFAULT NULL,
  `titulado` tinyint(1) DEFAULT NULL,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materia`
--

CREATE TABLE `materia` (
  `id` int(11) NOT NULL,
  `semestre` int(11) DEFAULT NULL,
  `plan_estudio` int(11) DEFAULT NULL,
  `tipo_materia` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `frecuencia_semanal` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `horas_extra` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` bigint(20) NOT NULL,
  `id_padre` bigint(20) DEFAULT NULL,
  `denominacion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `permiso` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ruta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `id_padre`, `denominacion`, `permiso`, `ruta`, `icon`) VALUES
(-1, -1, 'Menu', 'IS_AUTHENTICATED_ANONYMOUSLY', NULL, NULL),
(1, -1, 'Configuración', 'IS_AUTHENTICATED_ANONYMOUSLY', NULL, NULL),
(2, -1, 'Profesores', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_profesor', NULL),
(3, -1, 'Seguridad', 'ROLE_ADMINISTRADOR', NULL, NULL),
(101, 1, 'Materias', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_materia', NULL),
(102, 1, 'Idiomas', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_idioma', NULL),
(103, 1, 'Planes de estudio', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_planEstudio', NULL),
(104, 1, 'Grupos', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_grupo', NULL),
(105, 1, 'Horas por período', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_hora_periodo', NULL),
(106, 1, 'Aulas', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_aula', NULL),
(107, 1, 'Períodos', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_periodo', NULL),
(108, 1, 'Turnos', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_turno', NULL),
(109, 1, 'Horas', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_hora', NULL),
(301, 3, 'Usuarios', 'ROLE_ADMINISTRADOR', 'security_crud_user', NULL),
(302, 3, 'Roles', 'ROLE_ADMINISTRADOR', 'security_crud_group', NULL),
(303, 3, 'Permisos', 'NO_SHOW', 'security_crud_permission', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `perfilacademico`
--

CREATE TABLE `perfilacademico` (
  `id` int(11) NOT NULL,
  `perfil` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `periodo`
--

CREATE TABLE `periodo` (
  `id` int(11) NOT NULL,
  `tipo_periodo` int(11) DEFAULT NULL,
  `anno` int(11) DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permiso`
--

CREATE TABLE `permiso` (
  `id` bigint(20) NOT NULL,
  `padre` bigint(20) DEFAULT NULL,
  `denominacion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `permiso` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permiso`
--

INSERT INTO `permiso` (`id`, `padre`, `denominacion`, `permiso`, `activo`) VALUES
(-1, -1, 'Todos los permisos', 'Todos los permisos', 0),
(4, -1, 'Gestionar configuración', 'ROLE_GESTIONAR_CONFIGURACION', 0),
(5, -1, 'Gestionar profesores', 'ROLE_GESTIONAR_PROFESOR', 0),
(6, -1, 'Administrar sistema', 'ROLE_ADMINISTRADOR', 0);

-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `carrera` int(11) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `genero` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `foto` longtext COLLATE utf8_unicode_ci,
  `inactivo` tinyint(1) DEFAULT NULL,
  `correo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domicilio` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `perfil` longtext COLLATE utf8_unicode_ci,
  `discr` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan_estudio`
--

CREATE TABLE `plan_estudio` (
  `id` int(11) NOT NULL,
  `licenciatura` int(11) DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` bigint(20) NOT NULL,
  `position` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `position`) VALUES
(1, 'Director'),
(2, 'Principal'),
(3, 'Jefe de Departamento');

-- --------------------------------------------------------

--
-- Table structure for table `preferencia_profe_hora`
--

CREATE TABLE `preferencia_profe_hora` (
  `id` int(11) NOT NULL,
  `profe` int(11) DEFAULT NULL,
  `hora` int(11) DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `orden_preferencia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `preferencia_profe_materia`
--

CREATE TABLE `preferencia_profe_materia` (
  `id` int(11) NOT NULL,
  `materia` int(11) DEFAULT NULL,
  `profe` int(11) DEFAULT NULL,
  `orden_preferencia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profesor`
--

CREATE TABLE `profesor` (
  `id` int(11) NOT NULL,
  `carrera` int(11) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  `estado_civil` int(11) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `tel_lugar_labora` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_labora` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `genero` int(11) NOT NULL,
  `nombre_conyugue` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero_empleado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `fehca_ingreso_fac` date DEFAULT NULL,
  `foto` longtext COLLATE utf8_unicode_ci,
  `inactivo` tinyint(1) DEFAULT NULL,
  `linares` tinyint(1) DEFAULT NULL,
  `sabina` tinyint(1) DEFAULT NULL,
  `correo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lugar_labora` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_ingreso_uanl` date DEFAULT NULL,
  `domicilio` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `perfil` longtext COLLATE utf8_unicode_ci,
  `tel_particular` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `licenciatura_en` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel_celular` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel_nextel` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profe_periodo`
--

CREATE TABLE `profe_periodo` (
  `id` int(11) NOT NULL,
  `periodo` int(11) NOT NULL,
  `categoria` int(11) DEFAULT NULL,
  `profesor` int(11) DEFAULT NULL,
  `antiguedad` int(11) NOT NULL,
  `horas_cubrir` int(11) NOT NULL,
  `horas_asignadas` int(11) NOT NULL,
  `descarga_ant` int(11) DEFAULT NULL,
  `descarga_admva` int(11) DEFAULT NULL,
  `asistencia_sem_anterior` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profe_periodo_horario`
--

CREATE TABLE `profe_periodo_horario` (
  `id` int(11) NOT NULL,
  `profe_periodo` int(11) DEFAULT NULL,
  `materia` int(11) DEFAULT NULL,
  `hora_periodo` int(11) DEFAULT NULL,
  `grupo_estudiantes` int(11) DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `aula` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profe_periodo_materia`
--

CREATE TABLE `profe_periodo_materia` (
  `profe_periodo` int(11) NOT NULL,
  `materia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_grupo`
--

CREATE TABLE `security_grupo` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `security_grupo`
--

INSERT INTO `security_grupo` (`id`, `name`, `roles`) VALUES
(1, 'Profesor', 'a:1:{i:0;s:28:"ROLE_GESTIONAR_CONFIGURACION";}'),
(6, 'Administrador', 'a:3:{i:0;s:18:"ROLE_ADMINISTRADOR";i:1;s:23:"ROLE_GESTIONAR_PROFESOR";i:2;s:28:"ROLE_GESTIONAR_CONFIGURACION";}'),
(7, 'Gestor de configuración', 'a:3:{i:0;s:18:"ROLE_ADMINISTRADOR";i:1;s:23:"ROLE_GESTIONAR_PROFESOR";i:2;s:28:"ROLE_GESTIONAR_CONFIGURACION";}'),
(8, 'Planificador', 'a:3:{i:0;s:18:"ROLE_ADMINISTRADOR";i:1;s:23:"ROLE_GESTIONAR_PROFESOR";i:2;s:28:"ROLE_GESTIONAR_CONFIGURACION";}'),
(9, 'Super administrador', 'a:2:{i:0;s:23:"ROLE_GESTIONAR_PROFESOR";i:1;s:28:"ROLE_GESTIONAR_CONFIGURACION";}');

-- --------------------------------------------------------

--
-- Table structure for table `semestre`
--

CREATE TABLE `semestre` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ordinal` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_descarga_administrativa`
--

CREATE TABLE `tipo_descarga_administrativa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_materia`
--

CREATE TABLE `tipo_materia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_periodo`
--

CREATE TABLE `tipo_periodo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `turno`
--

CREATE TABLE `turno` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `activa` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `typecenter`
--

CREATE TABLE `typecenter` (
  `id` bigint(20) NOT NULL,
  `typeCenter` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonic_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cedula` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `nombre`, `token`, `canonic_name`, `cedula`) VALUES
(41, 'tmp', 'tmp', 'paco@gmail.com', 'paco@gmail.com', 1, 'kxpz903nplwwgk4sowkg0ow04kk448o', 'waKYAoW/ZWRxRptZp/SaGBA7O636czMnaUsfVr02CGuTXlHvhJYSpskUiWXiJ3gX0Xg8gsml08dmUk1H+vVX3A==', '2016-07-14 19:04:14', 0, 0, '2016-09-09 00:00:00', 'N', '0000-00-00 00:00:00', 'a:1:{i:0;s:18:"TODOS LOS PERMISOS";}', 0, '2016-09-09 00:00:00', 'paco', 'ko9kcqqu3ctglqspb9ebi02mv7', 'paco', '000000');

-- --------------------------------------------------------

--
-- Table structure for table `usuario_grupo`
--

CREATE TABLE `usuario_grupo` (
  `usuario` int(11) NOT NULL,
  `grupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usuario_grupo`
--

INSERT INTO `usuario_grupo` (`usuario`, `grupo`) VALUES
(41, 1),
(41, 6),
(41, 7),
(41, 8),
(41, 9);

-- --------------------------------------------------------

--
-- Table structure for table `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `usuario` int(11) NOT NULL,
  `permiso` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`usuario`, `permiso`) VALUES
(41, -1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anteproyecto`
--
ALTER TABLE `anteproyecto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_292667EF7316C4ED` (`periodo`),
  ADD KEY `IDX_292667EF2B38BC54` (`periodo_anterior`),
  ADD KEY `IDX_292667EF265DE1E3` (`estado`);

--
-- Indexes for table `aprovalstatus`
--
ALTER TABLE `aprovalstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aula`
--
ALTER TABLE `aula`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_31990A43A909126` (`nombre`);

--
-- Indexes for table `autoasignacion_aula`
--
ALTER TABLE `autoasignacion_aula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1257E90431990A4` (`aula`),
  ADD KEY `IDX_1257E9046DF05284` (`materia`);

--
-- Indexes for table `campus`
--
ALTER TABLE `campus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `center`
--
ALTER TABLE `center`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_40F0EB24C3688579` (`typeCenter`);

--
-- Indexes for table `config_html_part`
--
ALTER TABLE `config_html_part`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `descarga_administrativa`
--
ALTER TABLE `descarga_administrativa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_84B1A64FE10842E5` (`tipoDescarga`),
  ADD KEY `IDX_84B1A64F7316C4ED` (`periodo`),
  ADD KEY `IDX_84B1A64F5B7406D9` (`profesor`);

--
-- Indexes for table `dia`
--
ALTER TABLE `dia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estado_civil`
--
ALTER TABLE `estado_civil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estado_periodo`
--
ALTER TABLE `estado_periodo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grupo_estudiantes`
--
ALTER TABLE `grupo_estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A253CF7BE7976762` (`turno`),
  ADD KEY `IDX_A253CF7B31990A4` (`aula`),
  ADD KEY `IDX_A253CF7B347D0797` (`licenciatura`),
  ADD KEY `IDX_A253CF7B71688FBC` (`semestre`),
  ADD KEY `IDX_A253CF7B7316C4ED` (`periodo`),
  ADD KEY `IDX_A253CF7B9D096811` (`campus`),
  ADD KEY `IDX_A253CF7B1B45221` (`plan_estudio`);

--
-- Indexes for table `grupo_estudiantes_cambio`
--
ALTER TABLE `grupo_estudiantes_cambio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1FEEB5BBB9D500DE` (`anterior`),
  ADD UNIQUE KEY `UNIQ_1FEEB5BB227D9A24` (`actual`),
  ADD KEY `IDX_1FEEB5BB292667EF` (`anteproyecto`);

--
-- Indexes for table `grupo_horario_anteproyecto`
--
ALTER TABLE `grupo_horario_anteproyecto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B3EF59BF6DF05284` (`materia`),
  ADD KEY `IDX_B3EF59BF4D7F84DC` (`hora_periodo`),
  ADD KEY `IDX_B3EF59BFA253CF7B` (`grupo_estudiantes`),
  ADD KEY `IDX_B3EF59BF3E153BCE` (`dia`),
  ADD KEY `IDX_B3EF59BF31990A4` (`aula`),
  ADD KEY `IDX_B3EF59BF16AC0DB6` (`profe_periodo`);

--
-- Indexes for table `grupo_permiso`
--
ALTER TABLE `grupo_permiso`
  ADD PRIMARY KEY (`grupo`,`permiso`),
  ADD KEY `IDX_A27325398C0E9BD3` (`grupo`),
  ADD KEY `IDX_A2732539FD7AAB9E` (`permiso`);

--
-- Indexes for table `historico_materia_manual`
--
ALTER TABLE `historico_materia_manual`
  ADD PRIMARY KEY (`profe_periodo`,`materia`),
  ADD KEY `IDX_549168B016AC0DB6` (`profe_periodo`),
  ADD KEY `IDX_549168B06DF05284` (`materia`);

--
-- Indexes for table `hora`
--
ALTER TABLE `hora`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_BBE1C6573A909126` (`nombre`);

--
-- Indexes for table `hora_dia`
--
ALTER TABLE `hora_dia`
  ADD PRIMARY KEY (`hora`,`dia`),
  ADD KEY `IDX_AB505774BBE1C657` (`hora`),
  ADD KEY `IDX_AB5057743E153BCE` (`dia`);

--
-- Indexes for table `hora_periodo`
--
ALTER TABLE `hora_periodo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4D7F84DC7316C4ED` (`periodo`),
  ADD KEY `IDX_4D7F84DCE7976762` (`turno`);

--
-- Indexes for table `idioma`
--
ALTER TABLE `idioma`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1DC85E0C3A909126` (`nombre`);

--
-- Indexes for table `idioma_profe`
--
ALTER TABLE `idioma_profe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6EEC01A91DC85E0C` (`idioma`),
  ADD KEY `IDX_6EEC01A95B7406D9` (`profesor`);

--
-- Indexes for table `licenciatura`
--
ALTER TABLE `licenciatura`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maestria_doctorado`
--
ALTER TABLE `maestria_doctorado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FBA0032C5B7406D9` (`profesor`);

--
-- Indexes for table `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6DF0528471688FBC` (`semestre`),
  ADD KEY `IDX_6DF052841B45221` (`plan_estudio`),
  ADD KEY `IDX_6DF052847E097324` (`tipo_materia`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7D053A933DE02BDB` (`id_padre`);

--
-- Indexes for table `perfilacademico`
--
ALTER TABLE `perfilacademico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periodo`
--
ALTER TABLE `periodo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7316C4ED60EFE54D` (`tipo_periodo`);

--
-- Indexes for table `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FD7AAB9ED3656AEB` (`padre`);

--
-- Indexes for table `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9E588F07CF1ECD30` (`carrera`),
  ADD KEY `IDX_9E588F072265B05D` (`usuario`);

--
-- Indexes for table `plan_estudio`
--
ALTER TABLE `plan_estudio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1B45221347D0797` (`licenciatura`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preferencia_profe_hora`
--
ALTER TABLE `preferencia_profe_hora`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B231734EB332AA2E` (`profe`),
  ADD KEY `IDX_B231734EBBE1C657` (`hora`),
  ADD KEY `IDX_B231734E3E153BCE` (`dia`);

--
-- Indexes for table `preferencia_profe_materia`
--
ALTER TABLE `preferencia_profe_materia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6166425B6DF05284` (`materia`),
  ADD KEY `IDX_6166425BB332AA2E` (`profe`);

--
-- Indexes for table `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5B7406D9CF1ECD30` (`carrera`),
  ADD KEY `IDX_5B7406D94E10122D` (`categoria`),
  ADD KEY `IDX_5B7406D9F4222D84` (`estado_civil`),
  ADD KEY `IDX_5B7406D92265B05D` (`usuario`);

--
-- Indexes for table `profe_periodo`
--
ALTER TABLE `profe_periodo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_16AC0DB67316C4ED` (`periodo`),
  ADD KEY `IDX_16AC0DB64E10122D` (`categoria`),
  ADD KEY `IDX_16AC0DB65B7406D9` (`profesor`);

--
-- Indexes for table `profe_periodo_horario`
--
ALTER TABLE `profe_periodo_horario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6620BF8916AC0DB6` (`profe_periodo`),
  ADD KEY `IDX_6620BF896DF05284` (`materia`),
  ADD KEY `IDX_6620BF894D7F84DC` (`hora_periodo`),
  ADD KEY `IDX_6620BF89A253CF7B` (`grupo_estudiantes`),
  ADD KEY `IDX_6620BF893E153BCE` (`dia`),
  ADD KEY `IDX_6620BF8931990A4` (`aula`);

--
-- Indexes for table `profe_periodo_materia`
--
ALTER TABLE `profe_periodo_materia`
  ADD PRIMARY KEY (`profe_periodo`,`materia`),
  ADD KEY `IDX_E988BEAE16AC0DB6` (`profe_periodo`),
  ADD KEY `IDX_E988BEAE6DF05284` (`materia`);

--
-- Indexes for table `security_grupo`
--
ALTER TABLE `security_grupo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_60B278795E237E06` (`name`);

--
-- Indexes for table `semestre`
--
ALTER TABLE `semestre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_descarga_administrativa`
--
ALTER TABLE `tipo_descarga_administrativa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_materia`
--
ALTER TABLE `tipo_materia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_periodo`
--
ALTER TABLE `tipo_periodo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_E79767623A909126` (`nombre`);

--
-- Indexes for table `typecenter`
--
ALTER TABLE `typecenter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2265B05DF85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_2265B05D92FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_2265B05DE7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_2265B05DA0D96FBF` (`email_canonical`);

--
-- Indexes for table `usuario_grupo`
--
ALTER TABLE `usuario_grupo`
  ADD PRIMARY KEY (`usuario`,`grupo`),
  ADD KEY `IDX_91D0F1CD2265B05D` (`usuario`),
  ADD KEY `IDX_91D0F1CD8C0E9BD3` (`grupo`);

--
-- Indexes for table `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`usuario`,`permiso`),
  ADD KEY `IDX_845C01D92265B05D` (`usuario`),
  ADD KEY `IDX_845C01D9FD7AAB9E` (`permiso`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anteproyecto`
--
ALTER TABLE `anteproyecto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aprovalstatus`
--
ALTER TABLE `aprovalstatus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aula`
--
ALTER TABLE `aula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `autoasignacion_aula`
--
ALTER TABLE `autoasignacion_aula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `campus`
--
ALTER TABLE `campus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `carrera`
--
ALTER TABLE `carrera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `center`
--
ALTER TABLE `center`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `config_html_part`
--
ALTER TABLE `config_html_part`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=493;
--
-- AUTO_INCREMENT for table `descarga_administrativa`
--
ALTER TABLE `descarga_administrativa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dia`
--
ALTER TABLE `dia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `estado_civil`
--
ALTER TABLE `estado_civil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `estado_periodo`
--
ALTER TABLE `estado_periodo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `grupo_estudiantes`
--
ALTER TABLE `grupo_estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `grupo_estudiantes_cambio`
--
ALTER TABLE `grupo_estudiantes_cambio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `grupo_horario_anteproyecto`
--
ALTER TABLE `grupo_horario_anteproyecto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hora`
--
ALTER TABLE `hora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hora_periodo`
--
ALTER TABLE `hora_periodo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `idioma`
--
ALTER TABLE `idioma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `idioma_profe`
--
ALTER TABLE `idioma_profe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `licenciatura`
--
ALTER TABLE `licenciatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `maestria_doctorado`
--
ALTER TABLE `maestria_doctorado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `materia`
--
ALTER TABLE `materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;
--
-- AUTO_INCREMENT for table `perfilacademico`
--
ALTER TABLE `perfilacademico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `periodo`
--
ALTER TABLE `periodo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `plan_estudio`
--
ALTER TABLE `plan_estudio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `preferencia_profe_hora`
--
ALTER TABLE `preferencia_profe_hora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `preferencia_profe_materia`
--
ALTER TABLE `preferencia_profe_materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profesor`
--
ALTER TABLE `profesor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profe_periodo`
--
ALTER TABLE `profe_periodo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profe_periodo_horario`
--
ALTER TABLE `profe_periodo_horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `security_grupo`
--
ALTER TABLE `security_grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `semestre`
--
ALTER TABLE `semestre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipo_descarga_administrativa`
--
ALTER TABLE `tipo_descarga_administrativa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipo_materia`
--
ALTER TABLE `tipo_materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipo_periodo`
--
ALTER TABLE `tipo_periodo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `turno`
--
ALTER TABLE `turno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `typecenter`
--
ALTER TABLE `typecenter`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `anteproyecto`
--
ALTER TABLE `anteproyecto`
  ADD CONSTRAINT `FK_292667EF265DE1E3` FOREIGN KEY (`estado`) REFERENCES `estado_periodo` (`id`),
  ADD CONSTRAINT `FK_292667EF2B38BC54` FOREIGN KEY (`periodo_anterior`) REFERENCES `periodo` (`id`),
  ADD CONSTRAINT `FK_292667EF7316C4ED` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`);

--
-- Constraints for table `autoasignacion_aula`
--
ALTER TABLE `autoasignacion_aula`
  ADD CONSTRAINT `FK_1257E90431990A4` FOREIGN KEY (`aula`) REFERENCES `aula` (`id`),
  ADD CONSTRAINT `FK_1257E9046DF05284` FOREIGN KEY (`materia`) REFERENCES `materia` (`id`);

--
-- Constraints for table `descarga_administrativa`
--
ALTER TABLE `descarga_administrativa`
  ADD CONSTRAINT `FK_84B1A64F5B7406D9` FOREIGN KEY (`profesor`) REFERENCES `profesor` (`id`),
  ADD CONSTRAINT `FK_84B1A64F7316C4ED` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`),
  ADD CONSTRAINT `FK_84B1A64FE10842E5` FOREIGN KEY (`tipoDescarga`) REFERENCES `tipo_descarga_administrativa` (`id`);

--
-- Constraints for table `grupo_estudiantes`
--
ALTER TABLE `grupo_estudiantes`
  ADD CONSTRAINT `FK_A253CF7B1B45221` FOREIGN KEY (`plan_estudio`) REFERENCES `plan_estudio` (`id`),
  ADD CONSTRAINT `FK_A253CF7B31990A4` FOREIGN KEY (`aula`) REFERENCES `aula` (`id`),
  ADD CONSTRAINT `FK_A253CF7B347D0797` FOREIGN KEY (`licenciatura`) REFERENCES `licenciatura` (`id`),
  ADD CONSTRAINT `FK_A253CF7B71688FBC` FOREIGN KEY (`semestre`) REFERENCES `semestre` (`id`),
  ADD CONSTRAINT `FK_A253CF7B7316C4ED` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`),
  ADD CONSTRAINT `FK_A253CF7B9D096811` FOREIGN KEY (`campus`) REFERENCES `campus` (`id`),
  ADD CONSTRAINT `FK_A253CF7BE7976762` FOREIGN KEY (`turno`) REFERENCES `turno` (`id`);

--
-- Constraints for table `grupo_estudiantes_cambio`
--
ALTER TABLE `grupo_estudiantes_cambio`
  ADD CONSTRAINT `FK_1FEEB5BB227D9A24` FOREIGN KEY (`actual`) REFERENCES `grupo_estudiantes` (`id`),
  ADD CONSTRAINT `FK_1FEEB5BB292667EF` FOREIGN KEY (`anteproyecto`) REFERENCES `anteproyecto` (`id`),
  ADD CONSTRAINT `FK_1FEEB5BBB9D500DE` FOREIGN KEY (`anterior`) REFERENCES `grupo_estudiantes` (`id`);

--
-- Constraints for table `grupo_horario_anteproyecto`
--
ALTER TABLE `grupo_horario_anteproyecto`
  ADD CONSTRAINT `FK_B3EF59BF16AC0DB6` FOREIGN KEY (`profe_periodo`) REFERENCES `profe_periodo` (`id`),
  ADD CONSTRAINT `FK_B3EF59BF31990A4` FOREIGN KEY (`aula`) REFERENCES `aula` (`id`),
  ADD CONSTRAINT `FK_B3EF59BF3E153BCE` FOREIGN KEY (`dia`) REFERENCES `dia` (`id`),
  ADD CONSTRAINT `FK_B3EF59BF4D7F84DC` FOREIGN KEY (`hora_periodo`) REFERENCES `hora_periodo` (`id`),
  ADD CONSTRAINT `FK_B3EF59BF6DF05284` FOREIGN KEY (`materia`) REFERENCES `materia` (`id`),
  ADD CONSTRAINT `FK_B3EF59BFA253CF7B` FOREIGN KEY (`grupo_estudiantes`) REFERENCES `grupo_estudiantes` (`id`);

--
-- Constraints for table `grupo_permiso`
--
ALTER TABLE `grupo_permiso`
  ADD CONSTRAINT `FK_A27325398C0E9BD3` FOREIGN KEY (`grupo`) REFERENCES `security_grupo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A2732539FD7AAB9E` FOREIGN KEY (`permiso`) REFERENCES `permiso` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `historico_materia_manual`
--
ALTER TABLE `historico_materia_manual`
  ADD CONSTRAINT `FK_549168B016AC0DB6` FOREIGN KEY (`profe_periodo`) REFERENCES `profe_periodo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_549168B06DF05284` FOREIGN KEY (`materia`) REFERENCES `materia` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hora_dia`
--
ALTER TABLE `hora_dia`
  ADD CONSTRAINT `FK_AB5057743E153BCE` FOREIGN KEY (`dia`) REFERENCES `dia` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_AB505774BBE1C657` FOREIGN KEY (`hora`) REFERENCES `hora` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hora_periodo`
--
ALTER TABLE `hora_periodo`
  ADD CONSTRAINT `FK_4D7F84DC7316C4ED` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`),
  ADD CONSTRAINT `FK_4D7F84DCE7976762` FOREIGN KEY (`turno`) REFERENCES `turno` (`id`);

--
-- Constraints for table `idioma_profe`
--
ALTER TABLE `idioma_profe`
  ADD CONSTRAINT `FK_6EEC01A91DC85E0C` FOREIGN KEY (`idioma`) REFERENCES `idioma` (`id`),
  ADD CONSTRAINT `FK_6EEC01A95B7406D9` FOREIGN KEY (`profesor`) REFERENCES `profesor` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `maestria_doctorado`
--
ALTER TABLE `maestria_doctorado`
  ADD CONSTRAINT `FK_FBA0032C5B7406D9` FOREIGN KEY (`profesor`) REFERENCES `profesor` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materia`
--
ALTER TABLE `materia`
  ADD CONSTRAINT `FK_6DF052841B45221` FOREIGN KEY (`plan_estudio`) REFERENCES `plan_estudio` (`id`),
  ADD CONSTRAINT `FK_6DF0528471688FBC` FOREIGN KEY (`semestre`) REFERENCES `semestre` (`id`),
  ADD CONSTRAINT `FK_6DF052847E097324` FOREIGN KEY (`tipo_materia`) REFERENCES `tipo_materia` (`id`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `FK_7D053A933DE02BDB` FOREIGN KEY (`id_padre`) REFERENCES `menu` (`id`);

--
-- Constraints for table `periodo`
--
ALTER TABLE `periodo`
  ADD CONSTRAINT `FK_7316C4ED60EFE54D` FOREIGN KEY (`tipo_periodo`) REFERENCES `tipo_periodo` (`id`);

--
-- Constraints for table `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `FK_FD7AAB9ED3656AEB` FOREIGN KEY (`padre`) REFERENCES `permiso` (`id`);

--
-- Constraints for table `plan_estudio`
--
ALTER TABLE `plan_estudio`
  ADD CONSTRAINT `FK_1B45221347D0797` FOREIGN KEY (`licenciatura`) REFERENCES `licenciatura` (`id`);

--
-- Constraints for table `preferencia_profe_hora`
--
ALTER TABLE `preferencia_profe_hora`
  ADD CONSTRAINT `FK_B231734E3E153BCE` FOREIGN KEY (`dia`) REFERENCES `dia` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B231734EB332AA2E` FOREIGN KEY (`profe`) REFERENCES `profesor` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B231734EBBE1C657` FOREIGN KEY (`hora`) REFERENCES `hora` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `preferencia_profe_materia`
--
ALTER TABLE `preferencia_profe_materia`
  ADD CONSTRAINT `FK_6166425B6DF05284` FOREIGN KEY (`materia`) REFERENCES `materia` (`id`),
  ADD CONSTRAINT `FK_6166425BB332AA2E` FOREIGN KEY (`profe`) REFERENCES `profesor` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profesor`
--
ALTER TABLE `profesor`
  ADD CONSTRAINT `FK_5B7406D92265B05D` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_5B7406D94E10122D` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `FK_5B7406D9CF1ECD30` FOREIGN KEY (`carrera`) REFERENCES `licenciatura` (`id`),
  ADD CONSTRAINT `FK_5B7406D9F4222D84` FOREIGN KEY (`estado_civil`) REFERENCES `estado_civil` (`id`);

--
-- Constraints for table `profe_periodo`
--
ALTER TABLE `profe_periodo`
  ADD CONSTRAINT `FK_16AC0DB64E10122D` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `FK_16AC0DB65B7406D9` FOREIGN KEY (`profesor`) REFERENCES `profesor` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_16AC0DB67316C4ED` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`);

--
-- Constraints for table `profe_periodo_horario`
--
ALTER TABLE `profe_periodo_horario`
  ADD CONSTRAINT `FK_6620BF8916AC0DB6` FOREIGN KEY (`profe_periodo`) REFERENCES `profe_periodo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6620BF8931990A4` FOREIGN KEY (`aula`) REFERENCES `aula` (`id`),
  ADD CONSTRAINT `FK_6620BF893E153BCE` FOREIGN KEY (`dia`) REFERENCES `dia` (`id`),
  ADD CONSTRAINT `FK_6620BF894D7F84DC` FOREIGN KEY (`hora_periodo`) REFERENCES `hora_periodo` (`id`),
  ADD CONSTRAINT `FK_6620BF896DF05284` FOREIGN KEY (`materia`) REFERENCES `materia` (`id`),
  ADD CONSTRAINT `FK_6620BF89A253CF7B` FOREIGN KEY (`grupo_estudiantes`) REFERENCES `grupo_estudiantes` (`id`);

--
-- Constraints for table `profe_periodo_materia`
--
ALTER TABLE `profe_periodo_materia`
  ADD CONSTRAINT `FK_E988BEAE16AC0DB6` FOREIGN KEY (`profe_periodo`) REFERENCES `profe_periodo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E988BEAE6DF05284` FOREIGN KEY (`materia`) REFERENCES `materia` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usuario_grupo`
--
ALTER TABLE `usuario_grupo`
  ADD CONSTRAINT `FK_91D0F1CD2265B05D` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_91D0F1CD8C0E9BD3` FOREIGN KEY (`grupo`) REFERENCES `security_grupo` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `FK_845C01D92265B05D` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_845C01D9FD7AAB9E` FOREIGN KEY (`permiso`) REFERENCES `permiso` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
