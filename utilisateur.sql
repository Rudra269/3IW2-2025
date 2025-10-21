--
-- PostgreSQL database dump
--

-- Dumped from database version 15.14
-- Dumped by pg_dump version 15.4

-- Started on 2025-10-21 19:44:44 UTC

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 214 (class 1259 OID 16410)
-- Name: utilisateur; Type: TABLE; Schema: public; Owner: devuser
--

CREATE TABLE public.utilisateur (
    email character varying(255) NOT NULL,
    "firstName" character varying(255),
    "lastName" character varying(255),
    pwd character varying(255) NOT NULL
);


ALTER TABLE public.utilisateur OWNER TO devuser;

--
-- TOC entry 3402 (class 0 OID 16410)
-- Dependencies: 214
-- Data for Name: utilisateur; Type: TABLE DATA; Schema: public; Owner: devuser
--

COPY public.utilisateur (email, "firstName", "lastName", pwd) FROM stdin;
rrudra263@gmail.com	Rudra	ROY	$2y$10$1r0f4S41FMxM8quYUjVo4.zsrYLRa8oD9Msq4zKs815Up.2wALiWe
rrr263rrr@gmail.com			$2y$10$.rVFixyjIZaeLli.WrarTe4ytb1ZzorCkt7Yv65E0/LrvxT15Q5Q.
rrr@gmail.com	Rudra	ROY	$2y$10$mijSFofRvXGsXa4GwUOrNuRWqZGA4vE984ElOxz56BJP0KHf8Mo9.
azerty@yahoo.fr	&lt;p&gt;Rudra&lt;/p&gt;	ROY	$2y$10$pn4G/yrF5zkA4uB7oxuVTObl4DoL./Bu5UAgnCzBbIiImlTr7rjE6
\.


--
-- TOC entry 3259 (class 2606 OID 16416)
-- Name: utilisateur utilisateur_pkey; Type: CONSTRAINT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.utilisateur
    ADD CONSTRAINT utilisateur_pkey PRIMARY KEY (email);


-- Completed on 2025-10-21 19:44:44 UTC

--
-- PostgreSQL database dump complete
--

