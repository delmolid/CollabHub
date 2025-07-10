# Dockerfile pour service-recruteur (Java)
# Stage 1: Build
FROM gradle:8.4-jdk17 AS builder

# Définir le répertoire de travail
WORKDIR /app

# Copier les fichiers de configuration Gradle à la racine
COPY settings.gradle ./
COPY gradle gradle/

# Copier le wrapper Gradle
COPY gradlew gradlew.bat ./

# Rendre le gradlew exécutable
RUN chmod +x gradlew

# Copier le build.gradle du sous-projet
COPY app/build.gradle app/

# Télécharger les dépendances (cache layer)
RUN ./gradlew app:dependencies --no-daemon

# Copier tout le code source
COPY . .

# Build de l'application
RUN ./gradlew app:build --no-daemon -x test

# Stage 2: Runtime
FROM eclipse-temurin:17-jre

# Installation des outils de base
RUN apt-get update && apt-get install -y \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Créer un utilisateur non-root
RUN groupadd -r appgroup && useradd -r -g appgroup appuser

# Définir le répertoire de travail
WORKDIR /app

# Copier le JAR depuis le stage builder
COPY --from=builder /app/app/build/libs/*.jar app.jar

# Créer le répertoire pour les logs
RUN mkdir -p /var/log/app && chown appuser:appgroup /var/log/app

# Changer vers l'utilisateur non-root
USER appuser

# Exposer le port
EXPOSE 8081

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:8081/actuator/health || exit 1

# Variables d'environnement par défaut
ENV JAVA_OPTS="-Xmx512m -Xms256m"
ENV SERVER_PORT=8081

# Commande de démarrage
CMD ["sh", "-c", "java $JAVA_OPTS -jar app.jar"] 