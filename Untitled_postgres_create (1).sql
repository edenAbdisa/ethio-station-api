CREATE TABLE "Users" (
	"email" VARCHAR(50) NOT NULL UNIQUE,
	"id" serial NOT NULL UNIQUE,
	"password" varchar(100) NOT NULL,
	"phonenumber" varchar(15) NOT NULL,
	"type" VARCHAR(255) NOT NULL,
	"email_verified_at" TIMESTAMP NOT NULL,
	"remember_token" text NOT NULL,
	"created_at" TIMESTAMP NOT NULL,
	"updated_at" TIMESTAMP NOT NULL,
	"firstname" varchar(50) NOT NULL,
	"lastname" varchar(50) NOT NULL,
	CONSTRAINT "Users_pk" PRIMARY KEY ("id")
) WITH (
  OIDS=FALSE
);



CREATE TABLE "Car" (
	"id" serial NOT NULL UNIQUE,
	"license" varchar(50) NOT NULL UNIQUE,
	"category" integer NOT NULL,
	"status" varchar(10) NOT NULL,
	"numberofseat" integer NOT NULL,
	"carcondition" varchar(10) NOT NULL,
	"placeofservice" varchar(10) NOT NULL,
	"color" varchar(10) NOT NULL,
	"ownerid" VARCHAR(255) NOT NULL,
	"agreementwithus" VARCHAR(255) NOT NULL,
	"timestamp" TIMESTAMP NOT NULL,
	CONSTRAINT "Car_pk" PRIMARY KEY ("id")
) WITH (
  OIDS=FALSE
);



CREATE TABLE "Rate" (
	"id" serial NOT NULL UNIQUE,
	"ratedobjectid" varchar(10) NOT NULL UNIQUE,
	"rate" integer NOT NULL,
	"comment" VARCHAR(255) NOT NULL,
	"timestamp" TIMESTAMP NOT NULL,
	"rateobjecttype" BINARY NOT NULL,
	CONSTRAINT "Rate_pk" PRIMARY KEY ("id")
) WITH (
  OIDS=FALSE
);



CREATE TABLE "Bookedcar" (
	"id" serial NOT NULL UNIQUE,
	"carid" VARCHAR(255) NOT NULL UNIQUE,
	"daysofbooking" integer NOT NULL,
	"comment" VARCHAR(255) NOT NULL,
	"needsdriver" BOOLEAN NOT NULL,
	"govid" VARCHAR(255) NOT NULL,
	"placeofusage" varchar(255) NOT NULL,
	"timestamp" TIMESTAMP NOT NULL,
	"feeforservice" FLOAT NOT NULL,
	"status" varchar(10) NOT NULL,
	"userid" BINARY NOT NULL,
	CONSTRAINT "Bookedcar_pk" PRIMARY KEY ("id")
) WITH (
  OIDS=FALSE
);



CREATE TABLE "Categories" (
	"id" serial NOT NULL UNIQUE,
	"categorytype" varchar(10) NOT NULL UNIQUE,
	"name" varchar(10) NOT NULL,
	"timestamp" TIMESTAMP NOT NULL,
	CONSTRAINT "Categories_pk" PRIMARY KEY ("id")
) WITH (
  OIDS=FALSE
);




ALTER TABLE "Car" ADD CONSTRAINT "Car_fk0" FOREIGN KEY ("category") REFERENCES "Categories"("id");




