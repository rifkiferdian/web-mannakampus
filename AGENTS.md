# AGENTS.md — AI agent instructions for this repo

Purpose
- Provide concise, actionable guidance so AI coding agents can be productive quickly.

At-a-glance
- Project type: PHP (custom CMS), no build system or tests.
- Serve locally: use XAMPP (Apache + MySQL). Copy this repo into XAMPP `htdocs`, start Apache & MySQL, import `web_manna_kampus.sql` via phpMyAdmin.
- DB config: [admin/config.php](admin/config.php) contains DB connection settings.
- Main entry points: [index.php](index.php) and [admin/index.php](admin/index.php).

Key files & directories (important for agents)
- [admin/](admin/): backend admin panels and site management pages.
- [assets/](assets/), [img/](img/), [uploads/](assets/uploads/): static assets and uploaded files.
- [header.php](header.php), [footer.php](footer.php), [sidebar.php](sidebar.php): primary template includes.
- [web_manna_kampus.sql](web_manna_kampus.sql): database dump for local setup.
- [admin/functions.php](admin/functions.php) and [admin/config.php](admin/config.php): common helpers and configuration.

Conventions & notes for agents
- This is a procedural PHP codebase (no framework). Prefer small, localized changes.
- Templates are simple includes; update `header.php`/`footer.php` for global markup changes.
- Respect existing database schema; coordinate schema changes and migrations with the user before editing SQL or import scripts.
- There are no automated tests or linters configured; run manual verification on a local XAMPP instance.

If you modify files
- Keep changes minimal and explain rationale in PR descriptions.
- For DB changes, provide a migration SQL and instructions for applying it (and a rollback if possible).

Suggested next customizations (optional)
- Add a `.github/copilot-instructions.md` or expand this file to include PR/CI expectations.
- Create a small `skills/` prompt for common tasks: "Add admin CRUD page", "Fix image upload path", "Update site header/footer".

References
- See [README.md](README.md) for any project-specific notes.

---
Generated: concise agent guidance for rapid onboarding.
