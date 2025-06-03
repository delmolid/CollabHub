-- Supprimer les tables si elles existent (dans l'ordre inverse à cause des clés étrangères)
DROP TABLE IF EXISTS "education" CASCADE;
DROP TABLE IF EXISTS "experience" CASCADE;
DROP TABLE IF EXISTS "candidat" CASCADE;

CREATE TABLE "candidat" (
    "id" BIGINT NOT NULL,
    "first_name" VARCHAR(255) NOT NULL,
    "last_name" VARCHAR(255) NOT NULL,
    "email" VARCHAR(255) NOT NULL,
    "phone" VARCHAR(20) NOT NULL,
    "picture" TEXT,
    "date_birth" DATE NOT NULL,
    "adress" TEXT,
    "link_linkedin" TEXT,
    "link_github" TEXT,
    "link_portfolio" TEXT,
    "description" TEXT,
    "language" TEXT,        -- Exemple : 'Anglais, Français, Espagnol'
    "interests" TEXT,       -- Exemple : 'Football, Lecture, IA'
    PRIMARY KEY ("id")
);

CREATE TABLE "education"(
    "id" BIGINT NOT NULL,
    "title" VARCHAR(255) NOT NULL,
    "school" VARCHAR(255) NOT NULL,
    "description" TEXT NOT NULL,
    "candidat_id" BIGINT NOT NULL
);
ALTER TABLE
    "education" ADD PRIMARY KEY("id");
CREATE TABLE "experience"(
    "id" BIGINT NOT NULL,
    "job" VARCHAR(255) NOT NULL,
    "company" TEXT NULL,
    "period" BIGINT NOT NULL,
    "candidat_id" BIGINT NOT NULL
);
ALTER TABLE
    "experience" ADD PRIMARY KEY("id");
ALTER TABLE
    "education" ADD CONSTRAINT "education_candidat_id_foreign" FOREIGN KEY("candidat_id") REFERENCES "candidat"("id");
ALTER TABLE
    "experience" ADD CONSTRAINT "experience_candidat_id_foreign" FOREIGN KEY("candidat_id") REFERENCES "candidat"("id");