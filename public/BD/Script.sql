------------------------------------------------------------
--        Script Postgre 
------------------------------------------------------------



------------------------------------------------------------
-- Table: user
------------------------------------------------------------
CREATE TABLE public.user(
	id_user   SERIAL NOT NULL ,
	nom       VARCHAR (60) NOT NULL ,
	prenom    VARCHAR (60) NOT NULL ,
	mdp       VARCHAR (30) NOT NULL ,
	login     VARCHAR (20) NOT NULL  ,
	CONSTRAINT user_PK PRIMARY KEY (id_user) ,
	CONSTRAINT user_AK UNIQUE (login)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: typelogement
------------------------------------------------------------
CREATE TABLE public.typelogement(
	typelogement   VARCHAR (50) NOT NULL ,
	nblitdouble    INT  NOT NULL ,
	nblitsimple    INT  NOT NULL ,
	pamr           BOOL  NOT NULL  ,
	CONSTRAINT typelogement_PK PRIMARY KEY (typelogement)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: logement
------------------------------------------------------------
CREATE TABLE public.logement(
	num_logement   SERIAL NOT NULL ,
	typelogement   VARCHAR (50) NOT NULL  ,
	CONSTRAINT logement_PK PRIMARY KEY (num_logement)

	,CONSTRAINT logement_typelogement_FK FOREIGN KEY (typelogement) REFERENCES public.typelogement(typelogement)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: reservation
------------------------------------------------------------
CREATE TABLE public.reservation(
	id_reservation   SERIAL NOT NULL ,
	datedebut        DATE  NOT NULL ,
	datefin          DATE  NOT NULL ,
	nbpersonne       INT  NOT NULL ,
	pension          VARCHAR (40) NOT NULL ,
	menage           BOOL  NOT NULL ,
	valide           VARCHAR (50) NOT NULL ,
	id_user          INT  NOT NULL ,
	num_logement     INT   ,
	typelogement     VARCHAR (50) NOT NULL  ,
	CONSTRAINT reservation_PK PRIMARY KEY (id_reservation)

	,CONSTRAINT reservation_user_FK FOREIGN KEY (id_user) REFERENCES public.user(id_user)
	,CONSTRAINT reservation_logement0_FK FOREIGN KEY (num_logement) REFERENCES public.logement(num_logement)
	,CONSTRAINT reservation_typelogement1_FK FOREIGN KEY (typelogement) REFERENCES public.typelogement(typelogement)
)WITHOUT OIDS;