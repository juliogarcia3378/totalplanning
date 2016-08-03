/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100113
Source Host           : localhost:3306
Source Database       : prueba

Target Server Type    : MYSQL
Target Server Version : 100113
File Encoding         : 65001

Date: 2016-07-03 13:18:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for anteproyecto
-- ----------------------------
DROP TABLE IF EXISTS `anteproyecto`;
CREATE TABLE `anteproyecto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periodo` int(11) NOT NULL,
  `periodo_anterior` int(11) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `cambios` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_292667EF7316C4ED` (`periodo`),
  KEY `IDX_292667EF2B38BC54` (`periodo_anterior`),
  KEY `IDX_292667EF265DE1E3` (`estado`),
  CONSTRAINT `FK_292667EF265DE1E3` FOREIGN KEY (`estado`) REFERENCES `estado_periodo` (`id`),
  CONSTRAINT `FK_292667EF2B38BC54` FOREIGN KEY (`periodo_anterior`) REFERENCES `periodo` (`id`),
  CONSTRAINT `FK_292667EF7316C4ED` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of anteproyecto
-- ----------------------------

-- ----------------------------
-- Table structure for aula
-- ----------------------------
DROP TABLE IF EXISTS `aula`;
CREATE TABLE `aula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `activa` tinyint(1) DEFAULT NULL,
  `enlinea` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_31990A43A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of aula
-- ----------------------------
INSERT INTO `aula` VALUES ('1', '1', '1', '1', '1');

-- ----------------------------
-- Table structure for autoasignacion_aula
-- ----------------------------
DROP TABLE IF EXISTS `autoasignacion_aula`;
CREATE TABLE `autoasignacion_aula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aula` int(11) NOT NULL,
  `materia` int(11) DEFAULT NULL,
  `comentario` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_1257E90431990A4` (`aula`),
  KEY `IDX_1257E9046DF05284` (`materia`),
  CONSTRAINT `FK_1257E90431990A4` FOREIGN KEY (`aula`) REFERENCES `aula` (`id`),
  CONSTRAINT `FK_1257E9046DF05284` FOREIGN KEY (`materia`) REFERENCES `materia` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of autoasignacion_aula
-- ----------------------------

-- ----------------------------
-- Table structure for campus
-- ----------------------------
DROP TABLE IF EXISTS `campus`;
CREATE TABLE `campus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of campus
-- ----------------------------

-- ----------------------------
-- Table structure for categoria
-- ----------------------------
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of categoria
-- ----------------------------

-- ----------------------------
-- Table structure for config_html_part
-- ----------------------------
DROP TABLE IF EXISTS `config_html_part`;
CREATE TABLE `config_html_part` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `html` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of config_html_part
-- ----------------------------
INSERT INTO `config_html_part` VALUES ('1', 'portada_html', '<p>sdfsdf</p><p>sdf</p><p>s</p><p>df</p><p>sdf</p><p><br></p><p><img alt=\"\" data-cke-saved-src=\"http://localhost/totalplanning/web/tmp/ef41b855f355229fd1fc2dff2303360a.jpeg\" src=\"http://localhost/totalplanning/web/tmp/ef41b855f355229fd1fc2dff2303360a.jpeg\" style=\"width: 720px; height: 123px;\"><br></p>');

-- ----------------------------
-- Table structure for descarga_administrativa
-- ----------------------------
DROP TABLE IF EXISTS `descarga_administrativa`;
CREATE TABLE `descarga_administrativa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periodo` int(11) NOT NULL,
  `profesor` int(11) NOT NULL,
  `comentario` longtext COLLATE utf8_unicode_ci,
  `tipoDescarga` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_84B1A64FE10842E5` (`tipoDescarga`),
  KEY `IDX_84B1A64F7316C4ED` (`periodo`),
  KEY `IDX_84B1A64F5B7406D9` (`profesor`),
  CONSTRAINT `FK_84B1A64F5B7406D9` FOREIGN KEY (`profesor`) REFERENCES `profesor` (`id`),
  CONSTRAINT `FK_84B1A64F7316C4ED` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`),
  CONSTRAINT `FK_84B1A64FE10842E5` FOREIGN KEY (`tipoDescarga`) REFERENCES `tipo_descarga_administrativa` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of descarga_administrativa
-- ----------------------------

-- ----------------------------
-- Table structure for dia
-- ----------------------------
DROP TABLE IF EXISTS `dia`;
CREATE TABLE `dia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of dia
-- ----------------------------

-- ----------------------------
-- Table structure for estado
-- ----------------------------
DROP TABLE IF EXISTS `estado`;
CREATE TABLE `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of estado
-- ----------------------------

-- ----------------------------
-- Table structure for estado_civil
-- ----------------------------
DROP TABLE IF EXISTS `estado_civil`;
CREATE TABLE `estado_civil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of estado_civil
-- ----------------------------

-- ----------------------------
-- Table structure for estado_periodo
-- ----------------------------
DROP TABLE IF EXISTS `estado_periodo`;
CREATE TABLE `estado_periodo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of estado_periodo
-- ----------------------------

-- ----------------------------
-- Table structure for estudiante
-- ----------------------------
DROP TABLE IF EXISTS `estudiante`;
CREATE TABLE `estudiante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genero` int(11) NOT NULL,
  `nombres` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `foto` longtext COLLATE utf8_unicode_ci,
  `correo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel_celular` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of estudiante
-- ----------------------------

-- ----------------------------
-- Table structure for grupo_estudiantes
-- ----------------------------
DROP TABLE IF EXISTS `grupo_estudiantes`;
CREATE TABLE `grupo_estudiantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `enlinea` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A253CF7BE7976762` (`turno`),
  KEY `IDX_A253CF7B31990A4` (`aula`),
  KEY `IDX_A253CF7B347D0797` (`licenciatura`),
  KEY `IDX_A253CF7B71688FBC` (`semestre`),
  KEY `IDX_A253CF7B7316C4ED` (`periodo`),
  KEY `IDX_A253CF7B9D096811` (`campus`),
  KEY `IDX_A253CF7B1B45221` (`plan_estudio`),
  CONSTRAINT `FK_A253CF7B1B45221` FOREIGN KEY (`plan_estudio`) REFERENCES `plan_estudio` (`id`),
  CONSTRAINT `FK_A253CF7B31990A4` FOREIGN KEY (`aula`) REFERENCES `aula` (`id`),
  CONSTRAINT `FK_A253CF7B347D0797` FOREIGN KEY (`licenciatura`) REFERENCES `licenciatura` (`id`),
  CONSTRAINT `FK_A253CF7B71688FBC` FOREIGN KEY (`semestre`) REFERENCES `semestre` (`id`),
  CONSTRAINT `FK_A253CF7B7316C4ED` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`),
  CONSTRAINT `FK_A253CF7B9D096811` FOREIGN KEY (`campus`) REFERENCES `campus` (`id`),
  CONSTRAINT `FK_A253CF7BE7976762` FOREIGN KEY (`turno`) REFERENCES `turno` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of grupo_estudiantes
-- ----------------------------

-- ----------------------------
-- Table structure for grupo_estudiantes_cambio
-- ----------------------------
DROP TABLE IF EXISTS `grupo_estudiantes_cambio`;
CREATE TABLE `grupo_estudiantes_cambio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anterior` int(11) DEFAULT NULL,
  `actual` int(11) DEFAULT NULL,
  `anteproyecto` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1FEEB5BBB9D500DE` (`anterior`),
  UNIQUE KEY `UNIQ_1FEEB5BB227D9A24` (`actual`),
  KEY `IDX_1FEEB5BB292667EF` (`anteproyecto`),
  CONSTRAINT `FK_1FEEB5BB227D9A24` FOREIGN KEY (`actual`) REFERENCES `grupo_estudiantes` (`id`),
  CONSTRAINT `FK_1FEEB5BB292667EF` FOREIGN KEY (`anteproyecto`) REFERENCES `anteproyecto` (`id`),
  CONSTRAINT `FK_1FEEB5BBB9D500DE` FOREIGN KEY (`anterior`) REFERENCES `grupo_estudiantes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of grupo_estudiantes_cambio
-- ----------------------------

-- ----------------------------
-- Table structure for grupo_horario_anteproyecto
-- ----------------------------
DROP TABLE IF EXISTS `grupo_horario_anteproyecto`;
CREATE TABLE `grupo_horario_anteproyecto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `materia` int(11) DEFAULT NULL,
  `hora_periodo` int(11) DEFAULT NULL,
  `grupo_estudiantes` int(11) DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `aula` int(11) DEFAULT NULL,
  `profe_periodo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B3EF59BF6DF05284` (`materia`),
  KEY `IDX_B3EF59BF4D7F84DC` (`hora_periodo`),
  KEY `IDX_B3EF59BFA253CF7B` (`grupo_estudiantes`),
  KEY `IDX_B3EF59BF3E153BCE` (`dia`),
  KEY `IDX_B3EF59BF31990A4` (`aula`),
  KEY `IDX_B3EF59BF16AC0DB6` (`profe_periodo`),
  CONSTRAINT `FK_B3EF59BF16AC0DB6` FOREIGN KEY (`profe_periodo`) REFERENCES `profe_periodo` (`id`),
  CONSTRAINT `FK_B3EF59BF31990A4` FOREIGN KEY (`aula`) REFERENCES `aula` (`id`),
  CONSTRAINT `FK_B3EF59BF3E153BCE` FOREIGN KEY (`dia`) REFERENCES `dia` (`id`),
  CONSTRAINT `FK_B3EF59BF4D7F84DC` FOREIGN KEY (`hora_periodo`) REFERENCES `hora_periodo` (`id`),
  CONSTRAINT `FK_B3EF59BF6DF05284` FOREIGN KEY (`materia`) REFERENCES `materia` (`id`),
  CONSTRAINT `FK_B3EF59BFA253CF7B` FOREIGN KEY (`grupo_estudiantes`) REFERENCES `grupo_estudiantes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of grupo_horario_anteproyecto
-- ----------------------------

-- ----------------------------
-- Table structure for grupo_permiso
-- ----------------------------
DROP TABLE IF EXISTS `grupo_permiso`;
CREATE TABLE `grupo_permiso` (
  `grupo` int(11) NOT NULL,
  `permiso` bigint(20) NOT NULL,
  PRIMARY KEY (`grupo`,`permiso`),
  KEY `IDX_A27325398C0E9BD3` (`grupo`),
  KEY `IDX_A2732539FD7AAB9E` (`permiso`),
  CONSTRAINT `FK_A27325398C0E9BD3` FOREIGN KEY (`grupo`) REFERENCES `security_grupo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A2732539FD7AAB9E` FOREIGN KEY (`permiso`) REFERENCES `permiso` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of grupo_permiso
-- ----------------------------

-- ----------------------------
-- Table structure for historico_materia_manual
-- ----------------------------
DROP TABLE IF EXISTS `historico_materia_manual`;
CREATE TABLE `historico_materia_manual` (
  `profe_periodo` int(11) NOT NULL,
  `materia` int(11) NOT NULL,
  PRIMARY KEY (`profe_periodo`,`materia`),
  KEY `IDX_549168B016AC0DB6` (`profe_periodo`),
  KEY `IDX_549168B06DF05284` (`materia`),
  CONSTRAINT `FK_549168B016AC0DB6` FOREIGN KEY (`profe_periodo`) REFERENCES `profe_periodo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_549168B06DF05284` FOREIGN KEY (`materia`) REFERENCES `materia` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of historico_materia_manual
-- ----------------------------

-- ----------------------------
-- Table structure for hora
-- ----------------------------
DROP TABLE IF EXISTS `hora`;
CREATE TABLE `hora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hora` time NOT NULL,
  `activa` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BBE1C6573A909126` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hora
-- ----------------------------

-- ----------------------------
-- Table structure for hora_dia
-- ----------------------------
DROP TABLE IF EXISTS `hora_dia`;
CREATE TABLE `hora_dia` (
  `hora` int(11) NOT NULL,
  `dia` int(11) NOT NULL,
  PRIMARY KEY (`hora`,`dia`),
  KEY `IDX_AB505774BBE1C657` (`hora`),
  KEY `IDX_AB5057743E153BCE` (`dia`),
  CONSTRAINT `FK_AB5057743E153BCE` FOREIGN KEY (`dia`) REFERENCES `dia` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_AB505774BBE1C657` FOREIGN KEY (`hora`) REFERENCES `hora` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hora_dia
-- ----------------------------

-- ----------------------------
-- Table structure for hora_periodo
-- ----------------------------
DROP TABLE IF EXISTS `hora_periodo`;
CREATE TABLE `hora_periodo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periodo` int(11) DEFAULT NULL,
  `turno` int(11) DEFAULT NULL,
  `hora_time` time NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4D7F84DC7316C4ED` (`periodo`),
  KEY `IDX_4D7F84DCE7976762` (`turno`),
  CONSTRAINT `FK_4D7F84DC7316C4ED` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`),
  CONSTRAINT `FK_4D7F84DCE7976762` FOREIGN KEY (`turno`) REFERENCES `turno` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hora_periodo
-- ----------------------------

-- ----------------------------
-- Table structure for idioma
-- ----------------------------
DROP TABLE IF EXISTS `idioma`;
CREATE TABLE `idioma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1DC85E0C3A909126` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of idioma
-- ----------------------------

-- ----------------------------
-- Table structure for idioma_profe
-- ----------------------------
DROP TABLE IF EXISTS `idioma_profe`;
CREATE TABLE `idioma_profe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idioma` int(11) DEFAULT NULL,
  `profesor` int(11) DEFAULT NULL,
  `porciento` int(11) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6EEC01A91DC85E0C` (`idioma`),
  KEY `IDX_6EEC01A95B7406D9` (`profesor`),
  CONSTRAINT `FK_6EEC01A91DC85E0C` FOREIGN KEY (`idioma`) REFERENCES `idioma` (`id`),
  CONSTRAINT `FK_6EEC01A95B7406D9` FOREIGN KEY (`profesor`) REFERENCES `profesor` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of idioma_profe
-- ----------------------------

-- ----------------------------
-- Table structure for licenciatura
-- ----------------------------
DROP TABLE IF EXISTS `licenciatura`;
CREATE TABLE `licenciatura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of licenciatura
-- ----------------------------

-- ----------------------------
-- Table structure for maestria_doctorado
-- ----------------------------
DROP TABLE IF EXISTS `maestria_doctorado`;
CREATE TABLE `maestria_doctorado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profesor` int(11) DEFAULT NULL,
  `pasante` tinyint(1) DEFAULT NULL,
  `titulado` tinyint(1) DEFAULT NULL,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FBA0032C5B7406D9` (`profesor`),
  CONSTRAINT `FK_FBA0032C5B7406D9` FOREIGN KEY (`profesor`) REFERENCES `profesor` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of maestria_doctorado
-- ----------------------------

-- ----------------------------
-- Table structure for materia
-- ----------------------------
DROP TABLE IF EXISTS `materia`;
CREATE TABLE `materia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semestre` int(11) DEFAULT NULL,
  `plan_estudio` int(11) DEFAULT NULL,
  `tipo_materia` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `frecuencia_semanal` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `horas_extra` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6DF0528471688FBC` (`semestre`),
  KEY `IDX_6DF052841B45221` (`plan_estudio`),
  KEY `IDX_6DF052847E097324` (`tipo_materia`),
  CONSTRAINT `FK_6DF052841B45221` FOREIGN KEY (`plan_estudio`) REFERENCES `plan_estudio` (`id`),
  CONSTRAINT `FK_6DF0528471688FBC` FOREIGN KEY (`semestre`) REFERENCES `semestre` (`id`),
  CONSTRAINT `FK_6DF052847E097324` FOREIGN KEY (`tipo_materia`) REFERENCES `tipo_materia` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of materia
-- ----------------------------

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_padre` bigint(20) DEFAULT NULL,
  `denominacion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `permiso` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ruta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7D053A933DE02BDB` (`id_padre`),
  CONSTRAINT `FK_7D053A933DE02BDB` FOREIGN KEY (`id_padre`) REFERENCES `menu` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=304 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('-1', '-1', 'Menu', 'IS_AUTHENTICATED_ANONYMOUSLY', null, null);
INSERT INTO `menu` VALUES ('1', '-1', 'Configuración', 'IS_AUTHENTICATED_ANONYMOUSLY', null, null);
INSERT INTO `menu` VALUES ('2', '-1', 'Profesores', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_profesor', null);
INSERT INTO `menu` VALUES ('3', '-1', 'Seguridad', 'ROLE_ADMINISTRADOR', null, null);
INSERT INTO `menu` VALUES ('101', '1', 'Materias', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_materia', null);
INSERT INTO `menu` VALUES ('102', '1', 'Idiomas', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_idioma', null);
INSERT INTO `menu` VALUES ('103', '1', 'Planes de estudio', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_planEstudio', null);
INSERT INTO `menu` VALUES ('104', '1', 'Grupos', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_grupo', null);
INSERT INTO `menu` VALUES ('105', '1', 'Horas por período', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_hora_periodo', null);
INSERT INTO `menu` VALUES ('106', '1', 'Aulas', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_aula', null);
INSERT INTO `menu` VALUES ('107', '1', 'Períodos', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_periodo', null);
INSERT INTO `menu` VALUES ('108', '1', 'Turnos', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_turno', null);
INSERT INTO `menu` VALUES ('109', '1', 'Horas', 'IS_AUTHENTICATED_ANONYMOUSLY', 'planeacion_admin_crud_hora', null);
INSERT INTO `menu` VALUES ('301', '3', 'Usuarios', 'ROLE_ADMINISTRADOR', 'security_crud_user', null);
INSERT INTO `menu` VALUES ('302', '3', 'Roles', 'ROLE_ADMINISTRADOR', 'security_crud_group', null);
INSERT INTO `menu` VALUES ('303', '3', 'Permisos', 'NO_SHOW', 'security_crud_permission', null);

-- ----------------------------
-- Table structure for periodo
-- ----------------------------
DROP TABLE IF EXISTS `periodo`;
CREATE TABLE `periodo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_periodo` int(11) DEFAULT NULL,
  `anno` int(11) DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7316C4ED60EFE54D` (`tipo_periodo`),
  CONSTRAINT `FK_7316C4ED60EFE54D` FOREIGN KEY (`tipo_periodo`) REFERENCES `tipo_periodo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of periodo
-- ----------------------------

-- ----------------------------
-- Table structure for permiso
-- ----------------------------
DROP TABLE IF EXISTS `permiso`;
CREATE TABLE `permiso` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `padre` bigint(20) DEFAULT NULL,
  `denominacion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `permiso` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FD7AAB9ED3656AEB` (`padre`),
  CONSTRAINT `FK_FD7AAB9ED3656AEB` FOREIGN KEY (`padre`) REFERENCES `permiso` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permiso
-- ----------------------------
INSERT INTO `permiso` VALUES ('-1', '-1', 'Todos los permisos', 'Todos los permisos', '0');
INSERT INTO `permiso` VALUES ('4', '-1', 'Gestionar configuración', 'ROLE_GESTIONAR_CONFIGURACION', '0');
INSERT INTO `permiso` VALUES ('5', '-1', 'Gestionar profesores', 'ROLE_GESTIONAR_PROFESOR', '0');
INSERT INTO `permiso` VALUES ('6', '-1', 'Administrar sistema', 'ROLE_ADMINISTRADOR', '0');

-- ----------------------------
-- Table structure for plan_estudio
-- ----------------------------
DROP TABLE IF EXISTS `plan_estudio`;
CREATE TABLE `plan_estudio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `licenciatura` int(11) DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1B45221347D0797` (`licenciatura`),
  CONSTRAINT `FK_1B45221347D0797` FOREIGN KEY (`licenciatura`) REFERENCES `licenciatura` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of plan_estudio
-- ----------------------------

-- ----------------------------
-- Table structure for preferencia_profe_hora
-- ----------------------------
DROP TABLE IF EXISTS `preferencia_profe_hora`;
CREATE TABLE `preferencia_profe_hora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profe` int(11) DEFAULT NULL,
  `hora` int(11) DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `orden_preferencia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B231734EB332AA2E` (`profe`),
  KEY `IDX_B231734EBBE1C657` (`hora`),
  KEY `IDX_B231734E3E153BCE` (`dia`),
  CONSTRAINT `FK_B231734E3E153BCE` FOREIGN KEY (`dia`) REFERENCES `dia` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_B231734EB332AA2E` FOREIGN KEY (`profe`) REFERENCES `profesor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_B231734EBBE1C657` FOREIGN KEY (`hora`) REFERENCES `hora` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of preferencia_profe_hora
-- ----------------------------

-- ----------------------------
-- Table structure for preferencia_profe_materia
-- ----------------------------
DROP TABLE IF EXISTS `preferencia_profe_materia`;
CREATE TABLE `preferencia_profe_materia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `materia` int(11) DEFAULT NULL,
  `profe` int(11) DEFAULT NULL,
  `orden_preferencia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6166425B6DF05284` (`materia`),
  KEY `IDX_6166425BB332AA2E` (`profe`),
  CONSTRAINT `FK_6166425B6DF05284` FOREIGN KEY (`materia`) REFERENCES `materia` (`id`),
  CONSTRAINT `FK_6166425BB332AA2E` FOREIGN KEY (`profe`) REFERENCES `profesor` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of preferencia_profe_materia
-- ----------------------------

-- ----------------------------
-- Table structure for profesor
-- ----------------------------
DROP TABLE IF EXISTS `profesor`;
CREATE TABLE `profesor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `tel_nextel` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5B7406D9CF1ECD30` (`carrera`),
  KEY `IDX_5B7406D94E10122D` (`categoria`),
  KEY `IDX_5B7406D9F4222D84` (`estado_civil`),
  KEY `IDX_5B7406D92265B05D` (`usuario`),
  CONSTRAINT `FK_5B7406D92265B05D` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE SET NULL,
  CONSTRAINT `FK_5B7406D94E10122D` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id`),
  CONSTRAINT `FK_5B7406D9CF1ECD30` FOREIGN KEY (`carrera`) REFERENCES `licenciatura` (`id`),
  CONSTRAINT `FK_5B7406D9F4222D84` FOREIGN KEY (`estado_civil`) REFERENCES `estado_civil` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of profesor
-- ----------------------------

-- ----------------------------
-- Table structure for profe_periodo
-- ----------------------------
DROP TABLE IF EXISTS `profe_periodo`;
CREATE TABLE `profe_periodo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periodo` int(11) NOT NULL,
  `categoria` int(11) DEFAULT NULL,
  `profesor` int(11) DEFAULT NULL,
  `antiguedad` int(11) NOT NULL,
  `horas_cubrir` int(11) NOT NULL,
  `horas_asignadas` int(11) NOT NULL,
  `descarga_ant` int(11) DEFAULT NULL,
  `descarga_admva` int(11) DEFAULT NULL,
  `asistencia_sem_anterior` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_16AC0DB67316C4ED` (`periodo`),
  KEY `IDX_16AC0DB64E10122D` (`categoria`),
  KEY `IDX_16AC0DB65B7406D9` (`profesor`),
  CONSTRAINT `FK_16AC0DB64E10122D` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id`),
  CONSTRAINT `FK_16AC0DB65B7406D9` FOREIGN KEY (`profesor`) REFERENCES `profesor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_16AC0DB67316C4ED` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of profe_periodo
-- ----------------------------

-- ----------------------------
-- Table structure for profe_periodo_horario
-- ----------------------------
DROP TABLE IF EXISTS `profe_periodo_horario`;
CREATE TABLE `profe_periodo_horario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profe_periodo` int(11) DEFAULT NULL,
  `materia` int(11) DEFAULT NULL,
  `hora_periodo` int(11) DEFAULT NULL,
  `grupo_estudiantes` int(11) DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `aula` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6620BF8916AC0DB6` (`profe_periodo`),
  KEY `IDX_6620BF896DF05284` (`materia`),
  KEY `IDX_6620BF894D7F84DC` (`hora_periodo`),
  KEY `IDX_6620BF89A253CF7B` (`grupo_estudiantes`),
  KEY `IDX_6620BF893E153BCE` (`dia`),
  KEY `IDX_6620BF8931990A4` (`aula`),
  CONSTRAINT `FK_6620BF8916AC0DB6` FOREIGN KEY (`profe_periodo`) REFERENCES `profe_periodo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_6620BF8931990A4` FOREIGN KEY (`aula`) REFERENCES `aula` (`id`),
  CONSTRAINT `FK_6620BF893E153BCE` FOREIGN KEY (`dia`) REFERENCES `dia` (`id`),
  CONSTRAINT `FK_6620BF894D7F84DC` FOREIGN KEY (`hora_periodo`) REFERENCES `hora_periodo` (`id`),
  CONSTRAINT `FK_6620BF896DF05284` FOREIGN KEY (`materia`) REFERENCES `materia` (`id`),
  CONSTRAINT `FK_6620BF89A253CF7B` FOREIGN KEY (`grupo_estudiantes`) REFERENCES `grupo_estudiantes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of profe_periodo_horario
-- ----------------------------

-- ----------------------------
-- Table structure for profe_periodo_materia
-- ----------------------------
DROP TABLE IF EXISTS `profe_periodo_materia`;
CREATE TABLE `profe_periodo_materia` (
  `profe_periodo` int(11) NOT NULL,
  `materia` int(11) NOT NULL,
  PRIMARY KEY (`profe_periodo`,`materia`),
  KEY `IDX_E988BEAE16AC0DB6` (`profe_periodo`),
  KEY `IDX_E988BEAE6DF05284` (`materia`),
  CONSTRAINT `FK_E988BEAE16AC0DB6` FOREIGN KEY (`profe_periodo`) REFERENCES `profe_periodo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_E988BEAE6DF05284` FOREIGN KEY (`materia`) REFERENCES `materia` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of profe_periodo_materia
-- ----------------------------

-- ----------------------------
-- Table structure for security_grupo
-- ----------------------------
DROP TABLE IF EXISTS `security_grupo`;
CREATE TABLE `security_grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_60B278795E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of security_grupo
-- ----------------------------
INSERT INTO `security_grupo` VALUES ('1', 'Profesor', 'a:1:{i:0;s:28:\"ROLE_GESTIONAR_CONFIGURACION\";}');
INSERT INTO `security_grupo` VALUES ('6', 'Administrador', 'a:3:{i:0;s:18:\"ROLE_ADMINISTRADOR\";i:1;s:23:\"ROLE_GESTIONAR_PROFESOR\";i:2;s:28:\"ROLE_GESTIONAR_CONFIGURACION\";}');
INSERT INTO `security_grupo` VALUES ('7', 'Gestor de configuración', 'a:3:{i:0;s:18:\"ROLE_ADMINISTRADOR\";i:1;s:23:\"ROLE_GESTIONAR_PROFESOR\";i:2;s:28:\"ROLE_GESTIONAR_CONFIGURACION\";}');
INSERT INTO `security_grupo` VALUES ('8', 'Planificador', 'a:3:{i:0;s:18:\"ROLE_ADMINISTRADOR\";i:1;s:23:\"ROLE_GESTIONAR_PROFESOR\";i:2;s:28:\"ROLE_GESTIONAR_CONFIGURACION\";}');
INSERT INTO `security_grupo` VALUES ('9', 'Super administrador', 'a:2:{i:0;s:23:\"ROLE_GESTIONAR_PROFESOR\";i:1;s:28:\"ROLE_GESTIONAR_CONFIGURACION\";}');

-- ----------------------------
-- Table structure for semestre
-- ----------------------------
DROP TABLE IF EXISTS `semestre`;
CREATE TABLE `semestre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ordinal` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of semestre
-- ----------------------------

-- ----------------------------
-- Table structure for tipo_descarga_administrativa
-- ----------------------------
DROP TABLE IF EXISTS `tipo_descarga_administrativa`;
CREATE TABLE `tipo_descarga_administrativa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tipo_descarga_administrativa
-- ----------------------------

-- ----------------------------
-- Table structure for tipo_materia
-- ----------------------------
DROP TABLE IF EXISTS `tipo_materia`;
CREATE TABLE `tipo_materia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tipo_materia
-- ----------------------------

-- ----------------------------
-- Table structure for tipo_periodo
-- ----------------------------
DROP TABLE IF EXISTS `tipo_periodo`;
CREATE TABLE `tipo_periodo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tipo_periodo
-- ----------------------------

-- ----------------------------
-- Table structure for turno
-- ----------------------------
DROP TABLE IF EXISTS `turno`;
CREATE TABLE `turno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `activa` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E79767623A909126` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of turno
-- ----------------------------

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `cedula` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2265B05DF85E0677` (`username`),
  UNIQUE KEY `UNIQ_2265B05D92FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_2265B05DE7927C74` (`email`),
  UNIQUE KEY `UNIQ_2265B05DA0D96FBF` (`email_canonical`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES ('41', 'tmp', 'tmp', 'paco@gmail.com', 'paco@gmail.com', '1', 'kxpz903nplwwgk4sowkg0ow04kk448o', 'waKYAoW/ZWRxRptZp/SaGBA7O636czMnaUsfVr02CGuTXlHvhJYSpskUiWXiJ3gX0Xg8gsml08dmUk1H+vVX3A==', '2016-07-03 20:25:43', '0', '0', '2016-09-09 00:00:00', 'N', '0000-00-00 00:00:00', 'a:1:{i:0;s:18:\"TODOS LOS PERMISOS\";}', '0', '2016-09-09 00:00:00', 'paco', 'gj049s6mihvd6urs11qegsvs21', 'paco', '000000');

-- ----------------------------
-- Table structure for usuario_grupo
-- ----------------------------
DROP TABLE IF EXISTS `usuario_grupo`;
CREATE TABLE `usuario_grupo` (
  `usuario` int(11) NOT NULL,
  `grupo` int(11) NOT NULL,
  PRIMARY KEY (`usuario`,`grupo`),
  KEY `IDX_91D0F1CD2265B05D` (`usuario`),
  KEY `IDX_91D0F1CD8C0E9BD3` (`grupo`),
  CONSTRAINT `FK_91D0F1CD2265B05D` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_91D0F1CD8C0E9BD3` FOREIGN KEY (`grupo`) REFERENCES `security_grupo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of usuario_grupo
-- ----------------------------
INSERT INTO `usuario_grupo` VALUES ('41', '1');
INSERT INTO `usuario_grupo` VALUES ('41', '6');
INSERT INTO `usuario_grupo` VALUES ('41', '7');
INSERT INTO `usuario_grupo` VALUES ('41', '8');
INSERT INTO `usuario_grupo` VALUES ('41', '9');

-- ----------------------------
-- Table structure for usuario_permiso
-- ----------------------------
DROP TABLE IF EXISTS `usuario_permiso`;
CREATE TABLE `usuario_permiso` (
  `usuario` int(11) NOT NULL,
  `permiso` bigint(20) NOT NULL,
  PRIMARY KEY (`usuario`,`permiso`),
  KEY `IDX_845C01D92265B05D` (`usuario`),
  KEY `IDX_845C01D9FD7AAB9E` (`permiso`),
  CONSTRAINT `FK_845C01D92265B05D` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_845C01D9FD7AAB9E` FOREIGN KEY (`permiso`) REFERENCES `permiso` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of usuario_permiso
-- ----------------------------
INSERT INTO `usuario_permiso` VALUES ('41', '-1');
SET FOREIGN_KEY_CHECKS=1;
