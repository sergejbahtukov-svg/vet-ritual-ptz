# WordPress Skills Entrypoint Log

## 2026-07-21

What was fixed:

- `AGENTS.md` now has a mandatory WordPress project entrypoint.
- `memory/WORDPRESS_SKILLS.md` is the active skill/tool contract for WordPress work.
- The project now explicitly records that no dedicated Codex WordPress skill/tool is available in the current tool list.
- The accepted stack is native WordPress without base plugin dependency:
  - Pages
  - Menus
  - Media Library
  - Featured Images
  - CPTs or blocks for repeatable content
  - template hierarchy
  - template parts
  - global-only Customizer/theme mods
- Blocked shortcuts:
  - Smarty logic copied into PHP
  - Customizer JSON as page content storage
  - ACF/page builder/plugin dependency as a base architecture requirement
  - route-map overlay replacing WordPress template hierarchy

Required start order for every next WordPress agent:

1. Read `AGENTS.md`.
2. Read `memory/WORDPRESS_SKILLS.md`.
3. If subagents are used, read `memory/subagents/WORDPRESS_ASSIGNMENTS.md`.
4. If the work spans several slices, read `memory/WORDPRESS_MIGRATION_WORKFLOW.md`.
5. Confirm current dedicated WordPress skill/tool availability before editing.
6. Proceed with native WordPress architecture if no dedicated WordPress tool exists.

