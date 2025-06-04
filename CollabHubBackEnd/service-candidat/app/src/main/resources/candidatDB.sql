CREATE TABLE "candidat"(
    "id" BIGINT NOT NULL,
    "first_name" VARCHAR(255) NOT NULL,
    "last_name" VARCHAR(255) NOT NULL,
    "email" VARCHAR(255) UNIQUE NOT NULL,
    "phone" VARCHAR(255) UNIQUE NOT NULL,
    "picture" TEXT NULL,
    "date_birth" DATE NOT NULL,
    "adress" TEXT NULL,
    "link_linkedin" TEXT NULL,
    "description" TEXT NOT NULL,
    "link_Github" TEXT NULL,
    "link_portfolio" TEXT NULL,
    "language" VARCHAR(255) NOT NULL,
    "interests" TEXT NOT NULL,
    "cv" TEXT NOT NULL,
    "created_at" DATE NOT NULL
);
ALTER TABLE
    "candidat" ADD PRIMARY KEY("id");
CREATE TABLE "education"(
    "id" BIGINT NOT NULL,
    "title" VARCHAR(255) NOT NULL,
    "school" VARCHAR(255) NOT NULL,
    "description" TEXT NOT NULL,
    "candidat_id" BIGINT NOT NULL,
    "date_start" DATE NOT NULL,
    "date_end" DATE NOT NULL
);
ALTER TABLE
    "education" ADD PRIMARY KEY("id");
CREATE TABLE "experience"(
    "id" BIGINT NOT NULL,
    "job" VARCHAR(255) NOT NULL,
    "company" VARCHAR(255) NULL,
    "description" TEXT NOT NULL,
    "date_start" DATE NOT NULL,
    "date_end" DATE NOT NULL,
    "candidat_id" BIGINT NOT NULL
);
ALTER TABLE
    "experience" ADD PRIMARY KEY("id");
CREATE TABLE "application"(
    "id" BIGINT NOT NULL,
    "job_id" VARCHAR(255) NOT NULL,
    "status" VARCHAR(255) CHECK
        ("status" IN('PENDING', 'ACCEPTED', 'REJECTED', 'IN_PROGRESS')) NOT NULL,
        "date_applied" DATE NOT NULL,
        "candidat_id" BIGINT NOT NULL
);
ALTER TABLE
    "application" ADD PRIMARY KEY("id");
ALTER TABLE
    "education" ADD CONSTRAINT "education_candidat_id_foreign" FOREIGN KEY("candidat_id") REFERENCES "candidat"("id");
ALTER TABLE
    "experience" ADD CONSTRAINT "experience_candidat_id_foreign" FOREIGN KEY("candidat_id") REFERENCES "candidat"("id");
ALTER TABLE
    "application" ADD CONSTRAINT "application_candidat_id_foreign" FOREIGN KEY("candidat_id") REFERENCES "candidat"("id");