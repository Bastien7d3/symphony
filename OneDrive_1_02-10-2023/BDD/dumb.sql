--
-- PostgreSQL database dump
--

-- Dumped from database version 11.3
-- Dumped by pg_dump version 11.3

-- Started on 2019-12-16 08:54:07

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
-- TOC entry 2846 (class 1262 OID 74926)
-- Name: dws-cuet-message; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE "dws-cuet-message" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'French_France.1252' LC_CTYPE = 'French_France.1252';


ALTER DATABASE "dws-cuet-message" OWNER TO postgres;

\connect -reuse-previous=on "dbname='dws-cuet-message'"

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

SET default_with_oids = false;

--
-- TOC entry 199 (class 1259 OID 74936)
-- Name: device; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.device (
    id integer NOT NULL,
    name character varying(10) NOT NULL,
    description character varying(255) NOT NULL
);


ALTER TABLE public.device OWNER TO postgres;

--
-- TOC entry 197 (class 1259 OID 74932)
-- Name: device_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.device_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.device_id_seq OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 74941)
-- Name: message; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.message (
    id integer NOT NULL,
    texte character varying(200) NOT NULL,
    image bytea,
    date_creation timestamp(0) without time zone NOT NULL,
    date_fin timestamp(0) without time zone NOT NULL,
    emetteur_id integer NOT NULL
);


ALTER TABLE public.message OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 74949)
-- Name: message_device; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.message_device (
    message_id integer NOT NULL,
    device_id integer NOT NULL
);


ALTER TABLE public.message_device OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 74934)
-- Name: message_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.message_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.message_id_seq OWNER TO postgres;






--
-- TOC entry 2848 (class 0 OID 0)
-- Dependencies: 197
-- Name: device_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.device_id_seq', 37, true);


--
-- TOC entry 2849 (class 0 OID 0)
-- Dependencies: 198
-- Name: message_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.message_id_seq', 106, true);


--
-- TOC entry 2703 (class 2606 OID 74940)
-- Name: device device_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.device
    ADD CONSTRAINT device_pkey PRIMARY KEY (id);


--
-- TOC entry 2710 (class 2606 OID 74953)
-- Name: message_device message_device_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.message_device
    ADD CONSTRAINT message_device_pkey PRIMARY KEY (message_id, device_id);


--
-- TOC entry 2706 (class 2606 OID 74948)
-- Name: message message_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.message
    ADD CONSTRAINT message_pkey PRIMARY KEY (id);



--
-- TOC entry 2707 (class 1259 OID 74954)
-- Name: idx_3e082b81537a1329; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_3e082b81537a1329 ON public.message_device USING btree (message_id);


--
-- TOC entry 2708 (class 1259 OID 74955)
-- Name: idx_3e082b8194a4c7d4; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_3e082b8194a4c7d4 ON public.message_device USING btree (device_id);


--
-- TOC entry 2704 (class 1259 OID 74986)
-- Name: idx_b6bd307f79e92e8c; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_b6bd307f79e92e8c ON public.message USING btree (emetteur_id);


--
-- TOC entry 2712 (class 2606 OID 74956)
-- Name: message_device fk_3e082b81537a1329; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.message_device
    ADD CONSTRAINT fk_3e082b81537a1329 FOREIGN KEY (message_id) REFERENCES public.message(id) ON DELETE CASCADE;


--
-- TOC entry 2713 (class 2606 OID 74961)
-- Name: message_device fk_3e082b8194a4c7d4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.message_device
    ADD CONSTRAINT fk_3e082b8194a4c7d4 FOREIGN KEY (device_id) REFERENCES public.device(id) ON DELETE CASCADE;


--
-- TOC entry 2711 (class 2606 OID 74981)
-- Name: message fk_b6bd307f79e92e8c; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.message
    ADD CONSTRAINT fk_b6bd307f79e92e8c FOREIGN KEY (emetteur_id) REFERENCES public.device(id);


-- Completed on 2019-12-16 08:54:07

--
-- PostgreSQL database dump complete
--

