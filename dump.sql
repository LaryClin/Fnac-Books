--
-- PostgreSQL database dump
--

-- Dumped from database version 10.10 (Ubuntu 10.10-0ubuntu0.18.04.1)
-- Dumped by pg_dump version 10.10 (Ubuntu 10.10-0ubuntu0.18.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: fnac; Type: SCHEMA; Schema: -; Owner: fnac2c
--

CREATE SCHEMA fnac;


ALTER SCHEMA fnac OWNER TO fnac2c;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: t_e_adherent_adh; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_e_adherent_adh (
    adh_id integer NOT NULL,
    adh_numadherent numeric(10,0) NOT NULL,
    adh_datefinadhesion date NOT NULL,
    adh_mel character varying(80) NOT NULL,
    adh_motpasse character varying(128) NOT NULL,
    adh_pseudo character varying(20) NOT NULL,
    adh_civilite character varying(4) NOT NULL,
    adh_nom character varying(50) NOT NULL,
    adh_prenom character varying(50) NOT NULL,
    adh_telfixe character varying(15),
    adh_telportable character varying(15),
    mag_id integer,
    CONSTRAINT ck_adh_fixe_portable CHECK ((((adh_telfixe IS NULL) AND (adh_telportable IS NOT NULL)) OR ((adh_telfixe IS NOT NULL) AND (adh_telportable IS NULL)) OR ((adh_telfixe IS NOT NULL) AND (adh_telportable IS NOT NULL)))),
    CONSTRAINT ckc_adh_civilite_t_e_adhe CHECK (((adh_civilite)::text = ANY ((ARRAY['M.'::character varying, 'Mlle'::character varying, 'Mme'::character varying])::text[])))
);


ALTER TABLE fnac.t_e_adherent_adh OWNER TO fnac2c;

--
-- Name: t_e_adherent_adh_adh_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_e_adherent_adh_adh_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_e_adherent_adh_adh_id_seq OWNER TO fnac2c;

--
-- Name: t_e_adherent_adh_adh_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_e_adherent_adh_adh_id_seq OWNED BY fnac.t_e_adherent_adh.adh_id;


--
-- Name: t_e_adresse_adr; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_e_adresse_adr (
    adr_id integer NOT NULL,
    adh_id integer NOT NULL,
    adr_nom character varying(50) NOT NULL,
    adr_type character varying(15) NOT NULL,
    adr_rue character varying(200) NOT NULL,
    adr_complementrue character varying(200),
    adr_cp character varying(10) NOT NULL,
    adr_ville character varying(100) NOT NULL,
    pay_id integer NOT NULL,
    adr_latitude double precision,
    adr_longitude double precision,
    CONSTRAINT ckc_adr_type_t_e_adre CHECK (((adr_type)::text = ANY ((ARRAY['Livraison'::character varying, 'Facturation'::character varying])::text[])))
);


ALTER TABLE fnac.t_e_adresse_adr OWNER TO fnac2c;

--
-- Name: t_e_adresse_adr_adr_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_e_adresse_adr_adr_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_e_adresse_adr_adr_id_seq OWNER TO fnac2c;

--
-- Name: t_e_adresse_adr_adr_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_e_adresse_adr_adr_id_seq OWNED BY fnac.t_e_adresse_adr.adr_id;


--
-- Name: t_e_auteur_aut; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_e_auteur_aut (
    aut_id integer NOT NULL,
    aut_nom character varying(80) NOT NULL
);


ALTER TABLE fnac.t_e_auteur_aut OWNER TO fnac2c;

--
-- Name: t_e_auteur_aut_aut_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_e_auteur_aut_aut_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_e_auteur_aut_aut_id_seq OWNER TO fnac2c;

--
-- Name: t_e_auteur_aut_aut_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_e_auteur_aut_aut_id_seq OWNED BY fnac.t_e_auteur_aut.aut_id;


--
-- Name: t_e_avis_avi; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_e_avis_avi (
    avi_id integer NOT NULL,
    adh_id integer NOT NULL,
    liv_id integer NOT NULL,
    avi_date date DEFAULT CURRENT_DATE NOT NULL,
    avi_titre character varying(100) NOT NULL,
    avi_detail character varying(2000) NOT NULL,
    avi_note smallint NOT NULL,
    avi_nbutileoui smallint NOT NULL,
    avi_nbutilenon smallint NOT NULL,
    CONSTRAINT ck_avi_nbutilenon CHECK ((avi_nbutilenon >= 0)),
    CONSTRAINT ck_avi_nbutileoui CHECK ((avi_nbutileoui >= 0)),
    CONSTRAINT ckc_avi_note_t_e_avis CHECK (((avi_note >= 1) AND (avi_note <= 5)))
);


ALTER TABLE fnac.t_e_avis_avi OWNER TO fnac2c;

--
-- Name: t_e_avis_avi_avi_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_e_avis_avi_avi_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_e_avis_avi_avi_id_seq OWNER TO fnac2c;

--
-- Name: t_e_avis_avi_avi_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_e_avis_avi_avi_id_seq OWNED BY fnac.t_e_avis_avi.avi_id;


--
-- Name: t_e_commande_com; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_e_commande_com (
    com_id integer NOT NULL,
    adh_id integer NOT NULL,
    rel_id integer,
    adr_id integer,
    mag_id integer,
    com_date date NOT NULL,
    CONSTRAINT ck_com_rel_adr CHECK ((((rel_id IS NULL) AND (mag_id IS NULL) AND (adr_id IS NOT NULL)) OR ((rel_id IS NOT NULL) AND (mag_id IS NULL) AND (adr_id IS NULL)) OR ((rel_id IS NULL) AND (mag_id IS NOT NULL) AND (adr_id IS NULL))))
);


ALTER TABLE fnac.t_e_commande_com OWNER TO fnac2c;

--
-- Name: t_e_commande_com_com_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_e_commande_com_com_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_e_commande_com_com_id_seq OWNER TO fnac2c;

--
-- Name: t_e_commande_com_com_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_e_commande_com_com_id_seq OWNED BY fnac.t_e_commande_com.com_id;


--
-- Name: t_e_editeur_edi; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_e_editeur_edi (
    edi_id integer NOT NULL,
    edi_nom character varying(80) NOT NULL
);


ALTER TABLE fnac.t_e_editeur_edi OWNER TO fnac2c;

--
-- Name: t_e_editeur_edi_edi_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_e_editeur_edi_edi_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_e_editeur_edi_edi_id_seq OWNER TO fnac2c;

--
-- Name: t_e_editeur_edi_edi_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_e_editeur_edi_edi_id_seq OWNED BY fnac.t_e_editeur_edi.edi_id;


--
-- Name: t_e_livraison_cli; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_e_livraison_cli (
    cli_id integer NOT NULL,
    com_id integer NOT NULL,
    cli_datelivraison date
);


ALTER TABLE fnac.t_e_livraison_cli OWNER TO fnac2c;

--
-- Name: t_e_livraison_cli_cli_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_e_livraison_cli_cli_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_e_livraison_cli_cli_id_seq OWNER TO fnac2c;

--
-- Name: t_e_livraison_cli_cli_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_e_livraison_cli_cli_id_seq OWNED BY fnac.t_e_livraison_cli.cli_id;


--
-- Name: t_e_livre_liv; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_e_livre_liv (
    liv_id integer NOT NULL,
    for_id integer NOT NULL,
    edi_id integer NOT NULL,
    gen_id integer NOT NULL,
    liv_titre character varying(100) NOT NULL,
    liv_histoire character varying(500),
    liv_dateparution date NOT NULL,
    liv_prixttc numeric(5,2) NOT NULL,
    liv_isbn character varying(10) NOT NULL,
    liv_stock integer NOT NULL,
    CONSTRAINT ckc_liv_stock_t_e_livr CHECK ((liv_stock >= 0))
);


ALTER TABLE fnac.t_e_livre_liv OWNER TO fnac2c;

--
-- Name: t_e_livre_liv_liv_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_e_livre_liv_liv_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_e_livre_liv_liv_id_seq OWNER TO fnac2c;

--
-- Name: t_e_livre_liv_liv_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_e_livre_liv_liv_id_seq OWNED BY fnac.t_e_livre_liv.liv_id;


--
-- Name: t_e_panier_pan; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_e_panier_pan (
    adh_id integer NOT NULL,
    liv_id integer NOT NULL,
    liv_quantite integer
);


ALTER TABLE fnac.t_e_panier_pan OWNER TO fnac2c;

--
-- Name: t_e_photo_pho; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_e_photo_pho (
    pho_id integer NOT NULL,
    liv_id integer NOT NULL,
    pho_url character varying(200) NOT NULL
);


ALTER TABLE fnac.t_e_photo_pho OWNER TO fnac2c;

--
-- Name: t_e_photo_pho_pho_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_e_photo_pho_pho_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_e_photo_pho_pho_id_seq OWNER TO fnac2c;

--
-- Name: t_e_photo_pho_pho_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_e_photo_pho_pho_id_seq OWNED BY fnac.t_e_photo_pho.pho_id;


--
-- Name: t_e_relais_rel; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_e_relais_rel (
    rel_id integer NOT NULL,
    rel_nom character varying(100) NOT NULL,
    rel_rue character varying(200) NOT NULL,
    rel_cp character varying(10) NOT NULL,
    rel_ville character varying(100) NOT NULL,
    pay_id integer NOT NULL,
    rel_latitude double precision,
    rel_longitude double precision
);


ALTER TABLE fnac.t_e_relais_rel OWNER TO fnac2c;

--
-- Name: t_e_relais_rel_rel_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_e_relais_rel_rel_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_e_relais_rel_rel_id_seq OWNER TO fnac2c;

--
-- Name: t_e_relais_rel_rel_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_e_relais_rel_rel_id_seq OWNED BY fnac.t_e_relais_rel.rel_id;


--
-- Name: t_e_role_rol; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_e_role_rol (
    rol_id integer NOT NULL,
    rol_libelle character varying(200)
);


ALTER TABLE fnac.t_e_role_rol OWNER TO fnac2c;

--
-- Name: t_e_role_rol_rol_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_e_role_rol_rol_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_e_role_rol_rol_id_seq OWNER TO fnac2c;

--
-- Name: t_e_role_rol_rol_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_e_role_rol_rol_id_seq OWNED BY fnac.t_e_role_rol.rol_id;


--
-- Name: t_j_alerte_ale; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_j_alerte_ale (
    adh_id integer NOT NULL,
    liv_id integer NOT NULL
);


ALTER TABLE fnac.t_j_alerte_ale OWNER TO fnac2c;

--
-- Name: t_j_auteurlivre_aul; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_j_auteurlivre_aul (
    liv_id integer NOT NULL,
    aut_id integer NOT NULL
);


ALTER TABLE fnac.t_j_auteurlivre_aul OWNER TO fnac2c;

--
-- Name: t_j_avisabusif_ava; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_j_avisabusif_ava (
    adh_id integer NOT NULL,
    avi_id integer NOT NULL
);


ALTER TABLE fnac.t_j_avisabusif_ava OWNER TO fnac2c;

--
-- Name: t_j_avisutileoupas_avu; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_j_avisutileoupas_avu (
    avi_id integer NOT NULL,
    adh_id integer NOT NULL,
    avu_utile integer NOT NULL
);


ALTER TABLE fnac.t_j_avisutileoupas_avu OWNER TO fnac2c;

--
-- Name: t_j_favori_fav; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_j_favori_fav (
    adh_id integer NOT NULL,
    liv_id integer NOT NULL
);


ALTER TABLE fnac.t_j_favori_fav OWNER TO fnac2c;

--
-- Name: t_j_lignecommande_lec; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_j_lignecommande_lec (
    com_id integer NOT NULL,
    liv_id integer NOT NULL,
    lec_quantite integer NOT NULL,
    CONSTRAINT ckc_lec_quantite_t_j_lign CHECK ((lec_quantite >= 1))
);


ALTER TABLE fnac.t_j_lignecommande_lec OWNER TO fnac2c;

--
-- Name: t_j_relaisadherent_rea; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_j_relaisadherent_rea (
    adh_id integer NOT NULL,
    rel_id integer NOT NULL
);


ALTER TABLE fnac.t_j_relaisadherent_rea OWNER TO fnac2c;

--
-- Name: t_j_roleadherent_rad; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_j_roleadherent_rad (
    rol_id integer NOT NULL,
    adh_id integer NOT NULL
);


ALTER TABLE fnac.t_j_roleadherent_rad OWNER TO fnac2c;

--
-- Name: t_j_rubriquelivre_rul; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_j_rubriquelivre_rul (
    liv_id integer NOT NULL,
    rub_id integer NOT NULL
);


ALTER TABLE fnac.t_j_rubriquelivre_rul OWNER TO fnac2c;

--
-- Name: t_r_format_for; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_r_format_for (
    for_id integer NOT NULL,
    for_libelle character varying(30) NOT NULL
);


ALTER TABLE fnac.t_r_format_for OWNER TO fnac2c;

--
-- Name: t_r_format_for_for_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_r_format_for_for_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_r_format_for_for_id_seq OWNER TO fnac2c;

--
-- Name: t_r_format_for_for_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_r_format_for_for_id_seq OWNED BY fnac.t_r_format_for.for_id;


--
-- Name: t_r_genre_gen; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_r_genre_gen (
    gen_id integer NOT NULL,
    gen_libelle character varying(50) NOT NULL
);


ALTER TABLE fnac.t_r_genre_gen OWNER TO fnac2c;

--
-- Name: t_r_genre_gen_gen_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_r_genre_gen_gen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_r_genre_gen_gen_id_seq OWNER TO fnac2c;

--
-- Name: t_r_genre_gen_gen_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_r_genre_gen_gen_id_seq OWNED BY fnac.t_r_genre_gen.gen_id;


--
-- Name: t_r_magasin_mag; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_r_magasin_mag (
    mag_id integer NOT NULL,
    mag_nom character varying(100) NOT NULL,
    mag_ville character varying(100) NOT NULL
);


ALTER TABLE fnac.t_r_magasin_mag OWNER TO fnac2c;

--
-- Name: t_r_magasin_mag_mag_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_r_magasin_mag_mag_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_r_magasin_mag_mag_id_seq OWNER TO fnac2c;

--
-- Name: t_r_magasin_mag_mag_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_r_magasin_mag_mag_id_seq OWNED BY fnac.t_r_magasin_mag.mag_id;


--
-- Name: t_r_pays_pay; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_r_pays_pay (
    pay_id integer NOT NULL,
    pay_nom character varying(50) NOT NULL
);


ALTER TABLE fnac.t_r_pays_pay OWNER TO fnac2c;

--
-- Name: t_r_pays_pay_pay_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_r_pays_pay_pay_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_r_pays_pay_pay_id_seq OWNER TO fnac2c;

--
-- Name: t_r_pays_pay_pay_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_r_pays_pay_pay_id_seq OWNED BY fnac.t_r_pays_pay.pay_id;


--
-- Name: t_r_rubrique_rub; Type: TABLE; Schema: fnac; Owner: fnac2c
--

CREATE TABLE fnac.t_r_rubrique_rub (
    rub_id integer NOT NULL,
    rub_libelle character varying(50) NOT NULL
);


ALTER TABLE fnac.t_r_rubrique_rub OWNER TO fnac2c;

--
-- Name: t_r_rubrique_rub_rub_id_seq; Type: SEQUENCE; Schema: fnac; Owner: fnac2c
--

CREATE SEQUENCE fnac.t_r_rubrique_rub_rub_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fnac.t_r_rubrique_rub_rub_id_seq OWNER TO fnac2c;

--
-- Name: t_r_rubrique_rub_rub_id_seq; Type: SEQUENCE OWNED BY; Schema: fnac; Owner: fnac2c
--

ALTER SEQUENCE fnac.t_r_rubrique_rub_rub_id_seq OWNED BY fnac.t_r_rubrique_rub.rub_id;


--
-- Name: t_e_adherent_adh adh_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_adherent_adh ALTER COLUMN adh_id SET DEFAULT nextval('fnac.t_e_adherent_adh_adh_id_seq'::regclass);


--
-- Name: t_e_adresse_adr adr_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_adresse_adr ALTER COLUMN adr_id SET DEFAULT nextval('fnac.t_e_adresse_adr_adr_id_seq'::regclass);


--
-- Name: t_e_auteur_aut aut_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_auteur_aut ALTER COLUMN aut_id SET DEFAULT nextval('fnac.t_e_auteur_aut_aut_id_seq'::regclass);


--
-- Name: t_e_avis_avi avi_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_avis_avi ALTER COLUMN avi_id SET DEFAULT nextval('fnac.t_e_avis_avi_avi_id_seq'::regclass);


--
-- Name: t_e_commande_com com_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_commande_com ALTER COLUMN com_id SET DEFAULT nextval('fnac.t_e_commande_com_com_id_seq'::regclass);


--
-- Name: t_e_editeur_edi edi_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_editeur_edi ALTER COLUMN edi_id SET DEFAULT nextval('fnac.t_e_editeur_edi_edi_id_seq'::regclass);


--
-- Name: t_e_livraison_cli cli_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_livraison_cli ALTER COLUMN cli_id SET DEFAULT nextval('fnac.t_e_livraison_cli_cli_id_seq'::regclass);


--
-- Name: t_e_livre_liv liv_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_livre_liv ALTER COLUMN liv_id SET DEFAULT nextval('fnac.t_e_livre_liv_liv_id_seq'::regclass);


--
-- Name: t_e_photo_pho pho_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_photo_pho ALTER COLUMN pho_id SET DEFAULT nextval('fnac.t_e_photo_pho_pho_id_seq'::regclass);


--
-- Name: t_e_relais_rel rel_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_relais_rel ALTER COLUMN rel_id SET DEFAULT nextval('fnac.t_e_relais_rel_rel_id_seq'::regclass);


--
-- Name: t_e_role_rol rol_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_role_rol ALTER COLUMN rol_id SET DEFAULT nextval('fnac.t_e_role_rol_rol_id_seq'::regclass);


--
-- Name: t_r_format_for for_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_r_format_for ALTER COLUMN for_id SET DEFAULT nextval('fnac.t_r_format_for_for_id_seq'::regclass);


--
-- Name: t_r_genre_gen gen_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_r_genre_gen ALTER COLUMN gen_id SET DEFAULT nextval('fnac.t_r_genre_gen_gen_id_seq'::regclass);


--
-- Name: t_r_magasin_mag mag_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_r_magasin_mag ALTER COLUMN mag_id SET DEFAULT nextval('fnac.t_r_magasin_mag_mag_id_seq'::regclass);


--
-- Name: t_r_pays_pay pay_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_r_pays_pay ALTER COLUMN pay_id SET DEFAULT nextval('fnac.t_r_pays_pay_pay_id_seq'::regclass);


--
-- Name: t_r_rubrique_rub rub_id; Type: DEFAULT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_r_rubrique_rub ALTER COLUMN rub_id SET DEFAULT nextval('fnac.t_r_rubrique_rub_rub_id_seq'::regclass);


--
-- Data for Name: t_e_adherent_adh; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_e_adherent_adh VALUES (1, 1234567890, '2020-01-01', 'paul.durand@gmail.com', '123', 'paulo', 'M.', 'DURAND', 'Paul', '0450505050', NULL, 1);
INSERT INTO fnac.t_e_adherent_adh VALUES (2, 1234567891, '2020-10-01', 'marc.dupond@gmail.com', '123', 'marco', 'M.', 'DUPOND', 'Marc', '0450505051', '0601010101', 4);
INSERT INTO fnac.t_e_adherent_adh VALUES (3, 1234567892, '2021-05-30', 'pascal.poison@gmail.com', '123', 'curare', 'M.', 'POISON', 'Pascal', '0450505052', '0601010102', 3);
INSERT INTO fnac.t_e_adherent_adh VALUES (4, 1234567893, '2022-08-15', 'vincent.vivant@gmail.com', '123', 'vince', 'M.', 'VIVANT', 'Vincent', '0450505051', '0601010101', 1);
INSERT INTO fnac.t_e_adherent_adh VALUES (62, 9459515446, '2020-10-23', 'admin@fnac.com', '$2y$10$WTLWZXAiEMB63RO6J2p.R.UexP3p10qilZqRn2HVzUNKdeLCJuowu', 'admin', 'M.', 'PERRILLAT-COLLOMB', 'Tomu', '0450456565', '0642686868', 1);
INSERT INTO fnac.t_e_adherent_adh VALUES (63, 8964950395, '2020-10-23', 'client@fnac.com', '$2y$10$kdejW.UoPKxv7YnAW4elOu6rzLRDfjXH3cWRRgYZhYbl5W.t15YRK', 'Client', 'M.', 'Client', 'Alexis', '01020304055', '0604050607', 1);
INSERT INTO fnac.t_e_adherent_adh VALUES (64, 2518542113, '2020-11-22', 'cocod.tv@gmail.com', '$2y$10$CeA8ZRUv2kwFXGwLQluNG.1ZsubHMXg3fK7QoqxzZxnJPLGpnv3aC', 'ddddd', 'M.', 'dddd', 'ddd', '0986007771', '0686007771', 1);


--
-- Data for Name: t_e_adresse_adr; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_e_adresse_adr VALUES (1, 1, 'Chez moi', 'Facturation', 'Chemin de Bellevue', NULL, '74940', 'Annecy-le-Vieux', 1, 45.9211540000000014, 6.15379400000000043);
INSERT INTO fnac.t_e_adresse_adr VALUES (2, 1, 'Chez moi', 'Livraison', '9 rue de l''Arc en Ciel', NULL, '74940', 'Annecy-le-Vieux', 1, 45.9197869999999995, 6.160215);
INSERT INTO fnac.t_e_adresse_adr VALUES (3, 2, 'Lyon', 'Facturation', '10 rue des 3 Rois', NULL, '69007', 'Lyon', 1, 45.7539790000000011, 4.84277499999999961);
INSERT INTO fnac.t_e_adresse_adr VALUES (4, 3, 'Villeurbanne', 'Facturation', '43 Boulevard du 11 Novembre 1918', NULL, '69100', 'Villeurbanne', 1, 45.779122000000001, 4.86448299999999989);
INSERT INTO fnac.t_e_adresse_adr VALUES (5, 4, 'Annecy', 'Facturation', 'Rue de la gare', NULL, '74000', 'Annecy', 1, 45.9008699999999976, 6.1216090000000003);
INSERT INTO fnac.t_e_adresse_adr VALUES (52, 62, 'Bureau', 'Facturation', '12 chemin du code', 'Avulliens', '74000', 'Annecy', 1, 100351451, 100351451);
INSERT INTO fnac.t_e_adresse_adr VALUES (53, 63, '65 Rue Carnot', 'Facturation', '65 Rue Carnot', '65 Rue Carnot', '74000', 'Annecy', 1, 100351451, 100351451);
INSERT INTO fnac.t_e_adresse_adr VALUES (54, 64, 'dddddd', 'Facturation', 'dddd', 'dddd', '74650', 'dddd', 1, 100351451, 100351451);


--
-- Data for Name: t_e_auteur_aut; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_e_auteur_aut VALUES (1, 'Sorj Chalandon');
INSERT INTO fnac.t_e_auteur_aut VALUES (2, 'Zep');
INSERT INTO fnac.t_e_auteur_aut VALUES (3, 'Hélène Bruller');
INSERT INTO fnac.t_e_auteur_aut VALUES (4, 'Terry Goodkind');


--
-- Data for Name: t_e_avis_avi; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_e_avis_avi VALUES (1, 1, 1, '2019-09-27', 'Super', 'J''adore. Je recommande vivement son achat', 5, 0, 4);
INSERT INTO fnac.t_e_avis_avi VALUES (2, 2, 1, '2019-09-27', 'Un peu cher', 'Super, mais un peu cher quand même', 3, 3, 0);
INSERT INTO fnac.t_e_avis_avi VALUES (4, 1, 1, '2019-10-04', 'Nickel', 'On teste les tris par dates', 4, 0, 0);
INSERT INTO fnac.t_e_avis_avi VALUES (6, 2, 1, '2019-10-04', 'Super !', 'Il faut voir si cet avis est bien plus récent que les autres avec une notes égale', 5, 4, 0);
INSERT INTO fnac.t_e_avis_avi VALUES (7, 3, 3, '2019-10-04', 'Super !', 'J''ai bcp aimé ce livre', 5, 2, 0);


--
-- Data for Name: t_e_commande_com; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_e_commande_com VALUES (1, 1, 1, NULL, NULL, '2019-09-07');
INSERT INTO fnac.t_e_commande_com VALUES (2, 1, NULL, 2, NULL, '2019-09-17');
INSERT INTO fnac.t_e_commande_com VALUES (3, 1, NULL, NULL, 1, '2019-09-27');
INSERT INTO fnac.t_e_commande_com VALUES (28, 63, NULL, NULL, 1, '2019-10-23');
INSERT INTO fnac.t_e_commande_com VALUES (29, 63, 2, NULL, NULL, '2019-10-23');
INSERT INTO fnac.t_e_commande_com VALUES (30, 63, NULL, NULL, 1, '2019-10-24');
INSERT INTO fnac.t_e_commande_com VALUES (31, 63, NULL, NULL, 1, '2019-10-24');


--
-- Data for Name: t_e_editeur_edi; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_e_editeur_edi VALUES (1, 'Grasset');
INSERT INTO fnac.t_e_editeur_edi VALUES (2, 'Glénat');
INSERT INTO fnac.t_e_editeur_edi VALUES (3, 'Flammarion');
INSERT INTO fnac.t_e_editeur_edi VALUES (4, 'Milady');


--
-- Data for Name: t_e_livraison_cli; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_e_livraison_cli VALUES (2, 3, '2019-10-14');
INSERT INTO fnac.t_e_livraison_cli VALUES (3, 2, '2019-10-14');
INSERT INTO fnac.t_e_livraison_cli VALUES (4, 16, '2019-10-23');
INSERT INTO fnac.t_e_livraison_cli VALUES (5, 26, '2019-10-23');
INSERT INTO fnac.t_e_livraison_cli VALUES (6, 28, '2019-10-23');
INSERT INTO fnac.t_e_livraison_cli VALUES (7, 29, '2019-10-23');
INSERT INTO fnac.t_e_livraison_cli VALUES (8, 30, '2019-10-24');


--
-- Data for Name: t_e_livre_liv; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_e_livre_liv VALUES (1, 1, 1, 1, 'Profession du père', 'Mon pere a ete chanteur, footballeur, professeur de judo, parachutiste, espion, pasteur d''une Eglise pentecotiste americaine et conseiller personnel du general de Gaulle jusqu''en 1958. Un jour, il m''a dit que le General l''avait trahi. Son meilleur ami etait devenu son pire ennemi. Alors mon pere m''a annonce qu''il allait tuer de Gaulle. Et il m''a demande de l''aider.', '2015-08-19', 19.00, '2246857139', 8);
INSERT INTO fnac.t_e_livre_liv VALUES (2, 2, 2, 2, 'TITEUF, Bienvenue en adolescence !', 'La vie de Titeuf est bien bousculée ! Lui qui avait jusqu''ici l''habitude de se prendre des baffes avec les filles doit maintenant choisir entre deux prétendantes : Nadia ou Ramatou. Une situation à s''arracher les cheveux ! À moins que...', '2015-08-27', 9.99, '2344008462', 0);
INSERT INTO fnac.t_e_livre_liv VALUES (3, 2, 2, 2, 'TITEUF, Le guide du zizi sexuel', 'Est-ce que ça fait mal d''accoucher ? Et les animaux, ils naissent comment ? Titeuf est en prise directe avec les préoccupations des enfants : leur zizi et les mystères de la vie...', '2001-09-10', 7.99, '2723428028', 8);
INSERT INTO fnac.t_e_livre_liv VALUES (4, 3, 4, 3, 'L''épée de vérité, La première leçon du sorcier', 'Richard Cypher vivait paisiblement dans la forêt jusqu''au jour où son destin est bouleversé par une belle inconnue. Celle-ci ne consent à lui dire que son nom : Kahlan. Lui sait dès le premier regard, qu''il ne pourra plus la quitter. Mais des créatures monstrueuses traquent l''étrangère et le danger rôde en Hartland....', '2015-09-18', 9.90, '2811211187', 3);


--
-- Data for Name: t_e_panier_pan; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_e_panier_pan VALUES (64, 4, 1);


--
-- Data for Name: t_e_photo_pho; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_e_photo_pho VALUES (1, 1, '/storage/Chalandon1.jpg');
INSERT INTO fnac.t_e_photo_pho VALUES (3, 3, '/storage/Titeuf2.jpg');
INSERT INTO fnac.t_e_photo_pho VALUES (2, 2, '/storage/Titeuf1.jpg');
INSERT INTO fnac.t_e_photo_pho VALUES (4, 4, '/storage/Goodkind.jpg');


--
-- Data for Name: t_e_relais_rel; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_e_relais_rel VALUES (1, 'Tabac presse des pommaries', '12 Rue des Pommaries', '74940', 'Annecy-le-Vieux', 1, 45.9107929999999982, 6.14559199999999972);
INSERT INTO fnac.t_e_relais_rel VALUES (2, 'Casino', '7 Place du 18 Juin', '74940', 'Annecy-le-Vieux', 1, 45.9153499999999966, 6.14578000000000024);
INSERT INTO fnac.t_e_relais_rel VALUES (3, 'Casino', '119 Rue Sébastien Gryphe', '69007', 'Lyon', 1, 45.7486000000000033, 4.83974599999999988);
INSERT INTO fnac.t_e_relais_rel VALUES (4, 'Torrefaction des 3 Rois', '13 rue des 3 Rois', '69007', 'Lyon', 1, 45.7539790000000011, 4.84277499999999961);


--
-- Data for Name: t_e_role_rol; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_e_role_rol VALUES (1, 'Administrateur');
INSERT INTO fnac.t_e_role_rol VALUES (2, 'Client');
INSERT INTO fnac.t_e_role_rol VALUES (3, 'Service Communication');
INSERT INTO fnac.t_e_role_rol VALUES (5, 'Service Vente');
INSERT INTO fnac.t_e_role_rol VALUES (4, 'Service Adhérent
');


--
-- Data for Name: t_j_alerte_ale; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--



--
-- Data for Name: t_j_auteurlivre_aul; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_j_auteurlivre_aul VALUES (1, 1);
INSERT INTO fnac.t_j_auteurlivre_aul VALUES (2, 2);
INSERT INTO fnac.t_j_auteurlivre_aul VALUES (3, 2);
INSERT INTO fnac.t_j_auteurlivre_aul VALUES (3, 3);
INSERT INTO fnac.t_j_auteurlivre_aul VALUES (4, 4);


--
-- Data for Name: t_j_avisabusif_ava; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--



--
-- Data for Name: t_j_avisutileoupas_avu; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_j_avisutileoupas_avu VALUES (6, 63, 1);
INSERT INTO fnac.t_j_avisutileoupas_avu VALUES (5, 63, 0);
INSERT INTO fnac.t_j_avisutileoupas_avu VALUES (12, 63, 1);


--
-- Data for Name: t_j_favori_fav; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_j_favori_fav VALUES (64, 4);


--
-- Data for Name: t_j_lignecommande_lec; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_j_lignecommande_lec VALUES (1, 1, 1);
INSERT INTO fnac.t_j_lignecommande_lec VALUES (1, 2, 3);
INSERT INTO fnac.t_j_lignecommande_lec VALUES (1, 3, 1);
INSERT INTO fnac.t_j_lignecommande_lec VALUES (2, 1, 1);
INSERT INTO fnac.t_j_lignecommande_lec VALUES (2, 2, 1);
INSERT INTO fnac.t_j_lignecommande_lec VALUES (2, 3, 1);
INSERT INTO fnac.t_j_lignecommande_lec VALUES (2, 4, 1);
INSERT INTO fnac.t_j_lignecommande_lec VALUES (3, 3, 10);
INSERT INTO fnac.t_j_lignecommande_lec VALUES (28, 3, 1);
INSERT INTO fnac.t_j_lignecommande_lec VALUES (29, 1, 1);
INSERT INTO fnac.t_j_lignecommande_lec VALUES (29, 4, 1);
INSERT INTO fnac.t_j_lignecommande_lec VALUES (30, 2, 2);
INSERT INTO fnac.t_j_lignecommande_lec VALUES (30, 3, 1);
INSERT INTO fnac.t_j_lignecommande_lec VALUES (31, 4, 1);


--
-- Data for Name: t_j_relaisadherent_rea; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_j_relaisadherent_rea VALUES (1, 1);
INSERT INTO fnac.t_j_relaisadherent_rea VALUES (1, 2);
INSERT INTO fnac.t_j_relaisadherent_rea VALUES (62, 2);
INSERT INTO fnac.t_j_relaisadherent_rea VALUES (63, 2);
INSERT INTO fnac.t_j_relaisadherent_rea VALUES (64, 2);


--
-- Data for Name: t_j_roleadherent_rad; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_j_roleadherent_rad VALUES (2, 1);
INSERT INTO fnac.t_j_roleadherent_rad VALUES (1, 62);
INSERT INTO fnac.t_j_roleadherent_rad VALUES (2, 4);
INSERT INTO fnac.t_j_roleadherent_rad VALUES (2, 63);
INSERT INTO fnac.t_j_roleadherent_rad VALUES (2, 64);
INSERT INTO fnac.t_j_roleadherent_rad VALUES (2, 3);
INSERT INTO fnac.t_j_roleadherent_rad VALUES (2, 2);


--
-- Data for Name: t_j_rubriquelivre_rul; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_j_rubriquelivre_rul VALUES (1, 1);
INSERT INTO fnac.t_j_rubriquelivre_rul VALUES (1, 4);
INSERT INTO fnac.t_j_rubriquelivre_rul VALUES (2, 1);
INSERT INTO fnac.t_j_rubriquelivre_rul VALUES (2, 2);
INSERT INTO fnac.t_j_rubriquelivre_rul VALUES (3, 5);
INSERT INTO fnac.t_j_rubriquelivre_rul VALUES (4, 1);
INSERT INTO fnac.t_j_rubriquelivre_rul VALUES (4, 2);


--
-- Data for Name: t_r_format_for; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_r_format_for VALUES (1, 'Broché');
INSERT INTO fnac.t_r_format_for VALUES (2, 'Cartonné');
INSERT INTO fnac.t_r_format_for VALUES (3, 'Poche');


--
-- Data for Name: t_r_genre_gen; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_r_genre_gen VALUES (2, 'BD');
INSERT INTO fnac.t_r_genre_gen VALUES (29, 'SF');
INSERT INTO fnac.t_r_genre_gen VALUES (3, 'Fantasy');
INSERT INTO fnac.t_r_genre_gen VALUES (1, 'Roman');


--
-- Data for Name: t_r_magasin_mag; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_r_magasin_mag VALUES (1, 'Annecy', 'Annecy');
INSERT INTO fnac.t_r_magasin_mag VALUES (2, 'Chambéry', 'Chambéry');
INSERT INTO fnac.t_r_magasin_mag VALUES (3, 'Lyon Bellecour', 'Lyon');
INSERT INTO fnac.t_r_magasin_mag VALUES (4, 'Lyon Part-Dieu', 'Lyon');


--
-- Data for Name: t_r_pays_pay; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_r_pays_pay VALUES (1, 'France');
INSERT INTO fnac.t_r_pays_pay VALUES (2, 'Suisse');
INSERT INTO fnac.t_r_pays_pay VALUES (3, 'Italie');
INSERT INTO fnac.t_r_pays_pay VALUES (4, 'Espagne');
INSERT INTO fnac.t_r_pays_pay VALUES (5, 'UK');


--
-- Data for Name: t_r_rubrique_rub; Type: TABLE DATA; Schema: fnac; Owner: fnac2c
--

INSERT INTO fnac.t_r_rubrique_rub VALUES (1, 'Nouveautés');
INSERT INTO fnac.t_r_rubrique_rub VALUES (2, 'Meilleurs ventes');
INSERT INTO fnac.t_r_rubrique_rub VALUES (3, 'Réserver dès maintenant');
INSERT INTO fnac.t_r_rubrique_rub VALUES (4, 'Rentrée littéraire');
INSERT INTO fnac.t_r_rubrique_rub VALUES (5, 'Petits prix et bonnes affaires');


--
-- Name: t_e_adherent_adh_adh_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_e_adherent_adh_adh_id_seq', 64, true);


--
-- Name: t_e_adresse_adr_adr_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_e_adresse_adr_adr_id_seq', 54, true);


--
-- Name: t_e_auteur_aut_aut_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_e_auteur_aut_aut_id_seq', 4, true);


--
-- Name: t_e_avis_avi_avi_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_e_avis_avi_avi_id_seq', 12, true);


--
-- Name: t_e_commande_com_com_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_e_commande_com_com_id_seq', 31, true);


--
-- Name: t_e_editeur_edi_edi_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_e_editeur_edi_edi_id_seq', 4, true);


--
-- Name: t_e_livraison_cli_cli_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_e_livraison_cli_cli_id_seq', 8, true);


--
-- Name: t_e_livre_liv_liv_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_e_livre_liv_liv_id_seq', 14, true);


--
-- Name: t_e_photo_pho_pho_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_e_photo_pho_pho_id_seq', 19, true);


--
-- Name: t_e_relais_rel_rel_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_e_relais_rel_rel_id_seq', 4, true);


--
-- Name: t_e_role_rol_rol_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_e_role_rol_rol_id_seq', 5, true);


--
-- Name: t_r_format_for_for_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_r_format_for_for_id_seq', 3, true);


--
-- Name: t_r_genre_gen_gen_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_r_genre_gen_gen_id_seq', 29, true);


--
-- Name: t_r_magasin_mag_mag_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_r_magasin_mag_mag_id_seq', 4, true);


--
-- Name: t_r_pays_pay_pay_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_r_pays_pay_pay_id_seq', 5, true);


--
-- Name: t_r_rubrique_rub_rub_id_seq; Type: SEQUENCE SET; Schema: fnac; Owner: fnac2c
--

SELECT pg_catalog.setval('fnac.t_r_rubrique_rub_rub_id_seq', 5, true);


--
-- Name: t_e_adherent_adh pk_t_e_adherent_adh; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_adherent_adh
    ADD CONSTRAINT pk_t_e_adherent_adh PRIMARY KEY (adh_id);


--
-- Name: t_e_adresse_adr pk_t_e_adresse_adr; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_adresse_adr
    ADD CONSTRAINT pk_t_e_adresse_adr PRIMARY KEY (adr_id);


--
-- Name: t_e_auteur_aut pk_t_e_auteur_aut; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_auteur_aut
    ADD CONSTRAINT pk_t_e_auteur_aut PRIMARY KEY (aut_id);


--
-- Name: t_e_avis_avi pk_t_e_avis_avi; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_avis_avi
    ADD CONSTRAINT pk_t_e_avis_avi PRIMARY KEY (avi_id);


--
-- Name: t_e_commande_com pk_t_e_commande_com; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_commande_com
    ADD CONSTRAINT pk_t_e_commande_com PRIMARY KEY (com_id);


--
-- Name: t_e_editeur_edi pk_t_e_editeur_edi; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_editeur_edi
    ADD CONSTRAINT pk_t_e_editeur_edi PRIMARY KEY (edi_id);


--
-- Name: t_e_livre_liv pk_t_e_livre_liv; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_livre_liv
    ADD CONSTRAINT pk_t_e_livre_liv PRIMARY KEY (liv_id);


--
-- Name: t_e_photo_pho pk_t_e_photo_pho; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_photo_pho
    ADD CONSTRAINT pk_t_e_photo_pho PRIMARY KEY (pho_id);


--
-- Name: t_e_relais_rel pk_t_e_relais_rel; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_relais_rel
    ADD CONSTRAINT pk_t_e_relais_rel PRIMARY KEY (rel_id);


--
-- Name: t_j_alerte_ale pk_t_j_alerte_ale; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_alerte_ale
    ADD CONSTRAINT pk_t_j_alerte_ale PRIMARY KEY (adh_id, liv_id);


--
-- Name: t_j_auteurlivre_aul pk_t_j_auteurlivre_aul; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_auteurlivre_aul
    ADD CONSTRAINT pk_t_j_auteurlivre_aul PRIMARY KEY (aut_id, liv_id);


--
-- Name: t_j_avisabusif_ava pk_t_j_avisabusif_ava; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_avisabusif_ava
    ADD CONSTRAINT pk_t_j_avisabusif_ava PRIMARY KEY (adh_id, avi_id);


--
-- Name: t_j_favori_fav pk_t_j_favori_fav; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_favori_fav
    ADD CONSTRAINT pk_t_j_favori_fav PRIMARY KEY (adh_id, liv_id);


--
-- Name: t_j_lignecommande_lec pk_t_j_lignecommande_lec; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_lignecommande_lec
    ADD CONSTRAINT pk_t_j_lignecommande_lec PRIMARY KEY (com_id, liv_id);


--
-- Name: t_j_relaisadherent_rea pk_t_j_relaisadherent_rea; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_relaisadherent_rea
    ADD CONSTRAINT pk_t_j_relaisadherent_rea PRIMARY KEY (adh_id, rel_id);


--
-- Name: t_j_rubriquelivre_rul pk_t_j_rubriquelivre_rul; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_rubriquelivre_rul
    ADD CONSTRAINT pk_t_j_rubriquelivre_rul PRIMARY KEY (liv_id, rub_id);


--
-- Name: t_r_format_for pk_t_r_format_for; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_r_format_for
    ADD CONSTRAINT pk_t_r_format_for PRIMARY KEY (for_id);


--
-- Name: t_r_genre_gen pk_t_r_genre_gen; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_r_genre_gen
    ADD CONSTRAINT pk_t_r_genre_gen PRIMARY KEY (gen_id);


--
-- Name: t_r_magasin_mag pk_t_r_magasin_mag; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_r_magasin_mag
    ADD CONSTRAINT pk_t_r_magasin_mag PRIMARY KEY (mag_id);


--
-- Name: t_r_pays_pay pk_t_r_pays_pay; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_r_pays_pay
    ADD CONSTRAINT pk_t_r_pays_pay PRIMARY KEY (pay_id);


--
-- Name: t_r_rubrique_rub pk_t_r_rubrique_rub; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_r_rubrique_rub
    ADD CONSTRAINT pk_t_r_rubrique_rub PRIMARY KEY (rub_id);


--
-- Name: t_e_livraison_cli t_e_livraison_cli_pkey; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_livraison_cli
    ADD CONSTRAINT t_e_livraison_cli_pkey PRIMARY KEY (cli_id);


--
-- Name: t_e_panier_pan t_e_panier_pan_pkey; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_panier_pan
    ADD CONSTRAINT t_e_panier_pan_pkey PRIMARY KEY (adh_id, liv_id);


--
-- Name: t_e_role_rol t_e_role_rol_pkey; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_role_rol
    ADD CONSTRAINT t_e_role_rol_pkey PRIMARY KEY (rol_id);


--
-- Name: t_j_avisutileoupas_avu t_j_avisutileoupas_avu_pkey; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_avisutileoupas_avu
    ADD CONSTRAINT t_j_avisutileoupas_avu_pkey PRIMARY KEY (avi_id, adh_id);


--
-- Name: t_j_roleadherent_rad t_j_roleadherent_rad_pkey; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_roleadherent_rad
    ADD CONSTRAINT t_j_roleadherent_rad_pkey PRIMARY KEY (rol_id, adh_id);


--
-- Name: t_j_roleadherent_rad t_j_roleadherent_rad_rol_id_adh_id_key; Type: CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_roleadherent_rad
    ADD CONSTRAINT t_j_roleadherent_rad_rol_id_adh_id_key UNIQUE (rol_id, adh_id);


--
-- Name: t_e_adherent_adh fk_adh_mag; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_adherent_adh
    ADD CONSTRAINT fk_adh_mag FOREIGN KEY (mag_id) REFERENCES fnac.t_r_magasin_mag(mag_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_avis_avi fk_avi_abo; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_avis_avi
    ADD CONSTRAINT fk_avi_abo FOREIGN KEY (adh_id) REFERENCES fnac.t_e_adherent_adh(adh_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_commande_com fk_com_mag; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_commande_com
    ADD CONSTRAINT fk_com_mag FOREIGN KEY (mag_id) REFERENCES fnac.t_r_magasin_mag(mag_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_adresse_adr fk_t_e_adre_reference_t_e_adhe; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_adresse_adr
    ADD CONSTRAINT fk_t_e_adre_reference_t_e_adhe FOREIGN KEY (adh_id) REFERENCES fnac.t_e_adherent_adh(adh_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_adresse_adr fk_t_e_adre_reference_t_r_pays; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_adresse_adr
    ADD CONSTRAINT fk_t_e_adre_reference_t_r_pays FOREIGN KEY (pay_id) REFERENCES fnac.t_r_pays_pay(pay_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_avis_avi fk_t_e_avis_reference_t_e_livr; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_avis_avi
    ADD CONSTRAINT fk_t_e_avis_reference_t_e_livr FOREIGN KEY (liv_id) REFERENCES fnac.t_e_livre_liv(liv_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_commande_com fk_t_e_comm_reference_t_e_adhe; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_commande_com
    ADD CONSTRAINT fk_t_e_comm_reference_t_e_adhe FOREIGN KEY (adh_id) REFERENCES fnac.t_e_adherent_adh(adh_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_commande_com fk_t_e_comm_reference_t_e_adre; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_commande_com
    ADD CONSTRAINT fk_t_e_comm_reference_t_e_adre FOREIGN KEY (adr_id) REFERENCES fnac.t_e_adresse_adr(adr_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_commande_com fk_t_e_comm_reference_t_e_rela; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_commande_com
    ADD CONSTRAINT fk_t_e_comm_reference_t_e_rela FOREIGN KEY (rel_id) REFERENCES fnac.t_e_relais_rel(rel_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_livre_liv fk_t_e_livr_reference_t_e_edit; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_livre_liv
    ADD CONSTRAINT fk_t_e_livr_reference_t_e_edit FOREIGN KEY (edi_id) REFERENCES fnac.t_e_editeur_edi(edi_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_livre_liv fk_t_e_livr_reference_t_r_form; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_livre_liv
    ADD CONSTRAINT fk_t_e_livr_reference_t_r_form FOREIGN KEY (for_id) REFERENCES fnac.t_r_format_for(for_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_livre_liv fk_t_e_livr_reference_t_r_genr; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_livre_liv
    ADD CONSTRAINT fk_t_e_livr_reference_t_r_genr FOREIGN KEY (gen_id) REFERENCES fnac.t_r_genre_gen(gen_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_photo_pho fk_t_e_phot_reference_t_e_livr; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_photo_pho
    ADD CONSTRAINT fk_t_e_phot_reference_t_e_livr FOREIGN KEY (liv_id) REFERENCES fnac.t_e_livre_liv(liv_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_relais_rel fk_t_e_rela_reference_t_r_pays; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_relais_rel
    ADD CONSTRAINT fk_t_e_rela_reference_t_r_pays FOREIGN KEY (pay_id) REFERENCES fnac.t_r_pays_pay(pay_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_alerte_ale fk_t_j_aler_reference_t_e_adhe; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_alerte_ale
    ADD CONSTRAINT fk_t_j_aler_reference_t_e_adhe FOREIGN KEY (adh_id) REFERENCES fnac.t_e_adherent_adh(adh_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_alerte_ale fk_t_j_aler_reference_t_e_livr; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_alerte_ale
    ADD CONSTRAINT fk_t_j_aler_reference_t_e_livr FOREIGN KEY (liv_id) REFERENCES fnac.t_e_livre_liv(liv_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_auteurlivre_aul fk_t_j_aute_reference_t_e_aute; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_auteurlivre_aul
    ADD CONSTRAINT fk_t_j_aute_reference_t_e_aute FOREIGN KEY (aut_id) REFERENCES fnac.t_e_auteur_aut(aut_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_auteurlivre_aul fk_t_j_aute_reference_t_e_livr; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_auteurlivre_aul
    ADD CONSTRAINT fk_t_j_aute_reference_t_e_livr FOREIGN KEY (liv_id) REFERENCES fnac.t_e_livre_liv(liv_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_favori_fav fk_t_j_favo_reference_t_e_adhe; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_favori_fav
    ADD CONSTRAINT fk_t_j_favo_reference_t_e_adhe FOREIGN KEY (adh_id) REFERENCES fnac.t_e_adherent_adh(adh_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_favori_fav fk_t_j_favo_reference_t_e_livr; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_favori_fav
    ADD CONSTRAINT fk_t_j_favo_reference_t_e_livr FOREIGN KEY (liv_id) REFERENCES fnac.t_e_livre_liv(liv_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_lignecommande_lec fk_t_j_lign_reference_t_e_comm; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_lignecommande_lec
    ADD CONSTRAINT fk_t_j_lign_reference_t_e_comm FOREIGN KEY (com_id) REFERENCES fnac.t_e_commande_com(com_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_lignecommande_lec fk_t_j_lign_reference_t_e_livr; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_lignecommande_lec
    ADD CONSTRAINT fk_t_j_lign_reference_t_e_livr FOREIGN KEY (liv_id) REFERENCES fnac.t_e_livre_liv(liv_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_relaisadherent_rea fk_t_j_rela_reference_t_e_adhe; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_relaisadherent_rea
    ADD CONSTRAINT fk_t_j_rela_reference_t_e_adhe FOREIGN KEY (adh_id) REFERENCES fnac.t_e_adherent_adh(adh_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_relaisadherent_rea fk_t_j_rela_reference_t_e_rela; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_relaisadherent_rea
    ADD CONSTRAINT fk_t_j_rela_reference_t_e_rela FOREIGN KEY (rel_id) REFERENCES fnac.t_e_relais_rel(rel_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_rubriquelivre_rul fk_t_j_rubr_reference_t_e_livr; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_rubriquelivre_rul
    ADD CONSTRAINT fk_t_j_rubr_reference_t_e_livr FOREIGN KEY (liv_id) REFERENCES fnac.t_e_livre_liv(liv_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_rubriquelivre_rul fk_t_j_rubr_reference_t_r_rubr; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_rubriquelivre_rul
    ADD CONSTRAINT fk_t_j_rubr_reference_t_r_rubr FOREIGN KEY (rub_id) REFERENCES fnac.t_r_rubrique_rub(rub_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_avisabusif_ava fk_uti_abo; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_avisabusif_ava
    ADD CONSTRAINT fk_uti_abo FOREIGN KEY (adh_id) REFERENCES fnac.t_e_adherent_adh(adh_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_j_avisabusif_ava fk_uti_avi; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_j_avisabusif_ava
    ADD CONSTRAINT fk_uti_avi FOREIGN KEY (avi_id) REFERENCES fnac.t_e_avis_avi(avi_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_e_panier_pan t_e_panier_pan_adh_id_fkey; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_panier_pan
    ADD CONSTRAINT t_e_panier_pan_adh_id_fkey FOREIGN KEY (adh_id) REFERENCES fnac.t_e_adherent_adh(adh_id);


--
-- Name: t_e_panier_pan t_e_panier_pan_liv_id_fkey; Type: FK CONSTRAINT; Schema: fnac; Owner: fnac2c
--

ALTER TABLE ONLY fnac.t_e_panier_pan
    ADD CONSTRAINT t_e_panier_pan_liv_id_fkey FOREIGN KEY (liv_id) REFERENCES fnac.t_e_livre_liv(liv_id);


--
-- PostgreSQL database dump complete
--

