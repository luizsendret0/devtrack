# DevTrack

**Organize applications. Track opportunities. Grow your skills.**

**Version:** `v0.2.1-alpha` · **Status:** Active development · **Current milestone:** Public landing page and UI prototype

DevTrack is a personal full-stack web project designed for students and early-career developers who want to manage job applications and, in future releases, guide their studies using the technologies requested in the opportunities they save.

> **Development status:** The public landing page and the visual dashboard are available as a prototype. Application cards, counters, charts, and learning recommendations currently use **demonstration data**. Registration, login, persistent applications, and personalized recommendations are **not implemented yet**.

## Why DevTrack?

Tracking internships and junior developer positions across multiple platforms can get messy. DevTrack aims to bring applications, recruitment stages, and skills development into one place.

The project has two connected goals:

1. **Job application tracking:** Organize opportunities and follow every stage of the hiring process.
2. **Career-focused learning:** Identify frequently requested technologies and plan what to study next (planned feature).

## Preview

![Illustrative preview of the DevTrack dashboard](./public/assets/img/dashboard-preview.webp)

*Illustrative dashboard preview. The values shown are sample data, not actual user statistics.*

The interface uses **dark (black/navy with cyan accents)** and **light (white with blue accents)** themes, a responsive sidebar, a Kanban-style application overview, and a study section preview.

## Current functionality

| Feature | Status |
| --- | --- |
| Public landing page with feature overview and calls to action | Implemented (UI) |
| Landing sections, responsive menu, and internal navigation | Implemented (UI) |
| Responsive dashboard and sidebar navigation | Implemented (UI) |
| Kanban-style application cards | Demonstration only |
| Study area / learning path panels | Demonstration only |
| Light/dark themes with preference stored in the browser | Implemented |
| Glassmorphism and responsive layout | Implemented (UI) |
| Login, registration, logout, and protected routes | Planned — `v0.3.0-alpha` |
| Save, edit, filter, and delete applications in MySQL | Planned — `v0.4.0-alpha` |
| Dashboard counters and Kanban with real data | Planned — `v0.5.0-beta` |
| Skill gap analysis and personalized study suggestions | Planned — post-MVP (`v1.1`) |

**Important:** The presence of login/register links does not mean authentication is operational. Until the next milestone, private dashboard routes are **not yet access-controlled**.

## Tech stack

| Area | Technology |
| --- | --- |
| Front-end | HTML5, CSS3, vanilla JavaScript |
| Back-end | PHP (no Laravel) |
| Database (integration in progress) | MySQL, PDO |
| Architecture | Simplified MVC-style structure |
| Local environment | Laragon (Apache + PHP + MySQL) |
| Version control | Git / GitHub |

No front-end framework is required for the current interface.

## Project structure

```text
devtrack/
├── app/
│   ├── config/
│   ├── controllers/
│   ├── middleware/
│   └── models/
├── database/
│   └── schema.sql
├── docs/
│   ├── README.md
│   ├── escopo.md
│   ├── requisitos-funcionais.md
│   ├── requisitos-nao-funcionais.md
│   ├── regras-de-negocio.md
│   ├── modelo-de-dados.md
│   └── landing-page.md
├── public/
│   ├── assets/
│   │   ├── css/
│   │   │   ├── style.css
│   │   │   └── landing.css
│   │   ├── js/
│   │   │   ├── script.js
│   │   │   └── landing.js
│   │   └── img/
│   │       └── dashboard-preview.webp
│   └── index.php
├── views/
│   ├── auth/
│   ├── dashboard/
│   ├── jobs/
│   ├── landing/
│   ├── layouts/
│   └── shared/
├── .gitignore
└── README.md
```

## Run locally

The project is being developed on **Windows with Laragon**.

1. Clone the repository into Laragon's `www` directory:
   ```powershell
   cd C:\laragon\www
   git clone https://github.com/luizsendret0/devtrack.git
   ```
2. In Laragon, start **Apache**. MySQL is needed for the upcoming database-driven features, but the landing page itself does not require it.
3. Configure the local host `devtrack.test` to use `C:\laragon\www\devtrack\public` as its document root.
4. Open the following addresses:

   | Address | Description |
   | --- | --- |
   | `http://devtrack.test/` | Public landing page |
   | `http://devtrack.test/?page=dashboard` | Dashboard prototype (not yet protected) |
   | `http://devtrack.test/?page=login` | Login placeholder |
   | `http://devtrack.test/?page=register` | Registration placeholder |

If your Laragon configuration uses a different project URL, use that URL instead. Database setup instructions will be expanded when authentication is implemented.

## Roadmap

| Version | Milestone | Status |
| --- | --- | --- |
| `v0.1.0` | Folder structure and local development setup | Completed |
| `v0.2.0-alpha` | Dashboard prototype, Kanban UI, themes, and glassmorphism | Completed |
| **`v0.2.1-alpha`** | **Public landing page, responsive layout, and project presentation** | **Current** |
| `v0.3.0-alpha` | User registration, login, sessions, CSRF, logout, and access control | Next |
| `v0.4.0-alpha` | Application CRUD and ownership validation | Planned |
| `v0.5.0-beta` | Real dashboard metrics, search, filters, and functional Kanban | Planned |
| `v0.6.0-beta` | Testing, accessibility, fixes, and release preparation | Planned |
| `v1.0.0` | Tested and published application-tracking MVP | Goal |
| `v1.1` | Technology analysis and study recommendations using saved vacancies | Future |

*Version numbers describe the development plan; GitHub tags/releases must be created separately.*

## Documentation

Detailed documentation, including scope, functional and non-functional requirements, business rules, the planned data model, and landing-page acceptance criteria, is available in the [technical documentation](./docs/README.md).

## Next milestone — Authentication

The next release will connect the existing public landing page to real user accounts and protected dashboard access. It will include secure password hashing, server-side validation, CSRF protection, sessions, logout, and ownership-aware authorization for future application records.

## Author

**Luiz Felipe Sendreto**  
Systems Development student  
[GitHub](https://github.com/luizsendret0)

---

*DevTrack is an independent learning and portfolio project under active development.*
