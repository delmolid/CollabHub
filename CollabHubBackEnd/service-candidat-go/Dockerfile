# Dockerfile pour service-candidat-go
# Stage 1: Build  
FROM golang:alpine AS builder

# Installation des dépendances système
RUN apk add --no-cache git

# Définir le répertoire de travail
WORKDIR /app

# Copier les fichiers de dépendances
COPY go.mod go.sum ./

# Télécharger les dépendances
RUN go mod download

# Copier tout le code source
COPY . .

# Build de l'application
RUN CGO_ENABLED=0 GOOS=linux go build -a -installsuffix cgo -o main ./cmd

# Stage 2: Runtime
FROM alpine:latest

# Installation de ca-certificates pour HTTPS
RUN apk --no-cache add ca-certificates

# Créer un utilisateur non-root
RUN addgroup -g 1001 -S appgroup && \
    adduser -S appuser -u 1001 -G appgroup

WORKDIR /root/

# Copier le binaire depuis le stage builder
COPY --from=builder /app/main .

# Créer le répertoire pour les logs (si nécessaire)
RUN mkdir -p /var/log/app && chown appuser:appgroup /var/log/app

# Changer vers l'utilisateur non-root
USER appuser

# Exposer le port
EXPOSE 8080

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD wget --no-verbose --tries=1 --spider http://localhost:8080/health || exit 1

# Commande de démarrage
CMD ["./main"] 