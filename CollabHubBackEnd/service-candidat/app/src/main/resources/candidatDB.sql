CREATE TABLE "candidat"(
    "id" BIGSERIAL PRIMARY KEY,
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
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE "education"(
    "id" BIGSERIAL PRIMARY KEY,
    "title" VARCHAR(255) NOT NULL,
    "school" VARCHAR(255) NOT NULL,
    "description" TEXT NOT NULL,
    "candidat_id" BIGINT NOT NULL,
    "date_start" DATE NOT NULL,
    "date_end" DATE NOT NULL
);

CREATE TABLE "experience"(
    "id" BIGSERIAL PRIMARY KEY,
    "job" VARCHAR(255) NOT NULL,
    "company" VARCHAR(255) NULL,
    "description" TEXT NOT NULL,
    "date_start" DATE NOT NULL,
    "date_end" DATE NOT NULL,
    "candidat_id" BIGINT NOT NULL
);

CREATE TABLE "application"(
    "id" BIGSERIAL PRIMARY KEY,
    "job_id" VARCHAR(255) NOT NULL,
    "status" VARCHAR(255) CHECK
        ("status" IN('PENDING', 'ACCEPTED', 'REJECTED', 'IN_PROGRESS')) NOT NULL,
        "date_applied" DATE NOT NULL,
        "candidat_id" BIGINT NOT NULL
);

ALTER TABLE
    "education" ADD CONSTRAINT "education_candidat_id_foreign" FOREIGN KEY("candidat_id") REFERENCES "candidat"("id");
ALTER TABLE
    "experience" ADD CONSTRAINT "experience_candidat_id_foreign" FOREIGN KEY("candidat_id") REFERENCES "candidat"("id");
ALTER TABLE
    "application" ADD CONSTRAINT "application_candidat_id_foreign" FOREIGN KEY("candidat_id") REFERENCES "candidat"("id");

ALTER TABLE candidat RENAME COLUMN "link_Github" TO "link_github";