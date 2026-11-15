# DevTrack — Technical Documentation

**Reference version:** `v0.3.1-alpha`  
**Current milestone:** Authentication and profile management completed in local development  
**Next milestone:** Job application CRUD (`v0.4.0-alpha`)  
**Stack:** PHP, MySQL/PDO, HTML, CSS, JavaScript, Laragon

[Back to the main README](../README.md)

## Documentation index

| File | Contents |
| --- | --- |
| [Project Scope](./escopo.md) | Goals, target users, MVP and future features |
| [Functional Requirements (RF)](./requisitos-funcionais.md) | Expected system behavior |
| [Non-Functional Requirements (RNF)](./requisitos-nao-funcionais.md) | Security, usability and maintainability |
| [Business Rules (RN)](./regras-de-negocio.md) | Restrictions and conditions |
| [Data Model](./modelo-de-dados.md) | Planned schema and relationships |
| [Landing Page](./landing-page.md) | Public website requirements and acceptance criteria |
| [Authentication](./autenticacao.md) | Registration, login, logout, sessions and protected routes |
| [User Profile](./perfil.md) | Avatar dropdown, photo upload and sign-out |

## Current implementation

### Working locally

- Public landing page with navigation, responsive layout and calls to action.
- Responsive dashboard UI, light/dark themes and theme preference saved in the browser.
- Account registration and login with PHP and MySQL.
- Session-based access control for private dashboard routes.
- Logout through POST and CSRF protection.
- Profile dropdown on the avatar, supporting upload of JPG, PNG and WebP images (up to 2 MB).
- Profile image associated with the authenticated account and available after a new login.

### Prototype or not yet implemented

- Application lists, Kanban, counters, charts and study recommendations **still use demonstration data**.
- Application CRUD and ownership checks are the next delivery.
- Technology analysis and personalized learning plans are planned for later releases.
- Automated security and end-to-end testing are still pending.

## Navigation and authorization

```text
Public landing page (/)
    ├── Register (?page=register) ─┐
    └── Login (?page=login) ───────┤
                                   ↓
                          Private dashboard
                                   ├── Profile / avatar upload
                                   ├── Logout (POST + CSRF)
                                   └── Applications (next milestone)
```

The landing page is accessible to both visitors and authenticated users. **Having an account is not equivalent to being logged in:** the dashboard requires an active session.

## Implementation references

- Authentication: `app/controllers/AuthController.php`, `app/models/User.php`, `app/middleware/auth.php`, `app/helpers/security.php`.
- Profile: `app/controllers/ProfileController.php`, `views/shared/profile-menu.php` and its CSS/JavaScript assets.
- Avatar storage: `public/uploads/avatars/` and `users.avatar_path`.
- Entry point and routes: `public/index.php`.

## Release plan

| Version | Delivery | Status |
| --- | --- | --- |
| `v0.2.1-alpha` | Public landing page | Completed |
| `v0.3.0-alpha` | Authentication and protected routes | Completed locally |
| **`v0.3.1-alpha`** | **Profile menu, avatar upload and fixes** | **Current** |
| `v0.4.0-alpha` | Application CRUD | Next |
| `v0.5.0-beta` | Real dashboard and Kanban | Planned |
| `v0.6.0-beta` | Tests and stabilization | Planned |
| `v1.0.0` | Application tracking MVP | Goal |
| `v1.1` | Skills and personalized learning | Future |

## Documentation maintenance

When a feature is completed, update its RF/RNF/RN references and acceptance checklists, then update both READMEs and the changelog. The documentation describes the current direction; acceptance items should only be checked after verification in the local environment.

**Next technical task:** implement `v0.4.0-alpha` with persistent job applications, proper ownership validation and server-side input validation.
