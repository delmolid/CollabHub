-- Script d'initialisation pour CollabHub Database
-- Ce script s'exécute automatiquement lors du premier démarrage de PostgreSQL

-- Créer la base de données si elle n'existe pas (optionnel, car déjà créée via POSTGRES_DB)
-- CREATE DATABASE IF NOT EXISTS candidat;

-- Se connecter à la base de données candidat
\c candidat;

-- Créer des extensions utiles
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
CREATE EXTENSION IF NOT EXISTS "citext";

-- Créer un utilisateur de lecture seule pour les rapports (optionnel)
-- CREATE USER readonly_user WITH PASSWORD 'readonly_password';
-- GRANT CONNECT ON DATABASE candidat TO readonly_user;
-- GRANT USAGE ON SCHEMA public TO readonly_user;
-- GRANT SELECT ON ALL TABLES IN SCHEMA public TO readonly_user;
-- ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT SELECT ON TABLES TO readonly_user;

-- Log du succès d'initialisation
SELECT 'Database candidat initialized successfully' as status; 