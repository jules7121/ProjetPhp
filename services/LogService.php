<?php

namespace Services;

class LogService
{
    private string $folder;

    public function __construct()
    {
        // Dossier contenant les fichiers journaux
        $this->folder = __DIR__ . '/../logs/';

        if (!is_dir($this->folder)) {
            mkdir($this->folder, 0777, true);
        }
    }

    /**
     * Ajoute une entrée dans le fichier log du mois courant.
     *
     * Format du nom de fichier :
     *   MIHOYO_mm_YYYY.log
     *
     * Format d'une ligne :
     *   [JJ/MM/YYYY HH:MM:SS] [ACTION] message
     *
     * @param string $action  Action à loguer (CREATE, UPDATE, DELETE, LOGIN…)
     * @param string $message Message associé
     */
    public function write(string $action, string $message): void
    {
        $filename = 'MIHOYO_' . date('m_Y') . '.log';
        $filePath = $this->folder . $filename;

        $entry = "[" . date('d/m/Y H:i:s') . "] [$action] $message\n";

        file_put_contents($filePath, $entry, FILE_APPEND);
    }

    /**
     * Retourne la liste des fichiers logs disponibles.
     *
     * @return array Liste des fichiers *.log dans le dossier /logs
     */
    public function listLogs(): array
    {
        $files = scandir($this->folder);

        return array_values(array_filter($files, function ($f) {
            return $f !== '.' && $f !== '..' && str_ends_with($f, '.log');
        }));
    }

    /**
     * Lit le contenu d'un fichier log donné.
     *
     * @param string $filename Nom du fichier log
     * @return string Contenu du fichier, ou message d'erreur si introuvable
     */
    public function read(string $filename): string
    {
        $path = $this->folder . $filename;

        if (!file_exists($path)) {
            return "Fichier introuvable.";
        }

        return file_get_contents($path);
    }
}
