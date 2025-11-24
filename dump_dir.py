import sys
from pathlib import Path
import fnmatch

def should_ignore(path: Path, ignore_patterns):
    """Return True if path should be ignored based on patterns."""
    for pattern in ignore_patterns:
        if fnmatch.fnmatch(path.name, pattern) or fnmatch.fnmatch(str(path), pattern):
            return True
    return False


def dump_directory(root: Path, ignore_patterns):
    output_lines = []

    # --- DUMP ARBORESCENCE ---
    output_lines.append("=== ARBORESCENCE ===\n")

    for path in sorted(root.rglob("*")):
        rel = path.relative_to(root)
        if should_ignore(path, ignore_patterns):
            continue

        indent = "  " * (len(rel.parts) - 1)
        if path.is_dir():
            output_lines.append(f"{indent}[{path.name}]/")
        else:
            output_lines.append(f"{indent}{path.name}")

    output_lines.append("\n\n=== FICHIERS ET CONTENU ===\n")

    # --- DUMP FILE CONTENT ---
    for path in sorted(root.rglob("*")):
        if not path.is_file():
            continue
        if should_ignore(path, ignore_patterns):
            continue

        rel = path.relative_to(root)
        output_lines.append(f"\n--- {rel} ---\n")

        try:
            content = path.read_text(encoding="utf-8")
        except:
            content = "<Erreur : fichier binaire ou impossible à lire en UTF-8>\n"

        output_lines.append(content)

    return "\n".join(output_lines)


def main():
    if len(sys.argv) < 2:
        print("Usage : python dump_dir.py <repertoire> [patterns_a_ignorer...]")
        print("Exemple : python dump_dir.py ./monProjet *.png *.pyc node_modules")
        return

    root = Path(sys.argv[1]).resolve()
    ignore_patterns = sys.argv[2:]

    if not root.exists() or not root.is_dir():
        print(f"Erreur : {root} n'est pas un répertoire valide.")
        return

    print(f"Dump du répertoire : {root}")
    if ignore_patterns:
        print(f"Ignorés : {ignore_patterns}")

    dump_text = dump_directory(root, ignore_patterns)

    output_file = Path("dump.txt")
    output_file.write_text(dump_text, encoding="utf-8")

    print(f"\nDump terminé → dump.txt créé.")


if __name__ == "__main__":
    main()
