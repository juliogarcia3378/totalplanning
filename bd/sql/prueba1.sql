--
-- PostgreSQL database dump
--

-- Dumped from database version 9.4.6
-- Dumped by pg_dump version 9.5.1

-- Started on 2016-03-29 23:57:55

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 7 (class 2615 OID 20535)
-- Name: menu; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA menu;


ALTER SCHEMA menu OWNER TO postgres;

--
-- TOC entry 8 (class 2615 OID 20536)
-- Name: seguridad; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA seguridad;


ALTER SCHEMA seguridad OWNER TO postgres;

--
-- TOC entry 1 (class 3079 OID 11855)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2618 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = menu, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 175 (class 1259 OID 20537)
-- Name: menu; Type: TABLE; Schema: menu; Owner: postgres
--

CREATE TABLE menu (
    id bigint NOT NULL,
    id_padre bigint,
    denominacion character varying(50) NOT NULL,
    permiso character varying(50) DEFAULT NULL::character varying,
    ruta character varying(50) DEFAULT NULL::character varying,
    icon character varying(50) DEFAULT NULL::character varying
);


ALTER TABLE menu OWNER TO postgres;

--
-- TOC entry 176 (class 1259 OID 20543)
-- Name: menu_id_seq; Type: SEQUENCE; Schema: menu; Owner: postgres
--

CREATE SEQUENCE menu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE menu_id_seq OWNER TO postgres;

--
-- TOC entry 2619 (class 0 OID 0)
-- Dependencies: 176
-- Name: menu_id_seq; Type: SEQUENCE OWNED BY; Schema: menu; Owner: postgres
--

ALTER SEQUENCE menu_id_seq OWNED BY menu.id;


SET search_path = public, pg_catalog;

--
-- TOC entry 177 (class 1259 OID 20545)
-- Name: anteproyecto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE anteproyecto (
    id integer NOT NULL,
    periodo integer NOT NULL,
    periodo_anterior integer,
    estado integer NOT NULL,
    cambios text
);


ALTER TABLE anteproyecto OWNER TO postgres;

--
-- TOC entry 178 (class 1259 OID 20551)
-- Name: anteproyecto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE anteproyecto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE anteproyecto_id_seq OWNER TO postgres;

--
-- TOC entry 2620 (class 0 OID 0)
-- Dependencies: 178
-- Name: anteproyecto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE anteproyecto_id_seq OWNED BY anteproyecto.id;


--
-- TOC entry 179 (class 1259 OID 20553)
-- Name: aula; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE aula (
    id integer NOT NULL,
    nombre character varying(10) NOT NULL,
    capacidad integer,
    activa boolean,
    enlinea boolean
);


ALTER TABLE aula OWNER TO postgres;

--
-- TOC entry 180 (class 1259 OID 20556)
-- Name: aula_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE aula_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aula_id_seq OWNER TO postgres;

--
-- TOC entry 2621 (class 0 OID 0)
-- Dependencies: 180
-- Name: aula_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE aula_id_seq OWNED BY aula.id;


--
-- TOC entry 181 (class 1259 OID 20558)
-- Name: autoasignacion_aula; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE autoasignacion_aula (
    id integer NOT NULL,
    aula integer NOT NULL,
    materia integer,
    comentario text
);


ALTER TABLE autoasignacion_aula OWNER TO postgres;

--
-- TOC entry 182 (class 1259 OID 20564)
-- Name: autoasignacion_aula_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE autoasignacion_aula_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE autoasignacion_aula_id_seq OWNER TO postgres;

--
-- TOC entry 2622 (class 0 OID 0)
-- Dependencies: 182
-- Name: autoasignacion_aula_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE autoasignacion_aula_id_seq OWNED BY autoasignacion_aula.id;


--
-- TOC entry 183 (class 1259 OID 20566)
-- Name: campus; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE campus (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL
);


ALTER TABLE campus OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 20569)
-- Name: campus_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE campus_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE campus_id_seq OWNER TO postgres;

--
-- TOC entry 2623 (class 0 OID 0)
-- Dependencies: 184
-- Name: campus_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE campus_id_seq OWNED BY campus.id;


--
-- TOC entry 185 (class 1259 OID 20571)
-- Name: categoria; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE categoria (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL
);


ALTER TABLE categoria OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 20574)
-- Name: categoria_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE categoria_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE categoria_id_seq OWNER TO postgres;

--
-- TOC entry 2624 (class 0 OID 0)
-- Dependencies: 186
-- Name: categoria_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE categoria_id_seq OWNED BY categoria.id;


--
-- TOC entry 187 (class 1259 OID 20576)
-- Name: descarga_administrativa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE descarga_administrativa (
    id integer NOT NULL,
    periodo integer NOT NULL,
    profesor integer NOT NULL,
    comentario text,
    tipodescarga integer
);


ALTER TABLE descarga_administrativa OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 20582)
-- Name: descarga_administrativa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE descarga_administrativa_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE descarga_administrativa_id_seq OWNER TO postgres;

--
-- TOC entry 2625 (class 0 OID 0)
-- Dependencies: 188
-- Name: descarga_administrativa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE descarga_administrativa_id_seq OWNED BY descarga_administrativa.id;


--
-- TOC entry 189 (class 1259 OID 20584)
-- Name: dia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE dia (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL
);


ALTER TABLE dia OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 20587)
-- Name: dia_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE dia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dia_id_seq OWNER TO postgres;

--
-- TOC entry 2626 (class 0 OID 0)
-- Dependencies: 190
-- Name: dia_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE dia_id_seq OWNED BY dia.id;


--
-- TOC entry 191 (class 1259 OID 20589)
-- Name: estado; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE estado (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL
);


ALTER TABLE estado OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 20592)
-- Name: estado_civil; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE estado_civil (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL
);


ALTER TABLE estado_civil OWNER TO postgres;

--
-- TOC entry 193 (class 1259 OID 20595)
-- Name: estado_civil_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE estado_civil_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE estado_civil_id_seq OWNER TO postgres;

--
-- TOC entry 2627 (class 0 OID 0)
-- Dependencies: 193
-- Name: estado_civil_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE estado_civil_id_seq OWNED BY estado_civil.id;


--
-- TOC entry 194 (class 1259 OID 20597)
-- Name: estado_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE estado_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE estado_id_seq OWNER TO postgres;

--
-- TOC entry 2628 (class 0 OID 0)
-- Dependencies: 194
-- Name: estado_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE estado_id_seq OWNED BY estado.id;


--
-- TOC entry 195 (class 1259 OID 20599)
-- Name: estado_periodo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE estado_periodo (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL
);


ALTER TABLE estado_periodo OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 20602)
-- Name: estado_periodo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE estado_periodo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE estado_periodo_id_seq OWNER TO postgres;

--
-- TOC entry 2629 (class 0 OID 0)
-- Dependencies: 196
-- Name: estado_periodo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE estado_periodo_id_seq OWNED BY estado_periodo.id;


--
-- TOC entry 197 (class 1259 OID 20604)
-- Name: grupo_estudiantes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE grupo_estudiantes (
    id integer NOT NULL,
    nombre_completo character varying(50),
    licenciatura integer,
    turno integer,
    periodo integer,
    aula integer,
    semestre integer,
    nivel integer,
    aula_string character varying(50),
    campus integer NOT NULL,
    bilingue boolean NOT NULL,
    terceros boolean NOT NULL,
    plan_estudio integer,
    paquete boolean,
    enlinea boolean
);


ALTER TABLE grupo_estudiantes OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 20607)
-- Name: grupo_estudiantes_cambio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE grupo_estudiantes_cambio (
    id integer NOT NULL,
    anterior integer,
    actual integer,
    anteproyecto integer NOT NULL
);


ALTER TABLE grupo_estudiantes_cambio OWNER TO postgres;

--
-- TOC entry 199 (class 1259 OID 20610)
-- Name: grupo_estudiantes_cambio_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE grupo_estudiantes_cambio_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE grupo_estudiantes_cambio_id_seq OWNER TO postgres;

--
-- TOC entry 2630 (class 0 OID 0)
-- Dependencies: 199
-- Name: grupo_estudiantes_cambio_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE grupo_estudiantes_cambio_id_seq OWNED BY grupo_estudiantes_cambio.id;


--
-- TOC entry 200 (class 1259 OID 20612)
-- Name: grupo_estudiantes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE grupo_estudiantes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE grupo_estudiantes_id_seq OWNER TO postgres;

--
-- TOC entry 2631 (class 0 OID 0)
-- Dependencies: 200
-- Name: grupo_estudiantes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE grupo_estudiantes_id_seq OWNED BY grupo_estudiantes.id;


--
-- TOC entry 201 (class 1259 OID 20614)
-- Name: grupo_horario_anteproyecto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE grupo_horario_anteproyecto (
    id integer NOT NULL,
    materia integer,
    hora_periodo integer,
    grupo_estudiantes integer,
    dia integer,
    aula integer,
    profe_periodo integer
);


ALTER TABLE grupo_horario_anteproyecto OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 20617)
-- Name: grupo_horario_anteproyecto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE grupo_horario_anteproyecto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE grupo_horario_anteproyecto_id_seq OWNER TO postgres;

--
-- TOC entry 2632 (class 0 OID 0)
-- Dependencies: 202
-- Name: grupo_horario_anteproyecto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE grupo_horario_anteproyecto_id_seq OWNED BY grupo_horario_anteproyecto.id;


--
-- TOC entry 203 (class 1259 OID 20619)
-- Name: historico_materia_manual; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE historico_materia_manual (
    profe_periodo integer NOT NULL,
    materia integer NOT NULL
);


ALTER TABLE historico_materia_manual OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 20622)
-- Name: hora; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE hora (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL,
    hora time(0) without time zone NOT NULL,
    activa boolean
);


ALTER TABLE hora OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 20625)
-- Name: hora_dia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE hora_dia (
    hora integer NOT NULL,
    dia integer NOT NULL
);


ALTER TABLE hora_dia OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 20628)
-- Name: hora_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hora_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE hora_id_seq OWNER TO postgres;

--
-- TOC entry 2633 (class 0 OID 0)
-- Dependencies: 206
-- Name: hora_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE hora_id_seq OWNED BY hora.id;


--
-- TOC entry 207 (class 1259 OID 20630)
-- Name: hora_periodo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE hora_periodo (
    id integer NOT NULL,
    periodo integer,
    turno integer,
    hora_time time(0) without time zone DEFAULT NULL::time without time zone NOT NULL,
    nombre character varying(50) DEFAULT NULL::character varying
);


ALTER TABLE hora_periodo OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 20635)
-- Name: hora_periodo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hora_periodo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE hora_periodo_id_seq OWNER TO postgres;

--
-- TOC entry 2634 (class 0 OID 0)
-- Dependencies: 208
-- Name: hora_periodo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE hora_periodo_id_seq OWNED BY hora_periodo.id;


--
-- TOC entry 209 (class 1259 OID 20637)
-- Name: idioma_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE idioma_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE idioma_id_seq OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 20639)
-- Name: idioma; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE idioma (
    id integer DEFAULT nextval('idioma_id_seq'::regclass) NOT NULL,
    nombre character varying(50) NOT NULL
);


ALTER TABLE idioma OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 20643)
-- Name: idioma_profe; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE idioma_profe (
    id integer NOT NULL,
    idioma integer DEFAULT NULL::numeric,
    profesor integer,
    porciento integer,
    numero integer
);


ALTER TABLE idioma_profe OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 20647)
-- Name: idioma_profe_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE idioma_profe_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE idioma_profe_id_seq OWNER TO postgres;

--
-- TOC entry 2635 (class 0 OID 0)
-- Dependencies: 212
-- Name: idioma_profe_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE idioma_profe_id_seq OWNED BY idioma_profe.id;


--
-- TOC entry 213 (class 1259 OID 20649)
-- Name: licenciatura; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE licenciatura (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL
);


ALTER TABLE licenciatura OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 20652)
-- Name: licenciatura_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE licenciatura_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE licenciatura_id_seq OWNER TO postgres;

--
-- TOC entry 2636 (class 0 OID 0)
-- Dependencies: 214
-- Name: licenciatura_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE licenciatura_id_seq OWNED BY licenciatura.id;


--
-- TOC entry 215 (class 1259 OID 20654)
-- Name: maestria_doctorado; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE maestria_doctorado (
    id integer NOT NULL,
    pasante boolean,
    titulado boolean,
    nombre character varying(150) NOT NULL,
    profesor integer,
    tipo integer NOT NULL
);


ALTER TABLE maestria_doctorado OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 20657)
-- Name: maestria_doctorado_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE maestria_doctorado_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE maestria_doctorado_id_seq OWNER TO postgres;

--
-- TOC entry 2637 (class 0 OID 0)
-- Dependencies: 216
-- Name: maestria_doctorado_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE maestria_doctorado_id_seq OWNED BY maestria_doctorado.id;


--
-- TOC entry 217 (class 1259 OID 20659)
-- Name: materia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE materia (
    id integer NOT NULL,
    semestre integer,
    nombre character varying(100) NOT NULL,
    clave character varying(10) NOT NULL,
    frecuencia_semanal integer,
    activo boolean DEFAULT true NOT NULL,
    plan_estudio integer,
    tipo_materia integer NOT NULL,
    horas_extra boolean DEFAULT false NOT NULL
);


ALTER TABLE materia OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 20664)
-- Name: materia_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE materia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE materia_id_seq OWNER TO postgres;

--
-- TOC entry 2638 (class 0 OID 0)
-- Dependencies: 218
-- Name: materia_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE materia_id_seq OWNED BY materia.id;


--
-- TOC entry 219 (class 1259 OID 20666)
-- Name: materia_plan_estudio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE materia_plan_estudio (
    materia integer NOT NULL,
    plan_estudio integer NOT NULL
);


ALTER TABLE materia_plan_estudio OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 20669)
-- Name: periodo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE periodo (
    id integer NOT NULL,
    tipo_periodo integer,
    nombre character varying(50) DEFAULT NULL::character varying,
    anno integer
);


ALTER TABLE periodo OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 20673)
-- Name: periodo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE periodo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE periodo_id_seq OWNER TO postgres;

--
-- TOC entry 2639 (class 0 OID 0)
-- Dependencies: 221
-- Name: periodo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE periodo_id_seq OWNED BY periodo.id;


--
-- TOC entry 222 (class 1259 OID 20675)
-- Name: plan_estudio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE plan_estudio (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL,
    licenciatura integer,
    activo boolean NOT NULL
);


ALTER TABLE plan_estudio OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 20678)
-- Name: plan_estudio_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE plan_estudio_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE plan_estudio_id_seq OWNER TO postgres;

--
-- TOC entry 2640 (class 0 OID 0)
-- Dependencies: 223
-- Name: plan_estudio_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE plan_estudio_id_seq OWNED BY plan_estudio.id;


--
-- TOC entry 224 (class 1259 OID 20680)
-- Name: preferencia_profe_hora; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE preferencia_profe_hora (
    id integer NOT NULL,
    profe integer,
    hora integer,
    orden_preferencia integer,
    dia integer
);


ALTER TABLE preferencia_profe_hora OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 20683)
-- Name: preferencia_profe_hora_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE preferencia_profe_hora_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE preferencia_profe_hora_id_seq OWNER TO postgres;

--
-- TOC entry 2641 (class 0 OID 0)
-- Dependencies: 225
-- Name: preferencia_profe_hora_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE preferencia_profe_hora_id_seq OWNED BY preferencia_profe_hora.id;


--
-- TOC entry 226 (class 1259 OID 20685)
-- Name: preferencia_profe_materia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE preferencia_profe_materia (
    id integer NOT NULL,
    materia integer,
    profe integer,
    orden_preferencia integer
);


ALTER TABLE preferencia_profe_materia OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 20688)
-- Name: preferencia_profe_materia_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE preferencia_profe_materia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE preferencia_profe_materia_id_seq OWNER TO postgres;

--
-- TOC entry 2642 (class 0 OID 0)
-- Dependencies: 227
-- Name: preferencia_profe_materia_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE preferencia_profe_materia_id_seq OWNED BY preferencia_profe_materia.id;


--
-- TOC entry 228 (class 1259 OID 20690)
-- Name: profe_periodo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE profe_periodo (
    id integer NOT NULL,
    periodo integer NOT NULL,
    profesor integer,
    horas_cubrir integer NOT NULL,
    horas_asignadas integer NOT NULL,
    descarga_ant integer,
    descarga_admva integer,
    antiguedad integer NOT NULL,
    asistencia_sem_anterior integer,
    categoria integer
);


ALTER TABLE profe_periodo OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 20693)
-- Name: profe_periodo_horario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE profe_periodo_horario (
    id integer NOT NULL,
    profe_periodo integer,
    materia integer,
    dia integer,
    grupo_estudiantes integer,
    hora_periodo integer,
    aula integer
);


ALTER TABLE profe_periodo_horario OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 20696)
-- Name: profe_periodo_horario_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE profe_periodo_horario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE profe_periodo_horario_id_seq OWNER TO postgres;

--
-- TOC entry 2643 (class 0 OID 0)
-- Dependencies: 230
-- Name: profe_periodo_horario_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE profe_periodo_horario_id_seq OWNED BY profe_periodo_horario.id;


--
-- TOC entry 231 (class 1259 OID 20698)
-- Name: profe_periodo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE profe_periodo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE profe_periodo_id_seq OWNER TO postgres;

--
-- TOC entry 2644 (class 0 OID 0)
-- Dependencies: 231
-- Name: profe_periodo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE profe_periodo_id_seq OWNED BY profe_periodo.id;


--
-- TOC entry 232 (class 1259 OID 20700)
-- Name: profe_periodo_materia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE profe_periodo_materia (
    profe_periodo integer NOT NULL,
    materia integer NOT NULL
);


ALTER TABLE profe_periodo_materia OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 20703)
-- Name: profesor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE profesor (
    id integer NOT NULL,
    categoria integer,
    estado_civil integer,
    tel_lugar_labora character varying(250) DEFAULT NULL::character varying,
    dir_labora character varying(250) DEFAULT NULL::character varying,
    nombre_conyugue character varying(250) DEFAULT NULL::character varying,
    nombre character varying(50) NOT NULL,
    numero_empleado character varying(255),
    fecha_nacimiento date,
    fehca_ingreso_fac date,
    foto text,
    linares boolean,
    sabina boolean,
    correo character varying(250) DEFAULT NULL::character varying,
    facebook character varying(255) DEFAULT NULL::character varying,
    lugar_labora character varying(250) DEFAULT NULL::character varying,
    fecha_ingreso_uanl date,
    domicilio character varying(250) DEFAULT NULL::character varying,
    tel_particular character varying(50) DEFAULT NULL::character varying,
    tel_celular character varying(50) DEFAULT NULL::character varying,
    tel_nextel character varying(50) DEFAULT NULL::character varying,
    licenciatura_en character varying(250) DEFAULT NULL::character varying,
    fecha_actualizacion date,
    perfil text,
    genero integer NOT NULL,
    usuario integer,
    apellidos character varying(50) DEFAULT NULL::character varying,
    fullname character varying(50) DEFAULT NULL::character varying,
    inactivo boolean,
    carrera integer
);


ALTER TABLE profesor OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 20722)
-- Name: profesor_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE profesor_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE profesor_id_seq OWNER TO postgres;

--
-- TOC entry 2645 (class 0 OID 0)
-- Dependencies: 234
-- Name: profesor_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE profesor_id_seq OWNED BY profesor.id;


--
-- TOC entry 235 (class 1259 OID 20724)
-- Name: semestre; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE semestre (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL,
    ordinal character varying(50) DEFAULT NULL::character varying NOT NULL
);


ALTER TABLE semestre OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 20728)
-- Name: semestre_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE semestre_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE semestre_id_seq OWNER TO postgres;

--
-- TOC entry 2646 (class 0 OID 0)
-- Dependencies: 236
-- Name: semestre_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE semestre_id_seq OWNED BY semestre.id;


--
-- TOC entry 237 (class 1259 OID 20730)
-- Name: tipo_descarga_administrativa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE tipo_descarga_administrativa (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL
);


ALTER TABLE tipo_descarga_administrativa OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 20733)
-- Name: tipo_descarga_administrativa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipo_descarga_administrativa_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tipo_descarga_administrativa_id_seq OWNER TO postgres;

--
-- TOC entry 2647 (class 0 OID 0)
-- Dependencies: 238
-- Name: tipo_descarga_administrativa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tipo_descarga_administrativa_id_seq OWNED BY tipo_descarga_administrativa.id;


--
-- TOC entry 239 (class 1259 OID 20735)
-- Name: tipo_materia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE tipo_materia (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL
);


ALTER TABLE tipo_materia OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 20738)
-- Name: tipo_materia_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipo_materia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tipo_materia_id_seq OWNER TO postgres;

--
-- TOC entry 2648 (class 0 OID 0)
-- Dependencies: 240
-- Name: tipo_materia_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tipo_materia_id_seq OWNED BY tipo_materia.id;


--
-- TOC entry 241 (class 1259 OID 20740)
-- Name: tipo_periodo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE tipo_periodo (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL
);


ALTER TABLE tipo_periodo OWNER TO postgres;

--
-- TOC entry 242 (class 1259 OID 20743)
-- Name: tipo_periodo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipo_periodo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tipo_periodo_id_seq OWNER TO postgres;

--
-- TOC entry 2649 (class 0 OID 0)
-- Dependencies: 242
-- Name: tipo_periodo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tipo_periodo_id_seq OWNED BY tipo_periodo.id;


--
-- TOC entry 243 (class 1259 OID 20745)
-- Name: turno; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE turno (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL,
    activa boolean
);


ALTER TABLE turno OWNER TO postgres;

--
-- TOC entry 244 (class 1259 OID 20748)
-- Name: turno_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE turno_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE turno_id_seq OWNER TO postgres;

--
-- TOC entry 2650 (class 0 OID 0)
-- Dependencies: 244
-- Name: turno_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE turno_id_seq OWNED BY turno.id;


SET search_path = seguridad, pg_catalog;

--
-- TOC entry 245 (class 1259 OID 20750)
-- Name: grupo_id_seq; Type: SEQUENCE; Schema: seguridad; Owner: postgres
--

CREATE SEQUENCE grupo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE grupo_id_seq OWNER TO postgres;

--
-- TOC entry 246 (class 1259 OID 20752)
-- Name: grupo; Type: TABLE; Schema: seguridad; Owner: postgres
--

CREATE TABLE grupo (
    id integer DEFAULT nextval('grupo_id_seq'::regclass) NOT NULL,
    name character varying(255) NOT NULL,
    roles text NOT NULL
);


ALTER TABLE grupo OWNER TO postgres;

--
-- TOC entry 2651 (class 0 OID 0)
-- Dependencies: 246
-- Name: COLUMN grupo.roles; Type: COMMENT; Schema: seguridad; Owner: postgres
--

COMMENT ON COLUMN grupo.roles IS '(DC2Type:array)';


--
-- TOC entry 247 (class 1259 OID 20759)
-- Name: grupo_permiso; Type: TABLE; Schema: seguridad; Owner: postgres
--

CREATE TABLE grupo_permiso (
    grupo integer NOT NULL,
    permiso bigint NOT NULL
);


ALTER TABLE grupo_permiso OWNER TO postgres;

--
-- TOC entry 248 (class 1259 OID 20762)
-- Name: permiso; Type: TABLE; Schema: seguridad; Owner: postgres
--

CREATE TABLE permiso (
    id bigint NOT NULL,
    padre bigint,
    denominacion character varying(50) NOT NULL,
    permiso character varying(50) NOT NULL,
    activo boolean
);


ALTER TABLE permiso OWNER TO postgres;

--
-- TOC entry 249 (class 1259 OID 20765)
-- Name: permiso_id_seq; Type: SEQUENCE; Schema: seguridad; Owner: postgres
--

CREATE SEQUENCE permiso_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE permiso_id_seq OWNER TO postgres;

--
-- TOC entry 2652 (class 0 OID 0)
-- Dependencies: 249
-- Name: permiso_id_seq; Type: SEQUENCE OWNED BY; Schema: seguridad; Owner: postgres
--

ALTER SEQUENCE permiso_id_seq OWNED BY permiso.id;


--
-- TOC entry 250 (class 1259 OID 20767)
-- Name: usuario_id_seq; Type: SEQUENCE; Schema: seguridad; Owner: postgres
--

CREATE SEQUENCE usuario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE usuario_id_seq OWNER TO postgres;

--
-- TOC entry 251 (class 1259 OID 20769)
-- Name: usuario; Type: TABLE; Schema: seguridad; Owner: postgres
--

CREATE TABLE usuario (
    id integer DEFAULT nextval('usuario_id_seq'::regclass) NOT NULL,
    username character varying(255) NOT NULL,
    username_canonical character varying(255) NOT NULL,
    email character varying(255),
    email_canonical character varying(255),
    enabled boolean NOT NULL,
    salt character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    last_login timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    locked boolean NOT NULL,
    expired boolean NOT NULL,
    expires_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    confirmation_token character varying(255) DEFAULT NULL::character varying,
    password_requested_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    roles text NOT NULL,
    credentials_expired boolean NOT NULL,
    credentials_expire_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    nombre character varying(50),
    canonic_name character varying(50),
    cedula character varying(15),
    token character varying(100) DEFAULT NULL::character varying
);


ALTER TABLE usuario OWNER TO postgres;

--
-- TOC entry 2653 (class 0 OID 0)
-- Dependencies: 251
-- Name: COLUMN usuario.roles; Type: COMMENT; Schema: seguridad; Owner: postgres
--

COMMENT ON COLUMN usuario.roles IS '(DC2Type:array)';


--
-- TOC entry 252 (class 1259 OID 20782)
-- Name: usuario_grupo; Type: TABLE; Schema: seguridad; Owner: postgres
--

CREATE TABLE usuario_grupo (
    usuario integer NOT NULL,
    grupo integer NOT NULL
);


ALTER TABLE usuario_grupo OWNER TO postgres;

--
-- TOC entry 253 (class 1259 OID 20785)
-- Name: usuario_permiso; Type: TABLE; Schema: seguridad; Owner: postgres
--

CREATE TABLE usuario_permiso (
    usuario integer NOT NULL,
    permiso bigint NOT NULL
);


ALTER TABLE usuario_permiso OWNER TO postgres;

SET search_path = menu, pg_catalog;

--
-- TOC entry 2130 (class 2604 OID 21325)
-- Name: id; Type: DEFAULT; Schema: menu; Owner: postgres
--

ALTER TABLE ONLY menu ALTER COLUMN id SET DEFAULT nextval('menu_id_seq'::regclass);


SET search_path = public, pg_catalog;

--
-- TOC entry 2131 (class 2604 OID 21326)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY anteproyecto ALTER COLUMN id SET DEFAULT nextval('anteproyecto_id_seq'::regclass);


--
-- TOC entry 2132 (class 2604 OID 21327)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY aula ALTER COLUMN id SET DEFAULT nextval('aula_id_seq'::regclass);


--
-- TOC entry 2133 (class 2604 OID 21328)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY autoasignacion_aula ALTER COLUMN id SET DEFAULT nextval('autoasignacion_aula_id_seq'::regclass);


--
-- TOC entry 2134 (class 2604 OID 21329)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY campus ALTER COLUMN id SET DEFAULT nextval('campus_id_seq'::regclass);


--
-- TOC entry 2135 (class 2604 OID 21330)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY categoria ALTER COLUMN id SET DEFAULT nextval('categoria_id_seq'::regclass);


--
-- TOC entry 2136 (class 2604 OID 21331)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY descarga_administrativa ALTER COLUMN id SET DEFAULT nextval('descarga_administrativa_id_seq'::regclass);


--
-- TOC entry 2137 (class 2604 OID 21332)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY dia ALTER COLUMN id SET DEFAULT nextval('dia_id_seq'::regclass);


--
-- TOC entry 2138 (class 2604 OID 21333)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estado ALTER COLUMN id SET DEFAULT nextval('estado_id_seq'::regclass);


--
-- TOC entry 2139 (class 2604 OID 21334)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estado_civil ALTER COLUMN id SET DEFAULT nextval('estado_civil_id_seq'::regclass);


--
-- TOC entry 2140 (class 2604 OID 21335)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estado_periodo ALTER COLUMN id SET DEFAULT nextval('estado_periodo_id_seq'::regclass);


--
-- TOC entry 2141 (class 2604 OID 21336)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes ALTER COLUMN id SET DEFAULT nextval('grupo_estudiantes_id_seq'::regclass);


--
-- TOC entry 2142 (class 2604 OID 21337)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes_cambio ALTER COLUMN id SET DEFAULT nextval('grupo_estudiantes_cambio_id_seq'::regclass);


--
-- TOC entry 2143 (class 2604 OID 21338)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_horario_anteproyecto ALTER COLUMN id SET DEFAULT nextval('grupo_horario_anteproyecto_id_seq'::regclass);


--
-- TOC entry 2144 (class 2604 OID 21339)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hora ALTER COLUMN id SET DEFAULT nextval('hora_id_seq'::regclass);


--
-- TOC entry 2147 (class 2604 OID 21340)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hora_periodo ALTER COLUMN id SET DEFAULT nextval('hora_periodo_id_seq'::regclass);


--
-- TOC entry 2150 (class 2604 OID 21341)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY idioma_profe ALTER COLUMN id SET DEFAULT nextval('idioma_profe_id_seq'::regclass);


--
-- TOC entry 2151 (class 2604 OID 21342)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY licenciatura ALTER COLUMN id SET DEFAULT nextval('licenciatura_id_seq'::regclass);


--
-- TOC entry 2152 (class 2604 OID 21343)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY maestria_doctorado ALTER COLUMN id SET DEFAULT nextval('maestria_doctorado_id_seq'::regclass);


--
-- TOC entry 2155 (class 2604 OID 21344)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY materia ALTER COLUMN id SET DEFAULT nextval('materia_id_seq'::regclass);


--
-- TOC entry 2157 (class 2604 OID 21345)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY periodo ALTER COLUMN id SET DEFAULT nextval('periodo_id_seq'::regclass);


--
-- TOC entry 2158 (class 2604 OID 21346)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY plan_estudio ALTER COLUMN id SET DEFAULT nextval('plan_estudio_id_seq'::regclass);


--
-- TOC entry 2159 (class 2604 OID 21347)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preferencia_profe_hora ALTER COLUMN id SET DEFAULT nextval('preferencia_profe_hora_id_seq'::regclass);


--
-- TOC entry 2160 (class 2604 OID 21348)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preferencia_profe_materia ALTER COLUMN id SET DEFAULT nextval('preferencia_profe_materia_id_seq'::regclass);


--
-- TOC entry 2161 (class 2604 OID 21349)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo ALTER COLUMN id SET DEFAULT nextval('profe_periodo_id_seq'::regclass);


--
-- TOC entry 2162 (class 2604 OID 21350)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo_horario ALTER COLUMN id SET DEFAULT nextval('profe_periodo_horario_id_seq'::regclass);


--
-- TOC entry 2176 (class 2604 OID 21351)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profesor ALTER COLUMN id SET DEFAULT nextval('profesor_id_seq'::regclass);


--
-- TOC entry 2178 (class 2604 OID 21352)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY semestre ALTER COLUMN id SET DEFAULT nextval('semestre_id_seq'::regclass);


--
-- TOC entry 2179 (class 2604 OID 21353)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tipo_descarga_administrativa ALTER COLUMN id SET DEFAULT nextval('tipo_descarga_administrativa_id_seq'::regclass);


--
-- TOC entry 2180 (class 2604 OID 21354)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tipo_materia ALTER COLUMN id SET DEFAULT nextval('tipo_materia_id_seq'::regclass);


--
-- TOC entry 2181 (class 2604 OID 21355)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tipo_periodo ALTER COLUMN id SET DEFAULT nextval('tipo_periodo_id_seq'::regclass);


--
-- TOC entry 2182 (class 2604 OID 21356)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY turno ALTER COLUMN id SET DEFAULT nextval('turno_id_seq'::regclass);


SET search_path = seguridad, pg_catalog;

--
-- TOC entry 2184 (class 2604 OID 21357)
-- Name: id; Type: DEFAULT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY permiso ALTER COLUMN id SET DEFAULT nextval('permiso_id_seq'::regclass);


SET search_path = menu, pg_catalog;

--
-- TOC entry 2532 (class 0 OID 20537)
-- Dependencies: 175
-- Data for Name: menu; Type: TABLE DATA; Schema: menu; Owner: postgres
--

COPY menu (id, id_padre, denominacion, permiso, ruta, icon) FROM stdin;
-1	-1	Menu	IS_AUTHENTICATED_ANONYMOUSLY	\N	\N
1	-1	Configuración	IS_AUTHENTICATED_ANONYMOUSLY	\N	fa-cog
2	-1	Profesores	IS_AUTHENTICATED_ANONYMOUSLY	\N	fa-user
3	-1	Seguridad	ROLE_ADMINISTRADOR	\N	fa-lock
7	-1	Planes de Estudio	IS_AUTHENTICATED_ANONYMOUSLY	\N	fa-stack-overflow
8	-1	Horario	ROLE_GESTIONAR_CONFIGURACION	\N	fa-list-alt
101	7	Materias	IS_AUTHENTICATED_ANONYMOUSLY	planeacion_admin_crud_materia	fa-book
102	1	Idiomas	IS_AUTHENTICATED_ANONYMOUSLY	planeacion_admin_crud_idioma	fa-comment
103	7	Registro	IS_AUTHENTICATED_ANONYMOUSLY	planeacion_admin_crud_planEstudio	fa-edit
104	-1	Grupos	IS_AUTHENTICATED_ANONYMOUSLY	planeacion_admin_crud_grupo	fa-group
105	1	Horas por período	IS_AUTHENTICATED_ANONYMOUSLY	planeacion_admin_crud_hora_periodo	fa-tasks
107	1	Períodos	IS_AUTHENTICATED_ANONYMOUSLY	planeacion_admin_crud_periodo	fa-calendar
108	1	Turnos	IS_AUTHENTICATED_ANONYMOUSLY	planeacion_admin_crud_turno	fa-dashboard
109	1	Horas	IS_AUTHENTICATED_ANONYMOUSLY	planeacion_admin_crud_hora	fa-clock-o
301	3	Usuarios	ROLE_ADMINISTRADOR	security_crud_user	fa-group
302	3	Roles	ROLE_ADMINISTRADOR	security_crud_group	fa-cogs
303	3	Permisos	NO_SHOW	security_crud_permission	\N
400	2	Listado	IS_AUTHENTICATED_ANONYMOUSLY	planeacion_admin_crud_profesor	fa-list-ul
401	2	Descarga administrativa	IS_AUTHENTICATED_ANONYMOUSLY	planeacion_admin_crud_descargas	fa-minus-square
500	8	Anteproyecto	ROLE_GESTIONAR_CONFIGURACION	planeacion_horario_crud_anteproyecto	fa-paperclip
501	8	Inicio de Cambios	ROLE_GESTIONAR_CONFIGURACION	planeacion_horario_crud_cambio	fa-calendar
502	8	Asignación de Materias	ROLE_GESTIONAR_CONFIGURACION	planeacion_horario_crud_asignacion_materias	fa-book
503	8	Asignación de Profesores	ROLE_GESTIONAR_CONFIGURACION	planeacion_horario_crud_asignacion_profesores	fa-group
9	-1	Aulas	IS_AUTHENTICATED_ANONYMOUSLY	\N	fa-sitemap
201	9	Aulas	IS_AUTHENTICATED_ANONYMOUSLY	planeacion_admin_crud_aula	fa-list
202	9	Asignaciones	IS_AUTHENTICATED_ANONYMOUSLY	planeacion_admin_crud_autoasignacion_aula	fa-random
\.


--
-- TOC entry 2654 (class 0 OID 0)
-- Dependencies: 176
-- Name: menu_id_seq; Type: SEQUENCE SET; Schema: menu; Owner: postgres
--

SELECT pg_catalog.setval('menu_id_seq', 6, true);


SET search_path = public, pg_catalog;

--
-- TOC entry 2534 (class 0 OID 20545)
-- Dependencies: 177
-- Data for Name: anteproyecto; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY anteproyecto (id, periodo, periodo_anterior, estado, cambios) FROM stdin;
\.


--
-- TOC entry 2655 (class 0 OID 0)
-- Dependencies: 178
-- Name: anteproyecto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('anteproyecto_id_seq', 86, true);


--
-- TOC entry 2536 (class 0 OID 20553)
-- Dependencies: 179
-- Data for Name: aula; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY aula (id, nombre, capacidad, activa, enlinea) FROM stdin;
\.


--
-- TOC entry 2656 (class 0 OID 0)
-- Dependencies: 180
-- Name: aula_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('aula_id_seq', 80, true);


--
-- TOC entry 2538 (class 0 OID 20558)
-- Dependencies: 181
-- Data for Name: autoasignacion_aula; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY autoasignacion_aula (id, aula, materia, comentario) FROM stdin;
\.


--
-- TOC entry 2657 (class 0 OID 0)
-- Dependencies: 182
-- Name: autoasignacion_aula_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('autoasignacion_aula_id_seq', 9, true);


--
-- TOC entry 2540 (class 0 OID 20566)
-- Dependencies: 183
-- Data for Name: campus; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY campus (id, nombre) FROM stdin;
\.


--
-- TOC entry 2658 (class 0 OID 0)
-- Dependencies: 184
-- Name: campus_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('campus_id_seq', 3, true);


--
-- TOC entry 2542 (class 0 OID 20571)
-- Dependencies: 185
-- Data for Name: categoria; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY categoria (id, nombre) FROM stdin;
1	Tiempo Completo
2	Medio Tiempo
3	Horas Base
5	Horas contrato rectoría
6	Horas contrato Ingresos Propios
\.


--
-- TOC entry 2659 (class 0 OID 0)
-- Dependencies: 186
-- Name: categoria_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('categoria_id_seq', 6, true);


--
-- TOC entry 2544 (class 0 OID 20576)
-- Dependencies: 187
-- Data for Name: descarga_administrativa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY descarga_administrativa (id, periodo, profesor, comentario, tipodescarga) FROM stdin;
\.


--
-- TOC entry 2660 (class 0 OID 0)
-- Dependencies: 188
-- Name: descarga_administrativa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('descarga_administrativa_id_seq', 19, true);


--
-- TOC entry 2546 (class 0 OID 20584)
-- Dependencies: 189
-- Data for Name: dia; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY dia (id, nombre) FROM stdin;
\.


--
-- TOC entry 2661 (class 0 OID 0)
-- Dependencies: 190
-- Name: dia_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('dia_id_seq', 8, true);


--
-- TOC entry 2548 (class 0 OID 20589)
-- Dependencies: 191
-- Data for Name: estado; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY estado (id, nombre) FROM stdin;
1	Elaboracion
2	Aprobado
\.


--
-- TOC entry 2549 (class 0 OID 20592)
-- Dependencies: 192
-- Data for Name: estado_civil; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY estado_civil (id, nombre) FROM stdin;
1	Soltero
2	Casado
3	Divorciado
4	Viudo
\.


--
-- TOC entry 2662 (class 0 OID 0)
-- Dependencies: 193
-- Name: estado_civil_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('estado_civil_id_seq', 3, true);


--
-- TOC entry 2663 (class 0 OID 0)
-- Dependencies: 194
-- Name: estado_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('estado_id_seq', 2, true);


--
-- TOC entry 2552 (class 0 OID 20599)
-- Dependencies: 195
-- Data for Name: estado_periodo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY estado_periodo (id, nombre) FROM stdin;
\.


--
-- TOC entry 2664 (class 0 OID 0)
-- Dependencies: 196
-- Name: estado_periodo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('estado_periodo_id_seq', 5, true);


--
-- TOC entry 2554 (class 0 OID 20604)
-- Dependencies: 197
-- Data for Name: grupo_estudiantes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY grupo_estudiantes (id, nombre_completo, licenciatura, turno, periodo, aula, semestre, nivel, aula_string, campus, bilingue, terceros, plan_estudio, paquete, enlinea) FROM stdin;
\.


--
-- TOC entry 2555 (class 0 OID 20607)
-- Dependencies: 198
-- Data for Name: grupo_estudiantes_cambio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY grupo_estudiantes_cambio (id, anterior, actual, anteproyecto) FROM stdin;
\.


--
-- TOC entry 2665 (class 0 OID 0)
-- Dependencies: 199
-- Name: grupo_estudiantes_cambio_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('grupo_estudiantes_cambio_id_seq', 5138, true);


--
-- TOC entry 2666 (class 0 OID 0)
-- Dependencies: 200
-- Name: grupo_estudiantes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('grupo_estudiantes_id_seq', 21430, true);


--
-- TOC entry 2558 (class 0 OID 20614)
-- Dependencies: 201
-- Data for Name: grupo_horario_anteproyecto; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY grupo_horario_anteproyecto (id, materia, hora_periodo, grupo_estudiantes, dia, aula, profe_periodo) FROM stdin;
\.


--
-- TOC entry 2667 (class 0 OID 0)
-- Dependencies: 202
-- Name: grupo_horario_anteproyecto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('grupo_horario_anteproyecto_id_seq', 122128, true);


--
-- TOC entry 2560 (class 0 OID 20619)
-- Dependencies: 203
-- Data for Name: historico_materia_manual; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY historico_materia_manual (profe_periodo, materia) FROM stdin;
\.


--
-- TOC entry 2561 (class 0 OID 20622)
-- Dependencies: 204
-- Data for Name: hora; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY hora (id, nombre, hora, activa) FROM stdin;
\.


--
-- TOC entry 2562 (class 0 OID 20625)
-- Dependencies: 205
-- Data for Name: hora_dia; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY hora_dia (hora, dia) FROM stdin;
\.


--
-- TOC entry 2668 (class 0 OID 0)
-- Dependencies: 206
-- Name: hora_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('hora_id_seq', 71, true);


--
-- TOC entry 2564 (class 0 OID 20630)
-- Dependencies: 207
-- Data for Name: hora_periodo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY hora_periodo (id, periodo, turno, hora_time, nombre) FROM stdin;
\.


--
-- TOC entry 2669 (class 0 OID 0)
-- Dependencies: 208
-- Name: hora_periodo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('hora_periodo_id_seq', 1562, true);


--
-- TOC entry 2567 (class 0 OID 20639)
-- Dependencies: 210
-- Data for Name: idioma; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY idioma (id, nombre) FROM stdin;
1	Inglés
3	Alemán
4	Italiano
5	Portugués
2	Francés
10	Latín
11	Ruso
\.


--
-- TOC entry 2670 (class 0 OID 0)
-- Dependencies: 209
-- Name: idioma_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('idioma_id_seq', 11, true);


--
-- TOC entry 2568 (class 0 OID 20643)
-- Dependencies: 211
-- Data for Name: idioma_profe; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY idioma_profe (id, idioma, profesor, porciento, numero) FROM stdin;
\.


--
-- TOC entry 2671 (class 0 OID 0)
-- Dependencies: 212
-- Name: idioma_profe_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('idioma_profe_id_seq', 1498, true);


--
-- TOC entry 2570 (class 0 OID 20649)
-- Dependencies: 213
-- Data for Name: licenciatura; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY licenciatura (id, nombre) FROM stdin;
2	CRIMINOLOGÍA
1	DERECHO
\.


--
-- TOC entry 2672 (class 0 OID 0)
-- Dependencies: 214
-- Name: licenciatura_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('licenciatura_id_seq', 2, true);


--
-- TOC entry 2572 (class 0 OID 20654)
-- Dependencies: 215
-- Data for Name: maestria_doctorado; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY maestria_doctorado (id, pasante, titulado, nombre, profesor, tipo) FROM stdin;
\.


--
-- TOC entry 2673 (class 0 OID 0)
-- Dependencies: 216
-- Name: maestria_doctorado_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('maestria_doctorado_id_seq', 2093, true);


--
-- TOC entry 2574 (class 0 OID 20659)
-- Dependencies: 217
-- Data for Name: materia; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY materia (id, semestre, nombre, clave, frecuencia_semanal, activo, plan_estudio, tipo_materia, horas_extra) FROM stdin;
\.


--
-- TOC entry 2674 (class 0 OID 0)
-- Dependencies: 218
-- Name: materia_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('materia_id_seq', 1364, true);


--
-- TOC entry 2576 (class 0 OID 20666)
-- Dependencies: 219
-- Data for Name: materia_plan_estudio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY materia_plan_estudio (materia, plan_estudio) FROM stdin;
\.


--
-- TOC entry 2577 (class 0 OID 20669)
-- Dependencies: 220
-- Data for Name: periodo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY periodo (id, tipo_periodo, nombre, anno) FROM stdin;
\.


--
-- TOC entry 2675 (class 0 OID 0)
-- Dependencies: 221
-- Name: periodo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('periodo_id_seq', 26, true);


--
-- TOC entry 2579 (class 0 OID 20675)
-- Dependencies: 222
-- Data for Name: plan_estudio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY plan_estudio (id, nombre, licenciatura, activo) FROM stdin;
\.


--
-- TOC entry 2676 (class 0 OID 0)
-- Dependencies: 223
-- Name: plan_estudio_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('plan_estudio_id_seq', 6, true);


--
-- TOC entry 2581 (class 0 OID 20680)
-- Dependencies: 224
-- Data for Name: preferencia_profe_hora; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY preferencia_profe_hora (id, profe, hora, orden_preferencia, dia) FROM stdin;
\.


--
-- TOC entry 2677 (class 0 OID 0)
-- Dependencies: 225
-- Name: preferencia_profe_hora_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('preferencia_profe_hora_id_seq', 19375, true);


--
-- TOC entry 2583 (class 0 OID 20685)
-- Dependencies: 226
-- Data for Name: preferencia_profe_materia; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY preferencia_profe_materia (id, materia, profe, orden_preferencia) FROM stdin;
\.


--
-- TOC entry 2678 (class 0 OID 0)
-- Dependencies: 227
-- Name: preferencia_profe_materia_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('preferencia_profe_materia_id_seq', 20050, true);


--
-- TOC entry 2585 (class 0 OID 20690)
-- Dependencies: 228
-- Data for Name: profe_periodo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY profe_periodo (id, periodo, profesor, horas_cubrir, horas_asignadas, descarga_ant, descarga_admva, antiguedad, asistencia_sem_anterior, categoria) FROM stdin;
\.


--
-- TOC entry 2586 (class 0 OID 20693)
-- Dependencies: 229
-- Data for Name: profe_periodo_horario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY profe_periodo_horario (id, profe_periodo, materia, dia, grupo_estudiantes, hora_periodo, aula) FROM stdin;
\.


--
-- TOC entry 2679 (class 0 OID 0)
-- Dependencies: 230
-- Name: profe_periodo_horario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('profe_periodo_horario_id_seq', 14306, true);


--
-- TOC entry 2680 (class 0 OID 0)
-- Dependencies: 231
-- Name: profe_periodo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('profe_periodo_id_seq', 15717, true);


--
-- TOC entry 2589 (class 0 OID 20700)
-- Dependencies: 232
-- Data for Name: profe_periodo_materia; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY profe_periodo_materia (profe_periodo, materia) FROM stdin;
\.


--
-- TOC entry 2590 (class 0 OID 20703)
-- Dependencies: 233
-- Data for Name: profesor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY profesor (id, categoria, estado_civil, tel_lugar_labora, dir_labora, nombre_conyugue, nombre, numero_empleado, fecha_nacimiento, fehca_ingreso_fac, foto, linares, sabina, correo, facebook, lugar_labora, fecha_ingreso_uanl, domicilio, tel_particular, tel_celular, tel_nextel, licenciatura_en, fecha_actualizacion, perfil, genero, usuario, apellidos, fullname, inactivo, carrera) FROM stdin;
\.


--
-- TOC entry 2681 (class 0 OID 0)
-- Dependencies: 234
-- Name: profesor_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('profesor_id_seq', 890, true);


--
-- TOC entry 2592 (class 0 OID 20724)
-- Dependencies: 235
-- Data for Name: semestre; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY semestre (id, nombre, ordinal) FROM stdin;
1	1	PRIMER
2	2	SEGUNDO
9	9	NOVENO
8	8	OCTAVO
7	7	SÉPTIMO
6	6	SEXTO
5	5	QUINTO
4	4	CUARTO
3	3	TERCER
10	10	DÉCIMO
11	11	UNDÉCIMO
\.


--
-- TOC entry 2682 (class 0 OID 0)
-- Dependencies: 236
-- Name: semestre_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('semestre_id_seq', 11, true);


--
-- TOC entry 2594 (class 0 OID 20730)
-- Dependencies: 237
-- Data for Name: tipo_descarga_administrativa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tipo_descarga_administrativa (id, nombre) FROM stdin;
2	Licencia
3	Antigüedad
4	Administrativa
1	Incapacidad
\.


--
-- TOC entry 2683 (class 0 OID 0)
-- Dependencies: 238
-- Name: tipo_descarga_administrativa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_descarga_administrativa_id_seq', 4, true);


--
-- TOC entry 2596 (class 0 OID 20735)
-- Dependencies: 239
-- Data for Name: tipo_materia; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tipo_materia (id, nombre) FROM stdin;
1	Básica
2	Optativa
3	Libre Elección(PLAN)
\.


--
-- TOC entry 2684 (class 0 OID 0)
-- Dependencies: 240
-- Name: tipo_materia_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_materia_id_seq', 3, true);


--
-- TOC entry 2598 (class 0 OID 20740)
-- Dependencies: 241
-- Data for Name: tipo_periodo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tipo_periodo (id, nombre) FROM stdin;
1	Enero-Junio
2	Agosto-Diciembre
\.


--
-- TOC entry 2685 (class 0 OID 0)
-- Dependencies: 242
-- Name: tipo_periodo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_periodo_id_seq', 2, true);


--
-- TOC entry 2600 (class 0 OID 20745)
-- Dependencies: 243
-- Data for Name: turno; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY turno (id, nombre, activa) FROM stdin;
1	Matutino	t
2	Piloto	t
3	Vespertino	t
4	Nocturno	t
0	Por definir	t
\.


--
-- TOC entry 2686 (class 0 OID 0)
-- Dependencies: 244
-- Name: turno_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('turno_id_seq', 9, true);


SET search_path = seguridad, pg_catalog;

--
-- TOC entry 2603 (class 0 OID 20752)
-- Dependencies: 246
-- Data for Name: grupo; Type: TABLE DATA; Schema: seguridad; Owner: postgres
--

COPY grupo (id, name, roles) FROM stdin;
6	Administrador	a:3:{i:0;s:18:"ROLE_ADMINISTRADOR";i:1;s:23:"ROLE_GESTIONAR_PROFESOR";i:2;s:28:"ROLE_GESTIONAR_CONFIGURACION";}
9	Super administrador	a:3:{i:0;s:18:"ROLE_ADMINISTRADOR";i:1;s:23:"ROLE_GESTIONAR_PROFESOR";i:2;s:28:"ROLE_GESTIONAR_CONFIGURACION";}
7	Gestor de configuración	a:1:{i:0;s:28:"ROLE_GESTIONAR_CONFIGURACION";}
8	Planificador	a:2:{i:0;s:23:"ROLE_GESTIONAR_PROFESOR";i:1;s:28:"ROLE_GESTIONAR_CONFIGURACION";}
1	Profesor	a:1:{i:0;s:23:"ROLE_GESTIONAR_PROFESOR";}
10	Consultor	a:1:{i:0;s:23:"ROLE_GESTIONAR_PROFESOR";}
\.


--
-- TOC entry 2687 (class 0 OID 0)
-- Dependencies: 245
-- Name: grupo_id_seq; Type: SEQUENCE SET; Schema: seguridad; Owner: postgres
--

SELECT pg_catalog.setval('grupo_id_seq', 10, true);


--
-- TOC entry 2604 (class 0 OID 20759)
-- Dependencies: 247
-- Data for Name: grupo_permiso; Type: TABLE DATA; Schema: seguridad; Owner: postgres
--

COPY grupo_permiso (grupo, permiso) FROM stdin;
6	6
6	5
6	4
7	4
1	5
10	5
9	6
9	5
9	4
8	5
8	4
\.


--
-- TOC entry 2605 (class 0 OID 20762)
-- Dependencies: 248
-- Data for Name: permiso; Type: TABLE DATA; Schema: seguridad; Owner: postgres
--

COPY permiso (id, padre, denominacion, permiso, activo) FROM stdin;
-1	-1	Todos los permisos	Todos los permisos	t
6	-1	Administrar sistema	ROLE_ADMINISTRADOR	t
5	-1	Gestionar profesores	ROLE_GESTIONAR_PROFESOR	t
4	-1	Gestionar configuración	ROLE_GESTIONAR_CONFIGURACION	t
\.


--
-- TOC entry 2688 (class 0 OID 0)
-- Dependencies: 249
-- Name: permiso_id_seq; Type: SEQUENCE SET; Schema: seguridad; Owner: postgres
--

SELECT pg_catalog.setval('permiso_id_seq', 10, true);


--
-- TOC entry 2608 (class 0 OID 20769)
-- Dependencies: 251
-- Data for Name: usuario; Type: TABLE DATA; Schema: seguridad; Owner: postgres
--

COPY usuario (id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, locked, expired, expires_at, confirmation_token, password_requested_at, roles, credentials_expired, credentials_expire_at, nombre, canonic_name, cedula, token) FROM stdin;
33	admin	admin	cont@cto.com	cont@cto.com	t	1yquytwwsof4o0ok00c44k4oc0w8440	yI9xKmj6gh2fUfuCGBdojrH19FSkzPeH2rd2XJkSO147QtcH8+4WATHCCnHYzV0FYKEminwxx2QVnzkm4+ETrg==	2016-03-29 19:53:58	f	f	\N	\N	\N	a:0:{}	f	\N	Administrador	administrador	0000	8bn6kt0l5dids3mujrabhrh1s4
\.


--
-- TOC entry 2609 (class 0 OID 20782)
-- Dependencies: 252
-- Data for Name: usuario_grupo; Type: TABLE DATA; Schema: seguridad; Owner: postgres
--

COPY usuario_grupo (usuario, grupo) FROM stdin;
33	9
\.


--
-- TOC entry 2689 (class 0 OID 0)
-- Dependencies: 250
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: seguridad; Owner: postgres
--

SELECT pg_catalog.setval('usuario_id_seq', 54, true);


--
-- TOC entry 2610 (class 0 OID 20785)
-- Dependencies: 253
-- Data for Name: usuario_permiso; Type: TABLE DATA; Schema: seguridad; Owner: postgres
--

COPY usuario_permiso (usuario, permiso) FROM stdin;
\.


SET search_path = menu, pg_catalog;

--
-- TOC entry 2194 (class 2606 OID 20822)
-- Name: menu_pkey; Type: CONSTRAINT; Schema: menu; Owner: postgres
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_pkey PRIMARY KEY (id);


SET search_path = public, pg_catalog;

--
-- TOC entry 2196 (class 2606 OID 20824)
-- Name: anteproyecto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY anteproyecto
    ADD CONSTRAINT anteproyecto_pkey PRIMARY KEY (id);


--
-- TOC entry 2201 (class 2606 OID 20826)
-- Name: aula_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY aula
    ADD CONSTRAINT aula_pkey PRIMARY KEY (id);


--
-- TOC entry 2204 (class 2606 OID 20828)
-- Name: autoasignacion_aula_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY autoasignacion_aula
    ADD CONSTRAINT autoasignacion_aula_pkey PRIMARY KEY (id);


--
-- TOC entry 2208 (class 2606 OID 20830)
-- Name: campus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY campus
    ADD CONSTRAINT campus_pkey PRIMARY KEY (id);


--
-- TOC entry 2210 (class 2606 OID 20832)
-- Name: categoria_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY categoria
    ADD CONSTRAINT categoria_pkey PRIMARY KEY (id);


--
-- TOC entry 2212 (class 2606 OID 20834)
-- Name: descarga_administrativa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY descarga_administrativa
    ADD CONSTRAINT descarga_administrativa_pkey PRIMARY KEY (id);


--
-- TOC entry 2217 (class 2606 OID 20836)
-- Name: dia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY dia
    ADD CONSTRAINT dia_pkey PRIMARY KEY (id);


--
-- TOC entry 2221 (class 2606 OID 20838)
-- Name: estado_civil_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estado_civil
    ADD CONSTRAINT estado_civil_pkey PRIMARY KEY (id);


--
-- TOC entry 2223 (class 2606 OID 20840)
-- Name: estado_periodo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estado_periodo
    ADD CONSTRAINT estado_periodo_pkey PRIMARY KEY (id);


--
-- TOC entry 2219 (class 2606 OID 20842)
-- Name: estado_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estado
    ADD CONSTRAINT estado_pkey PRIMARY KEY (id);


--
-- TOC entry 2234 (class 2606 OID 20844)
-- Name: grupo_estudiantes_cambio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes_cambio
    ADD CONSTRAINT grupo_estudiantes_cambio_pkey PRIMARY KEY (id);


--
-- TOC entry 2225 (class 2606 OID 20846)
-- Name: grupo_estudiantes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes
    ADD CONSTRAINT grupo_estudiantes_pkey PRIMARY KEY (id);


--
-- TOC entry 2239 (class 2606 OID 20848)
-- Name: grupo_horario_anteproyecto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_horario_anteproyecto
    ADD CONSTRAINT grupo_horario_anteproyecto_pkey PRIMARY KEY (id);


--
-- TOC entry 2247 (class 2606 OID 20850)
-- Name: historico_materia_manual_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY historico_materia_manual
    ADD CONSTRAINT historico_materia_manual_pkey PRIMARY KEY (profe_periodo, materia);


--
-- TOC entry 2254 (class 2606 OID 20852)
-- Name: hora_dia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hora_dia
    ADD CONSTRAINT hora_dia_pkey PRIMARY KEY (hora, dia);


--
-- TOC entry 2258 (class 2606 OID 20854)
-- Name: hora_periodo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hora_periodo
    ADD CONSTRAINT hora_periodo_pkey PRIMARY KEY (id);


--
-- TOC entry 2251 (class 2606 OID 20856)
-- Name: hora_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hora
    ADD CONSTRAINT hora_pkey PRIMARY KEY (id);


--
-- TOC entry 2262 (class 2606 OID 20858)
-- Name: idioma_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY idioma
    ADD CONSTRAINT idioma_pkey PRIMARY KEY (id);


--
-- TOC entry 2265 (class 2606 OID 20860)
-- Name: idioma_profe_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY idioma_profe
    ADD CONSTRAINT idioma_profe_pkey PRIMARY KEY (id);


--
-- TOC entry 2269 (class 2606 OID 20862)
-- Name: licenciatura_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY licenciatura
    ADD CONSTRAINT licenciatura_pkey PRIMARY KEY (id);


--
-- TOC entry 2272 (class 2606 OID 20864)
-- Name: maestria_doctorado_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY maestria_doctorado
    ADD CONSTRAINT maestria_doctorado_pkey PRIMARY KEY (id);


--
-- TOC entry 2277 (class 2606 OID 20866)
-- Name: materia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY materia
    ADD CONSTRAINT materia_pkey PRIMARY KEY (id);


--
-- TOC entry 2281 (class 2606 OID 20868)
-- Name: materia_plan_estudio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY materia_plan_estudio
    ADD CONSTRAINT materia_plan_estudio_pkey PRIMARY KEY (materia, plan_estudio);


--
-- TOC entry 2284 (class 2606 OID 20870)
-- Name: periodo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY periodo
    ADD CONSTRAINT periodo_pkey PRIMARY KEY (id);


--
-- TOC entry 2287 (class 2606 OID 20872)
-- Name: plan_estudio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY plan_estudio
    ADD CONSTRAINT plan_estudio_pkey PRIMARY KEY (id);


--
-- TOC entry 2292 (class 2606 OID 20874)
-- Name: preferencia_profe_hora_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preferencia_profe_hora
    ADD CONSTRAINT preferencia_profe_hora_pkey PRIMARY KEY (id);


--
-- TOC entry 2296 (class 2606 OID 20876)
-- Name: preferencia_profe_materia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preferencia_profe_materia
    ADD CONSTRAINT preferencia_profe_materia_pkey PRIMARY KEY (id);


--
-- TOC entry 2309 (class 2606 OID 20878)
-- Name: profe_periodo_horario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo_horario
    ADD CONSTRAINT profe_periodo_horario_pkey PRIMARY KEY (id);


--
-- TOC entry 2313 (class 2606 OID 20880)
-- Name: profe_periodo_materia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo_materia
    ADD CONSTRAINT profe_periodo_materia_pkey PRIMARY KEY (profe_periodo, materia);


--
-- TOC entry 2301 (class 2606 OID 20882)
-- Name: profe_periodo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo
    ADD CONSTRAINT profe_periodo_pkey PRIMARY KEY (id);


--
-- TOC entry 2319 (class 2606 OID 20884)
-- Name: profesor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profesor
    ADD CONSTRAINT profesor_pkey PRIMARY KEY (id);


--
-- TOC entry 2321 (class 2606 OID 20886)
-- Name: semestre_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY semestre
    ADD CONSTRAINT semestre_pkey PRIMARY KEY (id);


--
-- TOC entry 2323 (class 2606 OID 20888)
-- Name: tipo_descarga_administrativa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tipo_descarga_administrativa
    ADD CONSTRAINT tipo_descarga_administrativa_pkey PRIMARY KEY (id);


--
-- TOC entry 2325 (class 2606 OID 20890)
-- Name: tipo_materia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tipo_materia
    ADD CONSTRAINT tipo_materia_pkey PRIMARY KEY (id);


--
-- TOC entry 2327 (class 2606 OID 20893)
-- Name: tipo_periodo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tipo_periodo
    ADD CONSTRAINT tipo_periodo_pkey PRIMARY KEY (id);


--
-- TOC entry 2329 (class 2606 OID 20895)
-- Name: turno_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY turno
    ADD CONSTRAINT turno_pkey PRIMARY KEY (id);


SET search_path = seguridad, pg_catalog;

--
-- TOC entry 2335 (class 2606 OID 20897)
-- Name: grupo_permiso_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY grupo_permiso
    ADD CONSTRAINT grupo_permiso_pkey PRIMARY KEY (grupo, permiso);


--
-- TOC entry 2332 (class 2606 OID 20899)
-- Name: grupo_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY grupo
    ADD CONSTRAINT grupo_pkey PRIMARY KEY (id);


--
-- TOC entry 2340 (class 2606 OID 20901)
-- Name: permiso_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY permiso
    ADD CONSTRAINT permiso_pkey PRIMARY KEY (id);


--
-- TOC entry 2350 (class 2606 OID 20903)
-- Name: usuario_grupo_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY usuario_grupo
    ADD CONSTRAINT usuario_grupo_pkey PRIMARY KEY (usuario, grupo);


--
-- TOC entry 2354 (class 2606 OID 20905)
-- Name: usuario_permiso_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY usuario_permiso
    ADD CONSTRAINT usuario_permiso_pkey PRIMARY KEY (usuario, permiso);


--
-- TOC entry 2346 (class 2606 OID 20907)
-- Name: usuario_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id);


SET search_path = menu, pg_catalog;

--
-- TOC entry 2192 (class 1259 OID 20908)
-- Name: idx_71f803a23de02bdb; Type: INDEX; Schema: menu; Owner: postgres
--

CREATE INDEX idx_71f803a23de02bdb ON menu USING btree (id_padre);


SET search_path = public, pg_catalog;

--
-- TOC entry 2205 (class 1259 OID 20909)
-- Name: idx_1257e90431990a4; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_1257e90431990a4 ON autoasignacion_aula USING btree (aula);


--
-- TOC entry 2206 (class 1259 OID 20910)
-- Name: idx_1257e9046df05284; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_1257e9046df05284 ON autoasignacion_aula USING btree (materia);


--
-- TOC entry 2297 (class 1259 OID 20911)
-- Name: idx_16ac0db64e10122d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_16ac0db64e10122d ON profe_periodo USING btree (categoria);


--
-- TOC entry 2298 (class 1259 OID 20912)
-- Name: idx_16ac0db65b7406d9; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_16ac0db65b7406d9 ON profe_periodo USING btree (profesor);


--
-- TOC entry 2299 (class 1259 OID 20913)
-- Name: idx_16ac0db67316c4ed; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_16ac0db67316c4ed ON profe_periodo USING btree (periodo);


--
-- TOC entry 2285 (class 1259 OID 20914)
-- Name: idx_1b45221347d0797; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_1b45221347d0797 ON plan_estudio USING btree (licenciatura);


--
-- TOC entry 2235 (class 1259 OID 20915)
-- Name: idx_1feeb5bb292667ef; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_1feeb5bb292667ef ON grupo_estudiantes_cambio USING btree (anteproyecto);


--
-- TOC entry 2197 (class 1259 OID 20916)
-- Name: idx_292667ef265de1e3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_292667ef265de1e3 ON anteproyecto USING btree (estado);


--
-- TOC entry 2198 (class 1259 OID 20917)
-- Name: idx_292667ef2b38bc54; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_292667ef2b38bc54 ON anteproyecto USING btree (periodo_anterior);


--
-- TOC entry 2278 (class 1259 OID 20918)
-- Name: idx_46a653361b45221; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_46a653361b45221 ON materia_plan_estudio USING btree (plan_estudio);


--
-- TOC entry 2279 (class 1259 OID 20919)
-- Name: idx_46a653366df05284; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_46a653366df05284 ON materia_plan_estudio USING btree (materia);


--
-- TOC entry 2259 (class 1259 OID 20920)
-- Name: idx_4d7f84dc7316c4ed; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_4d7f84dc7316c4ed ON hora_periodo USING btree (periodo);


--
-- TOC entry 2260 (class 1259 OID 20921)
-- Name: idx_4d7f84dce7976762; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_4d7f84dce7976762 ON hora_periodo USING btree (turno);


--
-- TOC entry 2248 (class 1259 OID 20922)
-- Name: idx_549168b016ac0db6; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_549168b016ac0db6 ON historico_materia_manual USING btree (profe_periodo);


--
-- TOC entry 2249 (class 1259 OID 20923)
-- Name: idx_549168b06df05284; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_549168b06df05284 ON historico_materia_manual USING btree (materia);


--
-- TOC entry 2314 (class 1259 OID 20924)
-- Name: idx_5b7406d92265b05d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_5b7406d92265b05d ON profesor USING btree (usuario);


--
-- TOC entry 2315 (class 1259 OID 20925)
-- Name: idx_5b7406d94e10122d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_5b7406d94e10122d ON profesor USING btree (categoria);


--
-- TOC entry 2316 (class 1259 OID 20926)
-- Name: idx_5b7406d9cf1ecd30; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_5b7406d9cf1ecd30 ON profesor USING btree (carrera);


--
-- TOC entry 2317 (class 1259 OID 20927)
-- Name: idx_5b7406d9f4222d84; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_5b7406d9f4222d84 ON profesor USING btree (estado_civil);


--
-- TOC entry 2293 (class 1259 OID 20928)
-- Name: idx_6166425b6df05284; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6166425b6df05284 ON preferencia_profe_materia USING btree (materia);


--
-- TOC entry 2294 (class 1259 OID 20929)
-- Name: idx_6166425bb332aa2e; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6166425bb332aa2e ON preferencia_profe_materia USING btree (profe);


--
-- TOC entry 2302 (class 1259 OID 20930)
-- Name: idx_6620bf8916ac0db6; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6620bf8916ac0db6 ON profe_periodo_horario USING btree (profe_periodo);


--
-- TOC entry 2303 (class 1259 OID 20931)
-- Name: idx_6620bf8931990a4; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6620bf8931990a4 ON profe_periodo_horario USING btree (aula);


--
-- TOC entry 2304 (class 1259 OID 20932)
-- Name: idx_6620bf893e153bce; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6620bf893e153bce ON profe_periodo_horario USING btree (dia);


--
-- TOC entry 2305 (class 1259 OID 20933)
-- Name: idx_6620bf894d7f84dc; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6620bf894d7f84dc ON profe_periodo_horario USING btree (hora_periodo);


--
-- TOC entry 2306 (class 1259 OID 20934)
-- Name: idx_6620bf896df05284; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6620bf896df05284 ON profe_periodo_horario USING btree (materia);


--
-- TOC entry 2307 (class 1259 OID 20935)
-- Name: idx_6620bf89a253cf7b; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6620bf89a253cf7b ON profe_periodo_horario USING btree (grupo_estudiantes);


--
-- TOC entry 2273 (class 1259 OID 20936)
-- Name: idx_6df052841b45221; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6df052841b45221 ON materia USING btree (plan_estudio);


--
-- TOC entry 2274 (class 1259 OID 20937)
-- Name: idx_6df0528471688fbc; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6df0528471688fbc ON materia USING btree (semestre);


--
-- TOC entry 2275 (class 1259 OID 20938)
-- Name: idx_6df052847e097324; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6df052847e097324 ON materia USING btree (tipo_materia);


--
-- TOC entry 2266 (class 1259 OID 20939)
-- Name: idx_6eec01a91dc85e0c; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6eec01a91dc85e0c ON idioma_profe USING btree (idioma);


--
-- TOC entry 2267 (class 1259 OID 20940)
-- Name: idx_6eec01a95b7406d9; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6eec01a95b7406d9 ON idioma_profe USING btree (profesor);


--
-- TOC entry 2282 (class 1259 OID 20941)
-- Name: idx_7316c4ed60efe54d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_7316c4ed60efe54d ON periodo USING btree (tipo_periodo);


--
-- TOC entry 2213 (class 1259 OID 20942)
-- Name: idx_84b1a64f5b7406d9; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_84b1a64f5b7406d9 ON descarga_administrativa USING btree (profesor);


--
-- TOC entry 2214 (class 1259 OID 20943)
-- Name: idx_84b1a64f7316c4ed; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_84b1a64f7316c4ed ON descarga_administrativa USING btree (periodo);


--
-- TOC entry 2215 (class 1259 OID 20944)
-- Name: idx_84b1a64fe10842e5; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_84b1a64fe10842e5 ON descarga_administrativa USING btree (tipodescarga);


--
-- TOC entry 2226 (class 1259 OID 20945)
-- Name: idx_a253cf7b1b45221; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_a253cf7b1b45221 ON grupo_estudiantes USING btree (plan_estudio);


--
-- TOC entry 2227 (class 1259 OID 20946)
-- Name: idx_a253cf7b31990a4; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_a253cf7b31990a4 ON grupo_estudiantes USING btree (aula);


--
-- TOC entry 2228 (class 1259 OID 20947)
-- Name: idx_a253cf7b347d0797; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_a253cf7b347d0797 ON grupo_estudiantes USING btree (licenciatura);


--
-- TOC entry 2229 (class 1259 OID 20948)
-- Name: idx_a253cf7b71688fbc; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_a253cf7b71688fbc ON grupo_estudiantes USING btree (semestre);


--
-- TOC entry 2230 (class 1259 OID 20949)
-- Name: idx_a253cf7b7316c4ed; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_a253cf7b7316c4ed ON grupo_estudiantes USING btree (periodo);


--
-- TOC entry 2231 (class 1259 OID 20950)
-- Name: idx_a253cf7b9d096811; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_a253cf7b9d096811 ON grupo_estudiantes USING btree (campus);


--
-- TOC entry 2232 (class 1259 OID 20951)
-- Name: idx_a253cf7be7976762; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_a253cf7be7976762 ON grupo_estudiantes USING btree (turno);


--
-- TOC entry 2255 (class 1259 OID 20952)
-- Name: idx_ab5057743e153bce; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_ab5057743e153bce ON hora_dia USING btree (dia);


--
-- TOC entry 2256 (class 1259 OID 20953)
-- Name: idx_ab505774bbe1c657; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_ab505774bbe1c657 ON hora_dia USING btree (hora);


--
-- TOC entry 2288 (class 1259 OID 20954)
-- Name: idx_b231734e3e153bce; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_b231734e3e153bce ON preferencia_profe_hora USING btree (dia);


--
-- TOC entry 2289 (class 1259 OID 20955)
-- Name: idx_b231734eb332aa2e; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_b231734eb332aa2e ON preferencia_profe_hora USING btree (profe);


--
-- TOC entry 2290 (class 1259 OID 20956)
-- Name: idx_b231734ebbe1c657; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_b231734ebbe1c657 ON preferencia_profe_hora USING btree (hora);


--
-- TOC entry 2240 (class 1259 OID 20957)
-- Name: idx_b3ef59bf16ac0db6; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_b3ef59bf16ac0db6 ON grupo_horario_anteproyecto USING btree (profe_periodo);


--
-- TOC entry 2241 (class 1259 OID 20958)
-- Name: idx_b3ef59bf31990a4; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_b3ef59bf31990a4 ON grupo_horario_anteproyecto USING btree (aula);


--
-- TOC entry 2242 (class 1259 OID 20959)
-- Name: idx_b3ef59bf3e153bce; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_b3ef59bf3e153bce ON grupo_horario_anteproyecto USING btree (dia);


--
-- TOC entry 2243 (class 1259 OID 20960)
-- Name: idx_b3ef59bf4d7f84dc; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_b3ef59bf4d7f84dc ON grupo_horario_anteproyecto USING btree (hora_periodo);


--
-- TOC entry 2244 (class 1259 OID 20961)
-- Name: idx_b3ef59bf6df05284; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_b3ef59bf6df05284 ON grupo_horario_anteproyecto USING btree (materia);


--
-- TOC entry 2245 (class 1259 OID 20962)
-- Name: idx_b3ef59bfa253cf7b; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_b3ef59bfa253cf7b ON grupo_horario_anteproyecto USING btree (grupo_estudiantes);


--
-- TOC entry 2310 (class 1259 OID 20963)
-- Name: idx_e988beae16ac0db6; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e988beae16ac0db6 ON profe_periodo_materia USING btree (profe_periodo);


--
-- TOC entry 2311 (class 1259 OID 20964)
-- Name: idx_e988beae6df05284; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e988beae6df05284 ON profe_periodo_materia USING btree (materia);


--
-- TOC entry 2270 (class 1259 OID 20965)
-- Name: idx_fba0032c5b7406d9; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_fba0032c5b7406d9 ON maestria_doctorado USING btree (profesor);


--
-- TOC entry 2263 (class 1259 OID 20966)
-- Name: uniq_1dc85e0c3a909126; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_1dc85e0c3a909126 ON idioma USING btree (nombre);


--
-- TOC entry 2236 (class 1259 OID 20967)
-- Name: uniq_1feeb5bb227d9a24; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_1feeb5bb227d9a24 ON grupo_estudiantes_cambio USING btree (actual);


--
-- TOC entry 2237 (class 1259 OID 20968)
-- Name: uniq_1feeb5bbb9d500de; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_1feeb5bbb9d500de ON grupo_estudiantes_cambio USING btree (anterior);


--
-- TOC entry 2199 (class 1259 OID 20969)
-- Name: uniq_292667ef7316c4ed; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_292667ef7316c4ed ON anteproyecto USING btree (periodo);


--
-- TOC entry 2202 (class 1259 OID 20970)
-- Name: uniq_31990a43a909126; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_31990a43a909126 ON aula USING btree (nombre);


--
-- TOC entry 2252 (class 1259 OID 20971)
-- Name: uniq_bbe1c6573a909126; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_bbe1c6573a909126 ON hora USING btree (nombre);


--
-- TOC entry 2330 (class 1259 OID 20972)
-- Name: uniq_e79767623a909126; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_e79767623a909126 ON turno USING btree (nombre);


SET search_path = seguridad, pg_catalog;

--
-- TOC entry 2336 (class 1259 OID 20973)
-- Name: idx_20ad8c18c0e9bd3; Type: INDEX; Schema: seguridad; Owner: postgres
--

CREATE INDEX idx_20ad8c18c0e9bd3 ON grupo_permiso USING btree (grupo);


--
-- TOC entry 2337 (class 1259 OID 20974)
-- Name: idx_20ad8c1fd7aab9e; Type: INDEX; Schema: seguridad; Owner: postgres
--

CREATE INDEX idx_20ad8c1fd7aab9e ON grupo_permiso USING btree (permiso);


--
-- TOC entry 2347 (class 1259 OID 20975)
-- Name: idx_31a90c352265b05d; Type: INDEX; Schema: seguridad; Owner: postgres
--

CREATE INDEX idx_31a90c352265b05d ON usuario_grupo USING btree (usuario);


--
-- TOC entry 2348 (class 1259 OID 20976)
-- Name: idx_31a90c358c0e9bd3; Type: INDEX; Schema: seguridad; Owner: postgres
--

CREATE INDEX idx_31a90c358c0e9bd3 ON usuario_grupo USING btree (grupo);


--
-- TOC entry 2338 (class 1259 OID 20977)
-- Name: idx_36346284d3656aeb; Type: INDEX; Schema: seguridad; Owner: postgres
--

CREATE INDEX idx_36346284d3656aeb ON permiso USING btree (padre);


--
-- TOC entry 2351 (class 1259 OID 20978)
-- Name: idx_9b3544b42265b05d; Type: INDEX; Schema: seguridad; Owner: postgres
--

CREATE INDEX idx_9b3544b42265b05d ON usuario_permiso USING btree (usuario);


--
-- TOC entry 2352 (class 1259 OID 20979)
-- Name: idx_9b3544b4fd7aab9e; Type: INDEX; Schema: seguridad; Owner: postgres
--

CREATE INDEX idx_9b3544b4fd7aab9e ON usuario_permiso USING btree (permiso);


--
-- TOC entry 2333 (class 1259 OID 20980)
-- Name: uniq_99e4acef5e237e06; Type: INDEX; Schema: seguridad; Owner: postgres
--

CREATE UNIQUE INDEX uniq_99e4acef5e237e06 ON grupo USING btree (name);


--
-- TOC entry 2341 (class 1259 OID 20981)
-- Name: uniq_e92b794792fc23a8; Type: INDEX; Schema: seguridad; Owner: postgres
--

CREATE UNIQUE INDEX uniq_e92b794792fc23a8 ON usuario USING btree (username_canonical);


--
-- TOC entry 2342 (class 1259 OID 20982)
-- Name: uniq_e92b7947a0d96fbf; Type: INDEX; Schema: seguridad; Owner: postgres
--

CREATE UNIQUE INDEX uniq_e92b7947a0d96fbf ON usuario USING btree (email_canonical);


--
-- TOC entry 2343 (class 1259 OID 20983)
-- Name: uniq_e92b7947e7927c74; Type: INDEX; Schema: seguridad; Owner: postgres
--

CREATE UNIQUE INDEX uniq_e92b7947e7927c74 ON usuario USING btree (email);


--
-- TOC entry 2344 (class 1259 OID 20984)
-- Name: uniq_e92b7947f85e0677; Type: INDEX; Schema: seguridad; Owner: postgres
--

CREATE UNIQUE INDEX uniq_e92b7947f85e0677 ON usuario USING btree (username);


SET search_path = menu, pg_catalog;

--
-- TOC entry 2355 (class 2606 OID 20985)
-- Name: fk_71f803a23de02bdb; Type: FK CONSTRAINT; Schema: menu; Owner: postgres
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT fk_71f803a23de02bdb FOREIGN KEY (id_padre) REFERENCES menu(id);


SET search_path = public, pg_catalog;

--
-- TOC entry 2359 (class 2606 OID 20990)
-- Name: fk_1257e90431990a4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY autoasignacion_aula
    ADD CONSTRAINT fk_1257e90431990a4 FOREIGN KEY (aula) REFERENCES aula(id);


--
-- TOC entry 2360 (class 2606 OID 20995)
-- Name: fk_1257e9046df05284; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY autoasignacion_aula
    ADD CONSTRAINT fk_1257e9046df05284 FOREIGN KEY (materia) REFERENCES materia(id);


--
-- TOC entry 2401 (class 2606 OID 21000)
-- Name: fk_16ac0db64e10122d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo
    ADD CONSTRAINT fk_16ac0db64e10122d FOREIGN KEY (categoria) REFERENCES categoria(id);


--
-- TOC entry 2402 (class 2606 OID 21005)
-- Name: fk_16ac0db65b7406d9; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo
    ADD CONSTRAINT fk_16ac0db65b7406d9 FOREIGN KEY (profesor) REFERENCES profesor(id) ON DELETE CASCADE;


--
-- TOC entry 2403 (class 2606 OID 21010)
-- Name: fk_16ac0db67316c4ed; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo
    ADD CONSTRAINT fk_16ac0db67316c4ed FOREIGN KEY (periodo) REFERENCES periodo(id);


--
-- TOC entry 2395 (class 2606 OID 21015)
-- Name: fk_1b45221347d0797; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY plan_estudio
    ADD CONSTRAINT fk_1b45221347d0797 FOREIGN KEY (licenciatura) REFERENCES licenciatura(id);


--
-- TOC entry 2371 (class 2606 OID 21020)
-- Name: fk_1feeb5bb227d9a24; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes_cambio
    ADD CONSTRAINT fk_1feeb5bb227d9a24 FOREIGN KEY (actual) REFERENCES grupo_estudiantes(id);


--
-- TOC entry 2372 (class 2606 OID 21025)
-- Name: fk_1feeb5bb292667ef; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes_cambio
    ADD CONSTRAINT fk_1feeb5bb292667ef FOREIGN KEY (anteproyecto) REFERENCES anteproyecto(id);


--
-- TOC entry 2373 (class 2606 OID 21030)
-- Name: fk_1feeb5bbb9d500de; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes_cambio
    ADD CONSTRAINT fk_1feeb5bbb9d500de FOREIGN KEY (anterior) REFERENCES grupo_estudiantes(id);


--
-- TOC entry 2356 (class 2606 OID 21035)
-- Name: fk_292667ef265de1e3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY anteproyecto
    ADD CONSTRAINT fk_292667ef265de1e3 FOREIGN KEY (estado) REFERENCES estado_periodo(id);


--
-- TOC entry 2357 (class 2606 OID 21040)
-- Name: fk_292667ef2b38bc54; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY anteproyecto
    ADD CONSTRAINT fk_292667ef2b38bc54 FOREIGN KEY (periodo_anterior) REFERENCES periodo(id);


--
-- TOC entry 2358 (class 2606 OID 21045)
-- Name: fk_292667ef7316c4ed; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY anteproyecto
    ADD CONSTRAINT fk_292667ef7316c4ed FOREIGN KEY (periodo) REFERENCES periodo(id);


--
-- TOC entry 2392 (class 2606 OID 21050)
-- Name: fk_46a653361b45221; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY materia_plan_estudio
    ADD CONSTRAINT fk_46a653361b45221 FOREIGN KEY (plan_estudio) REFERENCES plan_estudio(id) ON DELETE CASCADE;


--
-- TOC entry 2393 (class 2606 OID 21055)
-- Name: fk_46a653366df05284; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY materia_plan_estudio
    ADD CONSTRAINT fk_46a653366df05284 FOREIGN KEY (materia) REFERENCES materia(id) ON DELETE CASCADE;


--
-- TOC entry 2384 (class 2606 OID 21060)
-- Name: fk_4d7f84dc7316c4ed; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hora_periodo
    ADD CONSTRAINT fk_4d7f84dc7316c4ed FOREIGN KEY (periodo) REFERENCES periodo(id);


--
-- TOC entry 2385 (class 2606 OID 21065)
-- Name: fk_4d7f84dce7976762; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hora_periodo
    ADD CONSTRAINT fk_4d7f84dce7976762 FOREIGN KEY (turno) REFERENCES turno(id);


--
-- TOC entry 2380 (class 2606 OID 21070)
-- Name: fk_549168b016ac0db6; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY historico_materia_manual
    ADD CONSTRAINT fk_549168b016ac0db6 FOREIGN KEY (profe_periodo) REFERENCES profe_periodo(id) ON DELETE CASCADE;


--
-- TOC entry 2381 (class 2606 OID 21075)
-- Name: fk_549168b06df05284; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY historico_materia_manual
    ADD CONSTRAINT fk_549168b06df05284 FOREIGN KEY (materia) REFERENCES materia(id) ON DELETE CASCADE;


--
-- TOC entry 2412 (class 2606 OID 21080)
-- Name: fk_5b7406d92265b05d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profesor
    ADD CONSTRAINT fk_5b7406d92265b05d FOREIGN KEY (usuario) REFERENCES seguridad.usuario(id) ON DELETE SET NULL;


--
-- TOC entry 2413 (class 2606 OID 21085)
-- Name: fk_5b7406d94e10122d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profesor
    ADD CONSTRAINT fk_5b7406d94e10122d FOREIGN KEY (categoria) REFERENCES categoria(id);


--
-- TOC entry 2414 (class 2606 OID 21090)
-- Name: fk_5b7406d9cf1ecd30; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profesor
    ADD CONSTRAINT fk_5b7406d9cf1ecd30 FOREIGN KEY (carrera) REFERENCES licenciatura(id);


--
-- TOC entry 2415 (class 2606 OID 21095)
-- Name: fk_5b7406d9f4222d84; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profesor
    ADD CONSTRAINT fk_5b7406d9f4222d84 FOREIGN KEY (estado_civil) REFERENCES estado_civil(id);


--
-- TOC entry 2399 (class 2606 OID 21100)
-- Name: fk_6166425b6df05284; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preferencia_profe_materia
    ADD CONSTRAINT fk_6166425b6df05284 FOREIGN KEY (materia) REFERENCES materia(id);


--
-- TOC entry 2400 (class 2606 OID 21105)
-- Name: fk_6166425bb332aa2e; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preferencia_profe_materia
    ADD CONSTRAINT fk_6166425bb332aa2e FOREIGN KEY (profe) REFERENCES profesor(id) ON DELETE CASCADE;


--
-- TOC entry 2404 (class 2606 OID 21110)
-- Name: fk_6620bf8916ac0db6; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo_horario
    ADD CONSTRAINT fk_6620bf8916ac0db6 FOREIGN KEY (profe_periodo) REFERENCES profe_periodo(id) ON DELETE CASCADE;


--
-- TOC entry 2405 (class 2606 OID 21115)
-- Name: fk_6620bf8931990a4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo_horario
    ADD CONSTRAINT fk_6620bf8931990a4 FOREIGN KEY (aula) REFERENCES aula(id);


--
-- TOC entry 2406 (class 2606 OID 21120)
-- Name: fk_6620bf893e153bce; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo_horario
    ADD CONSTRAINT fk_6620bf893e153bce FOREIGN KEY (dia) REFERENCES dia(id);


--
-- TOC entry 2407 (class 2606 OID 21125)
-- Name: fk_6620bf894d7f84dc; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo_horario
    ADD CONSTRAINT fk_6620bf894d7f84dc FOREIGN KEY (hora_periodo) REFERENCES hora_periodo(id);


--
-- TOC entry 2408 (class 2606 OID 21130)
-- Name: fk_6620bf896df05284; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo_horario
    ADD CONSTRAINT fk_6620bf896df05284 FOREIGN KEY (materia) REFERENCES materia(id);


--
-- TOC entry 2409 (class 2606 OID 21135)
-- Name: fk_6620bf89a253cf7b; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo_horario
    ADD CONSTRAINT fk_6620bf89a253cf7b FOREIGN KEY (grupo_estudiantes) REFERENCES grupo_estudiantes(id);


--
-- TOC entry 2389 (class 2606 OID 21140)
-- Name: fk_6df052841b45221; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY materia
    ADD CONSTRAINT fk_6df052841b45221 FOREIGN KEY (plan_estudio) REFERENCES plan_estudio(id);


--
-- TOC entry 2390 (class 2606 OID 21145)
-- Name: fk_6df0528471688fbc; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY materia
    ADD CONSTRAINT fk_6df0528471688fbc FOREIGN KEY (semestre) REFERENCES semestre(id);


--
-- TOC entry 2391 (class 2606 OID 21150)
-- Name: fk_6df052847e097324; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY materia
    ADD CONSTRAINT fk_6df052847e097324 FOREIGN KEY (tipo_materia) REFERENCES tipo_materia(id);


--
-- TOC entry 2386 (class 2606 OID 21155)
-- Name: fk_6eec01a91dc85e0c; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY idioma_profe
    ADD CONSTRAINT fk_6eec01a91dc85e0c FOREIGN KEY (idioma) REFERENCES idioma(id);


--
-- TOC entry 2387 (class 2606 OID 21160)
-- Name: fk_6eec01a95b7406d9; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY idioma_profe
    ADD CONSTRAINT fk_6eec01a95b7406d9 FOREIGN KEY (profesor) REFERENCES profesor(id) ON DELETE CASCADE;


--
-- TOC entry 2394 (class 2606 OID 21165)
-- Name: fk_7316c4ed60efe54d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY periodo
    ADD CONSTRAINT fk_7316c4ed60efe54d FOREIGN KEY (tipo_periodo) REFERENCES tipo_periodo(id);


--
-- TOC entry 2361 (class 2606 OID 21170)
-- Name: fk_84b1a64f5b7406d9; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY descarga_administrativa
    ADD CONSTRAINT fk_84b1a64f5b7406d9 FOREIGN KEY (profesor) REFERENCES profesor(id);


--
-- TOC entry 2362 (class 2606 OID 21175)
-- Name: fk_84b1a64f7316c4ed; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY descarga_administrativa
    ADD CONSTRAINT fk_84b1a64f7316c4ed FOREIGN KEY (periodo) REFERENCES periodo(id);


--
-- TOC entry 2363 (class 2606 OID 21180)
-- Name: fk_84b1a64fe10842e5; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY descarga_administrativa
    ADD CONSTRAINT fk_84b1a64fe10842e5 FOREIGN KEY (tipodescarga) REFERENCES tipo_descarga_administrativa(id);


--
-- TOC entry 2364 (class 2606 OID 21185)
-- Name: fk_a253cf7b1b45221; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes
    ADD CONSTRAINT fk_a253cf7b1b45221 FOREIGN KEY (plan_estudio) REFERENCES plan_estudio(id);


--
-- TOC entry 2365 (class 2606 OID 21190)
-- Name: fk_a253cf7b31990a4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes
    ADD CONSTRAINT fk_a253cf7b31990a4 FOREIGN KEY (aula) REFERENCES aula(id);


--
-- TOC entry 2366 (class 2606 OID 21195)
-- Name: fk_a253cf7b347d0797; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes
    ADD CONSTRAINT fk_a253cf7b347d0797 FOREIGN KEY (licenciatura) REFERENCES licenciatura(id);


--
-- TOC entry 2367 (class 2606 OID 21200)
-- Name: fk_a253cf7b71688fbc; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes
    ADD CONSTRAINT fk_a253cf7b71688fbc FOREIGN KEY (semestre) REFERENCES semestre(id);


--
-- TOC entry 2368 (class 2606 OID 21205)
-- Name: fk_a253cf7b7316c4ed; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes
    ADD CONSTRAINT fk_a253cf7b7316c4ed FOREIGN KEY (periodo) REFERENCES periodo(id);


--
-- TOC entry 2369 (class 2606 OID 21210)
-- Name: fk_a253cf7b9d096811; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes
    ADD CONSTRAINT fk_a253cf7b9d096811 FOREIGN KEY (campus) REFERENCES campus(id);


--
-- TOC entry 2370 (class 2606 OID 21215)
-- Name: fk_a253cf7be7976762; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_estudiantes
    ADD CONSTRAINT fk_a253cf7be7976762 FOREIGN KEY (turno) REFERENCES turno(id);


--
-- TOC entry 2382 (class 2606 OID 21220)
-- Name: fk_ab5057743e153bce; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hora_dia
    ADD CONSTRAINT fk_ab5057743e153bce FOREIGN KEY (dia) REFERENCES dia(id) ON DELETE CASCADE;


--
-- TOC entry 2383 (class 2606 OID 21225)
-- Name: fk_ab505774bbe1c657; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hora_dia
    ADD CONSTRAINT fk_ab505774bbe1c657 FOREIGN KEY (hora) REFERENCES hora(id) ON DELETE CASCADE;


--
-- TOC entry 2396 (class 2606 OID 21230)
-- Name: fk_b231734e3e153bce; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preferencia_profe_hora
    ADD CONSTRAINT fk_b231734e3e153bce FOREIGN KEY (dia) REFERENCES dia(id) ON DELETE CASCADE;


--
-- TOC entry 2397 (class 2606 OID 21235)
-- Name: fk_b231734eb332aa2e; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preferencia_profe_hora
    ADD CONSTRAINT fk_b231734eb332aa2e FOREIGN KEY (profe) REFERENCES profesor(id) ON DELETE CASCADE;


--
-- TOC entry 2398 (class 2606 OID 21240)
-- Name: fk_b231734ebbe1c657; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preferencia_profe_hora
    ADD CONSTRAINT fk_b231734ebbe1c657 FOREIGN KEY (hora) REFERENCES hora(id) ON DELETE CASCADE;


--
-- TOC entry 2374 (class 2606 OID 21245)
-- Name: fk_b3ef59bf16ac0db6; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_horario_anteproyecto
    ADD CONSTRAINT fk_b3ef59bf16ac0db6 FOREIGN KEY (profe_periodo) REFERENCES profe_periodo(id);


--
-- TOC entry 2375 (class 2606 OID 21250)
-- Name: fk_b3ef59bf31990a4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_horario_anteproyecto
    ADD CONSTRAINT fk_b3ef59bf31990a4 FOREIGN KEY (aula) REFERENCES aula(id);


--
-- TOC entry 2376 (class 2606 OID 21255)
-- Name: fk_b3ef59bf3e153bce; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_horario_anteproyecto
    ADD CONSTRAINT fk_b3ef59bf3e153bce FOREIGN KEY (dia) REFERENCES dia(id);


--
-- TOC entry 2377 (class 2606 OID 21260)
-- Name: fk_b3ef59bf4d7f84dc; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_horario_anteproyecto
    ADD CONSTRAINT fk_b3ef59bf4d7f84dc FOREIGN KEY (hora_periodo) REFERENCES hora_periodo(id);


--
-- TOC entry 2378 (class 2606 OID 21265)
-- Name: fk_b3ef59bf6df05284; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_horario_anteproyecto
    ADD CONSTRAINT fk_b3ef59bf6df05284 FOREIGN KEY (materia) REFERENCES materia(id);


--
-- TOC entry 2379 (class 2606 OID 21270)
-- Name: fk_b3ef59bfa253cf7b; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupo_horario_anteproyecto
    ADD CONSTRAINT fk_b3ef59bfa253cf7b FOREIGN KEY (grupo_estudiantes) REFERENCES grupo_estudiantes(id);


--
-- TOC entry 2410 (class 2606 OID 21275)
-- Name: fk_e988beae16ac0db6; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo_materia
    ADD CONSTRAINT fk_e988beae16ac0db6 FOREIGN KEY (profe_periodo) REFERENCES profe_periodo(id) ON DELETE CASCADE;


--
-- TOC entry 2411 (class 2606 OID 21280)
-- Name: fk_e988beae6df05284; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profe_periodo_materia
    ADD CONSTRAINT fk_e988beae6df05284 FOREIGN KEY (materia) REFERENCES materia(id) ON DELETE CASCADE;


--
-- TOC entry 2388 (class 2606 OID 21285)
-- Name: fk_fba0032c5b7406d9; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY maestria_doctorado
    ADD CONSTRAINT fk_fba0032c5b7406d9 FOREIGN KEY (profesor) REFERENCES profesor(id) ON DELETE CASCADE;


SET search_path = seguridad, pg_catalog;

--
-- TOC entry 2416 (class 2606 OID 21290)
-- Name: fk_20ad8c18c0e9bd3; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY grupo_permiso
    ADD CONSTRAINT fk_20ad8c18c0e9bd3 FOREIGN KEY (grupo) REFERENCES grupo(id) ON DELETE CASCADE;


--
-- TOC entry 2417 (class 2606 OID 21295)
-- Name: fk_20ad8c1fd7aab9e; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY grupo_permiso
    ADD CONSTRAINT fk_20ad8c1fd7aab9e FOREIGN KEY (permiso) REFERENCES permiso(id) ON DELETE CASCADE;


--
-- TOC entry 2419 (class 2606 OID 21300)
-- Name: fk_31a90c352265b05d; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY usuario_grupo
    ADD CONSTRAINT fk_31a90c352265b05d FOREIGN KEY (usuario) REFERENCES usuario(id) ON DELETE CASCADE;


--
-- TOC entry 2420 (class 2606 OID 21305)
-- Name: fk_31a90c358c0e9bd3; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY usuario_grupo
    ADD CONSTRAINT fk_31a90c358c0e9bd3 FOREIGN KEY (grupo) REFERENCES grupo(id) ON DELETE CASCADE;


--
-- TOC entry 2418 (class 2606 OID 21310)
-- Name: fk_36346284d3656aeb; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY permiso
    ADD CONSTRAINT fk_36346284d3656aeb FOREIGN KEY (padre) REFERENCES permiso(id);


--
-- TOC entry 2421 (class 2606 OID 21315)
-- Name: fk_9b3544b42265b05d; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY usuario_permiso
    ADD CONSTRAINT fk_9b3544b42265b05d FOREIGN KEY (usuario) REFERENCES usuario(id) ON DELETE CASCADE;


--
-- TOC entry 2422 (class 2606 OID 21320)
-- Name: fk_9b3544b4fd7aab9e; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY usuario_permiso
    ADD CONSTRAINT fk_9b3544b4fd7aab9e FOREIGN KEY (permiso) REFERENCES permiso(id) ON DELETE CASCADE;


--
-- TOC entry 2617 (class 0 OID 0)
-- Dependencies: 9
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2016-03-29 23:57:56

--
-- PostgreSQL database dump complete
--

