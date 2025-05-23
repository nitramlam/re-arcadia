<?php

class SessionManager {
    private static int $timeout = 1200; // 20 minutes

    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        self::generateCsrfToken();
        self::checkToken();
    }

    public static function isAuthenticated(): bool {
        return isset($_SESSION['email'], $_SESSION['role'], $_SESSION['token'], $_COOKIE['user_token']) &&
               hash_equals($_SESSION['token'], $_COOKIE['user_token']);
    }

    public static function requireAuth(): void {
        self::start();

        if (!self::isAuthenticated()) {
            error_log("Redirection vers connexion.php : utilisateur non authentifié ou token manquant");
            self::destroy();
            header("Location: /connexion/connexion.php");
            exit();
        }

        error_log("Utilisateur authentifié : " . $_SESSION['email'] . " avec le rôle " . $_SESSION['role']);
    }

    private static function generateCsrfToken(): void {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    private static function checkToken(): void {
        if (isset($_SESSION['token'], $_COOKIE['user_token']) &&
            !hash_equals($_SESSION['token'], $_COOKIE['user_token'])) {
            error_log("Token invalide, déconnexion forcée");
            self::destroy();
            header("Location: /connexion/connexion.php");
            exit();
        }
    }

    public static function destroy(): void {
        session_unset();
        session_destroy();
    }

    public static function getCsrfToken(): string {
        return $_SESSION['csrf_token'] ?? '';
    }
}